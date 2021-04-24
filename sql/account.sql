CREATE TABLE `account` (
    `user_id` int AUTO_INCREMENT,
    `username` varchar(255) NOT NULL,
    `FirstName` varchar(255) NOT NULL,
    `LastName` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `birthday` date NOT NULL,
    `img_profile` varchar(255),
    `acc_status` enum('pending','accept','cancel') DEFAULT 'pending',
    `level` enum('member', 'admin') DEFAULT 'member',
    `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(`user_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;