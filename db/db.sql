CREATE TABLE `user` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(80) NULL,
    `password` VARCHAR(80) NOT NULL,
    `firstname` VARCHAR(80) NOT NULL,
    `lastname` VARCHAR(80) NOT NULL,
    `profile` VARCHAR(80) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;
CREATE TABLE `post` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `text` VARCHAR(80) NOT NULL,
    `image` VARCHAR(80) NOT NULL,
    `u_id` INT NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;