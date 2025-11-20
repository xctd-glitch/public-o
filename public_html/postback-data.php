<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/bootstrap.php';

use SRP\Middleware\Session;
use SRP\Models\Postback;

Session::start();

// Check authentication
if (empty($_SESSION['srp_admin_id'])) {
    http_response_code(401);
    echo json_encode(['ok' => false, 'error' => 'Unauthorized'], JSON_THROW_ON_ERROR);
    exit;
}

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

$method = $_SERVER['REQUEST_METHOD'] ?? '';

if ($method !== 'GET') {
    http_response_code(405);
    echo json_encode(['ok' => false, 'error' => 'Method Not Allowed'], JSON_THROW_ON_ERROR);
    exit;
}

try {
    $startDate = $_GET['start_date'] ?? null;
    $endDate = $_GET['end_date'] ?? null;

    $postback = new Postback();

    // Get postback records
    $data = $postback->getAll($startDate, $endDate);

    // Get statistics
    $stats = $postback->getStats($startDate, $endDate);

    // Get chart data (last 7 days)
    $chartData = $postback->getChartData();

    echo json_encode([
        'ok' => true,
        'data' => $data,
        'stats' => $stats,
        'chart' => $chartData
    ], JSON_THROW_ON_ERROR);

} catch (Throwable $e) {
    error_log('Postback data error: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'ok' => false,
        'error' => 'Failed to fetch postback data'
    ], JSON_THROW_ON_ERROR);
}
