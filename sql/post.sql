CREATE TABLE `post` (
    `post_id` int AUTO_INCREMENT,
    `post_message` TEXT,
    `post_img` varchar(255),
    `user_id` int NOT NULL,
    `create_time` datetime DEFAULT current_TIMESTAMP,
    PRIMARY KEY(`post_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;