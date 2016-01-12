-- phpMyAdmin SQL Dump
-- version 4.2.5
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Mar 12 Janvier 2016 à 09:29
-- Version du serveur :  5.5.38
-- Version de PHP :  5.5.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `pyscan`
--

-- --------------------------------------------------------

--
-- Structure de la table `linkchecked`
--

CREATE TABLE `linkchecked` (
`id` int(11) NOT NULL,
  `website` text NOT NULL,
  `checkeding` int(11) NOT NULL DEFAULT '0',
  `date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `logs`
--

CREATE TABLE `logs` (
`id` int(11) NOT NULL,
  `date_insert` text NOT NULL,
  `domain` text NOT NULL,
  `lien` text NOT NULL,
  `unread` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `payloadcve`
--

CREATE TABLE `payloadcve` (
`id` int(11) NOT NULL,
  `name` text NOT NULL,
  `payload` text NOT NULL,
  `pattern` text NOT NULL,
  `result` text NOT NULL,
  `perform` text NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `payloadcve`
--

INSERT INTO `payloadcve` (`id`, `name`, `payload`, `pattern`, `result`, `perform`) VALUES
(1, 'String injection', 'id=', 'id=''', 'SQL syntax', 'result'),
(2, 'String array', 'id=1', 'id=1[]''', 'SQL syntax', 'result'),
(3, 'String index', 'index=', 'index=''', 'SQL', 'result'),
(4, 'Blind', 'id=1', 'id=1%20AND%201=2', 'SQL', 'compare');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
`id` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `username`, `password`) VALUES
(1, 'root', '7b24afc8bc80e548d66c4e7ff72171c5');

-- --------------------------------------------------------

--
-- Structure de la table `vuln_logs`
--

CREATE TABLE `vuln_logs` (
`id` int(11) NOT NULL,
  `date_insert` text NOT NULL,
  `domain` text NOT NULL,
  `lien` text NOT NULL,
  `typeinjection` text NOT NULL,
  `sourcepage` text NOT NULL,
  `unread` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `linkchecked`
--
ALTER TABLE `linkchecked`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `logs`
--
ALTER TABLE `logs`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `payloadcve`
--
ALTER TABLE `payloadcve`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
 ADD PRIMARY KEY (`id`);

--
-- Index pour la table `vuln_logs`
--
ALTER TABLE `vuln_logs`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `linkchecked`
--
ALTER TABLE `linkchecked`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `logs`
--
ALTER TABLE `logs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `payloadcve`
--
ALTER TABLE `payloadcve`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `vuln_logs`
--
ALTER TABLE `vuln_logs`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
