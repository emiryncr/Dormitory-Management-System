-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 21 Ara 2024, 21:59:24
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `dormitorydb`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dormitory`
--

CREATE TABLE `dormitory` (
  `dormid` int(50) NOT NULL,
  `dormname` varchar(50) NOT NULL,
  `dormphone` int(50) NOT NULL,
  `location` varchar(50) NOT NULL,
  `typeofrooms` set('single','double','triple','quad','apartment') NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `dormitory`
--

INSERT INTO `dormitory` (`dormid`, `dormname`, `dormphone`, `location`, `typeofrooms`, `photo`) VALUES
(32, 'Alfam', 11111111, 'Famagusta', 'single,quad', '../../img/dorms/dorm1.jpg'),
(33, 'Pop Art', 222222222, 'Famagusta', 'single,triple,apartment', '../../img/dorms/dorm2.jpg'),
(34, 'DAU1', 3333333, 'Famagusta', 'double,quad', '../../img/dorms/dorm3.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `reservation`
--

CREATE TABLE `reservation` (
  `reservationid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `roomid` int(11) NOT NULL,
  `reservationdate` date NOT NULL DEFAULT current_timestamp(),
  `status` enum('Paid','Pending') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `reservation`
--

INSERT INTO `reservation` (`reservationid`, `studentid`, `roomid`, `reservationdate`, `status`) VALUES
(41, 44, 27, '2024-12-21', 'Paid'),
(42, 46, 30, '2024-12-21', 'Pending'),
(43, 47, 29, '2024-12-21', 'Paid');

--
-- Tetikleyiciler `reservation`
--
DELIMITER $$
CREATE TRIGGER `increase_capacity` AFTER DELETE ON `reservation` FOR EACH ROW BEGIN
    UPDATE rooms
    SET available_capacity = available_capacity + 1
    WHERE roomid = OLD.roomid;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `reduce_capacity` BEFORE INSERT ON `reservation` FOR EACH ROW BEGIN
    -- Kapasite kontrolü
    IF (SELECT available_capacity FROM rooms WHERE roomid = NEW.roomid) <= 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Room capacity is full. Cannot reserve this room.';
    END IF;

    -- Kapasiteyi düşür
    UPDATE rooms
    SET available_capacity = available_capacity - 1
    WHERE roomid = NEW.roomid;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `rooms`
--

CREATE TABLE `rooms` (
  `roomid` int(11) NOT NULL,
  `assigndorm` int(11) NOT NULL,
  `roomname` varchar(50) NOT NULL,
  `price` int(20) NOT NULL,
  `roomtype` enum('single','double','triple','quad','dormitory') NOT NULL,
  `capacity` int(11) NOT NULL,
  `available_capacity` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `rooms`
--

INSERT INTO `rooms` (`roomid`, `assigndorm`, `roomname`, `price`, `roomtype`, `capacity`, `available_capacity`, `photo`) VALUES
(27, 32, 'room1', 100, 'single', 1, 0, '../../img/rooms/room1.jpg'),
(28, 32, 'room2', 200, 'double', 2, 2, '../../img/rooms/room2.jpg'),
(29, 33, 'room1', 300, 'triple', 3, 2, '../../img/rooms/room3.jpg'),
(30, 33, 'room2', 400, 'quad', 4, 3, '../../img/rooms/room4.jpg');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `userid` int(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `surname` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `role` enum('Admin','Manager','Student') NOT NULL,
  `dormid` int(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`userid`, `username`, `name`, `surname`, `email`, `phone`, `role`, `dormid`, `password`) VALUES
(42, 'admin', NULL, NULL, NULL, NULL, 'Admin', NULL, '$2y$10$pFnBNhKwg4G2cKGsO4ZHcuYd1MmkxrrkMdBg6HTGIyAi5yyzTtZnO'),
(43, 'alikoc123', 'Ali', 'Koç', 'alikoc@gmail.com', '123123123', 'Manager', 32, '$2y$10$13QYtCqCnx/a8mc0ogeaNeyRPe2tgsDDgI7eF.sxChf0aXMDuZiqO'),
(44, 'emiryncr', 'Emir', 'Yeniçeri', '21330979@emu.edu.tr', '053300006', 'Student', NULL, '$2y$10$Co3IL3FxcBocvcEMe9cGZOUI1cbjJ7IfF.16u94u4z0TByauiJFHm'),
(45, 'johndoe123', 'John', 'Doe', 'johndoe@gmail.com', '54353423', 'Manager', 33, '$2y$10$W6HGs.oZCNX/7I0JeKtDrOO2Z.lARAM00wseFhjtR4m2mhoi0S00C'),
(46, 'loremipsum', 'Lorem', 'Ipsum', 'loremipsum@gmail.com', '5564234', 'Student', NULL, '$2y$10$82fUblMLklu1YveRtB2AVurV3BGPwxDMmbrGF3cQh7usjz2XxXkF6'),
(47, 'fatihterim', 'Fatih', 'Terim', 'fatihterim@gmail.com', '334324324', 'Student', NULL, '$2y$10$ZY3A8F9V0llr59dUM1fGq.xhk4lfgBVKNSr9MbknSHrzJ75iQbPKq');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `dormitory`
--
ALTER TABLE `dormitory`
  ADD PRIMARY KEY (`dormid`),
  ADD UNIQUE KEY `dormphone` (`dormphone`) USING BTREE;

--
-- Tablo için indeksler `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservationid`),
  ADD UNIQUE KEY `studentid` (`studentid`),
  ADD KEY `roomid` (`roomid`);

--
-- Tablo için indeksler `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`roomid`),
  ADD KEY `assigndorm` (`assigndorm`) USING BTREE;

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `fk_dormitory` (`dormid`) USING BTREE;

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `dormitory`
--
ALTER TABLE `dormitory`
  MODIFY `dormid` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Tablo için AUTO_INCREMENT değeri `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Tablo için AUTO_INCREMENT değeri `rooms`
--
ALTER TABLE `rooms`
  MODIFY `roomid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`studentid`) REFERENCES `users` (`userid`),
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`roomid`) REFERENCES `rooms` (`roomid`);

--
-- Tablo kısıtlamaları `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`assigndorm`) REFERENCES `dormitory` (`dormid`);

--
-- Tablo kısıtlamaları `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_dormitory` FOREIGN KEY (`dormid`) REFERENCES `dormitory` (`dormid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
