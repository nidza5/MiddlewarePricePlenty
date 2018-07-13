-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 11, 2018 at 02:34 PM
-- Server version: 10.1.33-MariaDB
-- PHP Version: 7.1.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `plentyintegration`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(10) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `title`, `body`, `created_at`, `updated_at`) VALUES
(1, 'Quos architecto fugiat consequuntur.', 'Magni veniam iusto occaecati dolor eveniet qui commodi. Omnis tempore iure id suscipit aut qui aut enim. Esse asperiores praesentium dolorem est.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(2, 'Et rerum facere deleniti voluptates ad ullam.', 'Dolores qui ab laboriosam impedit. Consectetur vero optio ex. Culpa quia nesciunt voluptate enim. Ipsa iste officiis quibusdam velit.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(3, 'Nihil totam voluptatum enim dolorem sequi.', 'Explicabo sunt et amet atque. Repellat velit illo a odit qui ut accusantium unde. A debitis animi minima enim non.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(4, 'Cumque velit quam sit quam.', 'Qui voluptatem dolorem aut nemo commodi repudiandae qui. Sunt magnam labore magnam. Similique vel velit similique rerum et.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(5, 'Culpa vel ea optio veniam.', 'Et ut illo aliquam asperiores maxime quod. Explicabo atque vel omnis atque. Aperiam nobis dolore in est quasi dolores facilis. Ducimus iusto velit nostrum corrupti unde accusamus cupiditate dolores.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(6, 'Sunt eaque ducimus iure error sint.', 'Qui eos incidunt accusantium voluptate vel sint tempore. Sit ut non quia eos voluptas consequuntur. Facilis nam non quos exercitationem nihil occaecati.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(7, 'Id molestiae in aut nihil ea voluptate explicabo.', 'Sint aut nostrum sequi dolores. Quidem et ut velit vero dolorem. Odio voluptas provident qui voluptatibus.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(8, 'Et quibusdam id dolores commodi rerum qui.', 'Molestias veniam qui nostrum tempore adipisci sit qui. Ea unde labore eos odio esse nesciunt. Modi impedit non sunt.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(9, 'Saepe et error quam et.', 'Amet iure alias cupiditate perspiciatis. Incidunt enim explicabo temporibus aspernatur harum. Asperiores cumque molestiae dolorem aut.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(10, 'Impedit omnis nulla doloribus iusto enim.', 'Molestiae labore voluptas eos omnis. In consectetur aut ab rem dolorem et ab. Delectus harum at ut fugiat incidunt eum culpa deleniti.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(11, 'Enim officia ipsam qui ut.', 'Exercitationem quasi nesciunt aut eos mollitia. Rem non adipisci perferendis et repellendus et minima. Quia blanditiis quo enim sint et deserunt eveniet.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(12, 'Est dicta eum optio similique autem ratione odio.', 'Omnis amet sunt repellat quis ducimus explicabo. Autem eum et sit deserunt. Atque ducimus qui nobis molestiae ea est voluptas.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(13, 'Ut culpa deleniti a consequuntur ut.', 'Adipisci quae excepturi illo ipsum. Libero temporibus ab nobis eligendi id. Quas sapiente eveniet reprehenderit provident. Et quasi magnam illum.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(14, 'Quia consequatur explicabo alias quia commodi.', 'Qui quia qui maiores qui aspernatur. Aperiam provident maxime quo et omnis. Nam eaque porro odio illum harum atque. Est pariatur architecto officia quia est et.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(15, 'Minus officia non qui.', 'Eum dolore a nemo nisi. Pariatur rerum aliquam aperiam rerum omnis. Nemo in et deserunt.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(16, 'Id accusamus eligendi illum assumenda ut numquam.', 'Voluptatem commodi sit et earum quaerat. Nam aliquid rem quam vel nihil id culpa. Aut eveniet quia temporibus qui doloremque et consequatur.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(17, 'Est quis itaque aut sequi.', 'Recusandae aut voluptatem animi quam eos quis animi. Ut vel quia quia accusantium quia. Dolores eius nihil debitis ea quo.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(18, 'Corporis accusamus ullam quo.', 'Repudiandae cumque vitae molestias incidunt aut ea quia. Fugit a voluptate labore voluptates sunt inventore. Temporibus ea totam ex ut. Aspernatur tenetur dicta omnis corporis.', '2018-07-06 09:32:08', '2018-07-06 09:32:08'),
(19, 'Eius et veniam et doloremque repellat aut.', 'Facere sapiente ullam molestias fuga veritatis repellendus. Est quo atque voluptatem eos repellendus atque.', '2018-07-06 09:32:09', '2018-07-06 09:32:09'),
(20, 'Est sint ut blanditiis facere quis magni.', 'Temporibus doloribus qui maxime ullam. Qui odit ut excepturi modi quisquam. Dolore et molestiae consequatur eum quibusdam. Rerum laudantium aspernatur et quisquam.', '2018-07-06 09:32:09', '2018-07-06 09:32:09'),
(21, 'Hic quo hic amet fuga reiciendis natus sapiente.', 'Dolorem harum eligendi cum ad. Beatae sit dolores sint voluptate facilis ad voluptate. Minus qui aliquid voluptas quod. Architecto eos est quos.', '2018-07-06 09:32:09', '2018-07-06 09:32:09'),
(22, 'In dolorem rerum rem laudantium.', 'Autem hic ut molestiae repellendus voluptates id. Dolorum libero cupiditate dolor eos. Et unde hic iure. Ullam sapiente voluptatem sed qui vero.', '2018-07-06 09:32:09', '2018-07-06 09:32:09'),
(23, 'Velit et atque dignissimos nihil id qui.', 'Laudantium quis odio repellat soluta. Voluptatum alias id officiis nihil aut. Laudantium qui officia sed nemo exercitationem assumenda a. Iste ea numquam rem vel quod id.', '2018-07-06 09:32:09', '2018-07-06 09:32:09'),
(24, 'Similique nihil ea sit autem accusantium minima.', 'Sed sed numquam neque at eum aliquam consequatur at. Ut ex minima aut in. Ullam sint enim et adipisci.', '2018-07-06 09:32:09', '2018-07-06 09:32:09'),
(25, 'Atque delectus sunt dicta.', 'Hic voluptatum in odio fuga est consequatur soluta. Qui quisquam odio mollitia eum rerum odio nihil sint. Quasi dolor qui aliquam delectus. Aut eos laborum est ut modi.', '2018-07-06 09:32:09', '2018-07-06 09:32:09'),
(26, 'Porro culpa sed a aut blanditiis mollitia nihil.', 'Et eius numquam ut esse ipsam architecto non. Facilis omnis assumenda excepturi cumque molestias et. Consequatur voluptates quo quis architecto qui iure esse odio. Fugit magni aut tenetur eum.', '2018-07-06 09:32:09', '2018-07-06 09:32:09'),
(27, 'Incidunt et aut illum autem.', 'Aut facere laudantium sed magnam aut suscipit non voluptatibus. Laboriosam doloremque officia quasi autem. Ratione et voluptates facere cumque qui.', '2018-07-06 09:32:09', '2018-07-06 09:32:09'),
(28, 'Non consequatur cumque id itaque dolor.', 'Ab dolor dolorum eius ut rerum. Consequuntur perferendis veritatis et quia. Nihil facilis vel et. Omnis rerum qui id dolorem hic.', '2018-07-06 09:32:09', '2018-07-06 09:32:09'),
(29, 'Ex dicta harum et nesciunt. Non id ipsa odit aut.', 'Qui id sed non fugit. Ab commodi ea voluptas quas at iure. Distinctio autem velit iusto et quas illo est. Aliquam dignissimos placeat aspernatur accusamus.', '2018-07-06 09:32:09', '2018-07-06 09:32:09'),
(30, 'Ducimus et qui eveniet quasi.', 'Sed maiores sint deserunt molestias sunt. Eos autem alias laboriosam veritatis eos. Ut dolor molestias fugit possimus itaque praesentium aut. Blanditiis porro quis consequuntur sapiente aut rerum.', '2018-07-06 09:32:09', '2018-07-06 09:32:09');

-- --------------------------------------------------------

--
-- Table structure for table `attributemapping`
--

CREATE TABLE `attributemapping` (
  `id` int(10) UNSIGNED NOT NULL,
  `attributeCode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priceMonitorCode` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operand` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contractId` int(11) NOT NULL,
  `priceMonitorContractId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `attributemapping`
--

INSERT INTO `attributemapping` (`id`, `attributeCode`, `priceMonitorCode`, `operand`, `value`, `contractId`, `priceMonitorContractId`) VALUES
(43, 'GTIN13', 'gtin', '', '', 9, '3p7h3i'),
(44, 'VariationN', 'name', '', '', 9, '3p7h3i'),
(45, '1', 'referencePrice', '', '', 9, '3p7h3i'),
(46, '1', 'minPriceBoundary', 'add', '3', 9, '3p7h3i'),
(47, '2', 'maxPriceBoundary', 'mul', '5', 9, '3p7h3i'),
(48, 'VariationNo', 'gffdgdfgd', '', '', 9, '3p7h3i');

-- --------------------------------------------------------

--
-- Table structure for table `configinfo`
--

CREATE TABLE `configinfo` (
  `id` int(10) UNSIGNED NOT NULL,
  `key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `configinfo`
--

INSERT INTO `configinfo` (`id`, `key`, `value`) VALUES
(1, 'email', 'goran.stamenkovski@logeecom.com'),
(2, 'password', 'Goran');

-- --------------------------------------------------------

--
-- Table structure for table `contract`
--

CREATE TABLE `contract` (
  `id` int(10) UNSIGNED NOT NULL,
  `priceMonitorId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salesPricesImport` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `isInsertSalesPrice` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contract`
--

INSERT INTO `contract` (`id`, `priceMonitorId`, `name`, `salesPricesImport`, `isInsertSalesPrice`) VALUES
(9, '3p7h3i', 'Test account for shopware', '1,2', 1),
(10, 'ctoefp', 'Testcontract 2', '', 0),
(11, '3c1vnr', 'Testcontract 3', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2018_07_06_110407_create_articles_table', 1),
(4, '2018_07_06_140708_create_contract_table', 2),
(5, '2018_07_07_200128_create_config_info_table', 3),
(6, '2018_07_09_142654_create_product_filter_table', 4),
(7, '2018_07_10_122903_create_attribute_mapping_table', 5),
(8, '2018_07_11_065115_create_schedule_table', 6),
(9, '2018_07_11_080607_update_schedule_default_values', 7),
(10, '2018_07_11_082110_create_price_monitor_table', 8),
(11, '2018_07_11_085116_create_runner_token_table', 9);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pricemonitorqueue`
--

CREATE TABLE `pricemonitorqueue` (
  `id` int(10) UNSIGNED NOT NULL,
  `queueName` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `reservationTime` datetime NOT NULL,
  `attempts` int(11) NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productfilter`
--

CREATE TABLE `productfilter` (
  `id` int(10) UNSIGNED NOT NULL,
  `contractId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `serializedFilter` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `productfilter`
--

INSERT INTO `productfilter` (`id`, `contractId`, `type`, `serializedFilter`) VALUES
(1, '3p7h3i', 'export_products', 'C:45:\"Patagona\\Pricemonitor\\Core\\Sync\\Filter\\Filter\":681:{a:3:{s:4:\"type\";s:15:\"export_products\";s:8:\"operator\";s:2:\"OR\";s:11:\"expressions\";a:1:{i:0;C:44:\"Patagona\\Pricemonitor\\Core\\Sync\\Filter\\Group\":530:{a:3:{s:4:\"name\";s:7:\"Group 1\";s:8:\"operator\";s:3:\"AND\";s:11:\"expressions\";a:2:{i:0;C:49:\"Patagona\\Pricemonitor\\Core\\Sync\\Filter\\Expression\":164:{a:5:{s:8:\"operator\";s:2:\"OR\";s:5:\"field\";s:10:\"VariationN\";s:9:\"condition\";s:5:\"equal\";s:9:\"valueType\";s:6:\"string\";s:6:\"values\";a:1:{i:0;s:16:\"dzoni varijacija\";}}}i:1;C:49:\"Patagona\\Pricemonitor\\Core\\Sync\\Filter\\Expression\":151:{a:5:{s:8:\"operator\";s:2:\"OR\";s:5:\"field\";s:11:\"VariationNo\";s:9:\"condition\";s:5:\"equal\";s:9:\"valueType\";s:6:\"string\";s:6:\"values\";a:1:{i:0;s:3:\"131\";}}}}}}}}}'),
(2, '3p7h3i', 'import_prices', 'C:45:\"Patagona\\Pricemonitor\\Core\\Sync\\Filter\\Filter\":660:{a:3:{s:4:\"type\";s:13:\"import_prices\";s:8:\"operator\";s:2:\"OR\";s:11:\"expressions\";a:1:{i:0;C:44:\"Patagona\\Pricemonitor\\Core\\Sync\\Filter\\Group\":511:{a:3:{s:4:\"name\";s:7:\"Group 1\";s:8:\"operator\";s:3:\"AND\";s:11:\"expressions\";a:2:{i:0;C:49:\"Patagona\\Pricemonitor\\Core\\Sync\\Filter\\Expression\":145:{a:5:{s:8:\"operator\";s:2:\"OR\";s:5:\"field\";s:3:\"UPC\";s:9:\"condition\";s:5:\"equal\";s:9:\"valueType\";s:6:\"string\";s:6:\"values\";a:1:{i:0;s:6:\"257852\";}}}i:1;C:49:\"Patagona\\Pricemonitor\\Core\\Sync\\Filter\\Expression\":151:{a:5:{s:8:\"operator\";s:2:\"OR\";s:5:\"field\";s:11:\"VariationNo\";s:9:\"condition\";s:5:\"equal\";s:9:\"valueType\";s:6:\"string\";s:6:\"values\";a:1:{i:0;s:3:\"158\";}}}}}}}}}');

-- --------------------------------------------------------

--
-- Table structure for table `runnertoken`
--

CREATE TABLE `runnertoken` (
  `id` int(10) UNSIGNED NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(10) UNSIGNED NOT NULL,
  `enableExport` tinyint(1) NOT NULL DEFAULT '0',
  `enableImport` tinyint(1) NOT NULL DEFAULT '0',
  `exportStart` datetime NOT NULL,
  `exportInterval` int(11) NOT NULL,
  `nextStart` datetime NOT NULL,
  `contractId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `enableExport`, `enableImport`, `exportStart`, `exportInterval`, `nextStart`, `contractId`) VALUES
(1, 1, 0, '2018-07-25 06:00:00', 15, '2018-07-25 06:00:00', 9);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributemapping`
--
ALTER TABLE `attributemapping`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `configinfo`
--
ALTER TABLE `configinfo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contract`
--
ALTER TABLE `contract`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pricemonitorqueue`
--
ALTER TABLE `pricemonitorqueue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `productfilter`
--
ALTER TABLE `productfilter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `runnertoken`
--
ALTER TABLE `runnertoken`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `attributemapping`
--
ALTER TABLE `attributemapping`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `configinfo`
--
ALTER TABLE `configinfo`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contract`
--
ALTER TABLE `contract`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `pricemonitorqueue`
--
ALTER TABLE `pricemonitorqueue`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `productfilter`
--
ALTER TABLE `productfilter`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `runnertoken`
--
ALTER TABLE `runnertoken`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
