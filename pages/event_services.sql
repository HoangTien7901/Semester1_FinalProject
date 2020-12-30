-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2020 at 04:52 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `envent_services`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `account_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `account_name`, `password`, `email`, `phone_number`, `address`) VALUES
(1, 'Admin1', 'Admin1', 'Admin1@gmail.com', '123123', 'str 1'),
(2, 'admin2', 'admin2', 'admin2@gmail.com', '456456', 'Str 2');

-- --------------------------------------------------------

--
-- Table structure for table `category_event`
--

CREATE TABLE `category_event` (
  `event_id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `image` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `category_event`
--

INSERT INTO `category_event` (`event_id`, `name`, `image`) VALUES
(1, 'Wedding', 'h4'),
(2, 'wedding Anniversaries', 'w2000'),
(3, 'Birthday', 'w5'),
(4, 'Promotion parties', 'w4'),
(5, 'Annual Shows', 's2'),
(6, 'Office', 'o2');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`id`, `address`, `email`) VALUES
(1, '24-26 Phan Liem ,district 1 ,Ho Chi Minh city', 'jadon1@gmail.com'),
(2, '15 Ha Noi city', 'jadon2@gmail.com ');

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `id` int(11) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `description` varchar(250) NOT NULL,
  `image` varchar(100) NOT NULL,
  `cost` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`id`, `event_name`, `description`, `image`, `cost`) VALUES
(1, 'promantic', 'Whether you get all hot and bothered over historical romance that takes you back to fluttering hearts of yore, paranormal romance that proves you don\'t need to have flesh and blood to heat things up, heartwarming tales that explore the tender side of', 'w1.jpg', 1000),
(2, 'Homey', 'The first examples of beekeeping in the Anatolian region occurred during an important phase of civilization. The Greeks learned beekeeping from the Egyptians and used honey for preserving dead bodies, including the corpse of Alexander the Great. The ', 'w2.jpg', 1000),
(3, 'PopSugar Cabana', 'Caravents produced PopSugar\'s weekend-long event programming at the Avalon Palm Springs, where the brand\'s logo figured prominently on the central cabana structure', 'w3.jpg', 4000),
(4, '\'Nylon\' Midnight Garden', 'A-listers like Leonardo DiCaprio and Kristen Stewart lounged in V.I.P. cabanas provided by the soon-to-open Dream Hollywood hotel at Nylon\'s popular party. The setups came complete with plush Dream Hollywood robes, hotel room minibars, and “Do Not Di', 'w4.jpg', 3000),
(5, 'Zoeasis', 'At designer Rachel Zoe\'s Palm Springs party, a sign announcing the brand hung from a floral trellis.', 'w5.jpg', 3000),
(6, 'Revolve Desert', 'Online retailer Revolve presented the debut of its Revolve Desert House this year in Indio, where an open-backed floral wall spelled out the host’s name', 'w6.jpg', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `id` int(11) NOT NULL,
  `image_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gallery`
--

INSERT INTO `gallery` (`id`, `image_name`) VALUES
(1, 'w1.jpg'),
(2, 'w2.jpg'),
(3, 'w3.jpg'),
(4, 'w4.jpg'),
(5, 'w5.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `organized_events`
--

CREATE TABLE `organized_events` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `event_id_category` int(11) NOT NULL,
  `event_name` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `review_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `staff` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `organized_events`
--

INSERT INTO `organized_events` (`id`, `event_id`, `event_id_category`, `event_name`, `user_id`, `review_id`, `date`, `staff`) VALUES
(1, 1, 1, 'romantic', 1, 1, '2019-05-19', 'Minh Hoang'),
(2, 2, 2, 'homey', 2, 2, '2019-09-03', 'Tran Hoang'),
(3, 3, 3, 'PopSugar Cabana', 3, 3, '2020-12-23', 'Thanh Phong'),
(4, 4, 4, '\'Nylon\' Minight Garden', 4, 4, '2020-11-28', 'Du Nguyen'),
(5, 5, 5, 'Zoeasis', 5, 5, '2020-07-06', 'Quang Hai');

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `content` varchar(100) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `event_id`, `content`, `user_name`, `date`) VALUES
(1, 1, 'You are the most perfect you there is', 'Yoshi', '2020-03-02'),
(2, 2, 'You\'re more helpful than you realize', 'Marrie', '2019-09-03'),
(3, 3, 'You\'re even more beautiful on the inside than you are on the outside.', 'LanAnh', '2020-09-12'),
(4, 4, 'Your kindness is a balm to all who encounter it', 'QuocAnh', '2019-12-23'),
(5, 5, 'You\'ve got an awesome sense of humor!', 'TranMinh', '2020-07-06');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone_number` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id`, `name`, `phone_number`, `email`) VALUES
(1, 'Minh Hoang', '382947', 'minhhoang12@gmail.com'),
(2, 'Tran Hoang', '84234', 'tranhoang12@gmail.com'),
(3, 'Thanh Phong', '325453', 'thanhphong@gmail.com'),
(4, 'Du Nguyen', '345354', 'dunguyen434@gmail.com'),
(5, 'Quang Hai', '12314534', 'haiquang@gmail.com'),
(6, 'Phuong Thanh', '1234723142', 'phuongthanh323@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `password`, `email`, `phone_number`, `address`) VALUES
(1, 'Yoshi', 'Yoshi234', 'Yoshi13@gmail.com', '1231231', '25 Han Thuyen'),
(2, 'Marrie', 'Marrie123', 'Marrie1232@gmail.com', '32563242', '37 Thai Ha'),
(3, 'LanAnh', 'Lananh1233', 'Lananh12@gmail.com', '43453565', '12 Ha noi'),
(4, 'QuocAnh', 'quocanh12345', 'quocanh22@gmail.com', '423534', '23 Hong Bang'),
(5, 'TranMinh', 'tranminh12', 'tranminh12@gmail.com', '4564611', '23 Phu Quoc');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `category_event`
--
ALTER TABLE `category_event`
  ADD PRIMARY KEY (`event_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_name` (`event_name`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organized_events`
--
ALTER TABLE `organized_events`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `event_name` (`event_name`),
  ADD UNIQUE KEY `event_id_category` (`event_id_category`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `review_id` (`review_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_name` (`user_name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `organized_events`
--
ALTER TABLE `organized_events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `organized_events`
--
ALTER TABLE `organized_events`
  ADD CONSTRAINT `organized_events_ibfk_1` FOREIGN KEY (`id`) REFERENCES `category_event` (`event_id`),
  ADD CONSTRAINT `organized_events_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `event` (`id`),
  ADD CONSTRAINT `organized_events_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `organized_events_ibfk_4` FOREIGN KEY (`review_id`) REFERENCES `review` (`id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_name`) REFERENCES `user` (`user_name`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
