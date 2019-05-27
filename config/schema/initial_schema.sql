--
-- Table structure for table `permissions`
--
CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `controller` varchar(30) NOT NULL,
  `status` tinyint(2) DEFAULT '0',
  `created` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `roles`
--
CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `allow_action_ids` text,
  `status` tinyint(2) DEFAULT '0',
  `created` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Table structure for table `users`
--
CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `user_code` varchar(50) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `confirmation` varchar(100) DEFAULT NULL,
  `confirm_expired_time` timestamp NULL DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  `modified` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;