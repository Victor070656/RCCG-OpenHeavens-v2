-- RCCG Open Heavens Parish - Admin Panel Database Schema

-- Create database
CREATE DATABASE IF NOT EXISTS `oh_church` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `oh_church`;

-- Admin users table
CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL UNIQUE,
  `email` varchar(100) NOT NULL UNIQUE,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `role` enum('super_admin','admin','editor') DEFAULT 'editor',
  `status` enum('active','inactive') DEFAULT 'active',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Events table
CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `location` varchar(200) DEFAULT 'RCCG Open Heavens Parish',
  `entry_type` enum('free','paid') DEFAULT 'free',
  `entry_fee` decimal(10,2) DEFAULT 0.00,
  `image` varchar(255) DEFAULT NULL,
  `status` enum('upcoming','ongoing','completed','cancelled') DEFAULT 'upcoming',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  FOREIGN KEY (`created_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Sermons table
CREATE TABLE IF NOT EXISTS `sermons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text,
  `pastor` varchar(100) NOT NULL,
  `sermon_date` date NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  `scripture_reference` varchar(100) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `audio_url` varchar(255) DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `views` int(11) DEFAULT 0,
  `downloads` int(11) DEFAULT 0,
  `status` enum('published','draft','archived') DEFAULT 'draft',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  FOREIGN KEY (`created_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Members table
CREATE TABLE IF NOT EXISTS `members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `date_of_birth` date DEFAULT NULL,
  `gender` enum('male','female') DEFAULT NULL,
  `membership_date` date NOT NULL,
  `membership_type` enum('full_member','associate_member','visitor') DEFAULT 'visitor',
  `department` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `created_by` (`created_by`),
  FOREIGN KEY (`created_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Newsletter subscriptions table
CREATE TABLE IF NOT EXISTS `newsletter_subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL UNIQUE,
  `status` enum('active','unsubscribed') DEFAULT 'active',
  `subscribed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `unsubscribed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contact messages table
CREATE TABLE IF NOT EXISTS `contact_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('new','read','replied','archived') DEFAULT 'new',
  `replied_by` int(11) DEFAULT NULL,
  `replied_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `replied_by` (`replied_by`),
  FOREIGN KEY (`replied_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Church settings table (for storing church account numbers and other info)
CREATE TABLE IF NOT EXISTS `church_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `church_name` varchar(200) DEFAULT 'RCCG Open Heavens Parish',
  `church_address` text,
  `church_phone` varchar(20) DEFAULT NULL,
  `church_email` varchar(100) DEFAULT NULL,
  `bank_name` varchar(100) DEFAULT NULL,
  `account_name` varchar(200) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `facebook_url` varchar(255) DEFAULT NULL,
  `twitter_url` varchar(255) DEFAULT NULL,
  `instagram_url` varchar(255) DEFAULT NULL,
  `youtube_url` varchar(255) DEFAULT NULL,
  `logo_url` varchar(255) DEFAULT NULL,
  `favicon_url` varchar(255) DEFAULT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `updated_by` (`updated_by`),
  FOREIGN KEY (`updated_by`) REFERENCES `admin_users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user (username: admin, password: Admin@123)
INSERT INTO `admin_users` (`username`, `email`, `password`, `full_name`, `role`, `status`) VALUES
('admin', 'admin@openheavens.org', 'Admin@123', 'System Administrator', 'super_admin', 'active');

-- Insert default church settings
INSERT INTO `church_settings` (`church_name`, `church_address`, `church_phone`, `church_email`, `bank_name`, `account_name`, `account_number`) VALUES
('RCCG Open Heavens Parish', 'Port Harcourt, Rivers State, Nigeria', '+234 XXX XXX XXXX', 'info@openheavens.org', 'First Bank of Nigeria', 'RCCG Open Heavens Parish', '1234567890');

-- Insert sample events
INSERT INTO `events` (`title`, `description`, `start_date`, `end_date`, `location`, `entry_type`, `status`, `created_by`) VALUES
('Sunday Worship Service', 'Join us for a powerful time of worship and the Word', '2025-10-12 09:30:00', '2025-10-12 11:30:00', 'RCCG Open Heavens Parish', 'free', 'upcoming', 1),
('Prayer Meeting', 'Corporate prayer meeting - Seeking God together', '2025-10-15 18:00:00', '2025-10-15 20:00:00', 'RCCG Open Heavens Parish', 'free', 'upcoming', 1),
('Bible Study', 'Weekly Bible study and fellowship', '2025-10-17 19:00:00', '2025-10-17 21:00:00', 'RCCG Open Heavens Parish', 'free', 'upcoming', 1);

-- Insert sample sermons
INSERT INTO `sermons` (`title`, `description`, `pastor`, `sermon_date`, `category`, `scripture_reference`, `status`, `created_by`) VALUES
('Walking in Divine Purpose', 'Discover and fulfill your God-given purpose', 'Pastor Emmanuel Adeyemi', '2025-10-06', 'Purpose', 'Jeremiah 29:11', 'published', 1),
('The Power of Prayer', 'Understanding the importance of prayer in the believers life', 'Pastor Emmanuel Adeyemi', '2025-09-29', 'Prayer', 'Matthew 6:9-13', 'published', 1),
('Faith That Moves Mountains', 'Building unshakeable faith in God', 'Pastor Emmanuel Adeyemi', '2025-09-22', 'Faith', 'Matthew 17:20', 'published', 1);
