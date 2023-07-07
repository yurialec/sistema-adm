-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 07-Jul-2023 às 13:31
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `adm`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_colors`
--

DROP TABLE IF EXISTS `adms_colors`;
CREATE TABLE IF NOT EXISTS `adms_colors` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb3_unicode_ci NOT NULL,
  `color` varchar(44) COLLATE utf8mb3_unicode_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `adms_colors`
--

INSERT INTO `adms_colors` (`id`, `name`, `color`, `created`, `modified`) VALUES
(1, 'Azul', '#0275d8', '2023-07-05 21:04:32', NULL),
(2, 'Cinza', '#868e95', '0000-00-00 00:00:00', NULL),
(3, 'Verde', '#5cb85c', '0000-00-00 00:00:00', NULL),
(4, 'Vermelho', '#d9534f', '0000-00-00 00:00:00', NULL),
(5, 'Laranjado', '#f0ad4e', '0000-00-00 00:00:00', NULL),
(6, 'Azul Claro', '#17a2b8', '0000-00-00 00:00:00', NULL),
(7, 'Cinza Claro', '#343a40', '0000-00-00 00:00:00', NULL),
(8, 'Branco', '#f8f9fa', '0000-00-00 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_confs_emails`
--

DROP TABLE IF EXISTS `adms_confs_emails`;
CREATE TABLE IF NOT EXISTS `adms_confs_emails` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(220) COLLATE utf8mb3_unicode_ci NOT NULL,
  `name` varchar(220) COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(220) COLLATE utf8mb3_unicode_ci NOT NULL,
  `host` varchar(220) COLLATE utf8mb3_unicode_ci NOT NULL,
  `username` varchar(220) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(220) COLLATE utf8mb3_unicode_ci NOT NULL,
  `smtp` varchar(220) COLLATE utf8mb3_unicode_ci NOT NULL,
  `port` int NOT NULL,
  `created` datetime NOT NULL,
  `modified` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `adms_confs_emails`
--

INSERT INTO `adms_confs_emails` (`id`, `title`, `name`, `email`, `host`, `username`, `password`, `smtp`, `port`, `created`, `modified`) VALUES
(1, 'Atendimento', 'Atendimento GetConnTi', 'atendimento@getconnti.com.br', 'sandbox.smtp.mailtrap.io', '597179ee59b197', 'ae16ab6ebb8a02', 'PHPMailer::ENCRYPTION_STARTTLS', 2525, '2023-07-05 14:11:31', NULL),
(2, 'Suporte', 'Suporte Técnico GetConnTi', 'suporte@getconnti.com.br', 'sandbox.smtp.mailtrap.io', '597179ee59b197', 'ae16ab6ebb8a02', 'PHPMailer::ENCRYPTION_STARTTLS', 0, '2023-07-05 19:24:05', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_sits_users`
--

DROP TABLE IF EXISTS `adms_sits_users`;
CREATE TABLE IF NOT EXISTS `adms_sits_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(45) COLLATE utf8mb3_unicode_ci NOT NULL,
  `adms_color` int NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `adms_sits_users`
--

INSERT INTO `adms_sits_users` (`id`, `name`, `adms_color`, `created`, `modified`) VALUES
(1, 'Ativo', 3, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'Inativo', 5, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Aguardando Confirmação', 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Spam', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Descadastrado', 4, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `adms_users`
--

DROP TABLE IF EXISTS `adms_users`;
CREATE TABLE IF NOT EXISTS `adms_users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(220) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `nick_name` varchar(44) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `email` varchar(220) COLLATE utf8mb3_unicode_ci NOT NULL,
  `user` varchar(220) COLLATE utf8mb3_unicode_ci NOT NULL,
  `password` varchar(220) COLLATE utf8mb3_unicode_ci NOT NULL,
  `recover_password` varchar(220) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `conf_email` varchar(220) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `image` varchar(220) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `adms_sits_user_id` int NOT NULL DEFAULT '3',
  `created_at` datetime NOT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Extraindo dados da tabela `adms_users`
--

INSERT INTO `adms_users` (`id`, `name`, `nick_name`, `email`, `user`, `password`, `recover_password`, `conf_email`, `image`, `adms_sits_user_id`, `created_at`, `modified`) VALUES
(1, 'Administrador', NULL, 'admin@getconnti.com.br', 'admin@getconnti.com.br', '$2y$10$F6eU2yd..JUMutFiqoRK1e8kOIxbigHAuI6bq4F3b51Dq4cmnbznG', NULL, NULL, NULL, 1, '2023-07-05 20:07:19', NULL),
(7, 'Yuri 1', NULL, 'yuri1@email.com', 'yuri1@email.com', '$2y$10$.1NoHW0a.qYufJ2cqTHAEefiEzYvMOXpWxuicEPSSL7eQrU3ipanK', NULL, NULL, NULL, 1, '2023-07-06 21:07:14', '2023-07-06 19:37:21'),
(8, 'Yuri2', NULL, 'yuri2@admin.com', 'yuri2@admin.com', '$2y$10$pRcTyeYFWNf2nK6NJDlAwuQvH5A.WeoyT5GmnqO6uTIGMnaFFGx42', NULL, NULL, NULL, 1, '2023-07-06 22:07:37', '2023-07-06 19:46:38');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
