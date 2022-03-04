CREATE TABLE `social_network`.`comment` (
    `comment_id` INT NOT NULL AUTO_INCREMENT,
    `comment_text` VARCHAR(255) NULL DEFAULT NULL,
    `post_id` INT NULL DEFAULT NULL,
    `user_id` INT NULL DEFAULT NULL,
    PRIMARY KEY (`comment_id`)
) ENGINE = InnoDB;