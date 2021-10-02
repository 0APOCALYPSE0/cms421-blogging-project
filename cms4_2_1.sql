-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2021 at 04:57 PM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cms4.2.1`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `datetime` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `password` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `aname` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `headline` varchar(30) COLLATE utf32_unicode_ci NOT NULL,
  `bio` text COLLATE utf32_unicode_ci NOT NULL,
  `image` text COLLATE utf32_unicode_ci NOT NULL,
  `addedby` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `permission` varchar(50) COLLATE utf32_unicode_ci NOT NULL DEFAULT 'User'
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `datetime`, `username`, `password`, `aname`, `headline`, `bio`, `image`, `addedby`, `permission`) VALUES
(1, '19 Jan 20 17:50:30', 'aakash', '123', 'Aakash Giri', 'Software Developer', 'My Name is Aakash Giri. I am a software Developer. I pursued my B.Tech in stream of Electronics and Communication Engineering.', 'Aakash.jpg', 'Admin', 'Superuser'),
(6, '19 Jan 20 17:51:30', 'vikash', '123', 'Vikash Giri', '', '', '', 'aakash', 'Admin'),
(8, ' 1 Oct 21 00:02:43', 'test', '123', 'test', '', '', '', 'System', 'User');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `datetime` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `title`, `author`, `datetime`) VALUES
(6, 'Technology', 'Aakash', 'January-01/13/20-202'),
(7, 'Education', 'aakash', '19 Jan 20 18:30:40'),
(8, 'Food', 'aakash', '19 Jan 20 18:30:44'),
(9, 'Travel', 'aakash', '19 Jan 20 18:30:49'),
(10, 'Music', 'aakash', '19 Jan 20 18:30:53'),
(11, 'Entertainment', 'aakash', '19 Jan 20 18:31:00'),
(12, 'Photography', 'aakash', '19 Jan 20 18:31:06'),
(13, 'Movie', 'aakash', '19 Jan 20 18:31:13'),
(14, 'Sports', 'aakash', '13 Sep 21 01:58:33');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `datetime` varchar(20) COLLATE utf32_unicode_ci NOT NULL,
  `name` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `comment` text COLLATE utf32_unicode_ci NOT NULL,
  `approvedby` varchar(50) COLLATE utf32_unicode_ci NOT NULL,
  `status` varchar(3) COLLATE utf32_unicode_ci NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf32 COLLATE=utf32_unicode_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `datetime`, `name`, `email`, `comment`, `approvedby`, `status`, `post_id`) VALUES
(8, '19 Jan 20 18:00:38', 'Aakash Giri', 'giriaakash00@gmail.com', 'I love this post on Blockchain.', 'Aakash Giri', 'ON', 1);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `datetime` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `tags` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `author` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `image` text COLLATE utf8_unicode_ci NOT NULL,
  `post` text COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `datetime`, `title`, `slug`, `tags`, `category`, `author`, `image`, `post`, `status`, `user_id`) VALUES
(1, '14 Sep 21 19:23:26', 'What is Blockchain', 'what-is-blockchain', 'Blockchain, Crypto Currency, Bit Coins', 'Technology', 'Aakash', 'blockchain.png', '<p>The blockchain is an undeniably ingenious invention &ndash; the brainchild of a person or group of people known by the pseudonym, Satoshi Nakamoto. But since then, it has evolved into something greater, and the main question every single person is asking is: What is Blockchain?</p>\r\n\r\n<p>By allowing digital information to be distributed but not copied, blockchain technology created the backbone of a new type of internet. Originally devised for the&nbsp;<strong><a href=\"https://blockgeeks.com/guides/what-is-cryptocurrency/\">digital currency</a>,&nbsp;<a href=\"https://blockgeeks.com/guides/what-is-bitcoin/\">Bitcoin</a>, (<a href=\"https://bitbuy.ca/?ref=40H9UH4AXZ\" target=\"_blank\">Buy Bitcoin</a></strong>) the tech community has now found other potential uses for the technology.</p>\r\n\r\n<p>In this guide, we are going to explain to you what the blockchain technology is, and what its properties are what make it so unique. So, we hope you enjoy this, What Is Blockchain Guide. And if you already know what blockchain is and want to become a blockchain developer please check out our in-depth&nbsp;<strong><a href=\"https://blockgeeks.com/guides/blockchain-developer/\">blockchain tutorial</a>&nbsp;</strong>and create your very first blockchain.</p>\r\n', 'publish', 1),
(2, '14 Sep 21 19:23:04', 'Introduction to Object Detection', 'introduction-to-object-detection', 'AI, Machine Learning, Data Science, Object Detection', 'Technology', 'aakash', 'object-detection.jpg', '<p>Humans can easily detect and identify objects present in an image. The human visual system is fast and accurate and can perform complex tasks like identifying multiple objects and detect obstacles with little conscious thought. With the availability of large amounts of data, faster GPUs, and better algorithms, we can now easily train computers to detect and classify multiple objects within an image with high accuracy. In this blog, we will explore terms such as object detection, object localization, loss function for object detection and localization, and finally explore an object detection algorithm known as &ldquo;You only look once&rdquo; (YOLO).</p>\r\n\r\n<h2><strong>Object Localization</strong></h2>\r\n\r\n<p>An image classification or image recognition model simply detect the probability of an object in an image. In contrast to this, object localization refers to identifying the location of an object in the image. An object localization algorithm will output the coordinates of the location of an object with respect to the image. In computer vision, the most popular way to localize an object in an image is to represent its location with the help of bounding boxes. Fig. 1 shows an example of a bounding box.</p>\r\n', 'publish', 1),
(3, '14 Sep 21 19:24:16', 'Beautiful Montreal', 'beautiful-montreal', 'Travel Blog, Montreal, World Tour', 'Travel', 'aakash', 'old_montreal2.jpg', '<p><a href=\"https://www.nomadicmatt.com/travel-guides/canada-travel-tips/montreal/\" target=\"_blank\">Montreal</a>&nbsp;is one of the world&rsquo;s best cities (at least in my opinion). From its lovely parks and historic downtown to its incredible music, art, and foodie scenes, Montreal is amazing.</p>\r\n\r\n<p>It also has robust hostel offerings, with dozens to choose from. In my visits to the city, I&rsquo;ve stayed at numerous hostels but always come back to my favorites listed below. To me, these are the best!</p>\r\n', 'publish', 1),
(4, '14 Sep 21 19:24:40', 'Tasty Pasta Recipie', 'tasty-pasta-recipie', 'Food, Cooking, Pasta, Recipies', 'Food', 'aakash', 'dinner.jpg', '<p>Do you ever have nights when you just can&rsquo;t seem to think of any easy dinner ideas? When you feel like you&rsquo;ve rotated through all your standbys, and nothing sounds good? If you do, you&rsquo;re in the right place. Below, you&rsquo;ll find over 50 healthy dinner ideas that are perfect for busy weeknights. All of these dinner recipes are quick and easy to make, but still full of flavor. They&rsquo;re ones we&rsquo;ve enjoyed time and time again, even on nights when we&rsquo;re tired, crunched for time, or not in the mood to cook.</p>\r\n\r\n<p>But before we get to the recipes, I want to talk strategy. On busy nights, knowing a few simple methods for getting a quick and easy dinner on the table can really pay off.</p>\r\n', 'publish', 1),
(9, '26 Sep 21 23:48:31', 'Write Hello World! program in python', 'write-hello-world-program-in-python', 'python, programming, hello world, computer science', 'Technology', 'aakash', 'program.jpg', '<p><span style=\"font-size:16px\"><big><strong>Write a python program to print Hello World!</strong></big></span><br />\r\nPython is a very popular, simple, interpreted high-level general-purpose programming language. Python can be used to develop web or desktop applications, task automation, data analysis, machine learning, and data visualization. If you want to learn more about the python language then you can follow the official documentation of python at <a href=\"https://www.python.org/\" target=\"_blank\">Python</a>.<br />\r\nThere are two versions of python, Python 2 and Python 3. We are going to use Python 3 for creating our Hello World! program in this tutorial.<br />\r\n<span style=\"font-size:16px\"><strong>Source Code</strong></span><br />\r\n<img alt=\"\" class=\"img-fluid\" src=\"https://blogging.lovestoblog.com/Upload/python-hello-world.png\" /><br />\r\nPython has a very straightforward syntax. In the above program, we are using the in-built print() method provided by python to print our &quot;Hello World!&quot; text on the screen. In python, we do not need to import any library as we do in any other programming language example C, C++, Java, etc. That&#39;s why Python is a&nbsp; very good choice for any newbie programmer.<br />\r\nSo now you have started your coding journey with the very popular Hello World! program in python. There is a lot more to explore. You can try to run this program on different IDE&#39;s available online.<br />\r\nThanks for learning with me. For more tutorials like this please follow all of my blogs related to programming.</p>\r\n', 'publish', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
