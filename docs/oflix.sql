-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20230818124146',	'2023-08-18 14:44:30',	31),
('DoctrineMigrations\\Version20230820204211',	'2023-08-20 22:42:20',	49),
('DoctrineMigrations\\Version20230820210427',	'2023-08-20 23:04:40',	51),
('DoctrineMigrations\\Version20230821115135',	'2023-08-21 13:51:50',	49),
('DoctrineMigrations\\Version20230821131359',	'2023-08-21 15:14:12',	66),
('DoctrineMigrations\\Version20230822113104',	'2023-08-22 13:31:09',	32),
('DoctrineMigrations\\Version20230822122900',	'2023-08-22 14:29:13',	105);

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `genre`;
CREATE TABLE `genre` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `genre` (`id`, `name`) VALUES
(1,	'Horreur'),
(2,	'Aventure'),
(3,	'Thriller'),
(4,	'Drame'),
(5,	'Fantastique');

DROP TABLE IF EXISTS `genre_movie`;
CREATE TABLE `genre_movie` (
  `genre_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  PRIMARY KEY (`genre_id`,`movie_id`),
  KEY `IDX_A058EDAA4296D31F` (`genre_id`),
  KEY `IDX_A058EDAA8F93B6FC` (`movie_id`),
  CONSTRAINT `FK_A058EDAA4296D31F` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_A058EDAA8F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `genre_movie` (`genre_id`, `movie_id`) VALUES
(1,	5),
(2,	5),
(3,	4),
(4,	4),
(5,	1);

DROP TABLE IF EXISTS `movie`;
CREATE TABLE `movie` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `release_date` date NOT NULL,
  `duration` int(11) NOT NULL,
  `type` varchar(10) NOT NULL,
  `summary` varchar(200) NOT NULL,
  `synopsis` varchar(5000) NOT NULL,
  `poster` varchar(2083) DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `movie` (`id`, `title`, `release_date`, `duration`, `type`, `summary`, `synopsis`, `poster`, `rating`) VALUES
(1,	'E.T l\'extraterrestre',	'1982-12-16',	115,	'Film',	'Une soucoupe volante atterrit en pleine nuit près de Los Angeles.',	'Une soucoupe volante atterrit en pleine nuit près de Los Angeles. Quelques extraterrestres, envoyés sur Terre en mission d\'exploration botanique, sortent de l\'engin, mais un des leurs s\'aventure au-delà de la clairière où se trouve la navette. Celui-ci se dirige alors vers la ville. C\'est sa première découverte de la civilisation humaine. Bientôt traquée par des militaires et abandonnée par les siens, cette petite créature apeurée se nommant E.T. se réfugie dans une résidence de banlieue.  Elliot, un garçon de dix ans, le découvre et lui construit un abri dans son armoire. Rapprochés par un échange télépathique, les deux êtres ne tardent pas à devenir amis. Aidé par sa soeur Gertie et son frère aîné Michael, Elliot va alors tenter de garder la présence d\'E.T. secrète.',	'https://fr.web.img4.acsta.net/medias/nmedia/00/02/36/52/affet.jpg',	2.3),
(4,	'Stranger Things',	'2018-05-15',	50,	'Serie',	'A Hawkins, en 1983 dans l\'Indiana. Lorsque Will Byers disparaît de son domicile, ses amis se lancent dans une recherche semée d’embûches pour le retrouver.',	'A Hawkins, en 1983 dans l\'Indiana. Lorsque Will Byers disparaît de son domicile, ses amis se lancent dans une recherche semée d’embûches pour le retrouver. Dans leur quête de réponses, les garçons rencontrent une étrange jeune fille en fuite. Les garçons se lient d\'amitié avec la demoiselle tatouée du chiffre \"11\" sur son poignet et au crâne rasé et découvrent petit à petit les détails sur son inquiétante situation. Elle est peut-être la clé de tous les mystères qui se cachent dans cette petite ville en apparence tranquille…',	'https://fr.web.img4.acsta.net/pictures/22/05/18/14/31/5186184.jpg',	3.7),
(5,	'The Walking Dead',	'2018-05-15',	50,	'Serie',	'Après une apocalypse ayant transformé la quasi-totalité de la population en zombies, un groupe d\'hommes et de femmes mené par l\'officier Rick Grimes tente de survivre...',	'Après une apocalypse ayant transformé la quasi-totalité de la population en zombies, un groupe d\'hommes et de femmes mené par l\'officier Rick Grimes tente de survivre... Ensemble, ils vont devoir tant bien que mal faire face à ce nouveau monde devenu méconnaissable, à travers leur périple dans le Sud profond des États-Unis.',	'https://media.senscritique.com/media/000004591491/0/the_walking_dead.jpg',	4.8);

DROP TABLE IF EXISTS `season`;
CREATE TABLE `season` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `movie_id` int(11) NOT NULL,
  `number` smallint(6) NOT NULL,
  `episodes_number` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F0E45BA98F93B6FC` (`movie_id`),
  CONSTRAINT `FK_F0E45BA98F93B6FC` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `season` (`id`, `movie_id`, `number`, `episodes_number`) VALUES
(1,	4,	1,	6),
(2,	4,	2,	7),
(3,	5,	1,	8),
(4,	5,	2,	9);

-- 2023-08-22 12:49:37