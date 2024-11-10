-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 10, 2024 at 04:47 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `BeautySkin`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('client','admin') DEFAULT 'client',
  `registration_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `email`, `password`, `role`, `registration_date`) VALUES
(1, 'admin@beauty-skin.com', '$2y$10$gav.45UGYqcaPQMxks4vAuyaGoXbFSFPSi7TDijE90S1YY2nKekcu', 'admin', '2024-05-05 11:58:33'),
(2, 'theanh24013@gmail.com', '$2y$10$PO043.2W8GpljSwLUcu/U./TXvChDsDau5GfDzUccxCRR7D/l7diG', 'client', '2024-10-10 13:32:11'),
(3, 'lily@gmail.com', '$2y$10$qiBLXwkS.xW4JMhfjgCjl.RTrZMD5np0DPhMDpdlznMfgKQz0hQ5m', 'client', '2024-10-09 13:49:56'),
(4, 'emma@gmail.com', '$2y$10$xrsorua8hnHjTkiwE5Rs1e/96cH3.BZ2sZNaub.ojDcFRX8FLC6vq', 'client', '2024-10-01 13:59:02'),
(5, 'charlotte@gmail.com', '$2y$10$j/7ydh2YfsOvPnsMKdbMluFkTbGFlKOfYS1V59JP9lpi4uaUJRxGu', 'client', '2024-09-10 14:14:03'),
(6, 'daisy@gmail.com', '$2y$10$GmRDx3Sc3qLWnAs815o0E.whNdvisKmDl15R4Qc91bqLDxwv99zqe', 'client', '2024-10-10 14:29:33'),
(7, 'luna@gmail.com', '$2y$10$13/AYTJVKU3tBJedj33LwOPnyik8o9Mbtzd/AwZKj2rKmy63tD2te', 'client', '2024-10-27 14:39:54'),
(8, 'jane@gmail.com', '$2y$10$UhrEfsTdZMuGmII4iALmbeCp659BBrpCXvtsP/rUI1OFPBGIY/qE2', 'client', '2024-10-20 14:46:33'),
(9, 'ivy@gmail.com', '$2y$10$o65y5D2JWx4K8OdTmptc2O83sU5XEJJaFw35/8MpiahETgQYcV6g2', 'client', '2024-11-04 14:48:34'),
(10, 'isla@gmail.com', '$2y$10$th.xD.59rUqsaFFKZ3GnKOR7fAnqLdsdx3fi6cs3V2PtanC6apw.a', 'client', '2024-09-10 14:54:01'),
(11, 'eleanor@gmail.com', '$2y$10$pEtxC2LzICpHJGOktUkuOu7OCFh87btIPt.LSxnOi84sINY81X0DW', 'client', '2024-05-10 14:55:12'),
(12, 'isabelle@gmail.com', '$2y$10$KlabapNYHifs0FIKPL5LUOTkaEXnPm4gseqEuAZI3fgPltrWLtuN6', 'client', '2024-08-10 14:56:02'),
(13, 'daisy.01@gmail.com', '$2y$10$SrmMgIjRbfHPqYxjNH6QpequhjTOLvI/sjn7a4WSYTdVmZZiVDzfC', 'client', '2024-07-10 14:56:37'),
(14, 'mia@gmail.com', '$2y$10$EiROt5rD844z7z4oU5HbUeLoava1Zq0u0iGq9AM/YscLAE88OP4FW', 'client', '2024-05-10 14:57:39'),
(15, 'lia@gmail.com', '$2y$10$0QLPCAGOWregWhn8icEJduDQWI4/R0qavXvWddSd2yaXhhw2Ahp26', 'client', '2024-06-10 14:58:11'),
(16, 'ava@gmail.com', '$2y$10$6KrmDxImAEVKQytPt1kxP.xzmPvHlqYleIPDwUTtrbSFPMR7cZAAK', 'client', '2024-05-10 14:58:54'),
(17, 'olivia@gmail.com', '$2y$10$DTgrEitsn2Ov7a1ezglXjOmok89DQZbeahbI7Ma/JgwNob9KajaJa', 'client', '2024-06-10 15:00:50'),
(18, 'lucia@gmail.com', '$2y$10$jVfERC5fAzBMjIdvONxCXer64SHKgSrsvVci/j6y5KcAoFJD4oQ5O', 'client', '2024-11-10 15:02:04'),
(19, 'lucy@gmail.com', '$2y$10$jMCtJiZUzVzJ59e6.d501ORXyWCte398/FGOorkEhTZDRXNElXjuy', 'client', '2024-11-10 15:03:00');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `account_id`) VALUES
(1, 'Admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `account_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `phone`, `address`, `account_id`) VALUES
(1, 'James', '0394365837', '33D, Cat Linh Street, Dong Da District, Hanoi', 2),
(2, 'Lily', '0314388372', '46/41 Tran Van On Street, Tan Son Nhi Ward, Tan Phu District, Ho Chi Minh City', 3),
(3, 'Emma', '0318696325', '166 Le Thanh Nghi, Dong Tam Ward, Hai Ba Trung Dist, Hanoi', 4),
(4, 'Charlotte', '0338601970', '62 Lac Long Quan, Ward 10, Tan Binh District, Ho Chi Minh City', 5),
(5, 'Daisy', '0315532577', '10-10A Lu Gia St., Ward 15, Dist. 11, HCMC', 6),
(6, 'Luna', '0333881069', 'Hung Vuong, Mong Cai, Quang Ninh', 7),
(7, 'Jane', '0519482579', '57 Dang Dung Street, Thua Thien Hue', 8),
(8, 'Ivy', '04284729875', 'Nguyen Van Troi, Phu Ly Town, Ha Nam', 9),
(9, 'Isla', '0357184368', '10, Viet Tower, 198B Tay Son, Hanoi', 10),
(10, 'Eleanor', '0418437681', '33D, Cat Linh Street, Dong Da District, Hanoi', 11),
(11, 'Isabelle', '0418324569', '46/41 Tran Van On Street, Tan Son Nhat Ward, Tan Phu District, Ho Chi Minh City', 12),
(12, 'Daisy', '0572841468', '10-10A Lu Gia St., Ward 15, Dist. 11, HCMC', 13),
(13, 'Mia', '0572581456', '167 Le Thanh Nghi, Dong Tam Ward, Hai Ba Trung Dist, Hanoi', 14),
(14, 'Lia', '0513245781', '31D, Cat Linh Street, Hoan Kiem District, Hanoi', 15),
(15, 'Ava', '0518472436', '110 Le Thanh Nghi, Dong Tam Ward, Hai Ba Trung Dist, Hanoi', 16),
(16, 'Olivia', '0398417581', '10-11 Lu Gia St., Ward 15, Dist. 12, HCMC', 17),
(17, 'Lucia', '0318539837', '132 Tran Hung Dao, Ward Phu Thuy, Binh Thuan', 18),
(18, 'Lucy', '0751254789', '206C Le Loi St., Ngo Quyen Dist, Hai Phong', 19);

-- --------------------------------------------------------

--
-- Table structure for table `faq`
--

CREATE TABLE `faq` (
  `id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faq`
--

INSERT INTO `faq` (`id`, `question`, `answer`) VALUES
(1, 'How long does shipping take?', 'Shipping times can vary depending on your location and the specific product. Typically, domestic orders are shipped within 2-4 business days, while international orders may take  5-14 business days.'),
(2, 'What is your return policy?', 'We offer a 2-day return policy for unopened and unused products. To initiate a return, please contact our customer support team within 2 days of receiving your order. Please note that shipping costs for returns are the customer\'s responsibility.'),
(3, 'Are your products cruelty-free?', 'Yes, we are committed to cruelty-free beauty. All of our products are not tested on animals.'),
(4, 'How do I choose the right shade of lipstick?', 'Choosing the right lipstick shade can be tricky. We recommend considering your skin tone and personal preference. For warmer skin tones, shades like warm reds, corals, and browns often complement well. For cooler skin tones, shades like pinks, purples, and cool reds can be flattering.');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `shipping_id` int(11) NOT NULL,
  `order_number` varchar(7) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp(),
  `shipping_address` text NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `order_status` enum('Cancel','Pending','Ready','Delivering','Completed','Return','Refund','NotRefund') DEFAULT 'Pending',
  `note` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `shipping_id`, `order_number`, `order_date`, `shipping_address`, `total_amount`, `order_status`, `note`) VALUES
(1, 1, 2, 'OK61H7', '2024-08-10 13:37:57', '33D, Cat Linh Street, Dong Da District, Hanoi', 160.38, 'NotRefund', '[CUSTOMER]: I dont like these products'),
(2, 1, 1, '1V6CZ8', '2024-07-10 13:48:21', '25, Nguyen Huu Tho St, Tan Phong Ward, District 7', 18.37, 'Ready', NULL),
(3, 2, 1, '46KE2V', '2024-06-10 13:51:02', '46/41 Tran Van On Street, Tan Son Nhi Ward, Tan Phu District, Ho Chi Minh City', 149.47, 'Completed', '2024-11-10 07:51:21'),
(4, 2, 2, '1F6HX9', '2024-06-10 13:53:42', '46/41 Tran Van On Street, Tan Son Nhi Ward, Tan Phu District, Ho Chi Minh City', 5403.00, 'Return', '[CUSTOMER]: Not suitable color!'),
(5, 3, 1, 'EL70X2', '2024-10-10 13:59:52', '166 Le Thanh Nghi, Dong Tam Ward, Hai Ba Trung Dist, Hanoi', 3802.05, 'Cancel', '[ADMIN]: Due to suspicion of a large-scale scam, I have decided to cancel the order'),
(6, 3, 3, '6QY0W5', '2024-08-10 14:02:24', 'Washington, USA', 48.96, 'Completed', '2024-11-10 08:02:39'),
(7, 3, 2, '4T31ND', '2024-11-10 14:06:34', '166 Le Thanh Nghi, Dong Tam Ward, Hai Ba Trung Dist, Hanoi', 170.33, 'Completed', '2024-11-10 08:07:25'),
(8, 3, 2, 'SBF654', '2024-10-10 14:10:17', '166 Le Thanh Nghi, Dong Tam Ward, Hai Ba Trung Dist, Hanoi', 22.00, 'Completed', '2024-11-10 08:10:46'),
(9, 3, 2, '5QA7T0', '2024-10-10 14:11:36', '166 Le Thanh Nghi, Dong Tam Ward, Hai Ba Trung Dist, Hanoi', 19.32, 'Completed', '2024-11-10 08:11:53'),
(10, 4, 1, '5QR3Y0', '2024-11-10 14:14:25', '62 Lac Long Quan, Ward 10, Tan Binh District, Ho Chi Minh City', 137.05, 'Completed', '2024-11-10 08:14:44'),
(11, 4, 2, 'JH819L', '2024-10-10 14:16:31', '62 Lac Long Quan, Ward 10, Tan Binh District, Ho Chi Minh City', 93.00, 'Cancel', '[CUSTOMER]: Wrong address'),
(12, 4, 2, '39BTK0', '2024-11-10 14:17:58', '62 Lac Long Quan, Ward 10, Tan Binh District, Ho Chi Minh City', 90.92, 'Completed', '2024-11-10 08:18:52'),
(13, 4, 2, 'IZ68J5', '2024-10-02 14:20:04', '62 Lac Long Quan, Ward 10, Tan Binh District, Ho Chi Minh City', 35.64, 'Pending', NULL),
(14, 4, 2, 'D6RL25', '2024-10-10 14:21:48', '62 Lac Long Quan, Ward 10, Tan Binh District, Ho Chi Minh City', 30.14, 'Completed', '2024-11-10 08:22:15'),
(15, 4, 2, 'Y6N48M', '2024-11-10 14:23:16', '62 Lac Long Quan, Ward 10, Tan Binh District, Ho Chi Minh City', 19.50, 'Pending', NULL),
(16, 4, 2, 'X67D0C', '2024-11-21 14:23:32', '62 Lac Long Quan, Ward 10, Tan Binh District, Ho Chi Minh City', 60.00, 'Completed', '2024-11-10 08:24:15'),
(17, 4, 1, 'E2YZ64', '2024-11-10 14:23:49', '62 Lac Long Quan, Ward 10, Tan Binh District, Ho Chi Minh City', 36.03, 'Refund', '[CUSTOMER]: This product I received is not as description!'),
(18, 5, 1, 'BX8E42', '2024-11-10 14:29:57', '10-10A Lu Gia St., Ward 15, Dist. 11, HCMC', 5.59, 'Completed', '2024-11-10 08:30:12'),
(19, 6, 2, 'A530BH', '2024-09-10 14:40:31', 'Hung Vuong, Mong Cai, Quang Ninh', 3.98, 'NotRefund', '[CUSTOMER]: I dont like this product anymore. I want to get back my money please!!!'),
(20, 6, 1, '5C6Z8D', '2024-10-10 14:42:54', 'Hung Vuong, Mong Cai, Quang Ninh', 272.05, 'Completed', '2024-11-10 08:43:06'),
(21, 6, 1, 'EN5W61', '2024-10-10 14:45:22', 'Hung Vuong, Mong Cai, Quang Ninh', 38.05, 'Delivering', NULL),
(22, 7, 1, '6WP7Z5', '2024-11-10 14:46:47', '57 Dang Dung Street, Thua Thien Hue', 3.23, 'Completed', '2024-11-10 08:46:59'),
(23, 8, 1, '82R4KS', '2024-10-10 14:49:18', 'Nguyen Van Troi, Phu Ly Town, Ha Nam', 6202.05, 'Completed', '2024-11-10 08:49:32'),
(24, 8, 2, 'KP6G45', '2024-11-10 15:09:14', 'Nguyen Van Troi, Phu Ly Town, Ha Nam', 18.00, 'Completed', '2024-11-10 09:10:18'),
(25, 8, 2, 'CB254J', '2024-11-10 15:09:29', 'Nguyen Van Troi, Phu Ly Town, Ha Nam', 65.00, 'Completed', '2024-11-10 09:10:17'),
(26, 8, 2, '8I31KS', '2024-11-10 15:09:53', 'Nguyen Van Troi, Phu Ly Town, Ha Nam', 217.95, 'Completed', '2024-11-10 09:10:14'),
(27, 1, 1, '03NZQ1', '2024-11-10 22:33:36', '33D, Cat Linh Street, Dong Da District, Hanoi', 326.05, 'Completed', '2024-11-10 16:34:52');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 5),
(2, 1, 7, 2),
(3, 1, 12, 2),
(4, 1, 17, 3),
(5, 2, 17, 1),
(6, 3, 17, 6),
(7, 3, 20, 3),
(8, 4, 8, 40),
(9, 5, 15, 200),
(10, 6, 21, 2),
(11, 7, 1, 2),
(12, 7, 9, 1),
(13, 7, 10, 3),
(14, 8, 15, 1),
(15, 9, 17, 1),
(16, 10, 8, 1),
(17, 11, 19, 5),
(18, 12, 13, 1),
(19, 12, 18, 2),
(20, 12, 19, 2),
(21, 13, 17, 2),
(22, 14, 1, 23),
(23, 15, 20, 1),
(24, 16, 15, 3),
(25, 17, 18, 2),
(26, 18, 1, 3),
(27, 19, 2, 1),
(28, 20, 8, 2),
(29, 21, 19, 2),
(30, 22, 1, 1),
(31, 23, 16, 100),
(32, 24, 11, 1),
(33, 25, 16, 1),
(34, 26, 7, 5),
(35, 27, 9, 3);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `category` varchar(20) NOT NULL,
  `stock` int(11) DEFAULT 0,
  `image` varchar(2048) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `description`, `price`, `category`, `stock`, `image`) VALUES
(1, 'New Arrival High-Quality Wholesale Customized Cheap Lipstick Waterproof Long Lasting Lipstick', 'Crafted with precision in Guangdong, China, this regular-sized lipstick boasts a sleek design and a weight of just 3.8g, making it perfect for on-the-go touch-ups.\r\n\r\nThe lipstick features a digital printing logo/pattern, available in 6 captivating color options to suit every mood and occasion.\r\n\r\nEnriched with chemical ingredients, this formula glides smoothly onto your lips, delivering intense color payoff and long-lasting wear.\r\n\r\nExperience the luxury of Daigangyan with every application. Elevate your beauty routine with the DGY Lipstick.', 1.18, 'Lipstick', 166, 'upload/4909442676730401e425d52.17953514.png;upload/298250416730401e427376.66523633.png;upload/5208417496730401e427624.07459654.png;upload/2545084516730401e4277d9.26188142.png;upload/20899496036730401e427990.66520165.png'),
(2, 'Multi-reflective Glitter Pearl Pigments Shimmers Satin Metallic Private Label Matte Lipstick', 'DGY Waterproof Matte Lipstick: Your Perfect Lip Companion\r\n\r\nElevate your beauty routine with the DGY Waterproof Matte Lipstick, a luxurious lip color that delivers stunning results. Crafted with precision in Guangdong, China, this lipstick is formulated with a blend of herbal and organic ingredients, ensuring a gentle and nourishing experience for your lips.\r\n\r\nThe long-lasting, waterproof formula ensures your lip color stays put throughout the day, defying smudges, fades, and transfers. The matte finish adds a touch of sophistication to your look, while the vibrant color options cater to every style and occasion.\r\n\r\nWith its convenient stick form and lightweight design, this lipstick is easy to apply and carry. Whether you prefer a bold, dramatic look or a subtle, everyday touch, this versatile lipstick has you covered.\r\n\r\nChoose from a range of captivating shades, including Red, Pink, Brown, Purple, Orange, CHERRY, and Rose Red. Each shade is carefully curated to complement various skin tones and personal preferences.\r\n\r\nExperience the convenience of private label options with DGY. Customize the packaging, branding, and formula to create a unique and personalized lip product. Our team of experts is dedicated to providing top-notch OEM, ODM, and private label services to meet your specific needs.\r\n\r\nRest assured, our products adhere to strict quality standards and are certified by CE, MSDS, HALAL, ISO22716, and GMPC. Each lipstick undergoes rigorous testing to ensure its safety and efficacy.\r\n\r\nWith a shelf life of 3 years, you can enjoy the beauty benefits of this lipstick for an extended period. Order your DGY Waterproof Matte Lipstick today and indulge in the ultimate lip luxury.', 3.98, 'Lipstick', 124, 'upload/1267323300673042cd8492e8.28755414.png;upload/100856594673042cd8497b0.58972159.png;upload/1507848358673042cd849928.58442906.png;upload/2121446080673042cd849a52.77089920.png'),
(3, 'Waterproof vegan make your own logo matte liquid lipstick private label custom lipstick', 'DGY Vegan Matte Lipstick: A Bold, Cruelty-Free Choice\r\n\r\nIndulge in the beauty of the DGY Vegan Matte Lipstick, a luxurious lip color that combines stunning shades with ethical values. Crafted in Guangdong, China, this lipstick is formulated with mineral ingredients, ensuring a gentle and nourishing experience for your lips.\r\n\r\nThe long-lasting, waterproof formula ensures your lip color stays put throughout the day, defying smudges, fades, and transfers. The matte finish adds a touch of sophistication to your look, while the vibrant color options cater to every style and occasion.\r\n\r\nChoose from a stunning palette of 49 matte nude colors, carefully curated to complement various skin tones and personal preferences. Whether you prefer a bold, dramatic look or a subtle, everyday touch, this versatile lipstick has you covered.\r\n\r\nExperience the convenience of private label options with DGY. Customize the packaging, branding, and formula to create a unique and personalized lip product. Our team of experts is dedicated to providing top-notch OEM and ODM services to meet your specific needs.\r\n\r\nRest assured, our products adhere to strict quality standards and are certified by MSDS. Each lipstick undergoes rigorous testing to ensure its safety and efficacy.\r\n\r\nWith a shelf life of 3 years, you can enjoy the beauty benefits of this lipstick for an extended period. Order your DGY Vegan Matte Lipstick today and indulge in the ultimate lip luxury, knowing that your choice supports cruelty-free beauty.', 1.62, 'Lipstick', 200, 'upload/10473367526730443aded577.22185782.png;upload/17227894316730443adeda36.90737687.png;upload/21294364916730443adedb98.95562576.png;upload/9800843906730443adedcc2.08791937.png;upload/3049135516730443adedde2.27630329.png;upload/1177686436730443adedef3.48670269.png'),
(4, '6Pcs Matte Liquid Lipstick Makeup Set, Matte liquid Long-Lasting Wear Non-Stick Cup Not Fade Waterproof Lip Gloss (Set A)', '    ★With a perfect package, it’s ready for as a Birthday gift to friends or families. Perfect for various occasions, such as dating, party, wedding, bar, ball, camping, office, school, or daily makeups.\r\n\r\n    ★The Matte Liquid Lipstick has high-intensity pigment for an instant bold matte lip. The extremely long-wearing lipstick contains moisturizing ingredients for a comfortable, emollient and silky feel that does not dry your lips out.\r\n\r\n    ★6 Colors Velvet Liquid Lip Stick Set, full-size lip gloss of the most popular colors. Charming matte, long-lasting and waterproof, Not stick cup, do not fade.\r\n\r\n    ★Not stick cup, do not fade, matte dry only lightly purse one\'s lips, otherwise, it will stick, painted lip gloss finish is dry because is fog surface velvet effect.\r\n\r\n    ★For everyone, whether you are a lady or you are a student, whether you are a make-up novice or a make-up artist. You can choose this product.\r\n', 8.99, 'Lipstick', 200, 'upload/180100946667304672cb48f7.60496625.jpg;upload/33276193167304672cb4d71.63819686.jpg;upload/206320629067304672cb4ee3.39367031.jpg;upload/57046723067304672cb5003.63079921.jpg;upload/71840489367304672cb5148.02243110.jpg;upload/47486840667304672cb5270.36916991.jpg'),
(5, 'Maybelline Super Stay Vinyl Ink Longwear No-Budge Liquid Lipcolor Makeup, Highly Pigmented Color and Instant Shine, Royal, Deep Wine Red Lipstick, 0.14 fl oz, 1 Count ', '    Glossy Maybelline Superstay Vinyl Ink Liquid Lipstick: This longwear liquid deep wine red lipcolor delivers no-budge vinyl color and up to 16 hour wear, featuring our Color Lock formula that defies smudging and transfer; Simply shake and swipe\r\n    Vegan Formula: Swipe this comfortable color on your lips for an instant shine in a vegan formula with no animal derived ingredients. Now available in 20 saturated shades from bold red to nude. Get up to 16H of no-budge wear.\r\n    To apply, simply shake and swipe the product on your lips. Shake for at least five seconds before applying; Apply as you normally would to clean, dry lips using its precise flocked tip applicator and let fully dry\r\n    Create any look with Maybelline: foundation, BB creams, concealers, and setting powders for the perfect canvas, eye shadows, mascara, brow pencils, and eyeliners for any eye look and lip products, from showstopping matte lipstick to a plumping lip gloss\r\n    Remove Maybelline Makeup With Micellar Water: Use Garnier Micellar Water as a gentle makeup remover at night, and as a facial cleanser in the morning to prep skin for Maybelline makeup', 79.98, 'Lipstick', 100, 'upload/197541804267304721137348.50989877.jpg;upload/1247232522673047211378e9.98391255.jpg;upload/28029452667304721137a65.75835697.jpg;upload/81268290267304721137bb1.59409859.jpg;upload/4712199567304721137cd2.52307599.jpg;upload/84041126767304721137df8.77317844.jpg;upload/55431700867304721137f35.96572921.jpg'),
(6, 'Revlon Liquid Lipstick with Clear Lip Gloss, ColorStay Overtime Lipcolor, Dual Ended with Vitamin E, 350 Bare Maximum, 0.07 Fl Oz', '    LONG LASTING LIQUID LIPSTICK: Forget touch-ups—this colorful, longwear lipstick lasts up to 16 hours. Pigment stays vibrant without smudging, bleeding, or feathering throughout the day\r\n    CONDITIONING, GOOD-FOR-YOU TOP COAT: With 99% of its ingredients being moisturizing (including vitamin E and chamomile extract)—the shiny top coat feels so good on lips, and it’s good for you\r\n    PERFECT, SHINY LIP MAKEUP: Working from the center of your lips outward, swipe on lip color and let it set. Then slick on the glossy top coat for major moisture and shine. Reapply top coat during the day as needed\r\n    30 COLORFUL SHADES: From vivid pinks and bold reds, to natural-looking nudes and browns, all 30 kiss-proof shades stays all day\r\n    LIVE BOLDLY WITH REVLON MAKEUP: Revlon has the high-quality, high-pigment, bold color you need to be yourself. Create any look—day to night, weekday to weekend—with our longwear ColorStay eyeshadows, eyeliners, matte or shiny lipsticks, and foundation', 17.91, 'Lipstick', 100, 'upload/1278988170673048496743c2.39449399.jpg;upload/194546664567304849674947.30935306.jpg;upload/156212613467304849674bc6.86176949.jpg;upload/184532395967304849674df2.92180194.jpg;upload/54629333967304849674fe3.33016193.jpg;upload/1753482357673048496751c4.30008034.jpg;upload/183795798867304849675375.44725944.jpg'),
(7, 'e.l.f. Sheer Slick Lipstick, Hydrating Lipstick For Sheer Color With A Shiny Finish, Infused With Vitamin E, Vegan & Cruelty-free, Black Cherry ', '    LIPSTICK FOR SHEER SHINE: This smooth, wear-anywhere sheer lipstick was inspired by that first bite into a juicy piece of fruit. Swipe it on your lips for a touch of dialed-down color and delicious shine that’s perfect for everyday.\r\n    SMOOTH, HYDRATING FORMULA: The nourishing formula is somewhere between lipstick and lip balm, leaving your lips feeling soft and hydrated.\r\n    INFUSED WITH VITAMIN E: This formula is infused with meadowfoam seed oil and vitamin E.\r\n    AVAILABLE IN BLACK CHERRY: Available in e.l.f.’s most popular shade, Black Cherry.\r\n    SKIN-LOVING INGREDIENTS: All e.l.f. products are made from skin-loving ingredients you want, minus the toxins you don’t—all at good-for-you prices. All e.l.f. products are 100% cruelty-free and vegan.', 42.99, 'Lipstick', 113, 'upload/2047687004673048b7d235c5.57632901.jpg;upload/1385465086673048b7d23af8.28179634.jpg;upload/303918468673048b7d23d64.75151344.jpg;upload/517267404673048b7d23f96.54992438.jpg;upload/342150248673048b7d241a8.77960966.jpg'),
(8, 'Christian Louboutin - Silky satin lipstick - Very Prive ', 'Indulge in the Luxurious World of Christian Louboutin\r\n\r\nElevate your beauty routine with the iconic Christian Louboutin Satin Silky Lip Colour in the captivating shade Very Prive 410, Rouge. This brand-new, unused, and unworn lipstick is a true masterpiece, housed in the brand\'s signature sleek black case adorned with a golden emblem.\r\n\r\nExperience the epitome of luxury with this paraben-free, alcohol-free, and cruelty-free formula. The satin finish glides effortlessly onto your lips, delivering a rich, pigmented color that lasts for hours. The lightweight texture feels comfortable and hydrating, ensuring your lips remain soft and supple.\r\n\r\nWith a 24-month shelf life and a standard size, this lipstick is the perfect addition to your makeup collection. Whether you\'re a seasoned beauty enthusiast or a newcomer to the world of high-end cosmetics, this Christian Louboutin lipstick is sure to impress.\r\n\r\nIndulge in the allure of this exquisite product and discover the difference that true luxury can make.', 135.00, 'Lipstick', 7, 'upload/118912610267304aa38d80c9.11110455.jpg'),
(9, 'FLORASIS Blooming Rouge Love Lock Lipstick M317 Be With You & Floral Engraving Odey Makeup Palette (The Encounter)', '\r\n    A 5,000-Year-Old Inspiration: Once a protector of gold and other precious items, Love Locks evolved into symbols of peace, happiness, long life, love, and marriage. Created in collaboration with Master locksmith Xiang, the Love Lock unites a love of virtuosic artistry, ancient heritage, and nourishing beauty into a wearable romantic emblem.\r\n    Loving Legacies Engraved: With each turn of the bullet, you\'ll discover an ancient romance told in intricate engravings. Choose from four Chinese literary classics: Zhang Chang Paints Eyebrows, The Legend of the White Snake, Flowers Blooming on the Pathway, and The Cowherd and the Weaver Girl.\r\n    Silky Soft All Day: This exceptionally soft matte lipstick contains silk oil that gently evaporates, leaving a soft, non-sticky finish. Our hydrophobic microsphere and flake particle formula adheres smoothly to lips, minimizes lip lines, and resists transfer even when drinking.\r\n    The Encounter Palette:A 9-shade palette depicting Cao Zhi\'s first moment with the goddess.1. Spring Pinecone (Matte merlot brown)2. Breathtaking Beauty (Matte maroon)3. Crystal Waters (Baby blue glitter)4. Gold Jade (Warm gold satin)5. Pink Pearl (Baby pink and gold glitter)6. Romantic Escape (Matte peach with a hint of gold glitter)7. Dark Reishi (Matte dark brown)8. Bright Eyes (Matte coral blush)9. Soft Gaze (Matte dusty\r\n    The Shape: Inspired by the beauty of exquisite folding fans and the goddess herself.', 108.00, 'Lipstick', 66, 'upload/50779728667304b3678f2f0.77878289.jpg;upload/159169303767304b3678f780.79416709.jpg;upload/180782099867304b3678f9f8.10327138.jpg;upload/198020693667304b3678fc20.00825639.jpg;upload/23046859167304b3678fe20.63212602.jpg;upload/63958491867304b36790034.87300454.jpg;upload/98222987267304b36790249.96917522.jpg'),
(10, 'Bioderma Sensibio H2O Micellar Water, Makeup Remover, Gentle for Skin, Fragrance-Free & Alcohol-Free, No Rinse Skincare With Micellar Technology for Normal To Sensitive Skin Types ', 'Bioderma presents a 200-gram product with dimensions of 2.76 x 2.76 x 8.27 inches. It boasts a refreshing scent and is suitable for adults.', 18.99, 'Makeup Remover', 97, 'upload/165689941567304bcc5e6a46.11930579.jpg;upload/183874229067304bcc5e6eb2.26545238.jpg;upload/206959590267304bcc5e7056.99403182.jpg;upload/171841945967304bcc5e71b5.82048368.jpg'),
(11, 'The Face Shop Rice Water Bright Light Facial Cleansing Oil, Daily Makeup Remover, Oil Cleanser, Vegan, Korean Skin Care with Jojoba Oil, Face Wash for Sensitive, Normal & Oily Skin, Face Pore Cleanser ', 'The Face Shop presents a 5.29-ounce product designed for adult use. Its compact dimensions of 1.77 x 1.77 x 6.89 inches make it easy to store and carry. The product\'s delicate rice and floral scent adds a pleasant sensory experience to your skincare routine. Whether it\'s a daily moisturizer or a specialized treatment, The Face Shop offers a range of products to cater to your individual needs.', 15.00, 'Makeup Remover', 199, 'upload/86821937767304c6ef19b50.91008321.jpg;upload/127934818167304c6ef19fe0.03446790.jpg;upload/63965632767304c6ef1a273.13008159.jpg;upload/155003214167304c6ef1a4d9.03598260.jpg;upload/137771724867304c6ef1a703.33879408.jpg;upload/44020414367304c6ef1a938.02233751.jpg'),
(12, 'Garnier Micellar Water, Hydrating Facial Cleanser & Makeup Remover, Suitable for Sensitive Skin, Vegan, Cruelty Free, 13.5 Fl Oz (400mL)', '\r\n    ALL-IN-1 Cleanser To hydrate and Rrefresh skin: This all-in-1 micellar cleansing water is a facial cleanser and makeup remover that is gentle on skin. This micellar water for all skin types gently cleanses, removes makeup, dirt and oils from skin.\r\n    A soothing formula that gently cleanses: micellar water leaves skin feeling/looking healthy and hydrated; formulated to be gentle on even the most sensitive skin; easily removes makeup without over-drying skin.\r\n    A multi-purpose cleanser powered by micelle technology: Micelles work like a magnet to gently cleanse, while removing makeup, dirt, sunscreen, and excess oil all in 1 step; No rinsing, no harsh rubbing- just clean, refreshed skin.\r\n    Dermatolgist and Ophthalmologist tested for safety: safe for use on face, lips and eye area. Approved by Cruelty-Free International under the Leaping Bunny Program. Vegan formula is oil-free, paraben-free, fragrance-free, sulfate-free and silicone free.\r\n    America\'s #1 Micellar Water Brand: there\'s a reason one bottle is sold every 3 seconds!* *Source: Nielsen Measured Mass Market, Full Year 2022, Unit Sales\r\n', 8.27, 'Makeup Remover', 248, 'upload/12805035067304cc410f5c2.23355417.jpg;upload/142680800267304cc410fa20.34494888.jpg;upload/213858063467304cc410fbc8.76770898.jpg'),
(13, 'Garnier Micellar Water for Waterproof Makeup, Hydrating Facial Cleanser & Makeup Remover, Suitable for Sensitive Skin, Vegan, Cruelty Free, 13.5 Fl Oz (400mL)', '    Garnier Waterproof Micellar Cleansing Water is a facial cleanser that soothes and refreshes skin while removing even stubborn waterproof makeup in just one step\r\n    Garnier micelle cleansing molecules lift dirt and impurities like a magnet, without irritation and this face cleanser can be used for all skin types, even sensitive skin\r\n    A no-rinse waterproof makeup remover and facial cleanser that refreshes, soothes and effectively cleanses skin without harsh rubbing\r\n    This Garnier micellar cleansing water removes dirt, excess oil and impurities and can also be used to remove waterproof or longwear face, lip and eye makeup', 17.94, 'Makeup Remover', 209, 'upload/189170842167304d71de1c56.79595172.jpg;upload/96324269067304d71de21a6.87121082.jpg;upload/121104616167304d71de2449.24840012.jpg;upload/132841750067304d71de26b4.74080452.jpg'),
(14, 'Amazon Basics Eye Makeup Remover, Removes Waterproof Mascara, Dermatologist Tested, Fragrance Free, 5.5 Fl Oz (Pack of 1) ', '    One 5.5-fluid ounce bottle of Amazon Basics Eye Makeup Remover\r\n    Dermatologist tested and oil free\r\n    Removes stubborn makeup, even waterproof mascara\r\n    Not tested on animals. Made in the U.S.A. with U.S. and foreign components\r\n    An Amazon brand', 5.50, 'Makeup Remover', 10, 'upload/201706088667304de8434e28.81937145.jpg;upload/209767401667304de84352d9.39734506.jpg;upload/77766259667304de8435477.14201189.jpg;upload/55746193767304de84355f2.56080704.jpg;upload/149998440867304de8435759.64354563.jpg'),
(15, 'BIODANCE Bio-Collagen Real Deep Mask, Hydrating Overnight Hydrogel Mask, Pore Minimizing, Elasticity Improvement, 34g x4ea', '\r\n    DEEP HYDRATION: The oligo-hyaluronic acid in the Biodance Bio-Collagen Real Deep Mask provides superior moisturizing effects compared to regular hyaluronic acid. It quickly hydrates the skin\'s surface and penetrates deeper layers, leaving the complexion healthy and well-moisturized.\r\n    PORE TIGHTENING & FIRMING: Ultra-low molecular collagen maximizes absorption and skin penetration. It helps refine enlarged pores, enhances skin elasticity immediately after application, and visibly reduces the appearance of fine lines and wrinkles.\r\n    BRIGHTENS THE SKIN: Formulated with Galactomyces Ferment Filtrate and Niacinamide, it improves uneven skin tone and texture while offering antioxidant effects, resulting in healthier, more radiant skin.\r\n    AMPOULE SOLIDIFIED: Each 1.19 oz bottle of ampoule is solidified into a sheet mask.\r\n    BECOMES TRANSPARENT: The mask turns transparent after 3 hours or overnight, delivering active ingredients deep into the skin.\r\n    SAFE FOR SENSITIVE SKIN: All Biodance products are formulated with non-toxic, non-irritant ingredients. They are free from common allergens and 19 other harmful or controversial substances, making them completely safe for sensitive skin.', 19.00, 'Face Mask', 496, 'upload/205645818367304ed3eee024.22360865.jpg;upload/37900431967304ed3eee524.87427508.jpg;upload/149613261367304ed3eee6f0.54916529.jpg;upload/38160506867304ed3eee874.76491434.jpg;upload/200967971567304ed3eee9f0.30295935.jpg;upload/150745312367304ed3eeec18.20004122.jpg'),
(16, 'Deep Collagen Overnight Mask 37gx17ea | The real collagen 2,160,000ppb | Facial Hydrogel Masks with low molecular weight collagen for elasticity, firming, and moisturizing', '\r\n    [REAL TikTok VIRAL COLLAGEN MASK] The real TikTok viral collagen mask contains up to 2,160,000ppb of collagen.\r\n    [OPTIMAL BLEND] We’ve focused on ingredients that deeply moisturize dry skin, providing a lasting dewy glow for a firm and radiant look.\r\n    [LOW MOLECULAR REAL COLLAGEN] Fish collagen can be hard to absorb, no matter the amount. Our low molecular collagen, smaller than your pores, penetrates deeply to boost collagen from within.\r\n    [COLLAGEN BOOSTING PEPTIDES] With a high collagen content and nine different peptide ingredients, this formula effectively supports collagen production in the skin. Perfectly blended by our ingredient experts to help improve skin elasticity.\r\n    [OVERNIGHT MASK SHEET] After 3 hours, the collagen hydrogel mask sheet is absorbed into the skin, becomes transparent. This mask can be used as an overnight mask, providing easy elasticity care while you sleep.\r\n    We provide you with the most specialized skincare solution for your skin with fine ingredients and a definite effect.', 62.00, 'Face Mask', 399, 'upload/156267656867304f42582a59.09517745.jpg;upload/76733672367304f42582ee9.46461451.jpg;upload/209988368367304f42583088.97541037.jpg;upload/30899222667304f42583205.99896594.jpg;upload/26772516367304f42583356.89831958.jpg;upload/7102717867304f42583494.32742160.jpg'),
(17, 'ANAI RUI Turmeric Clay Mask - Green Tea Clay Mask - Dead Sea Minerals Mud Mask, Spa Facial Mask Set, Face Mask Gift Set 2.5 oz each', '\r\n    ANAI RUI SPA FACIAL MASK --Facial therapy for all skin types. Turmeric clay mask, green tea clay mask, and dead sea mud mask 3 in one set, all content hyaluronic acid, deep cleansing while intensely hydrating, restore soft, clean, refreshed, and nourished skin look after use. Perfect for mud spa facial care 3 times per week.\r\n    DEAD SEA MUD MASK -- Mineral-infused Mud Mask, Rich in minerals and high-quality sea salt, the mud aids skin renewal, creating a gentle exfoliation effect that helps to cleanse the skin pores, removes dead skin cells, and provides a soothing, nourished and clean feeling.\r\n    TURMERIC CLAY MASK -- Turmeric face mask boosts radiance, helps achieve more even complexions, improves uneven skin tone, skin texture, and nourishes.Purify pores, cleanse pores, and correct pigmentation. ANAI RUI Turmeric clay mask gives you a deeply hydrating and supple, plump, radiant look after use.\r\n    GREEN TEA CLAY MASK -- Green tea has been a proven natural antioxidant and active in skincare. Green tea clay mud mask helps protect the skin and unblocks pores. Combat excess oil, and pores are tightened. It leaves skin feeling soft, refreshed, and perfectly hydrated.\r\n    FACE MASK GIFT SET--ANAI RUI clay mask set for face with natural and clean ingredients for all skin types ! Turmeric VC Face Mask, Green Tea Mask, Dead Sea Mud Mask 3 in 1 clay mask kit .70g each bottle .Our face mask skincare gift set is not only a perfect skincare gift option but also an ideal self-care treat for anyone seeking a rejuvenating skincare experience.\r\n    HOW TO USE-- Begin by applying a small amount of our clay mask set to a patch of skin, such as the arm or bend of the elbow, to test for any allergic reactions. Discontinue use immediately if any reaction occurs. Once the patch test is successful, cleanse your face thoroughly, then apply a thin, even layer of the mask, avoiding the eye and lip areas. Waiting for 15-20 minutes to dry, gently remove, and rinse thoroughly with water. For optimal results, follow with a moisturizer.', 16.32, 'Face Mask', 287, 'upload/3150857767304fbbcafb96.53518992.jpg;upload/53319004267304fbbcb00d0.40304997.jpg;upload/119903096167304fbbcb0293.92094566.jpg;upload/4425094767304fbbcb0403.04023273.jpg;upload/169757832767304fbbcb0545.39342015.jpg'),
(18, 'Era Organics Microdermabrasion Facial Scrub & Face Exfoliator - Spa Quality Exfoliating Mask with Manuka Honey Walnut Moisturizing Exfoliant for Dry Skin, Blackheads Wrinkles (2 oz)', '\r\n    Get Super Soft Skin In Minutes With 9X Superfood Blend: Gentle, moisturizing microdermabrasion facial scrub professionally crafted from Nature for clearer, glowing, and youthful-looking skin. Backed by our Empty Jar Promise!\r\n    The Best Facial Scrub For Dull, Dry, Sensitive Skin: Tough on buildup, gentle on skin. With medical grade Manuka Honey and calming Australian Cehami Extract to help balance skin tone, smooth wrinkles and rejuvenate dull skin as you exfoliate\r\n    Deeply Cleanse, Thoroughly Exfoliate, Totally Rejuvenate: Our face exfoliator scrubber uses natural particles to help cleanse pores, dead skin cells, blackheads and invigorate the skin. At home facial scrub carefully crafted for sensitive skin\r\n    Tested by Dermatologists, Loved By Customers: Our face scrub is pure, ethical & sustainable, proudly made in the USA. Ditch harsh chemicals that can make your skin WORSE. Cheap products use cheap ingredients that can ruin your skin.\r\n    Scrub the Day Away Without Compromise. Cheap products use cheap ingredients that can harm the skin’s delicate biome, dry your skin and irritate sensitive skin. Our pH balanced, sulfate free exfoliating face scrub is actually GOOD for your skin.', 16.99, 'Face Mask', 196, 'upload/106370787667305043bb9c69.75856598.jpg;upload/187121420667305043bba162.07299159.jpg;upload/53380517267305043bba327.00603920.jpg;upload/182220358267305043bba498.30069201.jpg'),
(19, 'Beauty of Joseon Glow Replenishing Rice Facial Sebum Toner for Oily Combination Skin Korean Moisturizing Balance Care 150ml, 5.07 fl.oz', '\r\n    Dual-Layer: Strong Sebum Contrl & Soft hydration: Shake well to mix the water and emulsion layers. The milky texture ensures deeper care and nourishment. Suitable oily, sensitive and combination skin.\r\n    Replenishing & Skin Tone Up: Rich in amino acids, as well as vitamins B and D from the major ingredients, including rice extract and panthenol, it replenishes skin and boosts the tone up benefits received by your skin.\r\n    Moisture Skin Barrier: It creates a rice-derived barrier deep inside & on the surface of your skin to protect it from outer aggressors such as bacteria, dryness, UV rays, etc. This dense moisture barrier also keeps pores balanced so that they do not produce excessive sebum and oil.\r\n    Antioxidant: Rice amino acids full of protein from the rice cells and callus under optimal conditions to increase the content of amino acids that help with antioxidant and moisturization effects.\r\n    Great Gift: Perfect for grand parents, moms, dads, girlfriends and boyfriends as a birthday gift and event for special occasions. Present your loved ones with this Beauty of Joseon Replenishing Rice Milk', 18.00, 'Toner', 196, 'upload/6193419336730508f817821.89106622.jpg;upload/18408990596730508f817ca5.35648445.jpg;upload/1135384366730508f817f23.15044749.jpg'),
(20, 'COSRX Niacinamide 2% + BHA 4% Blackhead Exfoliant Toner 3.38 fl.oz / 100ml, Korean Toner, Blackhead Remover, Pore Minimizer for Enlarged Pores, For All Skin Types, Korean Skin Care', '\r\n    CONCENTRATED BHA LIQUID: Formulated with 4% BHA (Betaine Salicylate), this product visibily diminishes enlarged pores and dead skin cells, replacing it with natural radiance while evening out your skin tone.\r\n    CONGESTED PORES, BE GONE: BHA penetrates deeply into the pores and helps clear clogged pores and gently exfoliates dead skin cells, giving the skin its natural glow. An easy and simple way to prevent acne and blackheads.\r\n    INGREDIENTS AND BENEFITS: Made with natural ingredients like the willow bark water to maximize exfoliating and clearing benefits without irritation. It is gentle enough for everyday use.\r\n    HOW TO USE: After cleansing, saturate a cotton pad and wipe gently over face or region with blackhead. You may experience brief tingling and discomfort. Make sure to apply broad spectrum SPF for day time usage. Use everyday during your night time routine and make sure to use sufficicient product so that the liquid may seep into the pores and help clear blackheads effectively.\r\n    COSRX Standards: All COSRX products are formulated with skin-friendly ingredients that alleviate irritated skin. Hypoallergenic, Dermatologist tested, Animal Testing-FREE, Parabens-FREE, Sulfates-FREE, Phthalates-FREE', 16.50, 'Toner', 196, 'upload/1479902484673050e5839a11.48264930.jpg;upload/1136087364673050e5839ec0.79728996.jpg;upload/1746953046673050e583a0a9.56588129.jpg'),
(21, 'Salicylic Acid Toner, BHA Toner, Niacinamide Toner, Potent Blackhead Remover & Face Exfoliator, Zealsea Gentle Pore Minimizer for Face & BHA Liquid Exfoliant for Sensitive Skin, Alcohol Free 6.76 OZ', '    Embrace Flawless Skin: Formulated to gently exfoliate, this face toner helps blackheads remove, pores reducing, control oil and refine skin texture. Perfect for daily use, it leaves skin feeling clean, smooth and visibly glow. Suitable for all skin types\r\n    Clear & Calm Skin: Experience the power of Salicylic Acid, Niacinamide and CICA, this potent blend gently exfoliates to unclog pores, reduces excess oil, and soothes skin, leaving it calm, balanced, and visibly refreshed. Ideal for smooth, clear skin\r\n    Safe & Hypoallergenic: This alcohol-free face exfoliator keeps your safety in mind. It is cruelty free, paraben free, fragrance free. Ideal for all skin types, including sensitive skin. It is rigorously tested to ensure hypoallergenic and non-irritating\r\n    Non-irritation Salicylic Acid: By combining betaine and salicylic acid through supramolecular tech, it offers the deep hydration benefits of betaine and the high-efficiency of BHA. A perfect solution for smoothing, renewing and soothing the skin\r\n    Warm Tips: For extremely sensitive skin, start with this toner every 2-3 days. Monitor your skin\'s response and adjust usage as needed. Always follow up with a broad-spectrum SPF during the day to protect skin from UV damage and ensure optimal results', 16.98, 'Toner', 18, 'upload/1942937665673051456eed98.57094686.jpg;upload/44434954673051456ef419.54366409.jpg;upload/2065170129673051456ef6f4.90852854.jpg'),
(22, 'test 11111', 'test', 1.98, 'Makeup Remover', 0, 'upload/21361780986730d459456981.88299204.jpg;upload/2884307366730d459456c75.85275656.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `product_reviews`
--

CREATE TABLE `product_reviews` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `review` text DEFAULT NULL,
  `review_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_reviews`
--

INSERT INTO `product_reviews` (`id`, `customer_id`, `product_id`, `order_id`, `rating`, `review`, `review_date`) VALUES
(1, 1, 1, 1, 3, 'The color payoff is decent, but the lipstick feels a bit drying on my lips. It\'s not the most moisturizing formula, and I often have to reapply throughout the day. The packaging is cute, but the product itself is just okay.', '2024-11-10 13:46:03'),
(2, 1, 7, 1, 5, 'This versatile lipstick shade complements any outfit and skin tone. It\'s not too bold, but it still makes a statement. I love how it makes my lips look fuller and more defined.', '2024-11-10 13:46:03'),
(3, 1, 12, 1, 5, 'I\'ve tried countless makeup removers, but this one takes the cake. It\'s gentle, effective, and leaves my skin feeling soft and hydrated. No more tugging or rubbing! It\'s a must-have for anyone who wears makeup.', '2024-11-10 13:46:03'),
(4, 1, 17, 1, 5, 'This clay mask is a miracle worker! It draws out impurities, minimizes pores, and leaves my skin feeling incredibly soft and smooth. I use it once a week, and my skin has never looked better.', '2024-11-10 13:46:03'),
(5, 2, 17, 3, 4, 'This clay mask is pretty good! It does a decent job of drawing out impurities and minimizing pores. I like the way it feels on my skin, and it doesn\'t dry out too much. However, I\'ve noticed that it can be a bit messy to apply and remove. Overall, it\'s a decent product, but not the best I\'ve tried.', '2024-11-10 13:52:52'),
(6, 2, 20, 3, 5, 'This makeup remover is a lifesaver! It effortlessly melts away even the most stubborn waterproof makeup, leaving my skin feeling clean, soft, and refreshed. It\'s gentle on my skin, doesn\'t irritate my eyes, and doesn\'t leave any greasy residue. I highly recommend this product to anyone looking for a gentle yet effective makeup remover.', '2024-11-10 13:52:52'),
(7, 3, 21, 6, 5, 'This toner is incredibly hydrating and refreshing. It absorbs quickly into my skin, leaving it feeling soft, smooth, and supple.', '2024-11-10 14:03:24'),
(8, 3, 1, 7, 4, 'For the price, this lipstick is a great deal. The color is pretty, and the formula is smooth and hydrating. It doesn\'t last as long as some high-end lipsticks, but it\'s still a good option for everyday wear.', '2024-11-10 14:09:24'),
(9, 3, 9, 7, 5, 'This lipstick is pure luxury. The formula is incredibly smooth and creamy, gliding on effortlessly. The color payoff is intense, and the lipstick lasts all day without drying out my lips. The packaging is stunning, and the overall experience is truly indulgent.', '2024-11-10 14:09:24'),
(10, 3, 10, 7, 4, 'This makeup remover is pretty good at removing most of my makeup, but it struggles with waterproof mascara. It can also leave a slight residue on my skin, which requires a second cleanse. Overall, it\'s a decent product, but not the best I\'ve tried.', '2024-11-10 14:09:24'),
(11, 3, 15, 8, 5, 'good. I like this product', '2024-11-10 14:11:05'),
(12, 3, 17, 9, 5, 'Good. I like this product!', '2024-11-10 14:12:05'),
(13, 4, 8, 10, 5, 'I like this lipstick', '2024-11-10 14:15:00'),
(14, 4, 13, 12, 3, 'I rather don\'t like this product', '2024-11-10 14:19:31'),
(15, 4, 18, 12, 5, 'I like this product', '2024-11-10 14:19:31'),
(16, 4, 19, 12, 5, 'I like this product', '2024-11-10 14:19:31'),
(17, 4, 1, 14, 5, 'This product makes me comfortable to use!', '2024-11-10 14:22:37'),
(18, 5, 1, 18, 5, 'I like this lipsticks, would buy it more later!', '2024-11-10 14:30:37'),
(19, 6, 8, 20, 5, 'Highly recommend this lipstick!\n', '2024-11-10 14:43:22'),
(20, 7, 1, 22, 5, 'Love this one', '2024-11-10 14:47:17'),
(21, 8, 16, 23, 5, 'Highly recommend this mask! I had a great experience', '2024-11-10 14:50:02'),
(22, 8, 7, 26, 3, 'This one might not suitable for me!', '2024-11-10 15:10:32'),
(23, 8, 16, 25, 5, 'Love this one', '2024-11-10 15:11:17'),
(24, 8, 11, 24, 5, 'Love this one', '2024-11-10 15:11:23'),
(25, 1, 9, 27, 4, '', '2024-11-10 22:35:20');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_services`
--

CREATE TABLE `shipping_services` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(1000) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_services`
--

INSERT INTO `shipping_services` (`id`, `name`, `description`, `price`) VALUES
(1, 'Ninja Van', 'providing hassle-free delivery services for businesses of all sizes across Southeast Asia.', 2.05),
(2, 'Viettel Post', 'specializing in domestic and international express', 3.00),
(3, 'UPS', 'providing international shipping services, including express and standard options.', 15.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `phone` (`phone`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `faq`
--
ALTER TABLE `faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `order_number` (`order_number`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `shipping_id` (`shipping_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `account_id` (`account_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `shipping_services`
--
ALTER TABLE `shipping_services`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `faq`
--
ALTER TABLE `faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `product_reviews`
--
ALTER TABLE `product_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `shipping_services`
--
ALTER TABLE `shipping_services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `customers`
--
ALTER TABLE `customers`
  ADD CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`shipping_id`) REFERENCES `shipping_services` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD CONSTRAINT `password_reset_tokens_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`);

--
-- Constraints for table `product_reviews`
--
ALTER TABLE `product_reviews`
  ADD CONSTRAINT `product_reviews_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`),
  ADD CONSTRAINT `product_reviews_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `product_reviews_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
