-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2023 at 07:14 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ajms_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `account_list`
--

CREATE TABLE `account_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `account_list`
--

INSERT INTO `account_list` (`id`, `name`, `description`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Cash', 'Cash', 1, 0, '2022-02-01 10:09:26', NULL),
(2, 'Petty Cash', 'Petty Cash', 1, 0, '2022-02-01 10:09:40', NULL),
(3, 'Cash Equivalents', 'Cash Equivalents', 1, 0, '2022-02-01 10:09:56', NULL),
(4, 'Accounts Receivable', 'Accounts Receivable', 1, 0, '2022-02-01 10:10:22', NULL),
(5, 'Interest Receivable', 'Interest Receivable', 1, 0, '2022-02-01 10:10:57', NULL),
(6, 'Office Supplies', 'Office Supplies', 1, 0, '2022-02-01 10:11:13', NULL),
(7, 'Accounts Payable', 'Accounts Payable', 1, 0, '2022-02-01 10:11:55', NULL),
(8, 'Insurance Payable', 'Insurance Payable', 1, 0, '2022-02-01 10:12:07', NULL),
(9, 'Interest Payable', 'Interest Payable', 1, 0, '2022-02-01 10:12:20', NULL),
(10, 'Legal Fees Payable', 'Legal Fees Payable', 1, 0, '2022-02-01 10:12:35', NULL),
(11, 'Office Salaries Payable', 'Office Salaries Payable', 1, 0, '2022-02-01 10:12:51', NULL),
(12, 'Salaries Payable', 'Salaries Payable', 1, 0, '2022-02-01 10:13:03', NULL),
(13, 'Wages Payable', 'Wages Payable', 1, 0, '2022-02-01 10:13:24', NULL),
(14, 'Owner’s Capital', 'Owner’s Capital', 1, 0, '2022-02-01 10:13:54', NULL),
(15, 'Owner’s Withdrawals', 'Owner’s Withdrawals', 1, 0, '2022-02-01 10:14:04', NULL),
(16, 'Common Stock, Par Value', 'Common Stock, Par Value', 1, 0, '2022-02-01 10:14:25', NULL),
(17, 'Common stock, no par value', 'Common stock, no par value', 1, 0, '2022-02-01 10:14:34', NULL),
(18, 'Common stock dividend distributable', 'Common stock dividend distributable', 1, 0, '2022-02-01 10:14:50', NULL),
(19, 'Paid-in capital in excess of par value, Common stock', 'Paid-in capital in excess of par value, Common\r\nstock', 1, 0, '2022-02-01 10:15:02', NULL),
(20, 'Paid-in capital in excess of stated value, No-par common stock', 'Paid-in capital in excess of stated value, No-par\r\ncommon stock', 1, 0, '2022-02-01 10:15:11', NULL),
(21, 'Retained earnings', 'Retained earnings', 1, 0, '2022-02-01 10:15:31', NULL),
(22, 'Cash dividends', 'Cash dividends', 1, 0, '2022-02-01 10:15:44', NULL),
(23, 'Stock dividends', 'Stock dividends', 1, 0, '2022-02-01 10:15:58', NULL),
(24, 'Treasury stock, Common', 'Treasury stock, Common', 1, 0, '2022-02-01 10:16:48', NULL),
(25, 'Unrealized gain-Equity', 'Unrealized gain-Equity', 1, 0, '2022-02-01 10:16:57', NULL),
(26, 'Unrealized loss-Equity', 'Unrealized loss-Equity', 1, 0, '2022-02-01 10:17:05', NULL),
(27, 'Fees earned from product one', 'Fees earned from product one', 1, 0, '2022-02-01 10:17:27', NULL),
(28, 'Fees earned from product two', 'Fees earned from product two', 1, 0, '2022-02-01 10:17:43', NULL),
(29, 'Service revenue one', 'Service revenue one', 1, 0, '2022-02-01 10:17:55', NULL),
(30, 'Service revenue two', 'Service revenue two', 1, 0, '2022-02-01 10:18:04', NULL),
(31, 'Commissions earned', 'Commissions earned', 1, 0, '2022-02-01 10:18:14', NULL),
(32, 'Rent revenue', 'Rent revenue', 1, 0, '2022-02-01 10:18:26', NULL),
(33, 'Dividends revenue', 'Dividends revenue', 1, 0, '2022-02-01 10:18:40', NULL),
(34, 'Earnings from investments in “blank”', 'Earnings from investments in “blank”', 1, 0, '2022-02-01 10:18:51', NULL),
(35, 'Interest revenue', 'Interest revenue', 1, 0, '2022-02-01 10:19:03', NULL),
(36, 'Sinking fund earnings', 'Sinking fund earnings', 1, 0, '2022-02-01 11:41:57', NULL),
(37, 'Amortization expense', 'Amortization expense', 1, 0, '2022-02-01 11:42:08', NULL),
(38, 'Depletion expense', 'Depletion expense', 1, 0, '2022-02-01 11:42:16', NULL),
(39, 'Depreciation expense-Automobiles', 'Depreciation expense-Automobiles', 1, 0, '2022-02-01 11:42:25', NULL),
(40, 'Depreciation expense-Building', 'Depreciation expense-Building', 1, 0, '2022-02-01 11:42:34', NULL),
(41, 'Depreciation expense-Furniture', 'Depreciation expense-Furniture', 1, 0, '2022-02-01 11:43:02', NULL),
(42, 'Office salaries expense', 'Office salaries expense', 1, 0, '2022-02-01 11:43:12', NULL),
(43, 'Sales salaries expense', 'Sales salaries expense', 1, 0, '2022-02-01 11:43:21', NULL),
(44, 'Salaries expense', 'Salaries expense', 1, 0, '2022-02-01 11:43:31', NULL),
(45, 'Income taxes expense', 'Income taxes expense', 1, 0, '2022-02-01 11:43:44', NULL),
(46, 'Warranty expense', 'Warranty expense', 1, 0, '2022-02-01 11:44:01', NULL),
(47, 'Utilities expense', 'Utilities expense', 1, 0, '2022-02-01 11:44:10', NULL),
(48, 'Selling expense', 'Selling expense', 1, 0, '2022-02-01 11:44:23', NULL),
(49, 'Sample101', 'Sample101', 0, 1, '2022-02-01 11:45:03', '2022-02-01 11:45:23'),
(50, 'Inventory', 'Inventory', 1, 0, '2023-07-10 00:29:20', NULL),
(51, 'Purchase', 'Purchase', 1, 0, '2023-07-10 00:36:13', NULL),
(52, 'Dell - A/C', 'Dell - A/C', 1, 0, '2023-07-10 04:27:08', NULL),
(53, 'test - A/C', 'test - A/C', 1, 0, '2023-07-10 04:44:27', NULL),
(54, 'Michael Sosa Trading - A/C', 'Michael Sosa Trading - A/C', 1, 0, '2023-07-10 05:27:28', NULL),
(55, 'Waters Rios Co - A/C', 'Waters Rios Co - A/C', 1, 0, '2023-07-10 06:31:06', NULL),
(56, 'Sales A/C', 'Sales recording ', 1, 0, '2023-07-10 08:59:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(1024) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `name`, `address`) VALUES
(1, 'Tucker Mcneil', 'Itaque sed quo recus'),
(2, 'Vincent Contreras', 'Nihil exercitation c');

-- --------------------------------------------------------

--
-- Table structure for table `group_list`
--

CREATE TABLE `group_list` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 = Debit, 2= Credit',
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0=Inactive, 1= Active',
  `delete_flag` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 = No, 1 = Yes ',
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `group_list`
--

INSERT INTO `group_list` (`id`, `name`, `description`, `type`, `status`, `delete_flag`, `date_created`, `date_updated`) VALUES
(1, 'Assets', 'The cash, inventory, and other resources you owned.', 1, 1, 0, '2022-02-01 09:56:35', '2022-02-01 09:56:58'),
(2, 'Revenue', 'Cash coming into your business through sales and other types of payments', 2, 1, 0, '2022-02-01 09:57:45', NULL),
(3, 'Expenses', 'The amount you’re spending on services and other items, like payroll, utility bills, and fees for contractors.', 1, 1, 0, '2022-02-01 09:58:09', '2022-02-01 09:59:13'),
(4, 'Liabilities', 'The money you still owe on loans, debts, and other obligations.', 2, 1, 0, '2022-02-01 09:58:34', NULL),
(5, 'Equity', 'How much is remaining after you subtract liabilities from assets.', 2, 1, 0, '2022-02-01 09:59:05', NULL),
(6, 'Dividend', 'Form of income that shareholders of corporations receive for each share of stock that they hold.', 1, 1, 0, '2022-02-01 10:00:13', NULL),
(7, 'Sample101', 'Sample', 1, 0, 1, '2022-02-01 10:01:35', '2022-02-01 10:03:28'),
(8, 'Credit', 'Credit', 2, 1, 0, '2023-07-10 00:40:12', NULL),
(9, 'Debit', 'Debit', 1, 1, 0, '2023-07-10 00:40:25', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `journal_entries`
--

CREATE TABLE `journal_entries` (
  `id` int(30) NOT NULL,
  `code` varchar(100) NOT NULL,
  `journal_date` date NOT NULL,
  `description` text NOT NULL,
  `user_id` int(30) DEFAULT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `journal_entries`
--

INSERT INTO `journal_entries` (`id`, `code`, `journal_date`, `description`, `user_id`, `date_created`, `date_updated`) VALUES
(3, '202202-00001', '2022-02-01', 'Capital', 1, '2022-02-01 14:08:50', NULL),
(4, '202202-00002', '2022-02-01', 'Sample', 1, '2022-02-01 15:55:46', NULL),
(12, '202307-00001', '2023-07-12', 'Purchase #17', 1, '2023-07-10 08:24:34', NULL),
(13, '202307-00002', '2023-07-10', 'Purchase #18', 1, '2023-07-10 08:25:09', NULL),
(18, '202307-00004', '2023-07-11', 'Purchase #19', 1, '2023-07-10 09:55:53', NULL),
(21, '202307-00005', '2023-07-10', 'Sales #4', 1, '2023-07-10 10:07:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `journal_items`
--

CREATE TABLE `journal_items` (
  `journal_id` int(30) NOT NULL,
  `account_id` int(30) NOT NULL,
  `group_id` int(30) NOT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `journal_items`
--

INSERT INTO `journal_items` (`journal_id`, `account_id`, `group_id`, `amount`, `date_created`) VALUES
(3, 1, 1, 15000, '2022-02-01 14:52:56'),
(3, 14, 5, 15000, '2022-02-01 14:52:56'),
(4, 42, 3, 5000, '2022-02-01 15:55:46'),
(4, 11, 4, 5000, '2022-02-01 15:55:46'),
(12, 51, 3, 4896, '2023-07-10 08:24:34'),
(12, 55, 8, 4896, '2023-07-10 08:24:34'),
(13, 51, 3, 150150, '2023-07-10 08:25:09'),
(13, 1, 8, 150150, '2023-07-10 08:25:09'),
(18, 51, 3, 21192, '2023-07-10 09:55:53'),
(18, 55, 8, 21192, '2023-07-10 09:55:53'),
(21, 4, 9, 267999, '2023-07-10 10:07:24'),
(21, 56, 2, 267999, '2023-07-10 10:07:24');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `cost` decimal(12,4) DEFAULT NULL,
  `price` decimal(12,4) DEFAULT NULL,
  `qty` int(11) DEFAULT 0,
  `avatar` text NOT NULL,
  `status` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `cost`, `price`, `qty`, `avatar`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Item', 'Testing item 1', '7500.0000', '8000.0000', 500, '', 0, '2023-07-09 23:47:39', '2023-07-09 23:47:39'),
(3, 'Item2', 'Testing item 2', '500.0000', '1000.0000', 933, '', 0, '2023-07-09 23:51:18', '2023-07-09 23:51:18'),
(4, 'Item3', 'Testing item 3', '15200.0000', '16580.0000', 50, '', 0, '2023-07-09 23:58:12', '2023-07-09 23:58:12'),
(5, 'Dell OptiPlex 390', 'Dell OptiPlex 390', '15000.0000', '20000.0000', 29, '', 0, '2023-07-09 23:59:19', '2023-07-09 23:59:19'),
(6, 'Dell OptiPlex 780', 'Dell OptiPlex 780', '18000.0000', '22000.0000', 500, '', 0, '2023-07-10 00:01:46', '2023-07-10 00:01:46');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `id` int(11) NOT NULL,
  `vendor_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `cost` decimal(12,2) DEFAULT NULL,
  `qty` int(11) DEFAULT 0,
  `payment_type` varchar(50) NOT NULL,
  `purchase_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`id`, `vendor_id`, `product_id`, `description`, `cost`, `qty`, `payment_type`, `purchase_date`) VALUES
(17, 5, 5, 'Et asperiores a occa', '48.00', 102, 'credit', '2023-07-12 00:00:00'),
(18, 1, 6, 'Cupidatat sed repreh', '210.00', 715, 'cash', '2023-07-10 00:00:00'),
(19, 5, 3, 'Amet pariatur Quia', '24.00', 883, 'credit', '2023-07-11 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_journal`
--

CREATE TABLE `purchase_journal` (
  `id` int(11) NOT NULL,
  `purchase_id` int(11) NOT NULL,
  `journal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase_journal`
--

INSERT INTO `purchase_journal` (`id`, `purchase_id`, `journal_id`) VALUES
(1, 6, 7),
(2, 11, 8),
(3, 16, 11),
(4, 17, 12),
(5, 18, 13),
(7, 19, 18);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `date` date NOT NULL,
  `customer_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(12,4) DEFAULT NULL,
  `qty` int(11) DEFAULT 0,
  `payment_type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `date`, `customer_id`, `product_id`, `description`, `price`, `qty`, `payment_type`) VALUES
(4, '2023-07-10', 2, 5, 'Non lorem cupiditate', '569.0000', 471, 'credit');

-- --------------------------------------------------------

--
-- Table structure for table `sales_journal`
--

CREATE TABLE `sales_journal` (
  `id` int(11) NOT NULL,
  `sales_id` int(11) NOT NULL,
  `journal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales_journal`
--

INSERT INTO `sales_journal` (`id`, `sales_id`, `journal_id`) VALUES
(1, 1, 14),
(2, 2, 15),
(3, 1972, 16),
(4, 2006, 19),
(5, 2006, 20),
(6, 4, 21);

-- --------------------------------------------------------

--
-- Table structure for table `system_info`
--

CREATE TABLE `system_info` (
  `id` int(30) NOT NULL,
  `meta_field` text NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `system_info`
--

INSERT INTO `system_info` (`id`, `meta_field`, `meta_value`) VALUES
(1, 'name', 'Accounting Journal Management System'),
(6, 'short_name', 'AJMS - PHP'),
(11, 'logo', 'uploads/logo-1643680475.png'),
(13, 'user_avatar', 'uploads/user_avatar.jpg'),
(14, 'cover', 'uploads/cover-1643680511.png'),
(15, 'content', 'Array'),
(16, 'email', 'info@xyzcompany.com'),
(17, 'contact', '09854698789 / 78945632'),
(18, 'from_time', '11:00'),
(19, 'to_time', '21:30'),
(20, 'address', 'XYZ Street, There City, Here, 2306');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(50) NOT NULL,
  `firstname` varchar(250) NOT NULL,
  `middlename` text DEFAULT NULL,
  `lastname` varchar(250) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 0,
  `status` int(1) NOT NULL DEFAULT 1 COMMENT '0=not verified, 1 = verified',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `date_updated` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `middlename`, `lastname`, `username`, `password`, `avatar`, `last_login`, `type`, `status`, `date_added`, `date_updated`) VALUES
(1, 'Adminstrator', NULL, 'Admin', 'admin', '0192023a7bbd73250516f069df18b500', 'uploads/avatar-1.png?v=1643703899', NULL, 1, 1, '2021-01-20 14:02:37', '2022-02-01 16:24:59'),
(5, 'Claire', NULL, 'Blake', 'cblake', '4744ddea876b11dcb1d169fadf494418', 'uploads/avatar-5.png?v=1643704129', NULL, 2, 1, '2022-02-01 16:28:49', '2022-02-01 16:28:49'),
(6, 'tets', NULL, 'werw ', '32e', '81dc9bdb52d04dc20036dbd8313ed055', NULL, NULL, 2, 1, '2023-07-09 22:40:10', NULL),
(7, 'test', NULL, 'test', 'm33', 'b0baee9d279d34fa1dfd71aadb908c3f', NULL, NULL, 2, 1, '2023-07-09 23:57:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vendor`
--

CREATE TABLE `vendor` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(1024) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `company` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vendor`
--

INSERT INTO `vendor` (`id`, `name`, `address`, `account_id`, `company`) VALUES
(1, 'Jon Watson', 'Jon Watson Test', 52, 'Dell'),
(4, 'Fay Monroe', 'Suscipit animi volu', 54, 'Michael Sosa Trading'),
(5, 'Nathaniel Miles', 'Et vel deleniti proi', 55, 'Waters Rios Co');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account_list`
--
ALTER TABLE `account_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `group_list`
--
ALTER TABLE `group_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `journal_items`
--
ALTER TABLE `journal_items`
  ADD KEY `journal_id` (`journal_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchase_journal`
--
ALTER TABLE `purchase_journal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales_journal`
--
ALTER TABLE `sales_journal`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_info`
--
ALTER TABLE `system_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vendor`
--
ALTER TABLE `vendor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account_list`
--
ALTER TABLE `account_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `group_list`
--
ALTER TABLE `group_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `journal_entries`
--
ALTER TABLE `journal_entries`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `purchase_journal`
--
ALTER TABLE `purchase_journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sales_journal`
--
ALTER TABLE `sales_journal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `system_info`
--
ALTER TABLE `system_info`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `vendor`
--
ALTER TABLE `vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `journal_entries`
--
ALTER TABLE `journal_entries`
  ADD CONSTRAINT `journal_entries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `journal_items`
--
ALTER TABLE `journal_items`
  ADD CONSTRAINT `journal_items_ibfk_1` FOREIGN KEY (`journal_id`) REFERENCES `journal_entries` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_items_ibfk_2` FOREIGN KEY (`account_id`) REFERENCES `account_list` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `journal_items_ibfk_3` FOREIGN KEY (`group_id`) REFERENCES `group_list` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
