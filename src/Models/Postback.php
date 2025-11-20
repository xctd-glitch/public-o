<?php

declare(strict_types=1);

namespace SRP\Models;

use SRP\Config\Database;
use mysqli;

/**
 * Postback Model
 * Handles CPA conversion tracking from iMonetizeIt
 */
class Postback
{
    private mysqli $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    /**
     * Create a new postback record
     */
    public function create(array $data): bool
    {
        $clickId = $data['click_id'] ?? '';
        $payout = (float)($data['payout'] ?? 0);
        $country = $data['country'] ?? '';
        $os = $data['os'] ?? '';
        $trafficType = $data['traffic_type'] ?? '';
        $ipAddress = $data['ip_address'] ?? '';
        $userAgent = $data['user_agent'] ?? '';

        if ($clickId === '') {
            return false;
        }

        $stmt = $this->db->prepare('
            INSERT INTO postbacks
            (click_id, payout, country, os, traffic_type, ip_address, user_agent, created_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
        ');

        if ($stmt === false) {
            error_log('Postback prepare error: ' . $this->db->error);
            return false;
        }

        $stmt->bind_param(
            'sdsssss',
            $clickId,
            $payout,
            $country,
            $os,
            $trafficType,
            $ipAddress,
            $userAgent
        );

        $result = $stmt->execute();
        $stmt->close();

        return $result;
    }

    /**
     * Get all postbacks with optional date range filter
     */
    public function getAll(?string $startDate = null, ?string $endDate = null): array
    {
        $sql = 'SELECT * FROM postbacks WHERE 1=1';
        $params = [];
        $types = '';

        if ($startDate !== null && $startDate !== '') {
            $sql .= ' AND DATE(created_at) >= ?';
            $params[] = $startDate;
            $types .= 's';
        }

        if ($endDate !== null && $endDate !== '') {
            $sql .= ' AND DATE(created_at) <= ?';
            $params[] = $endDate;
            $types .= 's';
        }

        $sql .= ' ORDER BY created_at DESC LIMIT 1000';

        if (empty($params)) {
            $result = $this->db->query($sql);
            if ($result === false) {
                error_log('Postback query error: ' . $this->db->error);
                return [];
            }
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        $stmt = $this->db->prepare($sql);
        if ($stmt === false) {
            error_log('Postback prepare error: ' . $this->db->error);
            return [];
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $data;
    }

    /**
     * Get statistics summary
     */
    public function getStats(?string $startDate = null, ?string $endDate = null): array
    {
        $sql = 'SELECT
                    COUNT(*) as total_conversions,
                    COALESCE(SUM(payout), 0) as total_payout,
                    COALESCE(AVG(payout), 0) as avg_payout,
                    COUNT(CASE WHEN DATE(created_at) = CURDATE() THEN 1 END) as today_conversions,
                    COALESCE(SUM(CASE WHEN DATE(created_at) = CURDATE() THEN payout ELSE 0 END), 0) as today_payout
                FROM postbacks
                WHERE 1=1';

        $params = [];
        $types = '';

        if ($startDate !== null && $startDate !== '') {
            $sql .= ' AND DATE(created_at) >= ?';
            $params[] = $startDate;
            $types .= 's';
        }

        if ($endDate !== null && $endDate !== '') {
            $sql .= ' AND DATE(created_at) <= ?';
            $params[] = $endDate;
            $types .= 's';
        }

        if (empty($params)) {
            $result = $this->db->query($sql);
            if ($result === false) {
                error_log('Postback stats error: ' . $this->db->error);
                return $this->getEmptyStats();
            }
            $row = $result->fetch_assoc();
            return $row ?? $this->getEmptyStats();
        }

        $stmt = $this->db->prepare($sql);
        if ($stmt === false) {
            error_log('Postback stats prepare error: ' . $this->db->error);
            return $this->getEmptyStats();
        }

        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        return $row ?? $this->getEmptyStats();
    }

    /**
     * Get chart data for last 7 days
     */
    public function getChartData(): array
    {
        $sql = 'SELECT
                    DATE(created_at) as date,
                    COUNT(*) as conversions,
                    COALESCE(SUM(payout), 0) as payout
                FROM postbacks
                WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                GROUP BY DATE(created_at)
                ORDER BY date ASC';

        $result = $this->db->query($sql);
        if ($result === false) {
            error_log('Postback chart error: ' . $this->db->error);
            return [];
        }

        $data = $result->fetch_all(MYSQLI_ASSOC);

        // Fill missing days with zeros
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $found = false;

            foreach ($data as $row) {
                if ($row['date'] === $date) {
                    $chartData[] = [
                        'date' => $date,
                        'conversions' => (int)$row['conversions'],
                        'payout' => (float)$row['payout']
                    ];
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $chartData[] = [
                    'date' => $date,
                    'conversions' => 0,
                    'payout' => 0
                ];
            }
        }

        return $chartData;
    }

    /**
     * Get empty stats structure
     */
    private function getEmptyStats(): array
    {
        return [
            'total_conversions' => 0,
            'total_payout' => 0,
            'avg_payout' => 0,
            'today_conversions' => 0,
            'today_payout' => 0
        ];
    }

    /**
     * Delete old postbacks (older than specified days)
     */
    public function deleteOld(int $days = 90): int
    {
        $stmt = $this->db->prepare('
            DELETE FROM postbacks
            WHERE created_at < DATE_SUB(NOW(), INTERVAL ? DAY)
        ');

        if ($stmt === false) {
            error_log('Postback delete error: ' . $this->db->error);
            return 0;
        }

        $stmt->bind_param('i', $days);
        $stmt->execute();
        $affected = $stmt->affected_rows;
        $stmt->close();

        return $affected;
    }
}
