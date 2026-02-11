-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 11, 2026 at 07:00 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `temple`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'Admin', 'admin@gmail.com', '7c4a8d09ca3762af61e59520943dc26494f8941b');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `question` text DEFAULT NULL,
  `answer` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `status`, `created_at`, `question`, `answer`) VALUES
(1, 1, '2025-11-19 17:57:35', 'Q1. Who is the best Pain, Musculoskeletal & Rehabilitation Specialist in Jaipur?', '<p>Dr. Aayushi Choudhary is a highly qualified Pain and Rehabilitation Specialist in Jaipur, known for her advanced non-surgical treatments for chronic pain, sports injuries, arthritis, cervical and neck pain.</p>\r\n'),
(2, 1, '2025-11-19 17:58:13', 'Q2. Which doctor is best for cervical pain in Jaipur?', '<p>For cervical pain and related spine issues, Dr. Aayushi Choudhary is one of the best doctors in Jaipur. She provides USG-guided therapies, modern physiotherapy, and personalized rehab plans for long-term relief.</p>\r\n'),
(3, 1, '2025-11-19 17:58:38', 'Q3. Who is the best doctor for sports injuries in Jaipur?', '<p>Dr. Aayushi Choudhary specializes in treating sports injuries like ligament tears, muscle strain, and joint pain using advanced rehabilitation and ultrasound-guided treatments, ensuring faster recovery.</p>\r\n'),
(4, 1, '2025-11-19 17:59:09', 'Q4. Which is the best clinic for arthritis treatment in Jaipur?', '<p>If you are suffering from arthritis or joint stiffness, Dr. Aayushi Choudhary offers expert arthritis management with holistic, non-surgical methods to improve mobility and reduce pain.</p>\r\n'),
(5, 1, '2025-11-19 18:07:43', 'Q5. Can neck pain be treated without surgery?', '<p>Yes, in most cases. Dr. Aayushi Choudhary uses non-surgical methods such as guided therapies, posture correction, and rehabilitation to treat chronic neck pain effectively.</p>\r\n'),
(6, 1, '2025-11-19 18:08:30', 'Q6. Why choose Dr. Aayushi Choudhary for pain treatment in Jaipur?', '<p>With MBBS, MD (PMR), and international training in musculoskeletal ultrasound, Dr. Aayushi provides safe, effective, and evidence-based treatments that focus on long-term relief without unnecessary surgeries.</p>\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `form`
--

CREATE TABLE `form` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `slug` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `phone` text DEFAULT NULL,
  `message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `form`
--

INSERT INTO `form` (`id`, `status`, `slug`, `created_at`, `name`, `email`, `phone`, `message`) VALUES
(1, 1, NULL, '2025-11-12 19:09:57', 'Vishwas Moorjani', 'vishwas.gdigital@gmail.com', '9549060381', 'test'),
(2, 1, NULL, '2025-11-12 19:09:59', 'Vishwas Moorjani', 'vishwas.gdigital@gmail.com', '9549060381', 'test'),
(3, 1, NULL, '2025-11-12 19:10:22', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `status`, `created_at`, `image`) VALUES
(1, 1, '2025-11-19 12:11:19', 'gallery11.jpg'),
(2, 1, '2025-11-19 12:11:24', 'gallery21.jpg'),
(3, 1, '2025-11-19 12:11:26', 'gallery31.jpg'),
(4, 1, '2025-11-19 12:11:30', 'gallery41.jpg'),
(5, 1, '2025-11-19 12:11:34', 'gallery51.jpg'),
(6, 1, '2025-11-19 12:11:38', 'gallery61.jpg'),
(7, 1, '2025-11-19 12:11:41', 'gallery71.jpg'),
(8, 1, '2025-11-19 12:11:43', 'gallery81.jpg'),
(9, 1, '2025-11-19 12:11:46', 'gallery91.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `global`
--

CREATE TABLE `global` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `global`
--

INSERT INTO `global` (`id`, `name`, `value`, `status`) VALUES
(1, 'headerlogo', 'tmc-logo.png', 1),
(2, 'footerlogo', 'tmc-logo.png', 1),
(3, 'footercontent', 'At Dazzle Events, we believe that every event is not just an occasion but a story waiting to be told — and we make sure it’s told in the most spectacular way.', 1),
(4, 'address', '26, S.B. Vihar, Swej Farm,\r\nCivil line Zone, Jaipur - 302019', 1),
(5, 'mobile', '+91 9090757585', 1),
(6, 'email', 'info@purpleheronhospitals.com', 1),
(7, 'topdata', '', 1),
(8, 'facebook', '', 1),
(9, 'twitter', '', 1),
(10, 'instagram', '', 1),
(11, 'youtube', '', 1),
(12, 'whatsapp', '+91 9090757585', 1),
(13, 'youtubevideo', 'BnMmVj_U8Q4', 1),
(14, 'mobile2', '+91 9090757585', 1),
(15, 'banner_title', '', 1),
(16, 'banner_content', '', 1),
(17, 'experience', '15', 1),
(18, 'satisfied_customer', '2000', 1),
(19, 'success', '95', 1),
(20, 'team', '200', 1),
(21, 'gmblink', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `hash` varchar(64) DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `fields` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `hash`, `name`, `table_name`, `fields`, `created_at`) VALUES
(6, 'd48dd1a26', 'Sliders', 'slider', '[{\"name\":\"image\",\"type\":\"file\",\"label\":\"Image\"}]', '2025-11-10 11:35:23'),
(7, '00f8e58f7', 'Services', 'services', '[{\"name\":\"name\",\"type\":\"text\",\"label\":\"Name\"},{\"name\":\"description\",\"type\":\"textarea\",\"label\":\"Description\"},{\"name\":\"image\",\"type\":\"file\",\"label\":\"Image\"},{\"name\":\"slug\",\"type\":\"text\",\"label\":\"Slug\"},{\"name\":\"bottom\",\"type\":\"textarea\",\"label\":\"Bottom Description\"},{\"name\":\"whychoose\",\"type\":\"textarea\",\"label\":\"Why Choose\"}]', '2025-11-12 15:09:29'),
(13, '00e6490cd', 'Pages', 'pages', '[{\"name\":\"title\",\"type\":\"text\",\"label\":\"Title\"},{\"name\":\"heading\",\"type\":\"text\",\"label\":\"Heading\"},{\"name\":\"description\",\"type\":\"textarea\",\"label\":\"Description\"},{\"name\":\"image\",\"type\":\"file\",\"label\":\"Image\"},{\"name\":\"slug\",\"type\":\"text\",\"label\":\"Slug\"}]', '2025-11-12 18:11:12'),
(14, 'a687256ce', 'Contact Form', 'form', '[{\"name\":\"name\",\"type\":\"text\",\"label\":\"Name\",\"relation_module\":\"\",\"relation_field\":\"\"},{\"name\":\"email\",\"type\":\"text\",\"label\":\"Email\",\"relation_module\":\"\",\"relation_field\":\"\"},{\"name\":\"phone\",\"type\":\"text\",\"label\":\"Phone No\",\"relation_module\":\"\",\"relation_field\":\"\"},{\"name\":\"message\",\"type\":\"textarea\",\"label\":\"Message\",\"relation_module\":\"\",\"relation_field\":\"\"}]', '2025-11-12 19:01:51'),
(16, 'ccedce13g', 'Videos', 'videos', '[{\"name\":\"video_id\",\"type\":\"text\",\"label\":\"Video Id\",\"relation_module\":\"\",\"relation_field\":\"\"}]', '2025-11-14 15:19:26'),
(22, '14b0b78dm', 'Gallery', 'gallery', '[{\"name\":\"image\",\"type\":\"file\",\"label\":\"Image\",\"relation_module\":\"\",\"relation_field\":\"\"}]', '2025-11-19 16:41:06'),
(25, '25e2e293p', 'Faqs', 'faqs', '[{\"name\":\"question\",\"type\":\"text\",\"label\":\"Question\",\"relation_module\":\"\",\"relation_field\":\"\"},{\"name\":\"answer\",\"type\":\"textarea\",\"label\":\"Answer\",\"relation_module\":\"\",\"relation_field\":\"\"}]', '2025-11-19 17:56:56');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `slug` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `title` text DEFAULT NULL,
  `heading` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `status`, `slug`, `created_at`, `title`, `heading`, `description`, `image1`, `image2`, `image`) VALUES
(1, 1, 'home', '2025-11-12 18:14:53', 'Home', 'Dr. Aayushi Choudhary', '<p><strong>MBBS, MD PMR(Pain Musculoskeletal Medicine &amp; Rehabilitation Specialist)</strong></p>\r\n\r\n<p><strong>Fellowship in Interventional Pain Management (FIPM)</strong></p>\r\n\r\n<p><strong>MSK USG (USPRM) Lisbon Portugal, President Award 2022 (ESPRM)</strong></p>\r\n\r\n<p>Her commitment to academic and clinical excellence was recognized when she graduated as a Gold Medalist in MD PMR, underscoring her expertise and leadership in her field.</p>\r\n', '1763123424_about-image.png', 'about/about-s-1-1.png', '1763548951_draayushinew2.png'),
(3, 1, 'about', '2025-11-19 16:13:17', 'About', 'Dr’s Aayushi Choudhary', '<h4>A Pioneer in Musculoskeletal Medicine and Holistic Care</h4>\r\n\r\n<p>Dr. Aayushi Choudhary&#39;s professional journey is marked by her dedication to improving patient outcomes through holistic, patient-centered care, with a particular focus on minimally invasive interventions in musculoskeletal medicine. Her expertise encompasses a wide range of areas, including musculoskeletal pain, comprehensive rehabilitation, and lifestyle integration into healthcare. Dr. Choudhary advocates for addressing the root causes of pain and dysfunction through early intervention and the integration of lifestyle modifications, ensuring that patients receive personalized care that not only alleviates symptoms but also promotes long-term health and well-being.<br />\r\n<br />\r\nA key element of Dr. Choudhary&#39;s approach is the use of advanced, minimally invasive techniques to treat musculoskeletal conditions. By focusing on image-guided interventions and cutting-edge therapies, she helps patients avoid unnecessary surgeries, managing conditions effectively with less risk and quicker recovery times. This approach is especially important in addressing lifestyle-related issues, where early intervention can prevent the progression of conditions that might otherwise require more invasive treatments.</p>\r\n\r\n<h4>Leadership in Shaping the Future of Healthcare</h4>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>As a thought leader in musculoskeletal medicine and holistic care, Dr. Aayushi Choudhary is poised to lead the transformation of healthcare in India. Her vision for the future involves integrating early interventions, lifestyle modifications, and comprehensive care into standard medical practice, ensuring that patients receive the most effective treatments from the outset. Dr. Choudhary&#39;s leadership is characterized by her ability to see the bigger picture&mdash;how each element of patient care, from diagnosis to treatment to long-term management, interconnects to create a comprehensive approach to health and well-being.<br />\r\n<br />\r\nAt Purple Heron Hospital, Dr. Choudhary has implemented her vision by establishing a culture that emphasizes the four-hour approach: Regeneration, Reconstruction, Rehabilitation, and Research. This approach simplifies medical science and ensures that patients receive holistic care tailored to their individual needs. Purple Heron Hospital is not just a center for rehabilitation but a comprehensive facility where cutting-edge interventions and personalized care come together to offer the best outcomes for patients with musculoskeletal and pain-related conditions. Dr. Choudhary&#39;s influence extends beyond the clinical setting. She is actively involved in promoting the integration of lifestyle considerations into healthcare practices across India. By advocating for early intervention, minimal invasiveness, and comprehensive care, she is helping to shape a future where healthcare is more effective, patient-centered, and focused on long-term well-being.</p>\r\n', NULL, NULL, '1763548997_aboutimg.jpg'),
(4, 1, 'whychoose', '2025-11-19 16:14:04', 'Why Choose Us', 'Why Choose Dr. Aayushi Choudhary and Purple Heron Hospital?', '<p>Dr. Aayushi Choudhary, a gold medalist in MD PMR and an internationally recognized specialist, has saved over 1,000 patients from unnecessary surgeries through her holistic and patient-centered approach. Her protocols do not just treat symptoms; they address the underlying causes of pain and dysfunction, offering patients long-term recovery and preventing future issues.</p>\r\n\r\n<p>Choosing Dr. Aayushi Choudhary and&nbsp;<a href=\"https://www.purpleheronhospitals.com/\">Purple Heron Hospital</a>&nbsp;means choosing a team that is dedicated to your overall well-being. We believe in empowering patients with knowledge, guiding them through every step of their healing journey, and providing care that is both innovative and compassionate. While we prioritize early intervention, regeneration, and rehabilitation, we also excel in surgical reconstruction when it is necessary, ensuring that patients receive the most appropriate and effective treatment for their needs.</p>\r\n\r\n<p>In summary, the approach of minimum interventions and comprehensive rehabilitation is not just about avoiding surgery; it&rsquo;s about choosing the best path to recovery. By selecting this approach and entrusting your care to experts like Dr. Aayushi Choudhary at Purple Heron Hospital, you are making an informed decision to prioritize your health in the most holistic and effective way possible. Early intervention and a balanced approach to treatment can make all the difference in achieving lasting wellness and avoiding unnecessary surgeries.</p>\r\n', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `slug` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `name` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` text DEFAULT NULL,
  `bottom` text DEFAULT NULL,
  `whychoose` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `slider`
--

CREATE TABLE `slider` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `slug` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `heading` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `slider`
--

INSERT INTO `slider` (`id`, `status`, `slug`, `created_at`, `heading`, `description`, `image`) VALUES
(5, 1, NULL, '2025-11-19 11:38:32', NULL, NULL, 'newbanner51.jpg'),
(6, 1, NULL, '2025-11-19 11:38:33', NULL, NULL, 'newbanner61.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `videos`
--

CREATE TABLE `videos` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `video_id` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `videos`
--

INSERT INTO `videos` (`id`, `status`, `created_at`, `video_id`) VALUES
(5, 1, '2025-11-19 16:43:15', 'QMe8QSga4r8'),
(6, 1, '2025-11-19 16:43:24', 'rNL5Vx18y-w'),
(7, 1, '2025-11-19 16:43:29', 'ObwHYeUFMnE'),
(8, 1, '2025-11-19 16:43:33', 'jOa6lD6CW2g'),
(9, 1, '2025-11-19 16:43:38', '5nUzW55EtZc'),
(10, 1, '2025-11-19 16:43:43', 'pLdfY4W8x1k'),
(11, 1, '2025-11-19 16:43:47', '2jx8UBzxtKY');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `form`
--
ALTER TABLE `form`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `global`
--
ALTER TABLE `global`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `videos`
--
ALTER TABLE `videos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `form`
--
ALTER TABLE `form`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `global`
--
ALTER TABLE `global`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `videos`
--
ALTER TABLE `videos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
