<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

use SRP\Models\Postback;

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

// Log all incoming requests for debugging
$logData = [
    'timestamp' => date('Y-m-d H:i:s'),
    'method' => $_SERVER['REQUEST_METHOD'] ?? 'UNKNOWN',
    'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    'get' => $_GET,
    'post' => $_POST
];
error_log('Postback received: ' . json_encode($logData));

try {
    // Accept both GET and POST
    $method = $_SERVER['REQUEST_METHOD'] ?? '';

    if ($method === 'POST') {
        // Try to parse JSON body first
        $raw = file_get_contents('php://input');
        if ($raw !== false && $raw !== '') {
            $jsonData = json_decode($raw, true);
            if (is_array($jsonData)) {
                $data = $jsonData;
            } else {
                $data = $_POST;
            }
        } else {
            $data = $_POST;
        }
    } else {
        // GET request
        $data = $_GET;
    }

    // Extract parameters
    $payout = trim($data['payout'] ?? '0');
    $country = trim($data['country'] ?? '');
    $trafficType = trim($data['traffic_type'] ?? '');

    // Validate required parameters
    if ($payout === '0' || $payout === '') {
        http_response_code(400);
        echo json_encode([
            'ok' => false,
            'error' => 'Missing payout parameter'
        ], JSON_THROW_ON_ERROR);
        exit;
    }

    // Clean payout value (remove currency symbols, etc)
    $payout = preg_replace('/[^0-9.]/', '', $payout);
    $payoutValue = (float)$payout;

    // Generate unique click_id based on timestamp and random string
    $clickId = 'pb_' . time() . '_' . bin2hex(random_bytes(4));

    // Save to database
    $postback = new Postback();
    $saved = $postback->create([
        'click_id' => $clickId,
        'payout' => $payoutValue,
        'country' => $country,
        'os' => '',
        'traffic_type' => $trafficType,
        'ip_address' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''
    ]);

    if ($saved) {
        echo json_encode([
            'ok' => true,
            'message' => 'Postback received successfully',
            'data' => [
                'click_id' => $clickId,
                'payout' => $payoutValue,
                'country' => $country,
                'traffic_type' => $trafficType
            ]
        ], JSON_THROW_ON_ERROR);
    } else {
        http_response_code(500);
        echo json_encode([
            'ok' => false,
            'error' => 'Failed to save postback'
        ], JSON_THROW_ON_ERROR);
    }

} catch (Throwable $e) {
    error_log('Postback error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'error' => 'Internal server error'
    ], JSON_THROW_ON_ERROR);
}
