-- Adminer 4.8.1 MySQL 10.11.3-MariaDB-1:10.11.3+maria~ubu2004 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `spot_id` int(255) NOT NULL,
  `date` date DEFAULT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526C2DF1D37C` (`spot_id`),
  KEY `IDX_9474526CA76ED395` (`user_id`),
  CONSTRAINT `FK_9474526C5B05007F` FOREIGN KEY (`spot_id`) REFERENCES `spot` (`id`),
  CONSTRAINT `comment_ibfk_5` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `comment` (`id`, `content`, `spot_id`, `date`, `rating`, `user_id`) VALUES
(4,	'On m\'avait recommandée ce spot, je comprends pourquoi maintenant! Il est INCROYABLE!',	1,	'2023-02-12',	5.0,	2),
(7,	'C\'est quoi cette blague lol',	4,	'2024-02-14',	2.0,	2),
(9,	'Là je dis oui!',	5,	'2024-02-14',	5.0,	2),
(10,	'Cété trop cool mème que je suis tombé qu\'une fois et ma maman a dit que GT trop fort!',	1,	'2024-02-01',	4.0,	4),
(12,	'ETOILEU DES NEIIIGEEUUUU PAYS MERVEILLEUUUUX',	13,	'2024-02-05',	5.0,	5),
(13,	'Ils sont toujours en travaux ils abusent pffff',	10,	'2024-01-19',	3.0,	4),
(32,	'Waouuuuh trop fort!!',	15,	'2024-02-22',	5.0,	21),
(33,	'Bof c\'est pas terrible',	12,	'2024-02-22',	2.0,	21);

DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `location` (`id`, `name`, `slug`) VALUES
(1,	'Isola',	'isola'),
(2,	'Vars',	'vars'),
(3,	'La Cluzaz',	'la-cluzaz'),
(4,	'Paris',	'paris'),
(5,	'Nantes',	'nantes'),
(6,	'Bordeaux',	'bordeaux'),
(7,	'Le Havre',	'le-havre'),
(8,	'Nancy',	'nancy'),
(9,	'Strasbourg',	'strasbourg'),
(10,	'Lyon',	'lyon'),
(11,	'Les 2 Alpes',	'les-2-alpes'),
(12,	'Serre-Chevalier',	'serre-chevalier'),
(13,	'Le Grand Bornand',	'le-grand-bornand'),
(20,	'Angers',	'angers');

DROP TABLE IF EXISTS `picture`;
CREATE TABLE `picture` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `path` varchar(500) NOT NULL,
  `spot_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_16DB4F892DF1D37C` (`spot_id`),
  CONSTRAINT `FK_16DB4F892DF1D37C` FOREIGN KEY (`spot_id`) REFERENCES `spot` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `picture` (`id`, `name`, `path`, `spot_id`) VALUES
(1,	'Isola.jpeg',	'https://isola2000.com/wp-content/uploads/2022/09/pano-cime-1920x960-1-1280x640.jpeg',	1),
(4,	'Bercy.jpg',	'https://cdn.paris.fr/paris/2021/03/17/huge-fe8b8dec36a98d44ea22fadfc2a095d1.jpg',	4),
(5,	'EGP18.jpeg',	'https://media.manawa.com/cache/activity_gallery_zoom_770x500/media/2019/01/99ed4a58c0595a482a40ddb65f406feb.jpeg',	5),
(6,	'Jemmapes.jpg',	'https://skateparks.fr/wp-content/uploads/2020/11/jemmapes-01.jpg',	6),
(7,	'Le_Hangar.jpg',	'https://static.wixstatic.com/media/7680dd_61081cf4a35a45deaa47559601a03e6f~mv2.jpg/v1/fill/w_2500,h_1502,al_c/7680dd_61081cf4a35a45deaa47559601a03e6f~mv2.jpg',	7),
(8,	'HDS.jpg',	'https://media.sudouest.fr/10315559/1200x-1/img-7203-2.jpg',	8),
(9,	'original-filename-70509a0230c75f36.jpg',	'original-filename-70509a0230c75f36.jpg',	9),
(10,	'original-filename-119c817543a7b4aa.jpg',	'original-filename-119c817543a7b4aa.jpg',	10),
(11,	'original-filename-7795cb53a3b16c94.jpg',	'original-filename-7795cb53a3b16c94.jpg',	11),
(12,	'original-filename-f230db3bff26d9ae.jpg',	'original-filename-f230db3bff26d9ae.jpg',	12),
(13,	'2_Alpes.jpg',	'https://reservation.les2alpes.com/medias/images/perrine/snowpark_hiv_paysage_2.jpg',	13),
(14,	'Serre-Chevalier.jpg',	'https://www.skiresort.fr/fileadmin/_processed_/c3/34/42/25/81527b2b3f.jpg',	14),
(15,	'original-filename-d4c4532f08498f7f.jpg',	'original-filename-d4c4532f08498f7f.jpg',	15),
(16,	'original-filename-b43ef5bcc85eed2a.webp',	'original-filename-b43ef5bcc85eed2a.webp',	1),
(19,	'original-filename-772e6bb2903bb730.jpg',	'original-filename-772e6bb2903bb730.jpg',	4),
(20,	'original-filename-b3713e18536d15cd.jpg',	'original-filename-b3713e18536d15cd.jpg',	5),
(21,	'original-filename-7d39a84c549fcd26.jpg',	'original-filename-7d39a84c549fcd26.jpg',	6),
(22,	'original-filename-c9601bfcfd6bc827.jpg',	'original-filename-c9601bfcfd6bc827.jpg',	7),
(23,	'original-filename-4f93350a0c1b6e18.jpg',	'original-filename-4f93350a0c1b6e18.jpg',	8),
(24,	'original-filename-4d2ab59fd67866ce.jpg',	'original-filename-4d2ab59fd67866ce.jpg',	9),
(25,	'original-filename-a49ce7d29606bc93.jpg',	'original-filename-a49ce7d29606bc93.jpg',	10),
(26,	'original-filename-6e79b4ef14e2a874.jpg',	'original-filename-6e79b4ef14e2a874.jpg',	11),
(27,	'original-filename-e4817f22c70d53cd.jpg',	'original-filename-e4817f22c70d53cd.jpg',	12),
(28,	'original-filename-8bcbe0f2a3a8be48.jpg',	'original-filename-8bcbe0f2a3a8be48.jpg',	13),
(29,	'original-filename-fe80ce7a895c5638.jpg',	'original-filename-fe80ce7a895c5638.jpg',	14),
(30,	'original-filename-3b7b98228d6cdb47.jpg',	'original-filename-3b7b98228d6cdb47.jpg',	15),
(31,	'original-filename-dcb5831ca2c32aea.webp',	'original-filename-dcb5831ca2c32aea.webp',	1),
(34,	'original-filename-49b8c8c33bb01169.jpg',	'original-filename-49b8c8c33bb01169.jpg',	4),
(35,	'original-filename-eed8f6de7c7f184d.jpg',	'original-filename-eed8f6de7c7f184d.jpg',	5),
(36,	'original-filename-3d2d89987de14f08.jpg',	'original-filename-3d2d89987de14f08.jpg',	6),
(37,	'original-filename-1bab05fcce476559.jpg',	'original-filename-1bab05fcce476559.jpg',	7),
(38,	'original-filename-2717645a08e87c44.jpg',	'original-filename-2717645a08e87c44.jpg',	8),
(39,	'original-filename-bdd8d57b2936bc4c.jpg',	'original-filename-bdd8d57b2936bc4c.jpg',	9),
(40,	'original-filename-a8f081c85db8e3f9.jpg',	'original-filename-a8f081c85db8e3f9.jpg',	10),
(41,	'original-filename-54fddabd1da9baa3.jpg',	'original-filename-54fddabd1da9baa3.jpg',	11),
(42,	'original-filename-ea0de57b16cf5051.jpg',	'original-filename-ea0de57b16cf5051.jpg',	12),
(43,	'original-filename-25b0c1a1de88a9b7.jpg',	'original-filename-25b0c1a1de88a9b7.jpg',	13),
(44,	'original-filename-a081025c1425b179.jpg',	'original-filename-a081025c1425b179.jpg',	14),
(45,	'original-filename-d458463fb02183b2.jpg',	'original-filename-d458463fb02183b2.jpg',	15);

DROP TABLE IF EXISTS `sport`;
CREATE TABLE `sport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `sport` (`id`, `name`, `slug`) VALUES
(1,	'Skateboard',	'Skateboard'),
(2,	'Snowboard',	'snowboard');

DROP TABLE IF EXISTS `spot`;
CREATE TABLE `spot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `picture` varchar(500) NOT NULL,
  `address` varchar(255) NOT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `location_id` int(11) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B9327A7364D218E` (`location_id`),
  CONSTRAINT `spot_ibfk_1` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `spot` (`id`, `name`, `description`, `picture`, `address`, `rating`, `location_id`, `slug`) VALUES
(1,	'Isola 2000',	'Le snowpark d\'Isola 2000 vous propose une expérience exceptionnelle à 2300 mètres d’altitude sur le secteur Marmotte. Découvrez de nouvelles sensations de glisse tous les jours de 10h à 16h dans cet espace ludique et technique, entretenu quotidiennement pour votre plaisir.',	'https://isola2000.com/wp-content/uploads/2022/09/pano-cime-1920x960-1-1280x640.jpeg',	'Station d\'Isola',	3.0,	1,	'isola-2000'),
(4,	'Bercy',	'3 mois après le début des travaux, le skatepark de Bercy est ré-ouvert. Belle performance quand on se souvient des déboires des travaux de couverture du skatepark Jules Noël. Notre skatepark de bercy est maintenant doté d\'un toit... fini les dimanches pluvieux sans session.',	'https://cdn.paris.fr/paris/2021/03/17/huge-fe8b8dec36a98d44ea22fadfc2a095d1.jpg',	'Rue Raymond Aron, 75012 Paris',	3.0,	4,	'bercy'),
(5,	'EGP18',	'C\'est désormais le plus gros skatepark parisien. Il se compose de parks, de 2  bowls en béton et d\'une fin-box permettant à des patineurs de niveaux variés de rider en indoor pour urface totale de 3545 m².',	'https://media.manawa.com/cache/activity_gallery_zoom_770x500/media/2019/01/99ed4a58c0595a482a40ddb65f406feb.jpeg',	'Imp. des Fillettes, 75018 Paris',	4.5,	4,	'egp18'),
(6,	'Jemmapes',	'Bien connu de la faune locale à roulettes, le skatepark du quai de Jemmapes fait partie des spots parisiens incontournables. Plutôt pas trop mal situé au bord du canal Saint Martin, assez ensoleillé, bien fréquenté en journée, ce petit park de ville aura de quoi vous combler pour démarrer/clôturer votre session entre potos.',	'https://skateparks.fr/wp-content/uploads/2020/11/jemmapes-01.jpg',	'140 quai de Jemmapes, 75010 Paris',	4.0,	4,	'jemmapes'),
(7,	'Le Hangar',	'Un skatepark indoor conçu à partir de matériaux de récupération pour rider proprement sur un florilège de modules : bowl en bois, big ramp, street area… Au Hangar, il y a de quoi faire le plein de sensations ou de frayeurs, ça dépendra de vous.',	'https://static.wixstatic.com/media/7680dd_61081cf4a35a45deaa47559601a03e6f~mv2.jpg/v1/fill/w_2500,h_1502,al_c/7680dd_61081cf4a35a45deaa47559601a03e6f~mv2.jpg',	'9 allée des Vinaigriers - 44300 Nantes',	4.5,	5,	'le-hangar'),
(8,	'Hangar Darwin Skatepark',	'Le skatepark Le Hangar est un skatepark couvert associatif de 5300 m², géré par la Ligue de l\'Enseignement - FAL 44. Accueillant des particuliers et des groupes, il propose des stages, des cours et organise des événements.',	'https://media.sudouest.fr/10315559/1200x-1/img-7203-2.jpg',	'87 Quai des Queyries, 33100 Bordeaux',	4.0,	6,	'hangar-darwin-skatepark'),
(9,	'Skatepark du Havre',	'C\'est le plus grand skatepark gratuit à ciel ouvert en France. Elaboré par des spécialistes, le skatepark a été pensé pour offrir une aire de jeux adaptée se prêtant au mieux à l\'exercice de la glisse. Il peut se vanter d\'offrir une aire de street de 600 m² avec des plans inclinés, mais aussi un bowl de 1200 m², soit une aire totale de 1800 m² pour s\'amuser, quelque soit son niveau ou sa pratique.',	'https://www.normandie-tourisme.fr/wp-content/uploads/wpetourisme/Skate-Park---Le-Havre.jpg',	'27 Boulevard Albert 1er, 76600 Le Havre',	4.5,	7,	'skatepark-du-havre'),
(10,	'Rives de Meurthe',	'Le skatepark des Rives de Meurthe est l\'un des spots de skate les plus populaires de Nancy. Avec ses différentes structures, il offre aux skateurs un lieu idéal pour pratiquer leur sport et développer leur talent.',	'https://numero4skateshop.com/product_images/uploaded_images/skatepark-de-nancy-rives-de-meurthe-n4-skateshop.jpg',	'Av. Charles Etienne Collignon, 54000 Nancy',	3.0,	8,	'rives-de-meurthe'),
(11,	'La Rotonde',	'C\'est l\'un des skateparks les plus réussis de l\'agglomération Strasbourgoise. Il est d\'ailleurs fréquenté par les BMX, skateboards et rollers. Il a été conçu et dessiné par David Mougin, le petit frère de Nicolas Mougin, champion du monde amateur 2003/2004 en rampe.',	'https://numero4skateshop.com/product_images/uploaded_images/strasbourg-skatepark-la-rotonde-n4-skateshop.jpeg',	'Rue Pierre Nuss, 67200 Strasbourg',	0.0,	9,	'la-rotonde'),
(12,	'Sergent Blandan',	'Très typé street (avec quand même deux trois courbes bien raides par ci par là), ce skatepark est rempli de belles idées. Il faudra quand même un bon niveau pour vraiment en profiter.',	'https://skateparks.fr/wp-content/uploads/2020/11/sergent-blandan-skatepark-full.jpg',	'Rue de l\'Epargne, 69007 Lyon',	2.0,	10,	'sergent-blandan'),
(13,	'Les 2 Alpes',	'Station de ski phare du département de l’Isère, Les 2 Alpes jouit d’une réputation internationale. Elle est située au cœur du massif des Ecrins, dans l’Oisans. Avec une neige naturelle garantie grâce au domaine de haute altitude culminant à 3600m, vous avez l’assurance de skier en toute saison.',	'https://reservation.les2alpes.com/medias/images/perrine/snowpark_hiv_paysage_2.jpg',	'Station des Deux Alpes',	5.0,	11,	'les-2-Alpes'),
(14,	'Serre-Chevalier',	'Plus grand domaine skiable des Alpes du Sud, Serre Chevalier est aussi l\'un des plus grands domaines d\'Europe avec ses 3 901 hectares. Débutant ou expert, découvrez tout un domaine XXL, par les forêts de mélèzes ou par les sommets offrant des panoramas de montagne exceptionnels.',	'https://www.skiresort.fr/fileadmin/_processed_/c3/34/42/25/81527b2b3f.jpg',	'Station de Serre-Chevalier',	4.0,	12,	'serre-chevalier'),
(15,	'Le Grand Bornand',	'Cette station propose un domaine skiable préservé dans lequel vous pouvez pratiquer de nombreuses disciplines : ski alpin, ski nordique, biathlon, snowboard, ski de randonnée, raquettes, marche nordique, luge.',	'https://www.barnes-montblanc.com/uploads/sectors/36/hero_pictures/53984/show.jpg?1573573424',	'Station du Grand Bornand',	5.0,	13,	'le-grand-bornand');

DROP TABLE IF EXISTS `spot_sport`;
CREATE TABLE `spot_sport` (
  `spot_id` int(11) NOT NULL,
  `sport_id` int(11) NOT NULL,
  PRIMARY KEY (`spot_id`,`sport_id`),
  KEY `IDX_3EC471FA2DF1D37C` (`spot_id`),
  KEY `IDX_3EC471FAAC78BCF8` (`sport_id`),
  CONSTRAINT `FK_3EC471FA2DF1D37C` FOREIGN KEY (`spot_id`) REFERENCES `spot` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_3EC471FAAC78BCF8` FOREIGN KEY (`sport_id`) REFERENCES `sport` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `spot_sport` (`spot_id`, `sport_id`) VALUES
(1,	2),
(4,	1),
(6,	1),
(7,	1),
(8,	1),
(9,	1),
(10,	1),
(11,	1),
(12,	1),
(13,	2),
(14,	2),
(15,	2);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(180) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `profilpicture` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `email`, `pseudo`, `firstname`, `lastname`, `password`, `roles`, `profilpicture`) VALUES
(1,	'admin@admin.fr',	'admin',	NULL,	NULL,	'$2y$13$zIblErlPHb.rtUvS3M.v6Os3rneQT5KDrA1pAXvkz4bpTKysytL2m',	'[\"ROLE_ADMIN\"]',	'https://i.postimg.cc/BZB7NG5J/default-profile.png'),
(2,	'rider@user.fr',	'rider',	NULL,	NULL,	'$2y$13$GE9o.xomhmJX.fNeyAb5zekh4gynBhUwehnb7vvp99HbMvdWoT5..',	'[\"ROLE_USER\"]',	'https://i.postimg.cc/BZB7NG5J/default-profile.png'),
(4,	'mhysa@user.fr',	'roidelaglisse96',	NULL,	NULL,	'$2y$10$qHyHiHEg623V7DxzXoYmOObyMwalCqMl3aj0Y.05h/6PF3COyy0H6',	'[\"ROLE_USER\"]',	'https://wallpapers-clan.com/wp-content/uploads/2023/08/kakashi-under-the-rain-green-wallpaper.jpg'),
(5,	'tyrion@user.fr',	'sasha',	NULL,	NULL,	'$2y$10$crtV3VDrF7J4smE8B8lXvO.i4xHralvZISzQNL3hRBLt8mzJaN32m',	'[\"ROLE_USER\"]',	'https://assets-prd.ignimgs.com/2023/08/29/mwii-s05-reloaded-announcement-016-1693306225115.jpg'),
(8,	'shorty@user.fr',	'shorty',	NULL,	NULL,	'$2y$13$ityD60QpNRv2Wo0wOu01mOFvEIE67B/iQS5HPNp.AdrPxci539rki',	'[\"ROLE_ADMIN\"]',	'https://i.postimg.cc/BZB7NG5J/default-profile.png'),
(21,	'stitch@user.fr',	'stitch',	NULL,	NULL,	'$2y$13$NwPKA7szwH3HvPjqS4Cecuiy6MXQ0fG3zUwHuCqDkQhAvY5cuhlVa',	'[]',	'vinyle-decoratif-pour-enfants-stitch-bbfaef927ef0ad62-50a85b7fafdd5238.jpg');

DROP TABLE IF EXISTS `user_spot`;
CREATE TABLE `user_spot` (
  `user_id` int(11) NOT NULL,
  `spot_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`spot_id`),
  KEY `IDX_C3B336BAA76ED395` (`user_id`),
  KEY `IDX_C3B336BA2DF1D37C` (`spot_id`),
  CONSTRAINT `FK_C3B336BA2DF1D37C` FOREIGN KEY (`spot_id`) REFERENCES `spot` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_C3B336BAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_spot` (`user_id`, `spot_id`) VALUES
(2,	7);

-- 2024-02-22 14:11:18