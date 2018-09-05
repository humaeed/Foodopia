-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 04, 2018 at 10:28 AM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `restaurant_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(10) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `Name`, `email`, `password`) VALUES
(1, 'admin', 'admin@lol.com', '123456789#');

-- --------------------------------------------------------

--
-- Table structure for table `foods`
--

CREATE TABLE `foods` (
  `food_id` int(10) NOT NULL,
  `res_id` int(11) NOT NULL,
  `food_name` varchar(50) NOT NULL,
  `food_price` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `foods`
--

INSERT INTO `foods` (`food_id`, `res_id`, `food_name`, `food_price`) VALUES
(1237, 439, 'Dumpling (5)', 500),
(1238, 439, 'Noodles (per plate)', 50),
(1239, 439, 'Chinese Chicken Burger', 120),
(1240, 444, 'Pizza', 500);

-- --------------------------------------------------------

--
-- Table structure for table `location`
--

CREATE TABLE `location` (
  `location_id` int(100) NOT NULL,
  `road` varchar(50) DEFAULT NULL,
  `house` varchar(50) DEFAULT NULL,
  `area` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `latitude` double(10,6) DEFAULT NULL,
  `longitude` double(10,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `location`
--

INSERT INTO `location` (`location_id`, `road`, `house`, `area`, `city`, `latitude`, `longitude`) VALUES
(1, '3', '780BCD', 'Putia', 'Rajshahi', 24.340847, 89.529710),
(3, '10', 'B', 'Mogla', 'Sylhet', 24.890777, 91.892904),
(4, NULL, NULL, 'Mohakhali', 'Dhaka', NULL, NULL),
(5, '3', '780BCD', 'Gulshan', 'Dhaka', 23.792496, 90.407806);

-- --------------------------------------------------------

--
-- Table structure for table `restaurants`
--

CREATE TABLE `restaurants` (
  `res_id` int(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `picture` varchar(100) NOT NULL DEFAULT 'upload/res_def.png',
  `services` mediumtext,
  `manager_name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `cuisine` varchar(100) DEFAULT NULL,
  `location_id` int(100) NOT NULL,
  `valid` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `restaurants`
--

INSERT INTO `restaurants` (`res_id`, `name`, `picture`, `services`, `manager_name`, `email`, `password`, `phone`, `cuisine`, `location_id`, `valid`) VALUES
(423, 'Van Ness Cafe', 'upload/res_def.png', 'Free Wifi%Takeout', 'Justin Timberlake', 'justin@gmail.com', '123456789#', NULL, NULL, 1, 'Y'),
(439, 'Hakka Dhaka Chinese Restaurant', 'upload/5b8b84c19dc2b0.80585653.jpg', 'Parking (Cars/Bikes)%TV%Free Wifi%Xbox', 'Halar Put', 'pope@lol.com', '123456789#', '01726598977', 'Chinese', 3, 'Y'),
(440, 'The Sini Restaurant', 'upload/res_def.png', NULL, 'Timon Ali', 'humaeed@outlook.com', '123456789#', NULL, NULL, 4, 'Y'),
(444, 'KFC', 'upload/res_def.png', 'Wifi', 'Jake Paul', 'haha@lol.com', '123456789#', NULL, NULL, 5, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `reviewer`
--

CREATE TABLE `reviewer` (
  `rev_username` varchar(15) NOT NULL,
  `name` varchar(20) NOT NULL,
  `dob` varchar(10) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(20) NOT NULL,
  `picture` mediumtext NOT NULL,
  `follower` longtext,
  `following` longtext,
  `points` float DEFAULT '0',
  `valid` varchar(1) NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviewer`
--

INSERT INTO `reviewer` (`rev_username`, `name`, `dob`, `email`, `password`, `picture`, `follower`, `following`, `points`, `valid`) VALUES
('badassiumoxide', 'Humaeed Ahmed', '1/1/1995', 'humaeedanik@gmail.com', '123456789#', 'upload/def.png', NULL, NULL, 0, 'Y'),
('hate_deadpool', 'Francis Barkalounger', '2/1/1990', 'rss.rafid@gmail.com', '123456789#', 'upload/def.png', 'ryan_coop', '', 0, 'Y'),
('janedoe', 'Jane Doe', '01/12/2000', 'jane@gmail.com', '123456789#', 'upload/5b7798899f68f1.89414946.png', 'john_pro@ryan_coop', '', 0, 'Y'),
('john_pro', 'Jake Ryan', '01/01/1995', 'john@lol.com', '123456789#', 'upload/5b8e1a35e5b631.92153270.png', 'ryan_coop', 'janedoe@ryan_coop', 0, 'N'),
('ryan_coop', 'Ryan Cooper', '1/1/1980', 'ryan@msn.com', '123456789#', 'upload/5b8de0fc0e7077.88753387.png', 'john_pro', 'john_pro@janedoe@hate_deadpool', 0, 'Y');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `rating` text NOT NULL,
  `review_id` int(10) NOT NULL,
  `res_id` int(10) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rev_username` varchar(15) NOT NULL,
  `restaurant` varchar(50) NOT NULL,
  `review` longtext NOT NULL,
  `approval` varchar(10) NOT NULL DEFAULT 'X',
  `notify` int(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`rating`, `review_id`, `res_id`, `date`, `rev_username`, `restaurant`, `review`, `approval`, `notify`) VALUES
('GOOD', 26467, 439, '2018-09-19 03:19:20', 'john_pro', 'Hakka Dhaka Chinese Restaurant', 'Beautiful new juice bar in downtown Palo Alto. It\'s the first of 3 PA locations I\'ve noticed to open (there\'s going to be one on Hamilton and one at Stanford Shopping Center), and I am still enraptured by the open, airy and highly ambient space.', 'Y', 2),
('BAD', 26468, 423, '2018-09-03 08:16:35', 'john_pro', 'Van Ness Cafe', 'Affordable and tasty!\r\n\r\nThere are a lot of mediterranean options around the tenderloin/tendernob but not all are great tasting or cheap. \r\n\r\nThankfully, this place does the fix. I had the lamb beef wrap gyro and it was very well done. The hummus aioli sauce went well with it and it was only 9.80! \r\n\r\nI will definitely be back. Give this place a shot, you won\'t regret it!', 'Y', 2),
('AVERAGE', 26469, 440, '2018-12-06 10:36:36', 'john_pro', 'The Sini Restaurant ', 'An absolute must try!!! I\'ve tried almost everything on the menu and I have never been disappointed. Why should you go to this place? It\'s simple, the food is delicious, fairly priced, and so simple. There are some places in the area with menus longer than the Harry Potter books. They make it very easy to make your choice and everything is so flavorful. You know this is the spot when you see the same people in there, join the movement \r\n\r\nThe last thing I had here was the salad with extra protein.', 'Y', 2),
('AVERAGE', 26478, 423, '2018-09-03 23:18:44', 'john_pro', 'Van Ness Cafe ', 'Not bad! But could have been better!', 'Y', 2),
('AVERAGE', 26480, 444, '2018-09-04 05:54:40', 'john_pro', 'KFC', 'Not bad.', 'Y', 1),
('AVERAGE', 26481, 439, '2018-09-04 07:34:50', 'ryan_coop', 'Hakka Dhaka Chinese Restaurant', 'GO GO !', 'X', 0),
('AVERAGE', 26482, 444, '2018-09-04 11:38:47', 'john_pro', 'KFC', 'Test', 'Y', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `foods`
--
ALTER TABLE `foods`
  ADD PRIMARY KEY (`food_id`),
  ADD UNIQUE KEY `food_name` (`food_name`);

--
-- Indexes for table `location`
--
ALTER TABLE `location`
  ADD UNIQUE KEY `location_id` (`location_id`);

--
-- Indexes for table `restaurants`
--
ALTER TABLE `restaurants`
  ADD PRIMARY KEY (`res_id`);

--
-- Indexes for table `reviewer`
--
ALTER TABLE `reviewer`
  ADD PRIMARY KEY (`rev_username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `foods`
--
ALTER TABLE `foods`
  MODIFY `food_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1241;

--
-- AUTO_INCREMENT for table `location`
--
ALTER TABLE `location`
  MODIFY `location_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `restaurants`
--
ALTER TABLE `restaurants`
  MODIFY `res_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=445;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26483;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
