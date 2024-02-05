
SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du commentaire',
  `spot_id` int(100) unsigned NOT NULL COMMENT 'Identifiant du spot concerné par le commentaire',
  `user_id` int(100) unsigned NOT NULL COMMENT 'Identifiant de l''utilisateur qui écrit le commentaire',
  `content` text NOT NULL COMMENT 'Contenu du commentaire',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE current_timestamp() COMMENT 'Date de création du commentaire',
  `updated_at` timestamp NOT NULL COMMENT 'Date de mise à jour du commentaire',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du lieu',
  `name` varchar(255) NOT NULL COMMENT 'Nom du lieu',
  `spot_id` int(100) unsigned NOT NULL COMMENT 'Identifiant du spot du lieu choisi',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `location` (`id`, `name`, `spot_id`) VALUES
(1, 'Isola', '1'),
(2, 'Vars', '2'),
(3, 'LCZ', '3'),
(4, 'Paris', '4')
(4, 'Paris', '5')
(4, 'Paris', '6')
(5, 'Nantes', '7')
(6, 'Bordeaux', '8')
(7, 'Le Havre', '9')
(8, 'Nancy', '10')
(9, 'Strasbourg', '11')
(10, 'Lyon', '12')
(11, 'Les deux Alpes', '13')
(12, 'Serre-Chevalier', '14')
(13, 'Le Grand Bornand', '15')


DROP TABLE IF EXISTS `picture`;
CREATE TABLE `picture` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant de l''image',
  `name` varchar(255) NOT NULL COMMENT 'Nom du spot',
  `location_id` int(100) unsigned NOT NULL COMMENT 'Identifiant du lieu du spot',
  `spot_id` int(100) unsigned NOT NULL COMMENT 'Identifiant du spot de l''image',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `picture` (`id`, `name`, `location_id`, `spot_id`) VALUES

(1, 'Rendu de la station d'Isola'', '1', '1')
(2, 'Rendu de la station de Vars', '2', '2')
(3, 'Rendu de la station de la Cluzaz', '3', '3')
(4, 'Rendu du skatepark de Bercy', '4', '4')
(5, 'Rendu du skatepark du plus grand spot de Paris ', '4', '5')
(6, 'Rendu du skatepark de Paris à Jemmapes', '4', '6')
(7, 'Rendu du skatepark du Hangar à Nantes', '5', '7')
(8, 'Rendu du Hangar Darwin skatepark à Bordeaux', '6', '8')
(9, 'Rendu du skatepark du havre', '7', '9')
(10, 'Rendu du skatepark du Rives de Meruthe', '8', '10')
(11, 'Rendu du skatepark de la Rotonde', '9', '11')
(12, 'Rendu du skatepark de la Sergent Blandan', '10', '12')
(13, 'Rendu de la Station des Deux Alpes', '11', '13')
(14, 'Rendu de la Station de Serre-Chevalier', '12', '14')
(15, 'Rendu de la Station du Grand Bornand', '13', '15')

DROP TABLE IF EXISTS `sport`;
CREATE TABLE `sport` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du sport',
  `name` varchar(255) NOT NULL COMMENT 'Nom du sport pratiqué',
  `spot_id` int(100) unsigned NOT NULL COMMENT 'Identifiant du spot concerné par le sport',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `sport` (`id`, `name`, `spot_id`) VALUES
(1, 'Skateboard', '4'),
(1, 'Skateboard', '5'),
(1, 'Skateboard', '6'),
(1, 'Skateboard', '7'),
(1, 'Skateboard', '8'),
(1, 'Skateboard', '9'),
(1, 'Skateboard', '10'),
(1, 'Skateboard', '11'),
(1, 'Skateboard', '12'),
(2, 'Snowboard', '1'),
(2, 'Snowboard', '2'),
(2, 'Snowboard', '3'),
(2, 'Snowboard', '13'),
(2, 'Snowboard', '14'),
(2, 'Snowboard', '15'),


DROP TABLE IF EXISTS `spot`;
CREATE TABLE `spot` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du spot',
  `sport_id` int(100) unsigned NOT NULL COMMENT 'Identifiant du sport concerné par le commentaire',
  `location_id` int(100) unsigned NOT NULL COMMENT 'Identifiant du lieu du spot',
  `name` varchar(255) NOT NULL COMMENT 'Nom du spot',
  `address` varchar(255) NOT NULL COMMENT 'Adresse du spot'
  `content` text NOT NULL COMMENT 'Description du spot',
  `path` varchar,
  `created_at` timestamp NOT NULL COMMENT 'Date de création du spot sur le site',
  `updated_at` timestamp NOT NULL COMMENT 'Date de la mise à jour du spot sur le site',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `spot` (`id`, `sport_id`, `location_id`, `name`, `address`, `content`, 'picture') VALUES
(1, 2, 1, 'Isola 2000', 'Station d''Isola', 'Le snowpark d''Isola 2000 vous propose une expérience exceptionnelle à 2300 mètres d’altitude sur le secteur Marmotte. Découvrez de nouvelles sensations de glisse tous les jours de 10h à 16h dans cet espace ludique et technique, entretenu quotidiennement pour votre plaisir.', 'https://isola2000.com/wp-content/uploads/2022/09/pano-cime-1920x960-1-1280x640.jpeg'),
(2, 2, 2, 'Vars Park', 'Station de Vars', 'Il y en a pour tout le monde. Le Varspark met un point d''honneur à démocratiser la pratique du freestyle aussi bien pour les débutants que les spécialistes de la discipline.', 'https://cdn-s-www.ledauphine.com/images/0B4C75D1-BE1B-47ED-9CDF-B171D74277BD/NW_raw/le-snowpark-de-vars-s-etale-sur-plus-de-1-000-metres-de-denivele-c-est-ce-qui-fait-sa-singularite-et-sa-notoriete-qui-depassent-aujourd-hui-les-frontieres-europeennes-1390340766.jpg'),
(3,	2, 3, 'LCZ Park', 'Station de La Clusaz', 'Le snowpark de La Cluzaz propose un espace ludique à tous les amateurs de freestyle ! Une multitude de modules est à disposition durant toute la saison pour permettre aux skieurs les plus fous d’exprimer toute leur créativité.', 'https://www.laclusaz.com/app/uploads/apidae/7138618-diaporama-890x500.jpg'),
(4, 1, 4, 'Bercy', 'Rue Raymond Aron, 75012 Paris', '3 mois après le début des travaux, le skatepark de Bercy est ré-ouvert. Belle performance quand on se souvient des déboires des travaux de couverture du skatepark Jules Noël. Notre skatepark de bercy est maintenant doté d''un toit... fini les dimanches pluvieux sans session.', 'https://cdn.paris.fr/paris/2021/03/17/huge-fe8b8dec36a98d44ea22fadfc2a095d1.jpg'),
(5, 1, 4, 'EGP18', 'Imp. des Fillettes, 75018 Paris', 'C''est désormais le plus gros skatepark parisien. Il se compose de parks, de 2  bowls en béton et d''une fin-box permettant à des patineurs de niveaux variés de rider en indoor pour urface totale de 3545 m².', 'https://media.manawa.com/cache/activity_gallery_zoom_770x500/media/2019/01/99ed4a58c0595a482a40ddb65f406feb.jpeg'),
(6, 1, 4, 'Jemmapes', '140 quai de Jemmapes, 75010 Paris', 'Bien connu de la faune locale à roulettes, le skatepark du quai de Jemmapes fait partie des spots parisiens incontournables. Plutôt pas trop mal situé au bord du canal Saint Martin, assez ensoleillé, bien fréquenté en journée, ce petit park de ville aura de quoi vous combler pour démarrer/clôturer votre session entre potos.', 'https://skateparks.fr/wp-content/uploads/2020/11/jemmapes-01.jpg'),
(7, 1, 5, 'Le Hangar', '9 allée des Vinaigriers - 44300 Nantes', 'Un skatepark indoor conçu à partir de matériaux de récupération pour rider proprement sur un florilège de modules : bowl en bois, big ramp, street area… Au Hangar, il y a de quoi faire le plein de sensations ou de frayeurs, ça dépendra de vous.', 'https://static.wixstatic.com/media/7680dd_61081cf4a35a45deaa47559601a03e6f~mv2.jpg/v1/fill/w_2500,h_1502,al_c/7680dd_61081cf4a35a45deaa47559601a03e6f~mv2.jpg'),
(8, 1, 6, 'Hangar Darwin Skatepark', '87 Quai des Queyries, 33100 Bordeaux', 'Le skatepark Le Hangar est un skatepark couvert associatif de 5300 m², géré par la Ligue de l''Enseignement - FAL 44. Accueillant des particuliers et des groupes, il propose des stages, des cours et organise des événements.', 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0d/90/a7/7b/fb-img-1478629979136.jpg?w=1200&h=-1&s=1'),
(9, 1, 7, 'Skatepark du Havre', '27 Boulevard Albert 1er, 76600 Le Havre', 'C''est le plus grand skatepark gratuit à ciel ouvert en France. Elaboré par des spécialistes, le skatepark a été pensé pour offrir une aire de jeux adaptée se prêtant au mieux à l''exercice de la glisse. Il peut se vanter d''offrir une aire de street de 600 m² avec des plans inclinés, mais aussi un bowl de 1200 m², soit une aire totale de 1800 m² pour s''amuser, quelque soit son niveau ou sa pratique.', 'https://3.bp.blogspot.com/-I5nw9gx752o/V2rQZWsyXuI/AAAAAAAAPvg/Z_iWEgI-5jwSYtnGBSVziBG9jeUp9guAQCLcB/s1600/Skatepark%2BLe%2BHavre%2B2.jpg'),
(10, 1, 8, 'Skatepark Rives de Meurthe', 'Av. Charles Etienne Collignon, 54000 Nancy', 'Le skatepark des Rives de Meurthe est l''un des spots de skate les plus populaires de Nancy. Avec ses différentes structures, il offre aux skateurs un lieu idéal pour pratiquer leur sport et développer leur talent.', 'https://numero4skateshop.com/product_images/uploaded_images/skatepark-de-nancy-rives-de-meurthe-n4-skateshop.jpg'),
(11, 1, 9, 'Skatepark de la Rotonde', 'Rue Pierre Nuss, 67200 Strasbourg', 'C''est l''un des plus réussis de l''agglomération Strasbourgoise. Il est d''ailleurs fréquenté par les BMX, skateboards et rollers. Il a été conçu et dessiné par David Mougin, le petit frère de Nicolas Mougin, champion du monde amateur 2003/2004 en rampe.', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7og6Z_GJeVIV2v76kj5pnwwnobUVuHwRzcDFr39CPTQ&s'),
(12, 1, 10, 'Skatepark Sergent Blandan', 'Rue de l''Epargne, 69007 Lyon', 'Très typé street (avec quand même deux trois courbes bien raides par ci par là), il est rempli de belles idées. Il faudra quand même un bon niveau pour vraiment en profiter.', 'https://lh5.googleusercontent.com/p/AF1QipOiqox3mm8s1YMUuVtqWbVu5aK4M5XljtRD170=w408-h272-k-no'),
(13, 2, 11, 'Les 2 Alpes', 'Station des Deux Alpes', 'Station de ski phare du département de l’Isère, Les 2 Alpes jouit d’une réputation internationale. Elle est située au cœur du massif des Ecrins, dans l’Oisans. Avec une neige naturelle garantie grâce au domaine de haute altitude culminant à 3600m, vous avez l’assurance de skier en toute saison.', 'https://reservation.les2alpes.com/medias/images/perrine/snowpark_hiv_paysage_2.jpg')
(14, 2, 12, 'Serre-Chevalier', 'Station de Serre-Chevalier', 'Plus grand domaine skiable des Alpes du Sud, Serre Chevalier est aussi l''un des plus grands domaines d''Europe avec ses 3 901 hectares. Débutant ou expert, découvrez tout un domaine XXL, par les forêts de mélèzes ou par les sommets offrant des panoramas de montagne exceptionnels.', 'https://www.skiresort.fr/fileadmin/_processed_/c3/34/42/25/81527b2b3f.jpg')
(15, 2, 13, 'Le Grand Bornand', 'Station du Grand Bornand', 'Elle propose un domaine skiable préservé dans lequel vous pouvez pratiquer de nombreuses disciplines : ski alpin, ski nordique, biathlon, snowboard, ski de randonnée, raquettes, marche nordique, luge.', 'https://www.snowsurf.com/media/__NEWS/news_2019/rs%202019/park%20check%20grand%20bo/snowpark%20gb%20grand%20bornand%202019%20ligne%20kickers.jpg');


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(100) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Identifiant du rider',
  `role` varchar(120) NOT NULL COMMENT 'Admin ou utilisateur',
  `firstname` varchar(64) DEFAULT NULL COMMENT 'Nom de famille du rider',
  `lastname` varchar(64) DEFAULT NULL COMMENT 'Prénom du rider',
  `email` varchar(60) NOT NULL COMMENT 'Email de connexion',
  `password` varchar(60) NOT NULL COMMENT 'Mot de passe de connexion',
  `picture` varchar(120) DEFAULT NULL COMMENT 'Photo de profil',
  `username` varchar(64) NOT NULL COMMENT 'Pseudo de l''utilisateur',
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


