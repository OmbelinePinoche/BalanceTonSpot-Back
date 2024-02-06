SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `spot_id_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526C5B05007F` (`spot_id_id`),
  CONSTRAINT `FK_9474526C5B05007F` FOREIGN KEY (`spot_id_id`) REFERENCES `spot` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DROP TABLE IF EXISTS `location`;
CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `spot_id_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_16DB4F895B05007F` (`spot_id_id`),
  CONSTRAINT `FK_16DB4F895B05007F` FOREIGN KEY (`spot_id_id`) REFERENCES `spot` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `picture` (`id`, `name`, `spot_id`, `path`) VALUES

(1, 'Isola', '1', 'https://isola2000.com/wp-content/uploads/2022/09/pano-cime-1920x960-1-1280x640.jpeg')
(2, 'Vars', '2', 'https://www.laclusaz.com/app/uploads/apidae/7138618-diaporama-890x500.jpg')
(3, 'La_Cluzaz', '3', 'https://www.laclusaz.com/app/uploads/apidae/7138618-diaporama-890x500.jpg')
(4, 'Bercy', '4', 'https://cdn.paris.fr/paris/2021/03/17/huge-fe8b8dec36a98d44ea22fadfc2a095d1.jpg')
(5, 'Paris ', '5', 'https://media.manawa.com/cache/activity_gallery_zoom_770x500/media/2019/01/99ed4a58c0595a482a40ddb65f406feb.jpeg')
(6, 'Jemmapes', '6', 'https://skateparks.fr/wp-content/uploads/2020/11/jemmapes-01.jpg')
(7, 'Nantes', '7', 'https://static.wixstatic.com/media/7680dd_61081cf4a35a45deaa47559601a03e6f~mv2.jpg/v1/fill/w_2500,h_1502,al_c/7680dd_61081cf4a35a45deaa47559601a03e6f~mv2.jpg')
(8, 'Bordeaux', '8', 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0d/90/a7/7b/fb-img-1478629979136.jpg?w=1200&h=-1&s=1')
(9, 'Le_Havre',  '9', 'https://3.bp.blogspot.com/-I5nw9gx752o/V2rQZWsyXuI/AAAAAAAAPvg/Z_iWEgI-5jwSYtnGBSVziBG9jeUp9guAQCLcB/s1600/Skatepark%2BLe%2BHavre%2B2.jpg')
(10, 'Rives_de_Meruthe',  '10', 'https://numero4skateshop.com/product_images/uploaded_images/skatepark-de-nancy-rives-de-meurthe-n4-skateshop.jpg')
(11, 'La_Rotonde', '11', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7og6Z_GJeVIV2v76kj5pnwwnobUVuHwRzcDFr39CPTQ&s')
(12, 'Sergent_Blandan', '12', 'https://lh5.googleusercontent.com/p/AF1QipOiqox3mm8s1YMUuVtqWbVu5aK4M5XljtRD170=w408-h272-k-no')
(13, '2_Alpes', '13', 'https://reservation.les2alpes.com/medias/images/perrine/snowpark_hiv_paysage_2.jpg')
(14, 'Serre-Chevalier', '14', 'https://www.skiresort.fr/fileadmin/_processed_/c3/34/42/25/81527b2b3f.jpg')
(15, 'Grand_Bornand',  '15', 'https://www.snowsurf.com/media/__NEWS/news_2019/rs%202019/park%20check%20grand%20bo/snowpark%20gb%20grand%20bornand%202019%20ligne%20kickers.jpg')

DROP TABLE IF EXISTS `sport`;
CREATE TABLE `sport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `sport` (`id`, `name`) VALUES
(1, 'Skateboard'),
(2, 'Snowboard')

DROP TABLE IF EXISTS `spot`;
CREATE TABLE `spot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `adress` varchar(255) NOT NULL,
  `rating` decimal(2,1) DEFAULT NULL,
  `location_id_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B9327A73918DB72` (`location_id_id`),
  CONSTRAINT `FK_B9327A73918DB72` FOREIGN KEY (`location_id_id`) REFERENCES `location` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `spot` (`id`, `sport_id`, `location_id`, `name`, `address`, `description`, `picture`, `rating`) VALUES
(1, 2, 1, 'Isola 2000', 'Station d''Isola', 'Le snowpark d''Isola 2000 vous propose une expérience exceptionnelle à 2300 mètres d’altitude sur le secteur Marmotte. Découvrez de nouvelles sensations de glisse tous les jours de 10h à 16h dans cet espace ludique et technique, entretenu quotidiennement pour votre plaisir.', 1, 5.4),
(2, 2, 2, 'Vars Park', 'Station de Vars', 'Il y en a pour tout le monde. Le Varspark met un point d''honneur à démocratiser la pratique du freestyle aussi bien pour les débutants que les spécialistes de la discipline.', 2, 5.4),
(3,	2, 3, 'LCZ Park', 'Station de La Clusaz', 'Le snowpark de La Cluzaz propose un espace ludique à tous les amateurs de freestyle ! Une multitude de modules est à disposition durant toute la saison pour permettre aux skieurs les plus fous d’exprimer toute leur créativité.', 3, 5.4),
(4, 1, 4, 'Bercy', 'Rue Raymond Aron, 75012 Paris', '3 mois après le début des travaux, le skatepark de Bercy est ré-ouvert. Belle performance quand on se souvient des déboires des travaux de couverture du skatepark Jules Noël. Notre skatepark de bercy est maintenant doté d''un toit... fini les dimanches pluvieux sans session.', 4, 5.4),
(5, 1, 4, 'EGP18', 'Imp. des Fillettes, 75018 Paris', 'C''est désormais le plus gros skatepark parisien. Il se compose de parks, de 2  bowls en béton et d''une fin-box permettant à des patineurs de niveaux variés de rider en indoor pour urface totale de 3545 m².', 5, 5.4),
(6, 1, 4, 'Jemmapes', '140 quai de Jemmapes, 75010 Paris', 'Bien connu de la faune locale à roulettes, le skatepark du quai de Jemmapes fait partie des spots parisiens incontournables. Plutôt pas trop mal situé au bord du canal Saint Martin, assez ensoleillé, bien fréquenté en journée, ce petit park de ville aura de quoi vous combler pour démarrer/clôturer votre session entre potos.', 6, 5.4),
(7, 1, 5, 'Le Hangar', '9 allée des Vinaigriers - 44300 Nantes', 'Un skatepark indoor conçu à partir de matériaux de récupération pour rider proprement sur un florilège de modules : bowl en bois, big ramp, street area… Au Hangar, il y a de quoi faire le plein de sensations ou de frayeurs, ça dépendra de vous.', 7, 5.4),
(8, 1, 6, 'Hangar Darwin Skatepark', '87 Quai des Queyries, 33100 Bordeaux', 'Le skatepark Le Hangar est un skatepark couvert associatif de 5300 m², géré par la Ligue de l''Enseignement - FAL 44. Accueillant des particuliers et des groupes, il propose des stages, des cours et organise des événements.', 8, 5.4),
(9, 1, 7, 'Skatepark du Havre', '27 Boulevard Albert 1er, 76600 Le Havre', 'C''est le plus grand skatepark gratuit à ciel ouvert en France. Elaboré par des spécialistes, le skatepark a été pensé pour offrir une aire de jeux adaptée se prêtant au mieux à l''exercice de la glisse. Il peut se vanter d''offrir une aire de street de 600 m² avec des plans inclinés, mais aussi un bowl de 1200 m², soit une aire totale de 1800 m² pour s''amuser, quelque soit son niveau ou sa pratique.', 9, 5.4),
(10, 1, 8, 'Skatepark Rives de Meurthe', 'Av. Charles Etienne Collignon, 54000 Nancy', 'Le skatepark des Rives de Meurthe est l''un des spots de skate les plus populaires de Nancy. Avec ses différentes structures, il offre aux skateurs un lieu idéal pour pratiquer leur sport et développer leur talent.', 10, 5.4),
(11, 1, 9, 'Skatepark de la Rotonde', 'Rue Pierre Nuss, 67200 Strasbourg', 'C''est l''un des plus réussis de l''agglomération Strasbourgoise. Il est d''ailleurs fréquenté par les BMX, skateboards et rollers. Il a été conçu et dessiné par David Mougin, le petit frère de Nicolas Mougin, champion du monde amateur 2003/2004 en rampe.', 11, 5.4),
(12, 1, 10, 'Skatepark Sergent Blandan', 'Rue de l''Epargne, 69007 Lyon', 'Très typé street (avec quand même deux trois courbes bien raides par ci par là), il est rempli de belles idées. Il faudra quand même un bon niveau pour vraiment en profiter.', 12, 5.4),
(13, 2, 11, 'Les 2 Alpes', 'Station des Deux Alpes', 'Station de ski phare du département de l’Isère, Les 2 Alpes jouit d’une réputation internationale. Elle est située au cœur du massif des Ecrins, dans l’Oisans. Avec une neige naturelle garantie grâce au domaine de haute altitude culminant à 3600m, vous avez l’assurance de skier en toute saison.', 13, 5.4)
(14, 2, 12, 'Serre-Chevalier', 'Station de Serre-Chevalier', 'Plus grand domaine skiable des Alpes du Sud, Serre Chevalier est aussi l''un des plus grands domaines d''Europe avec ses 3 901 hectares. Débutant ou expert, découvrez tout un domaine XXL, par les forêts de mélèzes ou par les sommets offrant des panoramas de montagne exceptionnels.', 14, 5.4)
(15, 2, 13, 'Le Grand Bornand', 'Station du Grand Bornand', 'Elle propose un domaine skiable préservé dans lequel vous pouvez pratiquer de nombreuses disciplines : ski alpin, ski nordique, biathlon, snowboard, ski de randonnée, raquettes, marche nordique, luge.', 15, 5.4);


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




DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  `picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;