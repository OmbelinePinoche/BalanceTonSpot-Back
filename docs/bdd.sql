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
  `rating` decimal(2,1) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_9474526C2DF1D37C` (`spot_id`),
  KEY `fk_comment_user` (`user_id`),
  CONSTRAINT `FK_9474526C5B05007F` FOREIGN KEY (`spot_id`) REFERENCES `spot` (`id`),
  CONSTRAINT `fk_comment_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `comment` (`id`, `content`, `spot_id`, `date`, `rating`, `user_id`) VALUES
(4,	'On m\'avait recommandée ce spot, je comprends pourquoi maintenant! Il est INCROYABLE!',	1,	'2023-02-12',	5.0,	2),
(7,	'C\'est quoi cette blague lol',	4,	'2024-02-14',	2.0,	2),
(8,	'J\'riiide toute la niiight, j\'ai pas le tiiime, donne-moi ton numéroo',	3,	'2024-02-14',	4.5,	3),
(9,	'Là je dis oui!',	5,	'2024-02-14',	5.0,	2),
(10,	'Cété trop cool mème que je suis tombé qu\'une fois et ma maman a dit que GT trop fort!',	1,	'2024-02-01',	4.0,	4),
(11,	'Ça ride à fond par ici j\'aimeuh bieng',	6,	'2024-02-11',	4.0,	3),
(12,	'ETOILEU DES NEIIIGEEUUUU PAYS MERVEILLEUUUUX',	13,	'2024-02-05',	5.0,	5),
(13,	'ils sont toujours en travaux ils abusent pffff',	10,	'2024-01-19',	3.0,	4),
(16,	'Pas foufou hein',	4,	'2024-01-04',	2.0,	2);

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
(2,	'Vars_Park.jpg',	'https://www.snowsurf.com/media/__NEWS/news_2017/vier%202017/top10_parks/vars_remi_morel_le_parc_de_leyssina_du_telesiege_de_crevoux.jpg',	2),
(3,	'La_Cluzaz.jpg',	'https://static.savoie-mont-blanc.com/wp-content/uploads/external/e132d5d4d725e4a69beabf7bcc818ecf-3800129-1745x1163.jpg',	3),
(4,	'Bercy.jpg',	'https://cdn.paris.fr/paris/2021/03/17/huge-fe8b8dec36a98d44ea22fadfc2a095d1.jpg',	4),
(5,	'EGP18.jpeg',	'https://media.manawa.com/cache/activity_gallery_zoom_770x500/media/2019/01/99ed4a58c0595a482a40ddb65f406feb.jpeg',	5),
(6,	'Jemmapes.jpg',	'https://skateparks.fr/wp-content/uploads/2020/11/jemmapes-01.jpg',	6),
(7,	'Le_Hangar.jpg',	'https://static.wixstatic.com/media/7680dd_61081cf4a35a45deaa47559601a03e6f~mv2.jpg/v1/fill/w_2500,h_1502,al_c/7680dd_61081cf4a35a45deaa47559601a03e6f~mv2.jpg',	7),
(8,	'HDS.jpg',	'https://media.sudouest.fr/10315559/1200x-1/img-7203-2.jpg',	8),
(9,	'Le_Havre.jpg',	'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0f/02/29/30/skatepark.jpg',	9),
(10,	'Rives_de_Meurthe.jpg',	'https://numero4skateshop.com/product_images/uploaded_images/skatepark-de-nancy-rives-de-meurthe-n4-skateshop.jpg',	10),
(11,	'La_Rotonde.jpeg',	'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS7og6Z_GJeVIV2v76kj5pnwwnobUVuHwRzcDFr39CPTQ&s',	11),
(12,	'Sergent_Blandan.jpg',	'https://lh5.googleusercontent.com/p/AF1QipOiqox3mm8s1YMUuVtqWbVu5aK4M5XljtRD170=w408-h272-k-no',	12),
(13,	'2_Alpes.jpg',	'https://reservation.les2alpes.com/medias/images/perrine/snowpark_hiv_paysage_2.jpg',	13),
(14,	'Serre-Chevalier.jpg',	'https://www.skiresort.fr/fileadmin/_processed_/c3/34/42/25/81527b2b3f.jpg',	14),
(15,	'Grand_Bornand.jpg',	'https://www.barnes-montblanc.com/uploads/sectors/36/hero_pictures/53984/show.jpg?1573573424',	15),
(16,	'Isola_2',	'https://www.nicecotedazur.org/wp-content/uploads/2020/12/isola3-1210x635.jpg',	1),
(17,	'Vars_Park_2.jpg',	'https://woody.cloudly.space/app/uploads/vars/2023/02/thumbs/snowpark-vars-640x640.png',	2),
(18,	'La_Cluzaz_2',	'https://www.laclusaz.com/app/uploads/apidae/7138618-diaporama-890x500.jpg',	3),
(19,	'Bercy_2',	'https://1.bp.blogspot.com/-JNu_6Kli_u4/U016v6FQ7xI/AAAAAAAAE5A/nLEuU9Aanc4/s1600/Skatepark+Bercy+1+bis.jpg',	4),
(20,	'EG18_2',	'https://skateparks.fr/wp-content/uploads/2023/11/EGP-18-Paris-05.jpg',	5),
(21,	'Jemmapes_2',	'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSfmNnFGkHylqHiHXkP436XfYp3GrDG2UkCqA&usqp=CAU',	6),
(22,	'Le_Hangar_2',	'https://www.rollerenligne.com/wp-content/uploads/skatepark-hangar-nantes-04-copyrigt-hangar.jpg',	7),
(23,	'HDS_2',	'https://darwin.camp/wp-content/uploads/2015/09/12194614_890543381041055_1273745160829784654_o.jpg',	8),
(24,	'Le_Havre_2',	'https://3.bp.blogspot.com/-I5nw9gx752o/V2rQZWsyXuI/AAAAAAAAPvg/Z_iWEgI-5jwSYtnGBSVziBG9jeUp9guAQCLcB/s1600/Skatepark%2BLe%2BHavre%2B2.jpg',	9),
(25,	'Rives_de_Meurthe_2',	'https://tuyo.fr/uploads/events/big/skatepark-rives-de-meurthe-594999.jpg',	10),
(26,	'La_Rotonde_2',	'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEh0uHMuN7TFMBa5wCqCkLdFgKW6p9PwD8I47938lLNWgvVBfSIQ5x9DxwV87bfQukPPd1yx91SjVB0PgGwpZzREbFR9XCJR0uKweGtxqi1Ce06UBp02T9bVCKfDG7BGfk3hobUWS6hMehsK32yjbKh9Be_or8t_o0QkyPi28Q2BezOxT6Le388nIAtKXsQ/s4000/Skatepark%20Strasbourg%20(9).jpg',	11),
(27,	'Sergent_Blandan_2',	'https://www.baseland.fr/wp-content/uploads/2019/09/BLD_900x500_22.jpg',	12),
(28,	'2_Alpes_2',	'https://www.skiresort.fr/fileadmin/_processed_/f9/94/44/44/f671ec821d.jpg',	13),
(29,	'Serre-Chevalier_2',	'https://www.skiresort.fr/fileadmin/_processed_/a3/3c/c8/89/19f0e50d64.jpg',	14),
(30,	'Grand_Bornand_2',	'https://www.legrandbornand.com/medias/images/prestations/snowpark-2023-j-cathala-ot-lg-5-1455919.jpg',	15),
(31,	'Isola_3',	'https://isola2000.com/wp-content/uploads/2023/11/isola-zoom-snowpark-2017-2018-v4-hd.png',	1),
(32,	'Vars_Park_3.jpg',	'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2d/Snowboard_freestyle_au_VarsPark.jpg/1024px-Snowboard_freestyle_au_VarsPark.jpg',	2),
(33,	'La_Cluzaz_3',	'https://www.snowpark-shop.com/upload/le-snowpark-de-la-clusaz-1633676444-43157.jpg',	3),
(34,	'Bercy_3',	'https://ridemypark.com/wp-content/uploads/listing-uploads/gallery/2022/08/IMG-20220821-WA0006.jpg',	4),
(35,	'EG18_3',	'https://ridemypark.com/wp-content/uploads/2021/03/7ddb4dc5ab3670654bad290bbebe9bc2_clementfemenias_43854_gallery_-1.jpeg',	5),
(36,	'Jemmapes_3',	'https://2.bp.blogspot.com/-IwinZxx36EY/U-YHHfwGUmI/AAAAAAAAIuM/vZRM8lmQd3s/s1600/Jemmapes+travaux+août+2.jpg',	6),
(37,	'Le_Hangar_3',	'https://adogesvreshome.files.wordpress.com/2020/03/img_0084.jpg',	7),
(38,	'HDS_3',	'https://skateparks.fr/wp-content/uploads/2021/08/mini-rampe-darwin.jpg',	8),
(39,	'Le_Havre_3',	'https://www.normandie-tourisme.fr/wp-content/uploads/wpetourisme/Skate-Park---Le-Havre.jpg',	9),
(40,	'Rives_de_Meurthe_3',	'https://locations.filmfrance.net/sites/default/files/photos/skate-park-nancy-145895/dsc01472.jpg',	10),
(41,	'La_Rotonde_3',	'https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgtgPHBidLSDm7Wb_ZOZl7oCo5VO1YUX0SINzIrd8w62X272BJSdPvov9XWaRuqmyKPi7xL-hG9HBjh0DYsEhKml3VWXxOZDc6no51-Qq244Va7-nkuN8R2eJfei44PDF1n5t9RHGp_bk97vUGLn4ZfkBBFKdwBvk0gwHkqgIM64RI-1VR07xO1EL27gwY/s4000/Skatepark%20Strasbourg.jpg',	11),
(42,	'Sergent_Blandan_3',	'https://x-move.net/2016/wp-content/uploads/2017/02/skatepark_blandan_zed_photographie_reportage_HD_55.jpg',	12),
(43,	'2_Alpes_3',	'https://www.skiresort.fr/fileadmin/_processed_/8f/fb/b3/3a/d34bd2ee3f.jpg',	13),
(44,	'Serre-Chevalier_3',	'https://www.skiresort.fr/fileadmin/_processed_/2b/b8/86/6e/29a89365f6.jpg',	14),
(45,	'Grand_Bornand_3',	'https://www.snowsurf.com/media/__NEWS/news_2019/rs%202019/park%20check%20gd%20bo%202/vue%20général%20snowparkgb%20grand%20bornand%20mars%202019.jpg',	15);

DROP TABLE IF EXISTS `sport`;
CREATE TABLE `sport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `sport` (`id`, `name`, `slug`) VALUES
(1,	'Skateboard',	'skateboard'),
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
(1,	'Isola 2000',	'Le snowpark d\'Isola 2000 vous propose une expérience exceptionnelle à 2300 mètres d’altitude sur le secteur Marmotte. Découvrez de nouvelles sensations de glisse tous les jours de 10h à 16h dans cet espace ludique et technique, entretenu quotidiennement pour votre plaisir.',	'https://isola2000.com/wp-content/uploads/2022/09/pano-cime-1920x960-1-1280x640.jpeg',	'Station d\'Isola',	0.0,	1,	'isola-2000'),
(2,	'Vars Park',	'Il y en a pour tout le monde. Le Varspark met un point d\'honneur à démocratiser la pratique du freestyle aussi bien pour les débutants que les spécialistes de la discipline.',	'https://www.snowsurf.com/media/__NEWS/news_2017/vier%202017/top10_parks/vars_remi_morel_le_parc_de_leyssina_du_telesiege_de_crevoux.jpg',	'Station de Vars',	4.5,	2,	'vars-park'),
(3,	'LCZ Park',	'Le snowpark de La Cluzaz propose un espace ludique à tous les amateurs de freestyle ! Une multitude de modules est à disposition durant toute la saison pour permettre aux skieurs les plus fous d’exprimer toute leur créativité.',	'https://static.savoie-mont-blanc.com/wp-content/uploads/external/e132d5d4d725e4a69beabf7bcc818ecf-3800129-1745x1163.jpg',	'Station de La Clusaz',	4.0,	3,	'lcz-park'),
(4,	'Bercy',	'3 mois après le début des travaux, le skatepark de Bercy est ré-ouvert. Belle performance quand on se souvient des déboires des travaux de couverture du skatepark Jules Noël. Notre skatepark de bercy est maintenant doté d\'un toit... fini les dimanches pluvieux sans session.',	'https://cdn.paris.fr/paris/2021/03/17/huge-fe8b8dec36a98d44ea22fadfc2a095d1.jpg',	'Rue Raymond Aron, 75012 Paris',	2.7,	4,	'bercy'),
(5,	'EGP18',	'C\'est désormais le plus gros skatepark parisien. Il se compose de parks, de 2  bowls en béton et d\'une fin-box permettant à des patineurs de niveaux variés de rider en indoor pour urface totale de 3545 m².',	'https://media.manawa.com/cache/activity_gallery_zoom_770x500/media/2019/01/99ed4a58c0595a482a40ddb65f406feb.jpeg',	'Imp. des Fillettes, 75018 Paris',	4.5,	4,	'egp18'),
(6,	'Jemmapes',	'Bien connu de la faune locale à roulettes, le skatepark du quai de Jemmapes fait partie des spots parisiens incontournables. Plutôt pas trop mal situé au bord du canal Saint Martin, assez ensoleillé, bien fréquenté en journée, ce petit park de ville aura de quoi vous combler pour démarrer/clôturer votre session entre potos.',	'https://skateparks.fr/wp-content/uploads/2020/11/jemmapes-01.jpg',	'140 quai de Jemmapes, 75010 Paris',	4.0,	4,	'jemmapes'),
(7,	'Le Hangar',	'Un skatepark indoor conçu à partir de matériaux de récupération pour rider proprement sur un florilège de modules : bowl en bois, big ramp, street area… Au Hangar, il y a de quoi faire le plein de sensations ou de frayeurs, ça dépendra de vous.',	'https://static.wixstatic.com/media/7680dd_61081cf4a35a45deaa47559601a03e6f~mv2.jpg/v1/fill/w_2500,h_1502,al_c/7680dd_61081cf4a35a45deaa47559601a03e6f~mv2.jpg',	'9 allée des Vinaigriers - 44300 Nantes',	4.5,	5,	'le-hangar'),
(8,	'Hangar Darwin Skatepark',	'Le skatepark Le Hangar est un skatepark couvert associatif de 5300 m², géré par la Ligue de l\'Enseignement - FAL 44. Accueillant des particuliers et des groupes, il propose des stages, des cours et organise des événements.',	'https://media.sudouest.fr/10315559/1200x-1/img-7203-2.jpg',	'87 Quai des Queyries, 33100 Bordeaux',	4.0,	6,	'hangar-darwin-skatepark'),
(9,	'Skatepark du Havre',	'C\'est le plus grand skatepark gratuit à ciel ouvert en France. Elaboré par des spécialistes, le skatepark a été pensé pour offrir une aire de jeux adaptée se prêtant au mieux à l\'exercice de la glisse. Il peut se vanter d\'offrir une aire de street de 600 m² avec des plans inclinés, mais aussi un bowl de 1200 m², soit une aire totale de 1800 m² pour s\'amuser, quelque soit son niveau ou sa pratique.',	'https://www.normandie-tourisme.fr/wp-content/uploads/wpetourisme/Skate-Park---Le-Havre.jpg',	'27 Boulevard Albert 1er, 76600 Le Havre',	4.5,	7,	'skatepark-du-havre'),
(10,	'Rives de Meurthe',	'Le skatepark des Rives de Meurthe est l\'un des spots de skate les plus populaires de Nancy. Avec ses différentes structures, il offre aux skateurs un lieu idéal pour pratiquer leur sport et développer leur talent.',	'https://numero4skateshop.com/product_images/uploaded_images/skatepark-de-nancy-rives-de-meurthe-n4-skateshop.jpg',	'Av. Charles Etienne Collignon, 54000 Nancy',	4.5,	8,	'rives-de-meurthe'),
(11,	'La Rotonde',	'C\'est l\'un des skateparks les plus réussis de l\'agglomération Strasbourgoise. Il est d\'ailleurs fréquenté par les BMX, skateboards et rollers. Il a été conçu et dessiné par David Mougin, le petit frère de Nicolas Mougin, champion du monde amateur 2003/2004 en rampe.',	'https://numero4skateshop.com/product_images/uploaded_images/strasbourg-skatepark-la-rotonde-n4-skateshop.jpeg',	'Rue Pierre Nuss, 67200 Strasbourg',	5.0,	9,	'la-rotonde'),
(12,	'Sergent Blandan',	'Très typé street (avec quand même deux trois courbes bien raides par ci par là), ce skatepark est rempli de belles idées. Il faudra quand même un bon niveau pour vraiment en profiter.',	'https://skateparks.fr/wp-content/uploads/2020/11/sergent-blandan-skatepark-full.jpg',	'Rue de l\'Epargne, 69007 Lyon',	3.5,	10,	'sergent-blandan'),
(13,	'Les 2 Alpes',	'Station de ski phare du département de l’Isère, Les 2 Alpes jouit d’une réputation internationale. Elle est située au cœur du massif des Ecrins, dans l’Oisans. Avec une neige naturelle garantie grâce au domaine de haute altitude culminant à 3600m, vous avez l’assurance de skier en toute saison.',	'https://reservation.les2alpes.com/medias/images/perrine/snowpark_hiv_paysage_2.jpg',	'Station des Deux Alpes',	5.0,	11,	'les-2-Alpes'),
(14,	'Serre-Chevalier',	'Plus grand domaine skiable des Alpes du Sud, Serre Chevalier est aussi l\'un des plus grands domaines d\'Europe avec ses 3 901 hectares. Débutant ou expert, découvrez tout un domaine XXL, par les forêts de mélèzes ou par les sommets offrant des panoramas de montagne exceptionnels.',	'https://www.skiresort.fr/fileadmin/_processed_/c3/34/42/25/81527b2b3f.jpg',	'Station de Serre-Chevalier',	4.0,	12,	'serre-chevalier'),
(15,	'Le Grand Bornand',	'Cette station propose un domaine skiable préservé dans lequel vous pouvez pratiquer de nombreuses disciplines : ski alpin, ski nordique, biathlon, snowboard, ski de randonnée, raquettes, marche nordique, luge.',	'https://www.barnes-montblanc.com/uploads/sectors/36/hero_pictures/53984/show.jpg?1573573424',	'Station du Grand Bornand',	4.0,	13,	'le-grand-bornand'),
(42,	'fgssdf',	'sGsGG',	'original-filename-9accd67b80775063.jpg',	'gsgessg',	NULL,	20,	'fgssdf');

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
(2,	2),
(3,	2),
(4,	1),
(5,	1),
(6,	1),
(7,	1),
(8,	1),
(9,	1),
(10,	1),
(11,	1),
(12,	1),
(13,	2),
(14,	2),
(15,	2),
(42,	1);

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
(1,	'admin@admin.fr',	'admin',	NULL,	NULL,	'$2y$13$mdsmlovcKOASxW9qzUZIve13As7kZ4k6g3wicFYWXPLYpVe5.nMvy',	'[\"ROLE_ADMIN\"]',	'https://i.postimg.cc/BZB7NG5J/default-profile.png'),
(2,	'rider@user.fr',	'rider',	NULL,	NULL,	'$2y$13$GE9o.xomhmJX.fNeyAb5zekh4gynBhUwehnb7vvp99HbMvdWoT5..',	'[\"ROLE_USER\"]',	'https://i.postimg.cc/BZB7NG5J/default-profile.png'),
(3,	'stitch@user.fr',	'stitch',	NULL,	NULL,	'okokok',	'[\"ROLE_USER\"]',	'https://www.muralsticker.com/42049-thickbox/vinyle-decoratif-pour-enfants-stitch.jpg'),
(4,	'mhysa@user.fr',	'roidelaglisse96',	NULL,	NULL,	'okokok',	'[\"ROLE_USER\"]',	'https://wallpapers-clan.com/wp-content/uploads/2023/08/kakashi-under-the-rain-green-wallpaper.jpg'),
(5,	'tyrion@user.fr',	'sasha',	NULL,	NULL,	'okokok',	'[\"ROLE_USER\"]',	'https://assets-prd.ignimgs.com/2023/08/29/mwii-s05-reloaded-announcement-016-1693306225115.jpg'),
(8,	'shorty@user.fr',	'shorty',	NULL,	NULL,	'$2y$13$77KfFAQxX7F20xffPdHGhO7GxVSKSmtp0Zz3BHg8EKrOlYs5Y1GZ2',	'[\"ROLE_USER\"]',	'https://i.postimg.cc/BZB7NG5J/default-profile.png');

DROP TABLE IF EXISTS `user_spot`;
CREATE TABLE `user_spot` (
  `user_id` int(11) NOT NULL,
  `spot_id` int(11) NOT NULL,
  PRIMARY KEY (`user_id`,`spot_id`),
  KEY `IDX_C3B336BAA76ED395` (`user_id`),
  KEY `IDX_C3B336BA2DF1D37C` (`spot_id`),
  CONSTRAINT `FK_C3B336BAA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `user_spot_ibfk_2` FOREIGN KEY (`spot_id`) REFERENCES `spot` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user_spot` (`user_id`, `spot_id`) VALUES
(2,	7),
(2,	13);

-- 2024-02-21 07:34:23