-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 29 avr. 2026 à 00:14
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `digital_store`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Téléphones'),
(2, 'Ordinateurs'),
(4, 'PC Portables'),
(5, 'Écrans'),
(6, 'Souris'),
(7, 'Claviers'),
(8, 'TV'),
(9, 'Imprimantes');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `order_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total`, `order_date`) VALUES
(6, 4, 2645.00, '2026-04-26 01:15:04'),
(7, 3, 2685.00, '2026-04-26 01:16:00'),
(8, 5, 1598.00, '2026-04-26 01:24:05'),
(10, 3, 1595.00, '2026-04-26 09:42:41');

-- --------------------------------------------------------

--
-- Structure de la table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(9, 6, 1, 1, 2600.00),
(10, 6, 3, 1, 45.00),
(11, 7, 6, 1, 1650.00),
(12, 7, 19, 1, 145.00),
(13, 7, 28, 1, 890.00),
(14, 8, 17, 1, 299.00),
(15, 8, 22, 1, 1299.00),
(16, 10, 3, 1, 45.00),
(17, 10, 8, 1, 1550.00);

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `image`, `category_id`) VALUES
(1, 'iPhone 13', 2600.00, '1777156897_69ed4321a3bfa.jpg', 1),
(2, 'PC HP', 1800.00, '1777157735_69ed4667156bb.jpg', 2),
(3, 'Souris Logitech', 45.00, '1777157778_69ed46927296c.jpg', 6),
(5, 'Laptop Dell Inspiron 15', 1899.00, '1777157827_69ed46c345fd6.jpg', 4),
(6, 'Laptop HP Pavilion 14', 1650.00, '1777157874_69ed46f2b4b5a.jpg', 4),
(7, 'Lenovo ThinkPad T14', 2490.00, '1777157948_69ed473ca79cf.jpg', 4),
(8, 'ASUS VivoBook 15', 1550.00, '1777157974_69ed4756b19eb.jpg', 4),
(9, 'MacBook Air M1', 3199.00, '1777158011_69ed477bac6d0.jpg', 4),
(10, 'Écran Samsung 24 pouces', 430.00, '1777158076_69ed47bc6ca4b.jpg', 5),
(11, 'Écran LG UltraGear 27 pouces', 899.00, '1777158110_69ed47de02be3.jpg', 5),
(12, 'Écran Dell 22 pouces', 360.00, '1777158159_69ed480fd1b79.jpg', 5),
(13, 'Écran ASUS 27 pouces', 720.00, '1777158193_69ed483113b06.jpg', 5),
(14, 'Souris Logitech M185', 39.00, '1777158292_69ed4894ebfa8.jpg', 6),
(15, 'Souris Gaming Razer DeathAdder', 189.00, '1777158325_69ed48b56a157.jpg', 6),
(16, 'Souris HP Wireless', 55.00, '1777158350_69ed48cec72fe.jpg', 6),
(17, 'Souris Logitech MX Master 3', 299.00, '1777158383_69ed48eff32cd.jpg', 6),
(18, 'Clavier Logitech K120', 45.00, '1777158418_69ed491280327.jpg', 7),
(19, 'Clavier Gaming Redragon', 145.00, '1777158448_69ed493015660.jpg', 7),
(20, 'Clavier mécanique Razer', 390.00, '1777158484_69ed49546f05c.jpg', 7),
(21, 'Clavier HP USB', 49.00, '1777158535_69ed49877e4fb.jpg', 7),
(22, 'TV Samsung 43 pouces Smart TV', 1299.00, '1777158563_69ed49a3c6ab2.jpg', 8),
(23, 'TV LG 55 pouces 4K', 1999.00, '1777158594_69ed49c2912ea.jpg', 8),
(24, 'TV TCL 50 pouces Android TV', 1499.00, '1777158625_69ed49e1ba481.jpg', 8),
(25, 'TV Hisense 43 pouces', 1099.00, '1777158657_69ed4a0187c12.jpg', 8),
(26, 'Imprimante HP LaserJet', 480.00, '1777158695_69ed4a27d6aec.jpg', 9),
(27, 'Imprimante Canon Pixma', 320.00, '1777158720_69ed4a406a55f.jpg', 9),
(28, 'Imprimante Epson EcoTank', 890.00, '1777158754_69ed4a626adc0.jpg', 9),
(29, 'Imprimante Brother Laser', 740.00, '1777158787_69ed4a8321184.jpg', 9);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` varchar(30) DEFAULT 'client'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(1, 'Admin', 'admin@gmail.com', '1234', 'admin'),
(3, 'kharrat', 'kharrat@gmail.com', '1234', 'client'),
(4, 'dali', 'dali@gmail.com', '1234', 'client'),
(5, 'Hemriti', 'hemriti@gmail.com', '1234', 'client');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Index pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
