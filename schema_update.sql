-- Run this file in phpMyAdmin or MySQL CLI after importing responsiveform.sql
-- This adds new tables and fixes missing primary keys / auto-increment

USE `responsiveform`;

-- Add proper PRIMARY KEY + AUTO_INCREMENT to tables that were missing them
ALTER TABLE `form2`
  ADD PRIMARY KEY (`id`),
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `form5`
  ADD PRIMARY KEY (`id`),
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

ALTER TABLE `form6`
  ADD PRIMARY KEY (`id`),
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `form3`
  ADD `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST,
  AUTO_INCREMENT=2;

ALTER TABLE `form4`
  ADD `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST,
  AUTO_INCREMENT=2;

-- Remove garbage test rows with id=0 from plan tables
DELETE FROM `form2` WHERE `plname` IN ('Onida','SONYHD') AND `pcname` IN ('452','4523');
DELETE FROM `form5` WHERE `mname` IN ('SONY452') AND `aname` = '452';

-- --------------------------------------------------------
-- Complaints table (replaces unused form7)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `complaints` (
  `id`          int(11)      NOT NULL AUTO_INCREMENT,
  `user_id`     int(11)      NOT NULL,
  `username`    varchar(50)  NOT NULL,
  `subject`     varchar(100) NOT NULL,
  `message`     text         NOT NULL,
  `status`      varchar(20)  NOT NULL DEFAULT 'Open',
  `admin_reply` text         DEFAULT NULL,
  `created_at`  timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `complaints_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `form1` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Connection requests table (new connection applications)
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `connection_requests` (
  `id`                int(11)      NOT NULL AUTO_INCREMENT,
  `full_name`         varchar(100) NOT NULL,
  `email`             varchar(100) NOT NULL,
  `phone`             varchar(15)  NOT NULL,
  `address`           varchar(255) NOT NULL,
  `area`              varchar(50)  NOT NULL,
  `subscription_type` varchar(50)  NOT NULL,
  `status`            varchar(20)  NOT NULL DEFAULT 'Pending',
  `created_at`        timestamp    NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- STB (Set-Top Box) inventory table
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS `stb_inventory` (
  `id`                   int(11)     NOT NULL AUTO_INCREMENT,
  `stb_number`           varchar(20) NOT NULL,
  `brand`                varchar(50) NOT NULL,
  `model`                varchar(50) NOT NULL,
  `assigned_customer_id` int(11)     DEFAULT NULL,
  `status`               varchar(20) NOT NULL DEFAULT 'Available',
  `added_date`           date        DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `stb_number` (`stb_number`),
  KEY `assigned_customer_id` (`assigned_customer_id`),
  CONSTRAINT `stb_ibfk_1` FOREIGN KEY (`assigned_customer_id`) REFERENCES `form1` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
