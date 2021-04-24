CREATE TABLE `friendrelation` (
    `AreFriend` enum('True', 'False') DEFAULT 'False',
    `user_id_1` int NOT NULL,
    `user_id_2` int NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8;