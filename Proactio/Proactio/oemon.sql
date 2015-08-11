-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jul 14, 2015 at 09:07 AM
-- Server version: 5.6.21-log
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `oemon`
--

-- --------------------------------------------------------

--
-- Table structure for table `alertdesc`
--

CREATE TABLE IF NOT EXISTS `alertdesc` (
  `desc_id` int(11) NOT NULL,
  `alertdisc` varchar(100) NOT NULL,
  `alerttype` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `alertdesc`
--

INSERT INTO `alertdesc` (`desc_id`, `alertdisc`, `alerttype`) VALUES
(1, 'Database Unavailable or Down', 'Critical'),
(2, 'Lock table overflow', 'Major'),
(3, 'BI size (in MB) is growing', 'Minor'),
(4, 'AI size in Megabytes', 'Major'),
(5, 'User Table overflow', 'Major'),
(6, 'BI size (in MB) is growing', 'Major'),
(7, 'BI size (in MB) is growing', 'Critical'),
(8, 'Record Locks for a process', 'Major'),
(9, 'Transaction active', 'Major'),
(10, 'Area size reached more than 80 %\r\n', 'Major'),
(11, 'Area size reached more than 90 %\r\n', 'Critical'),
(12, 'Buffer Hits less than 90%', 'Minor'),
(13, 'Buffer Hits less than 80%', 'Major'),
(14, 'Errors in Log file', 'Major'),
(21, 'CPU Utilization Alert', 'Major'),
(22, 'Disk IO Status Alert', 'Minor'),
(23, 'Physical Memory Space Alert', 'Minor'),
(24, 'Swap Memory Alert', 'Minor'),
(25, 'File System Free Space Alert', 'Minor');

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE IF NOT EXISTS `alerts` (
`alertid` int(50) NOT NULL,
  `dbid` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `desc_id` int(10) NOT NULL,
  `alert_read` tinyint(1) NOT NULL,
  `enddate` datetime DEFAULT NULL,
  `info` varchar(100) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `areagrowth`
--

CREATE TABLE IF NOT EXISTS `areagrowth` (
  `dbid` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `areaname` varchar(25) NOT NULL,
  `totalalloc` int(25) NOT NULL,
  `hiwater` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `bireport`
--

CREATE TABLE IF NOT EXISTS `bireport` (
  `dbid` varchar(50) NOT NULL,
  `bisize` int(11) NOT NULL,
  `clustersize` int(11) NOT NULL,
  `commits` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `configureddb`
--

CREATE TABLE IF NOT EXISTS `configureddb` (
  `dbuid` varchar(30) NOT NULL,
  `dbname` varchar(50) NOT NULL,
  `server` varchar(30) NOT NULL,
  `port` int(5) NOT NULL,
  `dbuser` varchar(50) NOT NULL,
  `dbpass` varchar(40) NOT NULL,
  `sslusername` varchar(40) NOT NULL,
  `sslpassword` varchar(40) NOT NULL,
  `environ` varchar(40) NOT NULL,
  `dblocation` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `connect`
--

CREATE TABLE IF NOT EXISTS `connect` (
  `dbid` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(25) NOT NULL,
  `utype` varchar(5) NOT NULL,
  `mip` varchar(25) NOT NULL,
  `connsince` varchar(30) NOT NULL,
  `pid` int(10) NOT NULL,
  `userno` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cpurep`
--

CREATE TABLE IF NOT EXISTS `cpurep` (
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dbid` varchar(50) NOT NULL,
  `user` decimal(5,2) NOT NULL,
  `nice` decimal(5,2) NOT NULL,
  `system` decimal(5,2) NOT NULL,
  `iowait` decimal(5,2) NOT NULL,
  `steal` decimal(5,2) NOT NULL,
  `idle` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `databaseio`
--

CREATE TABLE IF NOT EXISTS `databaseio` (
  `dbid` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `commits` int(25) NOT NULL,
  `undos` int(25) NOT NULL,
  `rupdates` int(25) NOT NULL,
  `rreads` int(25) NOT NULL,
  `rcreates` int(25) NOT NULL,
  `rdeletes` int(25) NOT NULL,
  `dbwrites` int(25) NOT NULL,
  `dbreads` int(25) NOT NULL,
  `rlocks` int(25) NOT NULL,
  `rwaits` int(25) NOT NULL,
  `checkpoints` int(25) NOT NULL,
  `buffflush` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbalogin`
--

CREATE TABLE IF NOT EXISTS `dbalogin` (
  `Name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dbalogin`
--

INSERT INTO `dbalogin` (`Name`, `username`, `password`, `email`) VALUES
('', 'admin', 'c96c0874e3598147f8508afca93afde7', 'ezaz.war@jktech.com');

-- --------------------------------------------------------

--
-- Table structure for table `dbparam`
--

CREATE TABLE IF NOT EXISTS `dbparam` (
`dbid` int(50) NOT NULL,
  `userid` varchar(30) NOT NULL,
  `dbuid` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `dbsizerep`
--

CREATE TABLE IF NOT EXISTS `dbsizerep` (
  `dbuid` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `size` decimal(30,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `diskrep`
--

CREATE TABLE IF NOT EXISTS `diskrep` (
  `dbid` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `totalsize` int(25) NOT NULL,
  `usedsize` int(25) NOT NULL,
  `freesize` int(25) NOT NULL,
  `mounted` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `forgottenpassword`
--

CREATE TABLE IF NOT EXISTS `forgottenpassword` (
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(50) NOT NULL,
  `passwordhash` varchar(64) NOT NULL,
  `reqby` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `idxstat`
--

CREATE TABLE IF NOT EXISTS `idxstat` (
  `dbid` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `idxstatid` int(25) NOT NULL,
  `blockdelete` int(25) NOT NULL,
  `createidx` int(25) NOT NULL,
  `deleteidx` int(25) NOT NULL,
  `readidx` int(25) NOT NULL,
  `idxstatname` varchar(25) NOT NULL,
  `split` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `login_db`
--

CREATE TABLE IF NOT EXISTS `login_db` (
  `user_id` varchar(25) NOT NULL,
  `name` varchar(25) NOT NULL COMMENT 'Name Of User',
  `email_id` varchar(30) NOT NULL COMMENT 'email id ',
  `password` varchar(64) NOT NULL,
  `mobile` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `longtrans`
--

CREATE TABLE IF NOT EXISTS `longtrans` (
  `dbid` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(25) NOT NULL,
  `pid` int(11) NOT NULL,
  `usrno` int(11) NOT NULL,
  `timerunning` int(11) NOT NULL,
  `transno` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `memrep`
--

CREATE TABLE IF NOT EXISTS `memrep` (
  `dbid` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `totalmem` int(25) NOT NULL,
  `usedmem` int(25) NOT NULL,
  `freemem` int(25) NOT NULL,
  `totalswap` int(25) NOT NULL,
  `usedswap` int(25) NOT NULL,
  `freeswap` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE IF NOT EXISTS `request` (
`reqid` int(20) NOT NULL,
  `userid` varchar(50) NOT NULL,
  `dbuid` varchar(50) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tableio`
--

CREATE TABLE IF NOT EXISTS `tableio` (
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dbid` varchar(50) NOT NULL,
  `createtio` int(25) NOT NULL,
  `deletetio` int(25) NOT NULL,
  `readtio` int(25) NOT NULL,
  `tableioid` int(25) NOT NULL,
  `tablename` varchar(25) NOT NULL,
  `updatetio` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `uconnrep`
--

CREATE TABLE IF NOT EXISTS `uconnrep` (
  `dbuid` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `noconn` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userio`
--

CREATE TABLE IF NOT EXISTS `userio` (
  `dbid` varchar(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `dbaccess` int(25) NOT NULL,
  `dbwrites` int(25) NOT NULL,
  `dbreads` int(25) NOT NULL,
  `name` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `userlist`
--

CREATE TABLE IF NOT EXISTS `userlist` (
  `dbid` int(50) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user` varchar(25) NOT NULL,
  `username` int(25) NOT NULL,
  `name` int(30) NOT NULL,
  `lastlogin` int(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alertdesc`
--
ALTER TABLE `alertdesc`
 ADD PRIMARY KEY (`desc_id`);

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
 ADD PRIMARY KEY (`alertid`), ADD UNIQUE KEY `dbid` (`dbid`,`date`), ADD KEY `idx` (`desc_id`);

--
-- Indexes for table `areagrowth`
--
ALTER TABLE `areagrowth`
 ADD KEY `areagrowth_fk` (`dbid`);

--
-- Indexes for table `bireport`
--
ALTER TABLE `bireport`
 ADD KEY `bireport_fk` (`dbid`);

--
-- Indexes for table `configureddb`
--
ALTER TABLE `configureddb`
 ADD PRIMARY KEY (`dbuid`);

--
-- Indexes for table `connect`
--
ALTER TABLE `connect`
 ADD KEY `connect_fk` (`dbid`);

--
-- Indexes for table `cpurep`
--
ALTER TABLE `cpurep`
 ADD KEY `dbid` (`dbid`);

--
-- Indexes for table `databaseio`
--
ALTER TABLE `databaseio`
 ADD KEY `databaseio_fk` (`dbid`);

--
-- Indexes for table `dbalogin`
--
ALTER TABLE `dbalogin`
 ADD PRIMARY KEY (`username`);

--
-- Indexes for table `dbdisc`
--
ALTER TABLE `dbdisc`
 ADD KEY `dbdisc_fk` (`dbid`);

--
-- Indexes for table `dbfeatures`
--
ALTER TABLE `dbfeatures`
 ADD KEY `dbfeatures_fk` (`dbid`);

--
-- Indexes for table `dbparam`
--
ALTER TABLE `dbparam`
 ADD PRIMARY KEY (`dbid`), ADD KEY `dbparam_fk` (`userid`), ADD KEY `dbparam1_fk` (`dbuid`);

--
-- Indexes for table `dbsizerep`
--
ALTER TABLE `dbsizerep`
 ADD PRIMARY KEY (`dbuid`,`date`), ADD KEY `dbuid` (`dbuid`);

--
-- Indexes for table `diskrep`
--
ALTER TABLE `diskrep`
 ADD KEY `diskrep_fk` (`dbid`);

--
-- Indexes for table `forgottenpassword`
--
ALTER TABLE `forgottenpassword`
 ADD PRIMARY KEY (`datetime`,`username`);

--
-- Indexes for table `idxstat`
--
ALTER TABLE `idxstat`
 ADD KEY `idxstat_fk` (`dbid`);

--
-- Indexes for table `login_db`
--
ALTER TABLE `login_db`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `longtrans`
--
ALTER TABLE `longtrans`
 ADD KEY `longtrans_fk` (`dbid`);

--
-- Indexes for table `memrep`
--
ALTER TABLE `memrep`
 ADD KEY `dbid` (`dbid`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
 ADD PRIMARY KEY (`reqid`);

--
-- Indexes for table `tableio`
--
ALTER TABLE `tableio`
 ADD KEY `tableio_fk` (`dbid`);

--
-- Indexes for table `uconnrep`
--
ALTER TABLE `uconnrep`
 ADD PRIMARY KEY (`dbuid`,`date`), ADD KEY `dbuid` (`dbuid`);

--
-- Indexes for table `userio`
--
ALTER TABLE `userio`
 ADD KEY `userio_fk` (`dbid`);

--
-- Indexes for table `userlist`
--
ALTER TABLE `userlist`
 ADD KEY `userlist_fk` (`dbid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
MODIFY `alertid` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=200;
--
-- AUTO_INCREMENT for table `dbparam`
--
ALTER TABLE `dbparam`
MODIFY `dbid` int(50) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
MODIFY `reqid` int(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
ADD CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`desc_id`) REFERENCES `alertdesc` (`desc_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cpurep`
--
ALTER TABLE `cpurep`
ADD CONSTRAINT `cpurep_ibfk_1` FOREIGN KEY (`dbid`) REFERENCES `configureddb` (`dbuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dbparam`
--
ALTER TABLE `dbparam`
ADD CONSTRAINT `dbparam1_fk` FOREIGN KEY (`dbuid`) REFERENCES `configureddb` (`dbuid`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `dbparam_fk` FOREIGN KEY (`userid`) REFERENCES `login_db` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `dbsizerep`
--
ALTER TABLE `dbsizerep`
ADD CONSTRAINT `dbsizerep_ibfk_1` FOREIGN KEY (`dbuid`) REFERENCES `configureddb` (`dbuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `memrep`
--
ALTER TABLE `memrep`
ADD CONSTRAINT `memrep_ibfk_1` FOREIGN KEY (`dbid`) REFERENCES `configureddb` (`dbuid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `uconnrep`
--
ALTER TABLE `uconnrep`
ADD CONSTRAINT `uconnrep_ibfk_1` FOREIGN KEY (`dbuid`) REFERENCES `configureddb` (`dbuid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
