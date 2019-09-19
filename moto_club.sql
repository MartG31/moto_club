-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  jeu. 19 sep. 2019 à 12:35
-- Version du serveur :  10.4.6-MariaDB
-- Version de PHP :  7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `moto_club`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresses`
--

CREATE TABLE `adresses` (
  `id` int(10) UNSIGNED NOT NULL,
  `bal_id` int(10) UNSIGNED DEFAULT NULL,
  `numero` int(11) NOT NULL,
  `libelle` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code_postal` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `titre` varchar(80) NOT NULL,
  `contenu` text NOT NULL,
  `datetime_post` datetime NOT NULL,
  `datetime_modif` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `balades`
--

CREATE TABLE `balades` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `titre` varchar(120) NOT NULL,
  `contenu` text NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `file_gps` varchar(80) DEFAULT NULL,
  `datetime_post` datetime NOT NULL,
  `datetime_modif` datetime DEFAULT NULL,
  `nb_max_pers` int(11) DEFAULT NULL,
  `bal_active` tinyint(1) NOT NULL,
  `insc_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `balades`
--

INSERT INTO `balades` (`id`, `user_id`, `titre`, `contenu`, `date_debut`, `date_fin`, `file_gps`, `datetime_post`, `datetime_modif`, `nb_max_pers`, `bal_active`, `insc_active`) VALUES
(1, 1, 'Trek dans le piémont', 'Amicalistes,\r\n\r\nLe 22 mai 2011, plusieurs amicalistes se sont retrouvés à VILLARD DE LANS à l\'occasion du rassemblement motos et rallye Gendarmerie.\r\n\r\n 3 amicalistes ont participé au rallye et 2 ont été primés (bon d\'achat et souvenir), à savoir Didier F et Gilles R.  sur leur BMW.  Le 3ème (peut-être parcequ\'il n\'avait pas de BMW) est passé tout prêt du podium.\r\n\r\nNous avons pu voir à trois reprises le show de Jean-Pierre GOY sur 3 BMW notamment une R 1200RT et une  1200CL comme celle d\'Alex et Christian ( celle où il a tourné les cascades dans le dernier James Bond) et avons pu papoter avec lui à l\'issue de ses cascades.\r\n\r\nPuis d\'autres amicalistes ont fait leurs emplettes auprès de Christine GOY , concessionnaire WUNDERLICH.( avec 10% de réduc). Accueil très sympa par ailleurs.\r\n\r\nEncore une bonne journée passée ensemble sous un soleil radieux.', '2016-09-22', '2016-09-23', NULL, '2019-09-11 14:48:02', '2019-09-18 23:46:49', NULL, 1, 0),
(2, 1, 'Rassemblement moteurs flat', 'Camarades amateurs de moteurs à plat, bonjour !\r\nNous organisons une rencontre entre les possesseurs de véhicules à moteur FLAT; auto et moto. Cela concerne donc côté auto: les 2CV, les COX, méharis, panhard, diane, GS, porche, ... et plein d\'autres! Côté motos, nous espérons attirer et donc exposer: BMW (bien sûr !) Oural, DNIEPR, .... etc ...\r\nCe premier rassemblement se veut modeste mais convivial, pour cette année. Il se déroulera dans l\'Ain (01), à ST Benoit (proche de Morestel, Belley, les Avenières, ....) le dimanche de la pentecôte (27 mai 2012).\r\nContactez-nous si vous souhaitez nous rejoindre: ce sera avec grand plaisir !Bonne route !\r\n(Claudius: motard en BMW 1200GS, R100 Attelé, R65, R60/6, Dniepr MT16)', '2018-12-25', '2018-12-25', NULL, '2019-09-11 15:55:00', '2019-09-17 00:47:32', NULL, 1, 0),
(3, 1, 'Mémorial SPADINO 2014', 'Cette année, le rassemblement en l\'honneur de SPADINO a changé de date. \r\n\r\nCette manifestation est fixée le we des 26 et 27 avril 2014 avec rassemblement le dimanche 27 avril à COURMAYER (Italie) et non plus à la sortie du tunnel, par mesure de sécurité. La traversée aller et retour du tunnel sera toujours gratuite pour les motards mais il n\'y aura plus de convoi comme l\'an dernier. Chaque moto passera le tunnel en respectant les distances de sécurité ce qui laisse présager  une forte attente  pour traverser le tunnel.  Il conviendra pour ceux qui veulent y participer de bien anticiper leur départ pour éviter de trop attendre. \r\n\r\nPour plus d\'infos, rendez-vous sur le site de Moto Mag par exemple. \r\n\r\nEn ce qui concerne les membres de l\'Amicale BMW 38, on fera le point sur les éventuels participants afin de partir en groupe, à la réunion du mois d\'Avril.', '2014-04-26', '2014-04-27', NULL, '2019-09-11 16:08:44', '2019-09-19 01:06:01', NULL, 1, 0),
(29, 6, 'Tour des Grandes Alpes', 'Vous voulez prendre le grand air et faire le tour des plus belles vallées des Alpes ? Rejoignez pour un parcours autour du massif des Écrins pour s\'en mettre plein. Sensations garanties !', '2017-07-04', '2017-07-05', NULL, '2019-09-17 00:50:55', '2019-09-19 00:36:30', 6, 1, 0),
(36, 2, 'Mont Saint-Michel', 'Petit séjour au Mont Saint-Michel, on ferait le tour de la région et visiterait tous les petits villages du coin, mangerait des omelettes de la mère Poulard et testeraient l\'étanchéité de nos motos', '2019-09-26', '2019-10-05', NULL, '2019-09-18 12:28:11', NULL, NULL, 1, 1),
(38, 2, 'Salon de la Moto 2019', 'Salon de la moto 2019 le 19 et 20 mai 2019 à Paris (porte de Versailles)', '2019-05-19', '2019-05-20', NULL, '2019-09-18 12:35:06', NULL, NULL, 1, 1),
(39, 8, 'Week-end à la campagne', 'On roulerait tout le week-end du 28/09 et on pourrait profiter de ma maison de campagne pour passer la nuit.', '2019-09-28', '2019-09-29', NULL, '2019-09-18 12:38:38', NULL, NULL, 0, 0),
(40, 7, 'Trip en Croatie', 'Salut les amis-calistes,\r\n\r\nJe sais que je m\'y prends un peu tôt mais j\'aimerais organiser un voyage en Croatie tous ensemble sur deux semaines pendant le printemps prochain, histoire de profiter pleinement des magnifiques paysages de l\'Adriatique. Si vous êtes motivés, rejoignez moi au plus vite. \r\n\r\nPour des raisons d\'organisation, je préfère limiter le nombre de personnes à 8 pour l\'instant, mais ce sera peut être amené à évoluer.\r\n\r\nBisous bisous.\r\n\r\nPS : Denis, tu es obligé d\'être de la partie ! (Et laisse un peu Simone tranquille plz)', '2020-05-11', '2020-05-24', NULL, '2019-09-19 00:55:08', NULL, 8, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `comptes_rendus`
--

CREATE TABLE `comptes_rendus` (
  `id` int(11) UNSIGNED NOT NULL,
  `reu_id` int(10) UNSIGNED DEFAULT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `titre` varchar(80) NOT NULL,
  `contenu` text NOT NULL,
  `datetime_post` datetime NOT NULL,
  `datetime_modif` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comptes_rendus`
--

INSERT INTO `comptes_rendus` (`id`, `reu_id`, `user_id`, `titre`, `contenu`, `datetime_post`, `datetime_modif`) VALUES
(4, 3, 2, 'CR idées site', 'Amis..Calistes Bonjour\r\nCela n\'a pas du arriver souvent dans l\'histoire de notre amicale que la réunion du mois de Mai se déroule après le week-end de l\'ascension, qui traditionnellement se situe plutôt vers la fin du mois .\r\nNous étions 28 présents pour déguster le succulent rôti de porc préparé par Martine à qui Gé a tenu à rendre hommage ;\r\nLors de la dernière réunion du mois d\'Avril, on s\'était quitté sur une impasse car le poste de trésorier était resté vacant.Quelques nuits portant conseil ,Denis s\'est porté volontaire pour assumer cette fonction ,et ainsi permettre à notre amicale de continuer à bien fonctionner .\r\nRestait à enteriner ce nouveau bureau par un vote ,ce qui fut fait à l\'unanimité moins 1 voix, celle de l\'époux de l\'ancienne trésorière !!!!\r\nGé a tenu à remercier chaleureusement Geneviève pour le bon travail effectué pendant ces 3 années ,et, au nom de l\'amicale, lui a offert un beau bouquet.\r\nNous souhaitons la bienvenue à Monique et Alain qui nous ont rejoints et ont déjà partcipé à notre week-end de l\'ascension .\r\nA propos de notre périple dans le sud, étant le G.O ,de cette expédition et \r\ndonc peut-être pas le plus objectif ,j\'ai demandé à Michel de nous le résumer .', '2019-09-18 15:00:41', NULL),
(5, 4, 2, 'CR réunion d\'infos', 'Je rajouterai juste que si nous partimes à 20 personnes, nous étions attendus par quelques milliers de moustiques ravis de voir tant de chair fraiche débarquer !! Ils avaient quand meme une préférence pour se poser sur quelques cranes bien dégarnis ...! je ne citerai pas de noms ....\r\nDepuis 14 ans pour ma part ,et bien plus encore pour J PY , je n\'avais jamais eu de telles conditions climatiques aussi exécrables pour un retour .Cela a eu raison de notre programe initial , mais tout le monde est arrivé à bon port , sain et sauf et trempé .Une pensée pour Jean-paul qui a\r\npatienté 1h30 sur le bord de l\'autoroute en attendant son dépanneur ..;et merci à lui pour les photos de groupe en pièces jointes .\r\n', '2019-09-18 15:06:53', NULL),
(7, 6, 2, 'CR Projets', 'Amis... Calistes...Bonjour En cette veille de 11 Novembre,ce n\'était pas la fête de la moto :Keine Motorad sur le trotoir de la \"Boule d\'or \"!! le froid arrive !et rien de tel qu\'une bonne choucroute pour se rechauffer. 21 amicalistes présent ,y compris Pascale M. qui a préféré notre compagnie à une soirée country ..\r\nGuillaume,exeptionellement en France ,nous a offert le champagne en apéro pour fêter son demi siècle et sa nouvelle carrière !! Merci à lui .\r\n BON ANNIVERSAIRE GUILLAUME !!!!\r\nAscension 2018 ,du 10 au13 mai 2018 ;beaucoup de campings contactés sont\r\ndéjà fermés jusqu\'en début d\'année : à suivre Gé nous a fait part de son projet de voyage en Croatie pour fin Aout /début septembre 2018: Dans les grandes lignes :trajet France /Ancona sur 2 jours , traversée en ferry ,5nuits sur Zadar ,et retour par Trieste,Venise Milan ...12 personnes maxi Que ceux qui sont intéréssés le contacte assez rapidement\r\nSorties \"Off Road \"entre France et Italie en juillet ou Aout selon la rapidité de la fonte des neiges ,sur 2 jours;,spécial trails :GS(A) naturlich,mais ,Africa twin\r\n,voire KTM acceptées !!!\r\nA noter :Alpes Aventure Moto festival à Barcelonnette début septembre ...', '2019-09-19 12:32:36', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `membres_balades`
--

CREATE TABLE `membres_balades` (
  `id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `bal_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `membres_balades`
--

INSERT INTO `membres_balades` (`id`, `user_id`, `bal_id`) VALUES
(2, 9, 1),
(3, 10, 1),
(4, 6, 2),
(6, 9, 2),
(7, 8, 3),
(8, 10, 3),
(24, 7, 2),
(32, 8, 1),
(33, 1, 29),
(34, 10, 29),
(35, 1, 36),
(36, 7, 40);

-- --------------------------------------------------------

--
-- Structure de la table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(14) COLLATE utf8mb4_unicode_ci NOT NULL,
  `executed_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `migration_versions`
--

INSERT INTO `migration_versions` (`version`, `executed_at`) VALUES
('20190910122402', '2019-09-10 12:24:09'),
('20190910125943', '2019-09-11 08:14:16'),
('20190910130424', '2019-09-11 08:33:17'),
('20190910171312', '2019-09-11 08:14:17'),
('20190910183740', '2019-09-11 08:14:17'),
('20190911081405', '2019-09-11 08:14:17'),
('20190911082738', '2019-09-11 08:33:17'),
('20190911083912', '2019-09-11 08:39:35'),
('20190911084609', '2019-09-11 08:46:14'),
('20190911084800', '2019-09-11 08:48:03'),
('20190912110023', '2019-09-12 11:00:29'),
('20190915143334', '2019-09-15 14:33:51'),
('20190915182144', '2019-09-15 18:21:50'),
('20190915191804', '2019-09-15 19:19:04'),
('20190916101936', '2019-09-16 17:38:38'),
('20190916144311', '2019-09-16 17:38:38'),
('20190917091657', '2019-09-17 16:38:13'),
('20190917091811', '2019-09-17 16:38:13'),
('20190917091929', '2019-09-17 16:38:13'),
('20190917152943', '2019-09-17 16:38:13'),
('20190917185748', '2019-09-17 18:57:56');

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) UNSIGNED NOT NULL,
  `bal_id` int(10) UNSIGNED DEFAULT NULL,
  `file_name` varchar(80) NOT NULL,
  `legende` varchar(50) DEFAULT NULL,
  `datetime_post` datetime NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `photos`
--

INSERT INTO `photos` (`id`, `bal_id`, `file_name`, `legende`, `datetime_post`, `user_id`) VALUES
(1, 1, '20190918-235228-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:52:28', 1),
(2, 1, '20190918-235231-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:52:31', 1),
(3, 1, '20190918-235236-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:52:36', 1),
(4, 1, '20190918-235241-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:52:41', 1),
(5, 1, '20190918-235300-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:53:00', 1),
(6, 1, '20190918-235305-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:53:05', 1),
(7, 1, '20190918-235312-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:53:12', 1),
(8, 1, '20190918-235318-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:53:18', 1),
(9, 1, '20190918-235329-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:53:29', 1),
(10, 1, '20190918-235333-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:53:33', 1),
(11, 1, '20190918-235336-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:53:36', 1),
(12, 1, '20190918-235340-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:53:40', 1),
(13, 1, '20190918-235343-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:53:43', 1),
(14, 1, '20190918-235347-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:53:47', 1),
(15, 1, '20190918-235352-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:53:52', 1),
(16, 1, '20190918-235358-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:53:58', 1),
(17, 1, '20190918-235401-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:54:01', 1),
(18, 1, '20190918-235405-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:54:05', 1),
(19, 1, '20190918-235409-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:54:09', 1),
(20, 1, '20190918-235413-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:54:13', 1),
(21, 1, '20190918-235427-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:54:27', 1),
(22, 1, '20190918-235430-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:54:30', 1),
(23, 1, '20190918-235435-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:54:35', 1),
(24, 1, '20190918-235439-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:54:39', 1),
(25, 1, '20190918-235443-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:54:43', 1),
(26, 1, '20190918-235447-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:54:47', 1),
(27, 1, '20190918-235502-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:55:02', 1),
(28, 1, '20190918-235506-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:55:06', 1),
(29, 1, '20190918-235511-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:55:11', 1),
(30, 1, '20190918-235515-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:55:15', 1),
(31, 1, '20190918-235518-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:55:18', 1),
(32, 1, '20190918-235522-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:55:22', 1),
(33, 1, '20190918-235531-trek-dans-le-piemont.jpg', NULL, '2019-09-18 23:55:31', 1),
(34, 29, '20190919-004511-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:45:11', 6),
(35, 29, '20190919-004514-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:45:14', 6),
(36, 29, '20190919-004517-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:45:17', 6),
(37, 29, '20190919-004528-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:45:28', 6),
(38, 29, '20190919-004534-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:45:34', 6),
(39, 29, '20190919-004545-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:45:45', 6),
(40, 29, '20190919-004548-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:45:48', 6),
(41, 29, '20190919-004552-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:45:52', 6),
(42, 29, '20190919-004556-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:45:56', 6),
(43, 29, '20190919-004559-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:45:59', 6),
(44, 29, '20190919-004602-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:46:02', 6),
(45, 29, '20190919-004605-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:46:05', 6),
(46, 29, '20190919-004609-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:46:09', 6),
(47, 29, '20190919-004611-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:46:11', 6),
(48, 29, '20190919-004614-tour-des-grandes-alpes.jpg', NULL, '2019-09-19 00:46:14', 6),
(49, 40, '20190919-005611-trip-en-croatie.jpg', NULL, '2019-09-19 00:56:11', 7),
(50, 40, '20190919-005617-trip-en-croatie.jpg', NULL, '2019-09-19 00:56:17', 7),
(51, 40, '20190919-005621-trip-en-croatie.jpg', NULL, '2019-09-19 00:56:21', 7),
(52, 2, '20190919-010214-rassemblement-moteurs-flat.jpg', NULL, '2019-09-19 01:02:14', 7),
(53, 2, '20190919-010212-rassemblement-moteurs-flat.jpg', NULL, '2019-09-19 01:02:12', 7),
(54, 2, '20190919-010217-rassemblement-moteurs-flat.jpg', NULL, '2019-09-19 01:02:17', 7),
(55, 2, '20190919-010220-rassemblement-moteurs-flat.jpg', NULL, '2019-09-19 01:02:20', 7);

-- --------------------------------------------------------

--
-- Structure de la table `reunions`
--

CREATE TABLE `reunions` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `titre` varchar(80) NOT NULL,
  `contenu` text NOT NULL,
  `datetime_reu` datetime NOT NULL,
  `lieu_reu` varchar(80) NOT NULL,
  `type_reu` varchar(30) NOT NULL,
  `datetime_post` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reunions`
--

INSERT INTO `reunions` (`id`, `user_id`, `titre`, `contenu`, `datetime_reu`, `lieu_reu`, `type_reu`, `datetime_post`) VALUES
(1, 3, 'site internet', 'discuter des politiques de confidentialité', '2019-09-19 18:30:00', 'Chez coco', 'bureau', '2019-09-12 10:34:34'),
(2, 2, 'Essais pour le lancement du site', 'On ferait des tests pour voir si tout fonctionne en prévision de lancer le site', '2019-09-19 10:00:00', 'WF3', 'Bureau', '2019-09-18 12:47:47'),
(3, 2, 'Rassemblement des idées pour le site', 'Venez nous donner vos idées pour le site', '2019-09-09 10:00:00', 'WF3', 'AG', '2019-09-18 12:52:15'),
(4, 2, 'Réunion d\'informations été 2019', 'Venez découvrir ce que vous réserve la nouvelle saison lors de cette réunion d\'informations, nous serons au bord du lac et Martin apportera des bières', '2019-08-10 15:00:00', 'QG Asso', 'AG', '2019-09-18 12:56:56'),
(5, 3, 'site internet', 'discuter des politiques de confidentialité', '2019-09-19 18:30:00', 'Chez coco', 'bureau', '2019-09-12 10:34:34'),
(6, 12, 'Réunion sur les projets', 'Balades', '2019-08-10 15:50:00', 'A la boule d\'or', 'Bureau', '2019-09-18 12:29:28'),
(7, 12, 'Réunion sur les motos', 'Quel mécanicien embaucher', '2019-11-12 09:59:00', 'Chez Alain', 'Autre', '2019-09-18 12:32:37'),
(8, 12, 'Réunion sur les routes', 'Demander de meilleures routes', '2019-09-05 20:02:00', 'Chez Alex', 'AG', '2019-09-18 12:34:00');

-- --------------------------------------------------------

--
-- Structure de la table `tokens`
--

CREATE TABLE `tokens` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `token` varchar(160) NOT NULL,
  `datetime_token` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `tokens`
--

INSERT INTO `tokens` (`id`, `user_id`, `token`, `datetime_token`) VALUES
(1, 1, 'a1d3d582cd36b7ac84b1c67cff5759083f6196f5c8a61f55079a68cd403ba1bd72421f2adec84247697f3f13a805b426fac8', '2019-09-14 13:50:00'),
(2, 1, '1616877336c17d7bbdddb830018b8bb497da9f6ea370f53cbb6fbd6349096f26c9b47aaf598c9b1e44f5a02841eb6d6df676', '2019-09-14 13:50:33'),
(3, 2, 'a66468676645c6e891f26120efe9ffdab58455ee683755f45cfeb01d4c68394c8cd00d1a3ec3fa03fd11a80c05ffe83eacc4', '2019-09-18 11:06:05'),
(4, 2, '8ed70fac394a5f932d7c5b87a09a07b61b6467ade50628254ee6bada4349d57cdf86f0855e6b5fbdbb5c535a32c0cd4764ac', '2019-09-18 11:49:06');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(50) NOT NULL,
  `pwd` varchar(80) NOT NULL,
  `acces` varchar(10) NOT NULL,
  `pseudo` varchar(50) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `avatar` varchar(120) DEFAULT NULL,
  `datetime_inscription` datetime NOT NULL,
  `datetime_adhesion` datetime DEFAULT NULL,
  `adresse` varchar(120) NOT NULL,
  `cp` varchar(10) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `date_naiss` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `email`, `pwd`, `acces`, `pseudo`, `nom`, `prenom`, `avatar`, `datetime_inscription`, `datetime_adhesion`, `adresse`, `cp`, `ville`, `telephone`, `date_naiss`) VALUES
(1, 'mg.martingagne@gmail.com', '$2y$10$/Dir5uFhpYgwletCk4/l5.D8YAm3MQPGSq3NVSzGXAUAqB3YeyoQG', 'admin', 'Moundzouk', 'Gagne', 'Martin', '20190919-120750-1.jpg', '2019-09-03 10:59:54', NULL, '431 chemin de Crabille', '31470', 'Saint-Lys', '0687396437', '1991-10-19'),
(2, 'mathieu.webforce3@gmail.com', '$2y$10$SkNdNrph5tizp5Bf320CcOHzWqm1ERgYp1EdKTMyZCS2i9CQT4KAu', 'admin', NULL, 'Capdeville', 'Mathieu', NULL, '2019-09-03 12:16:35', NULL, '52 rue des Olivers', '81100', 'Castres', '0123456789', '1990-06-29'),
(3, 'alice@wf3.com', '$2y$10$p4cwJNA6NqXkltE3iPDIveD7.q2wRsvRfXcoD4EcD0jX7RRQMyk/u', 'admin', NULL, 'Alix', 'Alice', NULL, '2019-09-04 12:20:54', NULL, '126 chemin de la Farigoule', '13080', 'Aix-en-Provence', '0123456789', '1986-09-18'),
(6, 'alain.proust@free.fr', '$2y$10$xgaT/CU43oPZE07JqS.I0.qi.FDMMozf8MdgUuej6rRJ7uTKA3iTi', 'bureau', NULL, 'Proust', 'Alain', '20190919-120956-6.jpg', '2019-09-07 12:34:31', '2019-09-08 17:12:57', '98 avenue de la Contamine', '38210', 'Tullins', '0564879564', '1972-03-22'),
(7, 'joanna.beauchamp@free.fr', '$2y$10$vjqPODnnXjBGG8uaA9Ltq.NoYwtexBOd0CmB9w9ai2Fslw3qzVG6S', 'bureau', '', 'Beauchamp', 'Joanna', '20190919-121035-7.png', '2019-09-13 12:39:07', NULL, '78 rue de Strasbourg', '63000', 'Clermont-Ferrand', '0435763654', '1982-04-22'),
(8, 'simone.dionne@free.fr', '$2y$10$tc3GKi9oOVNza0jE/x8vbuVZ1jbxSWVPWy0m6oavB0no/N9Y0bNWy', 'adherent', NULL, 'Dionne', 'Simone', '20190919-121144-8.jpg', '2019-09-13 12:44:01', NULL, '31 chemin Challet', '87000', 'Limoges', '0564896715', '1959-03-21'),
(9, 'bertrand.labrie@free.fr', '$2y$10$KLo5eQttqFTnGzqwiHXXiudGz05cwDBNecJfJcWwX0KjP.QISL49W', 'bureau', NULL, 'Labrie', 'Bertrand', NULL, '2019-09-15 12:28:52', NULL, '85 rue du Général Ailleret', '97139', 'Les Abymes', '0587309198', '1981-05-20'),
(10, 'audrey.souplet@free.fr', '$2y$10$OnzlTTpJjD.TYFQlbZ22Z.rfzYvytWivKhbGpoQzQx/a4l2oHJSoe', 'adherent', NULL, 'Souplet', 'Audrey', NULL, '2019-09-15 12:32:08', NULL, '99 rue Marie de Médicis', '34500', 'Béziers', '0468774517', '1970-09-08'),
(11, 'theodore.auger@free.fr', '$2y$10$YMiBQZxbwmBQWSoQJ5sokuNhX4gjVrOdn6TnM2uHOaDyjntms5uuW', 'membre', NULL, 'Auger', 'Théodore', NULL, '2019-09-15 12:33:26', NULL, '35 rue St Ferréol', '92360', 'Meudon-la-Forêt', '0174193770', '1961-12-06'),
(12, 'marion.fredet@superlicorne.fr', '$2y$10$xPO2UEdzUs/TIUQxUMt1WODrLUTLcBLl41HcsyFO2RKjUQrTC9KHu', 'admin', NULL, 'FREDET', 'Marion', '20190919-121117-12.jpg', '2019-09-18 10:31:31', NULL, '23 avenue des licornes (appt 67)', '31697', 'Unicorncity', '0619437619', '1789-04-01'),
(14, 'simon.cathala@wf3.com', '$2y$10$UEwBNTWjnWVUKkr.i8bWZubkW1TGc9lbECTUUehzLUXj3gaM7AJ76', 'admin', NULL, 'CATHALA', 'Simon', NULL, '2019-09-18 10:39:39', NULL, '666 rue des guillotines', '31444', 'Toulouse', '0637619437', '1985-12-27');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `adresses`
--
ALTER TABLE `adresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_adresses_bal_id` (`bal_id`);

--
-- Index pour la table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_art_user_id` (`user_id`);

--
-- Index pour la table `balades`
--
ALTER TABLE `balades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bal_user_id` (`user_id`);

--
-- Index pour la table `comptes_rendus`
--
ALTER TABLE `comptes_rendus`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_cr_reu_id` (`reu_id`),
  ADD KEY `fk_cr_user_id` (`user_id`);

--
-- Index pour la table `membres_balades`
--
ALTER TABLE `membres_balades`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_mb_bal_id` (`bal_id`),
  ADD KEY `fk_mb_user_id` (`user_id`);

--
-- Index pour la table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_photos_bal_id` (`bal_id`),
  ADD KEY `IDX_876E0D9A76ED395` (`user_id`);

--
-- Index pour la table `reunions`
--
ALTER TABLE `reunions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reu_user_id` (`user_id`);

--
-- Index pour la table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tok_user_id` (`user_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `adresses`
--
ALTER TABLE `adresses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `balades`
--
ALTER TABLE `balades`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pour la table `comptes_rendus`
--
ALTER TABLE `comptes_rendus`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `membres_balades`
--
ALTER TABLE `membres_balades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT pour la table `reunions`
--
ALTER TABLE `reunions`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `adresses`
--
ALTER TABLE `adresses`
  ADD CONSTRAINT `FK_EF192552B85C0596` FOREIGN KEY (`bal_id`) REFERENCES `balades` (`id`);

--
-- Contraintes pour la table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `fk_art_user_id` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `balades`
--
ALTER TABLE `balades`
  ADD CONSTRAINT `FK_3ED88FFA76ED395` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `comptes_rendus`
--
ALTER TABLE `comptes_rendus`
  ADD CONSTRAINT `FK_46141761631BB9D8` FOREIGN KEY (`reu_id`) REFERENCES `reunions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_cr_user_id` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `membres_balades`
--
ALTER TABLE `membres_balades`
  ADD CONSTRAINT `FK_A602F006A76ED395` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `FK_A602F006B85C0596` FOREIGN KEY (`bal_id`) REFERENCES `balades` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `FK_876E0D9A76ED395` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`),
  ADD CONSTRAINT `fk_photos_bal_id` FOREIGN KEY (`bal_id`) REFERENCES `balades` (`id`);

--
-- Contraintes pour la table `reunions`
--
ALTER TABLE `reunions`
  ADD CONSTRAINT `fk_reu_user_id` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`);

--
-- Contraintes pour la table `tokens`
--
ALTER TABLE `tokens`
  ADD CONSTRAINT `fk_tok_user_id` FOREIGN KEY (`user_id`) REFERENCES `utilisateurs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
