GRANT ALL PRIVILEGES ON *.* TO 'dbuser'@'localhost' IDENTIFIED BY 'dbpassword';
CREATE DATABASE security;
USE security;

CREATE TABLE `alert` (
  `id` int(10) UNSIGNED NOT NULL,
  `email_server` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `email_port` int(10) DEFAULT NULL,
  `email_login` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `email_password` varchar(50) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
CREATE TABLE `sensors` (
  `id` int(10) UNSIGNED NOT NULL,
  `sensor_name` varchar(40) COLLATE utf8_bin DEFAULT NULL,
  `sensor_type` varchar(10) COLLATE utf8_bin NOT NULL,
  `sensor_pin` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `sensors`
--

INSERT INTO `sensors` (`id`, `sensor_name`, `sensor_type`, `sensor_pin`) VALUES
(1, 'Main Hall', 'Motion', 12),
(2, 'Downstairs', 'temp', 4),
(3, 'Main Door', 'Intrusion', 7),
(4, 'Upstairs', 'Fire', 17);
CREATE TABLE `status` (
  `id` int(10) UNSIGNED NOT NULL,
  `status` varchar(30) NOT NULL,
  `silent` varchar(5) DEFAULT NULL,
  `set_by` varchar(50) NOT NULL,
  `set_date` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id`, `status`, `silent`, `set_by`, `set_date`) VALUES
(1, 'Unset', 'no', 'System Admin', '24/05/2023 11:33');
CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(50) COLLATE utf8_bin DEFAULT NULL,
  `access_level` varchar(11) COLLATE utf8_bin DEFAULT NULL,
  `created_at` varchar(25) COLLATE utf8_bin DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `phone`, `email`, `password`, `access_level`, `created_at`) VALUES
(1, 'admin', 'System Admin', '0873281888', 'mariusares@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'admin', '17/05/2023');

ALTER TABLE `alert`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sensors`
--
ALTER TABLE `sensors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `alert`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `sensors`
--
ALTER TABLE `sensors`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
