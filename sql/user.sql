CREATE TABLE `social_network`.`user` (
    `user_id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(255) NULL DEFAULT NULL,
    `firstname` VARCHAR(255) NULL DEFAULT NULL,
    `lastname` VARCHAR(255) NULL DEFAULT NULL,
    `password` VARCHAR(256) NULL DEFAULT NULL,
    `img` VARCHAR(255) NULL DEFAULT NULL,
    `gender` ENUM('male', 'female') NULL DEFAULT NULL,
    PRIMARY KEY (`user_id`)
) ENGINE = InnoDB;