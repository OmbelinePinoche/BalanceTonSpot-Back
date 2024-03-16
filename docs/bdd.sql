-- Adminer 4.8.1 MySQL 10.11.3-MariaDB-1:10.11.3+maria~ubu2004 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `comment`;
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(500) NOT NULL,
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
(9,	'Là je dis oui!',	5,	'2024-02-14',	5.0,	2),
(10,	'Cété trop cool mème que je suis tombé qu\'une fois et ma maman a dit que GT trop fort!',	1,	'2024-02-01',	4.0,	21),
(12,	'ETOILEU DES NEIIIGEEUUUU PAYS MERVEILLEUUUUX',	13,	'2024-02-05',	5.0,	4),
(13,	'Ils sont toujours en travaux ils abusent pffff',	10,	'2024-01-19',	3.0,	4),
(32,	'Waouuuuh trop fort!!',	15,	'2024-02-22',	5.0,	21),
(33,	'Bof c\'est pas terrible',	12,	'2024-02-22',	2.5,	21),
(42,	'J\'aime trop y aller, l\'ambiance est au top à chaque fois',	11,	'2024-02-24',	4.5,	8),
(43,	'J\'y vais tous les ans avec mes potes, c\'est le feu. Beaucoup de tremplins à dispo, ils ont ajouté un half-pipe cette année, trop cool!',	3,	'2024-02-24',	5.0,	5),
(44,	'Ok pas mal, station pas trop prisée ça fait du bien',	14,	'2024-01-18',	3.5,	8),
(45,	'Message adressé à la ville de Clermont:\r\nAfin que les usagers réguliers puissent profiter pleinement du skatepark Philippe Marcombes, notamment du bowl, il serait fort appréciable que son entretien ne soit pas négligé, à savoir extraire le sable, feuilles et autres éléments rendant la pratique dangereuse voir impossible. Il n’est pas rare de voir les usagers contraint à cette tâche propre à celle de la municipalité.\r\nA bon entendeur salut.',	50,	'2024-02-25',	3.5,	5),
(46,	'Skatepark à éviter ! Depuis que la ville de Rennes à enlever la plupart des installations et le U, ce park n’est plus intéressant. Il reste tout de même une partie Street, mais ça ne vaut pas le coup de s’y déplacer...',	52,	'2024-02-02',	2.5,	8),
(51,	'Super skate park ouvert a tous et pour tout âge. Que l\'on soit débutant expérimenté on peut tous pratiquer!',	52,	'2024-02-07',	4.5,	5),
(52,	'Bien mais trop de monde, ça peut vite être saoulant',	51,	'2023-11-10',	4.0,	5),
(53,	'Ne surtout pas y aller je veux garder le spot pour moi tous seul 😅😅',	51,	'2023-10-05',	1.0,	21),
(54,	'Bon skatepark mais il faudrait plus de courbe et moins de plans inc.',	51,	'2024-02-25',	4.0,	8),
(55,	'Lieu sympa pour petit niveau mais plaisant!',	59,	'2023-09-12',	4.0,	21),
(56,	'Skatepark super sympa. Le petit bémol est l\'entretien environnement très sale. Mais il est roulable... Je vous le recommande.',	59,	'2024-02-25',	4.0,	8),
(57,	'Trop petit, pas fermé sur l\'extérieur,\r\nsouvent il y a des enfants et impossible d\'essayer des tricks un peu plus dangereux',	59,	'2023-10-13',	3.0,	2),
(58,	'Bon skatepark avec un couloir street tout en longueur avec plein de modules, rail, curb etc... Le bowl est grand mais il commence a y avoir pas mal de trous et de fissures dedans, un peu dommage.',	60,	'2023-07-07',	4.0,	8);

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
(3,	'La Clusaz',	'la-clusaz'),
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
(21,	'Clermont-Ferrand',	'clermont-ferrand'),
(22,	'Nice',	'Nice'),
(24,	'Rennes',	'Rennes'),
(25,	'Châtel',	'Chatel'),
(26,	'Tignes',	'Tignes'),
(27,	'Avoriaz',	'Avoriaz'),
(28,	'Les 7 Laux',	'Les-7-Laux'),
(29,	'Saint-Lary',	'Saint-Lary'),
(30,	'Chamrousse',	'Chamrousse'),
(31,	'Toulouse',	'Toulouse'),
(33,	'Méribel',	'Meribel');

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
(1,	'Isola_2000',	'original-filename-6fe7d6365710e7c7.jpg',	1),
(2,	'original-filename-f42d6d20428670a5.jpg',	'original-filename-f42d6d20428670a5.jpg',	2),
(3,	'original-filename-358d5cd89dfc73c5.jpg',	'original-filename-358d5cd89dfc73c5.jpg',	3),
(4,	'Bercy',	'original-filename-c04157b5241767b1.jpg',	4),
(5,	'EGP18',	'original-filename-625a48c751ab8d2f.jpg',	5),
(7,	'Le_Hangar',	'original-filename-0aa1d706b87c850c.jpg',	7),
(8,	'HDS',	'original-filename-1e43f28e385025fa.jpg',	8),
(9,	'Le_Havre',	'original-filename-70509a0230c75f36.jpg',	9),
(10,	'Rives_de_Meurthe',	'original-filename-119c817543a7b4aa.jpg',	10),
(11,	'La_Rotonde',	'original-filename-7795cb53a3b16c94.jpg',	11),
(12,	'Sergent_Blandan',	'original-filename-f230db3bff26d9ae.jpg',	12),
(13,	'2_Alpes',	'original-filename-cb13bc7c7ecd823c.jpg',	13),
(14,	'Serre-Chevalier',	'original-filename-45ce972980589159.jpg',	14),
(15,	'Le_Grand_Bornand',	'original-filename-d4c4532f08498f7f.jpg',	15),
(16,	'Isola_2000_2',	'original-filename-b43ef5bcc85eed2a.webp',	1),
(17,	'Vars_Park_2',	'original-filename-cd4e9e9fa05632a4.jpg',	2),
(18,	'La_Cluzaz_3',	'original-filename-78c8e8ff9d85add1.jpg',	3),
(19,	'Bercy_2',	'original-filename-772e6bb2903bb730.jpg',	4),
(20,	'EGP18_2',	'original-filename-b3713e18536d15cd.jpg',	5),
(22,	'Le_Hangar_2',	'original-filename-c9601bfcfd6bc827.jpg',	7),
(23,	'HDS_2',	'original-filename-4f93350a0c1b6e18.jpg',	8),
(24,	'Le_Havre_2',	'original-filename-4d2ab59fd67866ce.jpg',	9),
(25,	'Rives_de_Meurthe_2',	'original-filename-a49ce7d29606bc93.jpg',	10),
(26,	'La_Rotonde_2',	'original-filename-6e79b4ef14e2a874.jpg',	11),
(27,	'Sergent_Blandan_2',	'original-filename-e4817f22c70d53cd.jpg',	12),
(28,	'Les_2_Alpes_2',	'original-filename-8bcbe0f2a3a8be48.jpg',	13),
(29,	'Serre-Chevalier_2',	'original-filename-fe80ce7a895c5638.jpg',	14),
(30,	'Le_Grand_Bornand_2',	'original-filename-3b7b98228d6cdb47.jpg',	15),
(31,	'Isola_2000_3',	'original-filename-dcb5831ca2c32aea.webp',	1),
(32,	'Vars_Park_3',	'original-filename-6014f754ff3c7a39.png',	2),
(33,	'La_Cluzaz_3',	'original-filename-3030c7f7d5d87b86.jpg',	3),
(34,	'Bercy_3',	'original-filename-49b8c8c33bb01169.jpg',	4),
(35,	'EGP18_3',	'original-filename-eed8f6de7c7f184d.jpg',	5),
(37,	'Le_Hangar_3',	'original-filename-1bab05fcce476559.jpg',	7),
(38,	'HDS_3',	'original-filename-2717645a08e87c44.jpg',	8),
(39,	'Le_Havre_3',	'original-filename-bdd8d57b2936bc4c.jpg',	9),
(40,	'Rives_de_Meurthe_3',	'original-filename-a8f081c85db8e3f9.jpg',	10),
(41,	'La_Rotonde_3',	'original-filename-54fddabd1da9baa3.jpg',	11),
(42,	'Sergent_Blandan_3',	'original-filename-ea0de57b16cf5051.jpg',	12),
(43,	'Les_2_Alpes_3',	'original-filename-25b0c1a1de88a9b7.jpg',	13),
(44,	'Serre-Chevalier_3',	'original-filename-a081025c1425b179.jpg',	14),
(45,	'Le_Grand_Bornand_3',	'original-filename-28c57156fed25706.jpg',	15),
(46,	'Jean_Bouin',	'original-filename-4df410c3a194f4ce.jpg',	48),
(47,	'Jean_Bouin_2',	'original-filename-db35271916e29aec.jpg',	48),
(48,	'Jean_Bouin_3',	'original-filename-8e8ca17db335f304.jpg',	48),
(63,	'Falicon',	'original-filename-ca203fcfa7850e54.jpg',	49),
(64,	'Falicon_2',	'original-filename-ba6947ba2fd329ff.jpg',	49),
(65,	'Falicon_3',	'original-filename-db430843a43ad86c.jpg',	49),
(66,	'Marcombes',	'original-filename-678a708bb09dc7fc.jpg',	50),
(67,	'Marcombes_2',	'original-filename-f2334e337a1b976a.jpg',	50),
(68,	'Marcombes_3',	'original-filename-2d54593ed9b334cc.jpg',	50),
(69,	'Arsenal_2',	'original-filename-3f1aba36c2e65247.jpg',	51),
(70,	'Arsenal',	'original-filename-cce83ec0c15505e3.avif',	51),
(71,	'Arsenal',	'original-filename-e4d784c2035ac0fb.jpg',	51),
(72,	'La_Poterie',	'original-filename-3ba64ab7316d84b2.jpg',	52),
(73,	'La_Poterie_2',	'original-filename-01bc9c79e4f641d8.avif',	52),
(74,	'La_Poterie_3',	'original-filename-e52653ad8c5091ff.jpg',	52),
(75,	'7_Laux',	'original-filename-b61c0f7a62f8496d.jpg',	53),
(76,	'7_Laux_2',	'original-filename-61dbf516531db1b9.jpg',	53),
(77,	'7_Laux_3',	'original-filename-0ea46383388289f9.jpg',	53),
(78,	'PDS',	'original-filename-26b8c57354294e98.jpg',	54),
(79,	'PDS_2',	'original-filename-49fabb2fdadeaf0e.jpg',	54),
(80,	'PDS_3',	'original-filename-563464ababfb7a94.jpg',	54),
(81,	'Tignes',	'original-filename-95699faddf116fff.jpg',	55),
(82,	'Tignes_2',	'original-filename-716f36cb83e0cbc0.jpg',	55),
(83,	'Tignes_3',	'original-filename-948e2fc1061caf64.jpg',	55),
(87,	'St_Lary',	'original-filename-3097cae2541d554c.jpg',	57),
(88,	'Saint_Lary_2',	'original-filename-fd30d52130cbc78c.jpg',	57),
(89,	'St_Lary_3',	'original-filename-223d7bdd4350ad58.jpg',	57),
(90,	'Sunset_Park',	'original-filename-e3e67185aacea1fe.jpg',	58),
(91,	'Sunset_Park_2',	'original-filename-52530703da9cd0bc.jpg',	58),
(92,	'Sunset_Park_3',	'original-filename-744de083209930df.jpg',	58),
(93,	'Fougères',	'original-filename-0c9ae91a812a0f3d.jpg',	59),
(94,	'Fougères_2',	'original-filename-3aad9c22935512f5.jpg',	59),
(95,	'Fougères_3',	'original-filename-57ede24ea65930df.jpg',	59),
(96,	'Ponts_Jumeaux',	'original-filename-ca6aabad75f56ad8.jpg',	60),
(97,	'Pont_Jumeaux_2',	'original-filename-546dab4712c83225.jpg',	60),
(98,	'Ponts_Jumeaux_3',	'original-filename-43bf82c87b4ba5e2.jpg',	60),
(99,	'Avoriaz',	'original-filename-ea2ceae86b686052.jpg',	61),
(100,	'Avoriaz_2',	'original-filename-c2dfd3011f4e5756.jpg',	61),
(101,	'Avoriaz_3',	'original-filename-1f5469a787002f83.jpg',	61),
(104,	'Jemmapes',	'original-filename-5cef74ea1b209149.jpg',	68),
(105,	'Jemmapes_2',	'original-filename-e735ed45ce0bfba0.jpg',	68),
(106,	'Jemmapes_3',	'original-filename-b13bb0b1b0ed65cc.jpg',	68);

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
(1,	'Isola 2000',	'Le snowpark d\'Isola 2000 vous propose une expérience exceptionnelle à 2300 mètres d’altitude sur le secteur Marmotte. Découvrez de nouvelles sensations de glisse tous les jours de 10h à 16h dans cet espace ludique et technique, entretenu quotidiennement pour votre plaisir.',	'original-filename-8ba337c43db7325c.jpg',	'Station d\'Isola',	4.5,	1,	'isola-2000'),
(2,	'Vars Park',	'Il y en a pour tout le monde. Le Varspark met un point d\'honneur à démocratiser la pratique du freestyle aussi bien pour les débutants que les spécialistes de la discipline.',	'original-filename-1c89f1151dbeae60.jpg',	'Station de Vars',	NULL,	2,	'vars-park'),
(3,	'LCZ Park',	'Le snowpark de La Cluzaz propose un espace ludique à tous les amateurs de freestyle ! Une multitude de modules est à disposition durant toute la saison pour permettre aux skieurs les plus fous d’exprimer toute leur créativité.',	'original-filename-51c0d06b199f1ea7.jpg',	'Station de La Clusaz',	5.0,	3,	'lcz-park'),
(4,	'Bercy',	'3 mois après le début des travaux, le skatepark de Bercy est ré-ouvert. Belle performance quand on se souvient des déboires des travaux de couverture du skatepark Jules Noël. Notre skatepark de bercy est maintenant doté d\'un toit... fini les dimanches pluvieux sans session.',	'original-filename-b34fffe4e998589c.jpg',	'Rue Raymond Aron, 75012 Paris',	0.0,	4,	'bercy'),
(5,	'EGP18',	'C\'est désormais le plus gros skatepark parisien. Il se compose de parks, de 2  bowls en béton et d\'une fin-box permettant à des patineurs de niveaux variés de rider en indoor pour urface totale de 3545 m².',	'original-filename-576244f19dacbab4.jpg',	'Imp. des Fillettes, 75018 Paris',	5.0,	4,	'egp18'),
(7,	'Le Hangar',	'Un skatepark indoor conçu à partir de matériaux de récupération pour rider proprement sur un florilège de modules : bowl en bois, big ramp, street area… Au Hangar, il y a de quoi faire le plein de sensations ou de frayeurs, ça dépendra de vous.',	'original-filename-0e0534c4a206be9b.jpg',	'9 allée des Vinaigriers - 44300 Nantes',	NULL,	5,	'le-hangar'),
(8,	'Hangar Darwin Skatepark',	'Le skatepark Le Hangar est un skatepark couvert associatif de 5300 m², géré par la Ligue de l\'Enseignement - FAL 44. Accueillant des particuliers et des groupes, il propose des stages, des cours et organise des événements.',	'original-filename-80bcb63f6ce21e9f.jpg',	'87 Quai des Queyries, 33100 Bordeaux',	NULL,	6,	'hangar-darwin-skatepark'),
(9,	'Skatepark du Havre',	'C\'est le plus grand skatepark gratuit à ciel ouvert en France. Elaboré par des spécialistes, le skatepark a été pensé pour offrir une aire de jeux adaptée se prêtant au mieux à l\'exercice de la glisse. Il peut se vanter d\'offrir une aire de street de 600 m² avec des plans inclinés, mais aussi un bowl de 1200 m², soit une aire totale de 1800 m² pour s\'amuser, quelque soit son niveau ou sa pratique.',	'original-filename-f703817580f61b68.jpg',	'27 Boulevard Albert 1er, 76600 Le Havre',	NULL,	7,	'skatepark-du-havre'),
(10,	'Rives de Meurthe',	'Le skatepark des Rives de Meurthe est l\'un des spots de skate les plus populaires de Nancy. Avec ses différentes structures, il offre aux skateurs un lieu idéal pour pratiquer leur sport et développer leur talent.',	'original-filename-a318a135747ad9a9.jpg',	'Av. Charles Etienne Collignon, 54000 Nancy',	3.0,	8,	'rives-de-meurthe'),
(11,	'La Rotonde',	'C\'est l\'un des skateparks les plus réussis de l\'agglomération Strasbourgoise. Il est d\'ailleurs fréquenté par les BMX, skateboards et rollers. Il a été conçu et dessiné par David Mougin, le petit frère de Nicolas Mougin, champion du monde amateur 2003/2004 en rampe.',	'original-filename-046b4209a99d5441.jpg',	'Rue Pierre Nuss, 67200 Strasbourg',	4.5,	9,	'la-rotonde'),
(12,	'Sergent Blandan',	'Très typé street (avec quand même deux trois courbes bien raides par ci par là), ce skatepark est rempli de belles idées. Il faudra quand même un bon niveau pour vraiment en profiter.',	'original-filename-eb9a4b2c3e1cbc4c.jpg',	'Rue de l\'Epargne, 69007 Lyon',	2.5,	10,	'sergent-blandan'),
(13,	'Les 2 Alpes',	'Ce snowpark est connu comme l’un des berceaux du snowboard en France. Les 2 Alpes est un lieu réputé par les spécialistes car il est constamment entretenu et renouvelé et cela tout a long de l’année, des qualités très appréciables pour un park enneigé. Un snowpark hivernal constitué de trois grandes zones ainsi qu’un pipe et un park sur le glacier hors saison. La zone de shred du park d’hiver peut être assez créative et le slopestyle est bien propre. Une zone kids a été ouverte pour les jeunes et riders amateurs sur ce qui est considéré comme un véritable park d’attraction avec des sections pour tous les niveaux.',	'original-filename-9e5bfc93cf86fe13.jpg',	'Station des Deux Alpes',	5.0,	11,	'les-2-Alpes'),
(14,	'Serre-Chevalier',	'Plus grand domaine skiable des Alpes du Sud, Serre Chevalier est aussi l\'un des plus grands domaines d\'Europe avec ses 3 901 hectares. Débutant ou expert, découvrez tout un domaine XXL, par les forêts de mélèzes ou par les sommets offrant des panoramas de montagne exceptionnels.',	'original-filename-f1cb3636fbb5e70d.jpg',	'Station de Serre-Chevalier',	3.5,	12,	'serre-chevalier'),
(15,	'Le Grand Bornand',	'Cette station propose un domaine skiable préservé dans lequel vous pouvez pratiquer de nombreuses disciplines : ski alpin, ski nordique, biathlon, snowboard, ski de randonnée, raquettes, marche nordique, luge.',	'original-filename-c6047084b9409249.jpg',	'Station du Grand Bornand',	5.0,	13,	'le-grand-bornand'),
(48,	'Jean Bouin',	'Le skatepark Jean Bouin à Nice va vous permettre de vous envoler très haut dans le ciel. Ce spot est plutôt réservé aux riders expérimentés voire très expérimentés. Il consiste en une série de longues rampes et de spines avec ensuite quelques gros quarters qui vont vous permettre de jumper à des hauteurs impressionnantes. Rénové il y a peu de temps, ce skatepark est gratuit, mais le port du casque y est obligatoire.',	'original-filename-da1657599a2417ea.jpg',	'2 Rue Jean Allègre, 06000 Nice',	NULL,	22,	'Jean-Bouin'),
(49,	'Comte de Falicon',	'Conçu en partenariat avec le Lycée Vauban et la Fondation Don Bosco, ce skatepark offre aux jeunes des espaces adaptés et sécurisés sur une superficie de 1300m², en dehors de tous risques liés à la pratique en milieu urbain. Second skatepark après celui du plateau Jean Bouin, l’équipement permet d’accueillir des compétitions de niveau national. Il est constitué de deux aires distinctes : le Street Plaza et le Bowl.',	'original-filename-3b18403b084d1b5e.jpg',	'52 avenue du Ray, 06100 Nice',	NULL,	22,	'Comte-de-Falicon'),
(50,	'Philippe Marcombes',	'Le skatepark Philippe Marcombes comporte des modules adaptés à tous les niveaux : débutants, intermédiaires et experts. On y trouve une aire de street de 1200m2 équipée de rails, curb et escaliers, un bowl extérieur de 670m2, un baby park, une mini rampe de 1m85 de haut, un grand quart pipe et une pyramide avec double curb.\r\n\r\nGrâce à cette diversité de modules, chaque skateur peut évoluer à son rythme et progresser en difficulté. Même les skateurs confirmés trouvent à s’amuser grâce aux zones techniques comme le grand bowl et la pyramide.',	'original-filename-06937d3a04b1fb97.jpg',	'121 Av. de la Libération, 63000 Clermont-Ferrand',	3.5,	21,	'Philippe-Marcombes'),
(51,	'Arsenal',	'Ce skatepark axé street accueille beaucoup de riders et de public, avec sets de marches, rails, palettes à wheelings, ainsi qu\'une petite courbe. Curbs, ledges, plans inclinés, surface lisse en béton... Placé au niveau d\'un carrefour à feux, ce spot situé sur l\'axe sud-centre ville bénéficie d\'une très bonne visibilité mais n\'est pas directement éclairé le soir.',	'original-filename-0ccf3cbe9229cabc.jpg',	'30 Bd de la Tour d\'Auvergne, 35000 Rennes',	3.0,	24,	'Arsenal'),
(52,	'La Poterie',	'Que vous soyez fan de skate, de roller, de BMX, ou encore de trottinette, vous êtes sûrs de trouver votre bonheur au skatepark de la Poterie.\r\n\r\nIl possède une multitude de modules qui s\'adaptent aux débutants comme aux confirmés.\r\n\r\nDes curbs, un plan incliné, des rampes, une funbox... Il y a tout ce qu\'il faut.\r\n\r\nGraffitis et béton se mêlent pour une ambiance urbaine idéale pour les sports de glisse.',	'original-filename-841beca737afa77c.jpg',	'Rue Emile Littré, 35200 Rennes',	3.5,	24,	'La-Poterie'),
(53,	'Oakley 7 Laux',	'Une référence en Europe pour les pros, notamment grâce à Oakley qui est partenaire du lieu avec une série de modules originaux à l’image de la marque. On peut ainsi y rider un escalier, un missile, un woops, un éléphant, un air bag et même un chalet !\r\nLa variété de son équipement et structures fait aussi la différence avec également quatre parcours qui correspondent chacun à un niveau, de novices à plus confirmé. Bref, un freestyle park incontournable où l’on peut progresser à son rythme.',	'original-filename-c445609679adf695.jpg',	'Station des 7 Laux',	NULL,	28,	'Oakley-7-Laux'),
(54,	'Portes Du Soleil',	'Sur le domaine des Portes Du Soleil, rails, kickers, slidebox, hips et boarder cross vous attendent. Le Smoothpark de Super-Châtel accueille les freestylers débutants comme les confirmés avec des modules adaptés à tous les niveaux de pratique dans un espace ludique et convivial. Musique et barbecue en guise de cerise sur le gâteau dans ce snowpark de Châtel avec un big half pipe de 120 m de long et un slopestyle de plus de 800 mètres. Avec ses deux téléskis et ses modules bien shapés, ce spot a toutes les qualités des plus grands snowparks mondiaux.',	'original-filename-1393ee81d866867f.jpg',	'Station de Châtel',	NULL,	25,	'Portes-Du-Soleil'),
(55,	'Tignes',	'Situé sur l’envers de Bellevarde, dans la combe du Mont Blanc (2500 m), Tignes est un des plus connus car ce snowpark a eu le privilège d’accueillir la version Européenne des Winter X-Games entre 2010 et 2013. Il possède un atout majeur avec son pipe surdimensionné (le Super-Pipe du Val Claret), pour les plus confirmés. En outre, ce snowpark dispose d’un énorme airbag pour tenter des nouvelles acrobaties sans se faire mal ainsi qu’un innovant système de suivi par caméra bien pratique. Ce spot est idéal pour tous les niveaux de ride.',	'original-filename-9e83846afd373a1a.jpg',	'Station de Tignes/Val d\'Isère',	NULL,	26,	'Tignes'),
(57,	'Saint-Lary',	'Le snowpark de Saint-Lary est aujourd’hui considéré comme la référence dans le milieu du snowboard dans les Pyrénées car il accueille des événements comme la Poney Session ou encore la Coupe du Monde de Freestyle. A Saint-Lary 2400, ce snowpark parrainé par la famille Delerue, propose différentes zones de glisse avec des modules pour tous les niveaux répartis sur plusieurs lignes.\r\n\r\nLe site dispose d’une vingtaine de modules accessibles à tous les âges, constitués de jib, box, rails… Le park est situé à la sortie de la télécabine du col du Portet sur un belle espace ensoleillé.',	'original-filename-31e1f71dcb12b2fe.jpg',	'Station de Saint-Lary',	NULL,	29,	'Saint-Lary'),
(58,	'Sunset Park',	'Le Sunset Park de Chamrousse est réputé pour ses superbes sessions au coucher du soleil (d’où son nom). Ce spot se compose de 4 espaces : le Snowpark, le Kid Park, l’Initiatic Park et le Family Park qui correspondent à des pratiques et niveaux variés.\r\nOutre une vue imprenable sur Grenoble, ce lieu magique est principalement connu pour ses modules très ludiques et son ambiance ultra fun. Un park conçu pour s’amuser, que ce soit entre potes ou en famille et le tout dans un espace sécurisé. La petite station iséroise joue dans la cour des grands avec ce spot composé d’une trentaine de modules en tout genre.',	'original-filename-ebf7c77ecb254b0a.jpg',	'Station de Chamrousse',	NULL,	30,	'Sunset-Park'),
(59,	'Les Fougères',	'Un bien beau skatepark à l\'Est de Paris, porte des Lilas. Le spot est très street, beaucoup de curbs.\r\nPas mal de style aussi : original dans sa construction, avec des modules qu\'on ne voit pas partout. Un look bien intégré intégré au paysage urbain, et une conception franchement sympa.',	'original-filename-297cdad7f9df3f3f.jpg',	'26 Rue de Noisy-le-Sec, 75020 Paris',	3.7,	4,	'Les-Fougeres'),
(60,	'Ponts-Jumeaux',	'Ce skatepark en béton propose une surface de 1400m². Il contient une partie rampe avec un grand bowl (profondeur : 1m80) composé d’un coping (1m20) et d’un ilot central, ainsi qu\'une partie street en longueur avec des ledges et rails en descente sur deux niveaux. Il y a deux niveaux sur ce parcours. La partie inférieure contient des ledges en descente en arêtes, deux longs ledges (30cm et 40cm), une barre, table à manual et un quarter en bout de spot.',	'original-filename-d01f0bb0b58aaeba.jpg',	'Port de l\'Embouchure, 31200 Toulouse',	4.0,	31,	'Ponts-Jumeaux'),
(61,	'Avoriaz',	'Créé en 1993, le spot d’Avoriaz est non seulement le 1er snowpark a avoir vu le jour en France Mais c’est surtout le plus écologique. Notamment grâce à Jake Burton qui a pu y developper le projet “The Stash” avec des modules en bois et murs végétaux entre autres. Avoriaz est est aussi réputée comme la station qui a le plus investi dans le snowboard ces 20 dernières années avec principalement le park d’Arare ou celui de La Chapelle qui feront votre bonheur quel que soit votre niveau et votre âge.',	'original-filename-d129fcf6febd508f.jpg',	'Station d\'Avoriaz',	NULL,	27,	'Avoriaz'),
(68,	'Jemmapes',	'Bien connu de la faune locale à roulettes, le skatepark du quai de Jemmapes fait partie des spots parisiens incontournables. Plutôt pas trop mal situé au bord du canal Saint Martin, assez ensoleillé, bien fréquenté en journée, ce petit park de ville aura de quoi vous combler pour démarrer/clôturer votre session entre potos.',	'original-filename-3f266477dd504fe9.jpg',	'140 quai de Jemmapes, 75010 Paris',	NULL,	4,	'Jemmapes');

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
(7,	1),
(8,	1),
(9,	1),
(10,	1),
(11,	1),
(12,	1),
(13,	2),
(14,	2),
(15,	2),
(48,	1),
(49,	1),
(50,	1),
(51,	1),
(52,	1),
(53,	2),
(54,	2),
(55,	2),
(57,	2),
(58,	2),
(59,	1),
(60,	1),
(61,	2),
(68,	1);

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
(1,	'admin@admin.fr',	'admin',	NULL,	NULL,	'$2y$13$k9zUWlt.ZVNSMYkL.VGsT.t/6UVL6WgmcK8h0ADXsCpfwGt0chfZC',	'[\"ROLE_ADMIN\"]',	'65d8ba170e938.default-profile.png'),
(2,	'rider@user.fr',	'rider',	NULL,	NULL,	'$2y$13$vWrEFRaKjNzEaYQq6NjxsukeLNU.rKxm4pWBNPqihvmjj2O3XJObW',	'[\"ROLE_USER\"]',	'65d8ba2a2a9c6.default-profile.png'),
(4,	'mhysa@user.fr',	'roidelaglisse96',	NULL,	NULL,	'$2y$13$Cvx01.bRvCZo4IY.2ZRg4uq.FzGmEOR9O9XM65gt2XNFC3TpZToCC',	'[\"ROLE_USER\"]',	'65d8b914493b9.kakashi-under-the-rain-green-wallpaper.jpg'),
(5,	'tyrion@user.fr',	'sasha',	NULL,	NULL,	'$2y$13$Ycm.Q2ezapeASNYkZn2gROLR5uKMLvkrtfODtvLBlA3B05yOU4Ocy',	'[\"ROLE_USER\"]',	'65d8bb9f428bc.mwii-s05-reloaded-announcement-016-1693306225115.jpg'),
(8,	'shorty@user.fr',	'shorty',	NULL,	NULL,	'$2y$13$p/.X4JOi495SovmF2d/lNOqy9pW2We6SHI6s8mIp9fVc.79ObrQ96',	'{\"1\":\"ROLE_USER\"}',	'65d8d48ef3a40.Adrien.jpeg'),
(21,	'stitch@user.fr',	'stitch',	NULL,	NULL,	'$2y$13$8MzdkqO68ynnPad0EzcjJ.ydYXtUGgOXPujgi1nbmADJqbVLrMUyy',	'[\"ROLE_USER\"]',	'65d8bfa897ff6.vinyle-decoratif-pour-enfants-stitch.jpg');

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

-- 2024-03-14 16:43:05