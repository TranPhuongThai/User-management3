--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_code`, `full_name`, `email`, `password`, `role_id`, `status`, `confirmation`, `confirm_expired_time`, `created`, `modified`) VALUES
(1, 'USER1', 'Thai', 'thai@gmail.com', '$2y$10$OxHdLLylmdoy/7Bgo1XPR.YNSfOSt8UU/Li4gAyjlUm67k3M7QRyW', 1, 1, NULL, NULL, NULL, NULL),
(2, 'USER2', 'Thai', 'tha2i@gmail.com', '$2y$10$OxHdLLylmdoy/7Bgo1XPR.YNSfOSt8UU/Li4gAyjlUm67k3M7QRyW', 2, 1, NULL, NULL, NULL, NULL);

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `allow_action_ids`, `status`, `created`, `modified`) VALUES
(0, 'default', '', 1, '2019-05-24 11:48:30', '2019-05-24 11:48:30'),
(1, 'admin', 'all', 1, NULL, NULL),
(2, 'manager', '1,2,3,4,6', 1, '2019-05-24 11:47:50', '2019-05-24 11:47:26');

--
-- Dumping data for table `permissions`
--
INSERT INTO `permissions` (`id`, `name`, `controller`, `status`, `created`, `modified`) VALUES
(1, 'add', 'Users', 1, '2019-05-21 10:21:07', NULL),
(2, 'delete', 'Users', 1, '2019-05-21 12:06:02', NULL),
(3, 'update', 'Users', 1, '2019-05-21 12:06:03', NULL),
(4, 'view', 'Users', 1, '2019-05-21 12:06:05', NULL),
(5, 'register', 'Users', 1, '2019-05-21 12:06:06', NULL),
(6, 'viewDetail', 'Users', 1, '2019-05-24 06:28:07', NULL),
(7, 'add', 'Roles', 1, '2019-05-24 06:27:59', NULL),
(8, 'delete', 'Roles', 1, '2019-05-24 06:27:55', NULL),
(9, 'update', 'Roles', 1, '2019-05-24 06:27:53', NULL),
(10, 'view', 'Roles', 1, '2019-05-24 06:27:50', NULL),
(11, 'viewDetail', 'Roles', 1, '2019-05-24 06:30:52', NULL),
(12, 'add', 'Permissions', 1, '2019-05-24 06:30:41', NULL),
(13, 'delete', 'Permissions', 1, '2019-05-24 06:30:36', NULL),
(14, 'update', 'Permissions', 1, '2019-05-24 06:30:34', NULL),
(15, 'view', 'Permissions', 1, '2019-05-24 06:30:30', NULL),
(16, 'viewDetail', 'Permissions', 1, '2019-05-24 06:30:54', NULL);