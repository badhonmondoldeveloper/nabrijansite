-- Migration 002: Add Manual Payment Settings and Subscription Payment Logging

-- 1. Extend store_settings table for granular merchant manual payment control
ALTER TABLE `store_settings`
    ADD COLUMN IF NOT EXISTS `cod_enabled` TINYINT(1) NOT NULL DEFAULT 1 AFTER `outside_dhaka_delivery_charge`,
    ADD COLUMN IF NOT EXISTS `bkash_enabled` TINYINT(1) NOT NULL DEFAULT 1 AFTER `cod_enabled`,
    ADD COLUMN IF NOT EXISTS `bkash_type` ENUM('personal', 'agent', 'merchant') NOT NULL DEFAULT 'personal' AFTER `bkash_number`,
    ADD COLUMN IF NOT EXISTS `bkash_instruction` TEXT NULL AFTER `bkash_type`,
    ADD COLUMN IF NOT EXISTS `nagad_enabled` TINYINT(1) NOT NULL DEFAULT 1 AFTER `bkash_instruction`,
    ADD COLUMN IF NOT EXISTS `nagad_type` ENUM('personal', 'agent', 'merchant') NOT NULL DEFAULT 'personal' AFTER `nagad_number`,
    ADD COLUMN IF NOT EXISTS `nagad_instruction` TEXT NULL AFTER `nagad_type`,
    ADD COLUMN IF NOT EXISTS `rocket_enabled` TINYINT(1) NOT NULL DEFAULT 0 AFTER `nagad_instruction`,
    ADD COLUMN IF NOT EXISTS `rocket_number` VARCHAR(20) NULL AFTER `rocket_enabled`,
    ADD COLUMN IF NOT EXISTS `rocket_type` ENUM('personal', 'agent', 'merchant') NOT NULL DEFAULT 'personal' AFTER `rocket_number`,
    ADD COLUMN IF NOT EXISTS `rocket_instruction` TEXT NULL AFTER `rocket_type`,
    ADD COLUMN IF NOT EXISTS `bank_enabled` TINYINT(1) NOT NULL DEFAULT 0 AFTER `rocket_instruction`;

-- 2. Create platform_payment_settings table for Super Admin SaaS Manual Payments
CREATE TABLE IF NOT EXISTS `platform_payment_settings` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `setting_key` VARCHAR(100) NOT NULL UNIQUE,
    `setting_value` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default SaaS manual payment details if not exist
INSERT IGNORE INTO `platform_payment_settings` (`setting_key`, `setting_value`) VALUES
('bkash_number', '01700000000'),
('bkash_type', 'personal'),
('bkash_instruction', 'Send money to 01700000000 (Personal). Enter your TrxID and mobile number.'),
('nagad_number', '01700000000'),
('nagad_type', 'personal'),
('nagad_instruction', 'Send money to 01700000000 (Personal). Enter your TrxID and mobile number.'),
('rocket_number', '017000000007'),
('rocket_type', 'personal'),
('rocket_instruction', 'Send money to 017000000007 (Personal). Enter your TrxID and mobile number.'),
('bank_details', 'Bank Name: Dutch Bangla Bank Ltd\nAccount Name: Nabrijan Tech Ltd\nAccount No: 123.456.7890\nBranch: Gulshan Branch, Dhaka');

-- 3. Create subscription_payments table for logging merchant subscription upgrades
CREATE TABLE IF NOT EXISTS `subscription_payments` (
    `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `store_id` BIGINT UNSIGNED NOT NULL,
    `plan_id` BIGINT UNSIGNED NOT NULL,
    `payment_method` VARCHAR(50) NOT NULL,
    `transaction_id` VARCHAR(100) NOT NULL,
    `sender_number` VARCHAR(50) NULL,
    `amount` DECIMAL(10,2) NOT NULL,
    `payment_note` TEXT NULL,
    `status` ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    `rejection_reason` TEXT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (`store_id`) REFERENCES `stores`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`plan_id`) REFERENCES `plans`(`id`) ON DELETE RESTRICT,
    INDEX `idx_sub_payments_store` (`store_id`),
    INDEX `idx_sub_payments_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
