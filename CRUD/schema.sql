-- Database: crud
CREATE DATABASE IF NOT EXISTS `crud`;
USE `crud`;

-- Table structure for table `tasks`
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(288) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `create_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `update_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Optional: Initial data for testing
INSERT INTO `tasks` (`id`, `title`, `description`) VALUES
(1, 'learning php from scratch', 'learn the complete basic of php from scartch'),
(2, 'learn bootstrap 5', 'learn how to create responsive website using BS5');
