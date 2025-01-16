CREATE TABLE `users` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_general_ci',
	`lastname` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_general_ci',
	`address` VARCHAR(255) NOT NULL COLLATE 'utf8mb4_general_ci',
	`email` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_general_ci',
	PRIMARY KEY (`id`) USING BTREE,
	UNIQUE INDEX `email` (`email`) USING BTREE
)
COMMENT='tabla de usuarios'
COLLATE='utf8mb4_general_ci'
ENGINE=InnoDB
AUTO_INCREMENT=2
;