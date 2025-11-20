-- Postbacks Table for CPA Conversion Tracking
-- Run this SQL to create the postbacks table

CREATE TABLE IF NOT EXISTS `postbacks` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `click_id` varchar(255) NOT NULL,
  `payout` decimal(10,2) NOT NULL DEFAULT 0.00,
  `country` varchar(10) DEFAULT NULL,
  `os` varchar(50) DEFAULT NULL,
  `traffic_type` varchar(50) DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_click_id` (`click_id`),
  KEY `idx_created_at` (`created_at`),
  KEY `idx_country` (`country`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
