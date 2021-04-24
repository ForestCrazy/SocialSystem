CREATE TABLE `comment` (
    `cm_id` int AUTO_INCREMENT,
    `cm_message` TEXT NOT NULL,
    `user_id` int NOT NULL,
    `post_id` int NOT NULL,
    `create_time` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(`cm_id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;