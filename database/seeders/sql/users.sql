INSERT INTO `users` (`id`, `username`, `email`, `password`, `phone`, `name`, `role_id`, `image`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$12$OobmkunD5s3o816b7qciKukG8JPZ3HpUvKahw8tqAooeu1XQX92iC', '0987654321', 'Thịnh Nguyễn', -1, 'common/image/user-default.jpg', NULL, NULL, NULL, NULL),
(2, 'htx1', 'htx1@gmail.com', '$2y$12$380jZTDIpXhboYSGF5k6uOjZyuQByBOtb8hIAg1LPrYtqUeX4aAqS', '0869555754', 'Trần Mỹ Linh', 1, 'common/image/user-default.jpg', NULL, NULL, NULL, NULL),
(3, 'htx2', 'htx2@gmail.com', '$2y$12$Y3NLEix6vCFILEvZZFxqGuTGt9g1eOs5IMOKhpYQoCLJsnVFi6RZW', '0869555754', 'Trần Mỹ Linh', 1, 'common/image/user-default.jpg', NULL, NULL, NULL, NULL),
(4, 'htx3', 'htx3@gmail.com', '$2y$12$t4qToAcipItDTFOtHnIaXeSgo3s2/AvmVg4otMal7ZzKTF2hHLfCK', '0869555754', 'Trần Mỹ Linh', 1, 'common/image/user-default.jpg', NULL, NULL, NULL, NULL),
(5, 'htx4', 'htx4@gmail.com', '$2y$12$/NcVktDvdSpnzQ0D/2jQKOHFoREd7tT6TkxoBtibma0ZVbj4D50gG', '0869555754', 'Trần Mỹ Linh', 1, 'common/image/user-default.jpg', NULL, NULL, NULL, NULL),
(6, 'htx5', 'htx5@gmail.com', '$2y$12$ZOdP0RyybktzC/jq0hAiH.NiKeKtxn7LEvMCSCt9bcPYUnSvDTJpS', '0869555754', 'Trần Mỹ Linh', 1, 'common/image/user-default.jpg', NULL, NULL, NULL, NULL);

INSERT INTO `shippings` (`id`, `user_id`, `default`, `name`, `phone`, `provinceId`, `districtId`, `wardsId`, `address`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'Trần Mỹ Linh', '0869555754', 1, 1, 1, 'số 1', '2024-05-26 07:59:26', '2024-05-26 07:59:26'),
(2, 3, 1, 'Trần Mỹ Linh', '0869555754', 1, 1, 1, '1', '2024-05-26 08:25:13', '2024-05-26 08:25:13'),
(3, 4, 1, 'Trần Mỹ Linh', '0869555754', 2, 32, 589, 'số 21', '2024-05-26 08:32:47', '2024-05-26 08:32:47'),
(4, 5, 1, 'Trần Mỹ Linh', '0869555754', 1, 1, 1, '1', '2024-05-26 08:25:13', '2024-05-26 08:25:13'),
(5, 6, 1, 'Trần Mỹ Linh', '0869555754', 1, 1, 1, '1', '2024-05-26 08:25:13', '2024-05-26 08:25:13');
