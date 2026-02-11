-- Drop previous community tables to rebuild for V3 (Cloning Target)
DROP TABLE IF EXISTS `com_application_docs`;
DROP TABLE IF EXISTS `com_applications`;
DROP TABLE IF EXISTS `com_donations`;
DROP TABLE IF EXISTS `com_donation_causes`;
DROP TABLE IF EXISTS `com_business_listings`;
DROP TABLE IF EXISTS `com_business_categories`;
DROP TABLE IF EXISTS `com_family_members`;
DROP TABLE IF EXISTS `com_post_media`;
DROP TABLE IF EXISTS `com_posts`;
DROP TABLE IF EXISTS `com_categories`; -- Re-creating as com_business_categories mostly, but keeping generic if needed.
DROP TABLE IF EXISTS `com_members`;

-- 1. Core Members (Enhanced for Community Profile)
CREATE TABLE `com_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `membership_no` varchar(50) UNIQUE DEFAULT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150),
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dob` date DEFAULT NULL,
  `gotra` varchar(100) DEFAULT NULL,
  `marital_status` enum('Single','Married','Widowed') DEFAULT 'Single',
  `spouse_name` varchar(150) DEFAULT NULL,
  `address` text,
  `city` varchar(100),
  `pincode` varchar(10),
  `profile_image` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT 1 COMMENT '1=Active, 0=Banned',
  `is_deleted` tinyint(1) DEFAULT 0,
  `deleted_at` datetime DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Family Members
CREATE TABLE `com_family_members` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `relation` enum('Spouse','Son','Daughter','Father','Mother','Brother','Sister','Other') NOT NULL,
  `dob` date DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`member_id`) REFERENCES `com_members`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Business Directory
CREATE TABLE `com_business_categories` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `status` tinyint(1) DEFAULT 1,
    `is_deleted` tinyint(1) DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `com_business_listings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `business_name` varchar(200) NOT NULL,
  `category_id` int(11) NOT NULL,
  `description` text,
  `address` text,
  `contact_person` varchar(100),
  `contact_phone` varchar(20),
  `website` varchar(255),
  `logo` varchar(255),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejection_reason` varchar(255) DEFAULT NULL,

  `is_deleted` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`member_id`) REFERENCES `com_members`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Donations & Payments
CREATE TABLE `com_donation_causes` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL, -- e.g. "General Fund", "Medical Relief"
    `status` tinyint(1) DEFAULT 1,
    `is_deleted` tinyint(1) DEFAULT 0,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `com_donations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `donor_name` varchar(150) NOT NULL, 
  `member_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `cause_id` int(11) NOT NULL,
  `payment_mode` enum('Online','Cash','Cheque','UPI') NOT NULL,
  `transaction_ref` varchar(100) DEFAULT NULL,
  `payment_status` enum('pending','success','failed') DEFAULT 'pending',
  `receipt_no` varchar(50) DEFAULT NULL,
  `is_80g_eligible` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Assistance Applications
CREATE TABLE `com_applications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `type` enum('Medical','Education','Pension') NOT NULL,
  `amount_requested` decimal(10,2) DEFAULT NULL,
  `description` text,
  `status` enum('submitted','under_review','approved','rejected','disbursed') DEFAULT 'submitted',
  
  -- Audit
  `reviewed_by` int(11) DEFAULT NULL,
  `reviewed_at` datetime DEFAULT NULL,
  `rejection_reason` text,
  
  `is_deleted` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`member_id`) REFERENCES `com_members`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `com_application_docs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_id` int(11) NOT NULL,
  `doc_type` varchar(50) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`application_id`) REFERENCES `com_applications`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Re-create generic Post categories if needed for "News" section of the site
CREATE TABLE `com_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `icon` varchar(50) DEFAULT 'fas fa-newspaper',
  `status` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 7. Re-create Posts for "News/Events"
CREATE TABLE `com_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL, -- Added Title for News
  `content` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  
  `approved_by` int(11) DEFAULT NULL,
  `approved_at` datetime DEFAULT NULL,
  `rejected_by` int(11) DEFAULT NULL,
  `rejected_at` datetime DEFAULT NULL,
  `rejection_reason` varchar(255) DEFAULT NULL,
  
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `com_post_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(50) DEFAULT 'image',
  `sort_order` int(11) DEFAULT 0,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  FOREIGN KEY (`post_id`) REFERENCES `com_posts`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
