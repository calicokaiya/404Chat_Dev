-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2021 at 02:50 PM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `404chat`
--
CREATE DATABASE IF NOT EXISTS `404chat` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `404chat`;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `MessageID` int(11) NOT NULL,
  `RoomID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `MessageContent` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`MessageID`, `RoomID`, `UserID`, `MessageContent`) VALUES
(1, 1, 1, 'SlJwWHg5STZWajlSbytBOUtmbG94MzdWU1Erd2JNdzRWaWgwSW5keG1HWmYraThzaExuWkk3WGtqYzU5dkJOUHplRE5OMUdCd3gwd3hNNDMxbHA0ZGlKSHFacmx5NGViMDdTcENuLzF5cTQ9'),
(2, 1, 1, 'S1pNakRES2FGM0U1dEtWQ29Ub1F5YnBmL0JDM2JqM3QwSHNWWHZPSHFSdGV6ZjgrcUplam04aHVENDgyQW1lTnBvWjVPMm1mMldRY0draUFzeFJjbDY2cmhJYmdLVEs1SFl4bWRYN3hGQzFKMVpHRVhxK1ZsdTlVUTJkZ2RKVXBiU1VVems5STBLMzNhVXRqMkdxUFZRPT0='),
(3, 1, 1, 'ODcvb2VIWENZd0pyanVpN3UyblhnZjBkcE1GZExyT3R3Wkd2TlJlM2V5YWFIVkl4a21TMjN4c0NLdGVZc3JOdjJWWEp6Q21HdFIzV1B1YVIvQWdVLzhGdG9ENkFCTWJHQ0xKRUJOd1BtcTRheCtud2k4Vk9OOVFGMUVnTDVQVWU='),
(4, 1, 1, 'MERHa3F6TmYrSTRPT1FkNUtsT3lPK01nTkU2eHIyNnJ5UzhaeUQ1VzYwdG9sM0pnRkJCam5vQUU4a0FrRjJaSWJOV2NLajIwbU1hbFdjL0R2Z01OQmJLRXJoL0xPdGFHdHFhYWhnV2J5QWs1QzhaMGRnVjBXNmtyYzI0SU83VDN5WWtmdHkwWHkzOWdyZHFkSlYzUUF3PT0='),
(5, 1, 1, 'aGY2SWxsVGFwWWxHVlhSTngyTVhPemE4aXcvSVZHaElGMWFqeFJwWkRMVHg4dVFNTkhGSkxmSk5LLy9vb3hPbm1aNGVHdHpmL1hlOGJNTGxOenhuUDh3Vm5wTzhsMUQ0LzBqVDl2ZXZ3UUJpMVpPSTdxT3hXNDBqTDNPODlVb1BDVDRHV3EvY3QxTW5PYmwycDVCSFh3PT0='),
(6, 1, 1, 'S3RFam5QRlZLR0QvRzJQZ0prTEUzUGZWdGRNU05xelpWaVE4YUw2SjUzb2lyVmZvRDk1ZUVXMHMweWZhdm9wdFhndnBYT1Jnd25rdGp5Q3Q5KzFrUFZDRnV5RVY3a2NUSDh3N1BaWmpuNVNhNkhBZ1g1T2NmUGtLeFNYc2dtcUhjK2wzTXhMTnJRR3piQ1pOLzBPR1hRPT0='),
(7, 1, 1, 'UityY3FaOUlWd0pFcDRuQktWOUpZZEdMaXdlcDJycXowSmFXOHVhdlFVN3I5ajExb3oza2VmeDFOT3dTaFBmbG50cDJoS2dmZllNbVFlMXNSNmw2cDkwREVlenV2eDE3SitIWWlxVlpIWC9zL3JiQkh4VGQ2UDN5R3ordm5TWTVidGlTbjl4M0YxNWFzOElOZ3VwTkhkUE53OWc1QVdPcEVxbjNGVHFDQ2RVPQ=='),
(8, 1, 1, 'bUN0OVE1a0F6b29maXNzNy9lbjFyTXRCSEwzeGt0emt6Q3JqZi9LNlhlU3MvdGZ3NWttbWVwNXkyQ2p3MjhaZGI4UUtaYWZFQ3pOOWtRNWJxbFlxMWZkNmRyc2tFb1JzY0I0S1lWV0w5S0lvV20vNVhLK1hXbWNPdzM2dE9OeTQ='),
(9, 1, 1, 'cVdRbmxYci9WeU12WEs0YWVnNGUyZTQ1aHV6by9hYU16QVpzUitWdFUxYWwvZk1Jd0hVc1ZNaFhia0w4dHpEWndpcnZuZ3creHRsWURDeHNkWkpVUEE9PQ==');

-- --------------------------------------------------------

--
-- Table structure for table `rooms`
--

CREATE TABLE `rooms` (
  `RoomID` int(11) NOT NULL,
  `RoomName` varchar(50) NOT NULL,
  `RoomPassword` varchar(50) NOT NULL,
  `daily_deletion` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rooms`
--

INSERT INTO `rooms` (`RoomID`, `RoomName`, `RoomPassword`, `daily_deletion`) VALUES
(1, 'VVdyVGpUeGlsR3pIT0RUQWxTWFZuUT09', '', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `UserID` int(11) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `room_id` int(11) NOT NULL,
  `last_seen_message_id` int(11) NOT NULL,
  `daily_deletion` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`UserID`, `Username`, `room_id`, `last_seen_message_id`, `daily_deletion`) VALUES
(1, 'Admin', 1, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`MessageID`);

--
-- Indexes for table `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`RoomID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `MessageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rooms`
--
ALTER TABLE `rooms`
  MODIFY `RoomID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
