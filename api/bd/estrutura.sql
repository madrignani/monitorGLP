DROP DATABASE IF EXISTS `monitor_glp`;

CREATE DATABASE IF NOT EXISTS `monitor_glp` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE `monitor_glp`;

CREATE TABLE `ultimas_leituras` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `valor` INT NOT NULL,
  `data_hora` DATETIME NOT NULL,
  `statusLeitura` ENUM('NIVEL_NORMAL','NIVEL_PERIGOSO') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;