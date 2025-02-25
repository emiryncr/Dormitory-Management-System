-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 21 Ara 2024, 17:46:31
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
(1, 'MARMARA', 98777456, 'Famagusta', 'single,triple,quad', '../../img/dorms/dorm1.jpg'),
(2, 'POP ART', 1010010101, 'Famagusta', 'single', '../../img/dorms/dorm2.jpg'),
(3, 'Alfam', 435345345, 'Famagusta', 'quad', '../../img/dorms/dorm3.jpg'),
(6, 'DAU1', 1, 'Famagusta', 'quad', '../../img/dorms/dorm4.jpg'),
(8, 'Akdeniz', 11111, 'Famagusta', 'quad', '../../img/dorms/dorm5.jpg'),
(17, 'Ekor', 7676, 'Famagusta', 'single,triple,quad', '../../img/dorms/dorm6.jpg'),
(25, 'SALAMIS', 4545, 'Famagusta', 'single,triple,quad', '../../img/dorms/dorm7.jpg'),
(26, 'yncr', 2147483647, 'kocaeli', 'double', '../../img/dorms/dorm3.jpg');

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
(20, 22, 6, '2024-12-15', 'Pending'),
(36, 2, 3, '2024-12-21', 'Paid'),
(37, 29, 3, '2024-12-21', 'Pending');

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
(2, 3, 'nealaka', 0, 'single', 1, 1, '../../img/rooms/room1.jpg'),
(3, 1, 'odaadımıolur', 200, 'double', 2, 0, '../../img/rooms/room2.jpg'),
(4, 1, 'isim', 1212, 'double', 1, 3, '../../img/rooms/room3.jpg'),
(6, 3, 'oda1', 100, 'double', 2, 1, '../../img/rooms/room3.jpg'),
(12, 25, 'aaa', 1, 'single', 1, 1, '../../img/rooms/room1.jpg'),
(14, 1, 'denemeoda', 1212, 'quad', 4, 4, '../../img/rooms/room2.jpg'),
(15, 26, 'bizimev', 214748368, 'dormitory', 6, 6, '../../img/rooms/room3.jpg'),
(16, 1, 'oda9', 2, 'double', 2, 2, '../../img/rooms/room4.jpg'),
(22, 2, 'ORNEK ', 111, 'single', 1, 1, '../../img/rooms/room1.jpg'),
(23, 2, 'WhiteKing', 6000, 'double', 2, 2, '../../img/rooms/room5.jpg');

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
(1, 'admin', '', '', '', '', 'Admin', NULL, 'admin'),
(2, 'emiryncr', 'Emir', 'Yeniçeri', '213309792@emu.edu.tr', '05338750006', 'Student', NULL, 'ruhi1234'),
(15, 'johndoe', 'John', 'Doe', 'johndoe@gmail.com', '0001200', 'Manager', 1, 'johndoe123'),
(19, 'memati', 'Memati', 'Bas', 'memati@gmail.com', '00111001', 'Manager', 2, 'mematibas'),
(21, 'MANAGER', 'MANAGER', 'MANAGER', 'MANAGER@gmail.com', '00000000', 'Manager', 3, '123123123'),
(22, 'uzmen', 'Barkan', 'Uzmen', 'brknuzmn@bau.edu.tr', '98731678', 'Student', NULL, 'saksakcıkus'),
(29, 'glsmalbrk', 'gülsüm', 'albayrak', 'gulsun4132@gmail.com', '05338750006', 'Student', NULL, 'slkemri123'),
(30, 'emrialbrk', 'emir', 'albayrak', 'emrialbrk0608@gmail.com', '00000000', 'Manager', 26, 'emriglsmeasık'),
(34, 'Ruhi', 'Ruhi', 'Çenet', 'cenediayrik@gmail.com', '1298313', 'Student', NULL, 'ruhi1234'),
(36, 'checker', 'checker', 'checker', 'checker@gmail.com', '1233223', 'Manager', 25, '111222333'),
(40, 'admin2', NULL, NULL, NULL, NULL, 'Admin', NULL, 'admin2');

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
  MODIFY `dormid` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Tablo için AUTO_INCREMENT değeri `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservationid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- Tablo için AUTO_INCREMENT değeri `rooms`
--
ALTER TABLE `rooms`
  MODIFY `roomid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `userid` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

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
