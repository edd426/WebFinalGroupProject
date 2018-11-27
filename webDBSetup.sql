
CREATE DATABASE meeting;

USE meeting;

CREATE TABLE IF NOT EXISTS `room` (
    `RoomID` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Name` tinytext NOT NULL,
    `Occupancy` int NOT NULL,
    `Deleted` bool NOT NULL DEFAULT FALSE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `user` (
    `UserID` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Email` varchar(255) NOT NULL UNIQUE,
    `Password` tinytext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `admin` (
    `AdminID` int NOT NULL AUTO_INCREMENT,
    `UserID` int NOT NULL,
    FOREIGN KEY (UserID) REFERENCES user(UserID),
    PRIMARY KEY (AdminID, UserID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `feature` (
    `FeatureID` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `FName` varchar(255) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `room_feature` (
    `RoomID` int NOT NULL,
    `FeatureID` int NOT NULL,
    FOREIGN KEY (RoomID) REFERENCES room(RoomID),
    FOREIGN KEY (FeatureID) REFERENCES feature(FeatureID),
    PRIMARY KEY (RoomID, FeatureID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `reservation` (
    `ResID` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `RoomID` int NOT NULL,
    `UserID` int NOT NULL,
    `StartTime` tinyint NOT NULL,
    `EndTime` tinyint NOT NULL,
    `ResDate` date NOT NULL,
    FOREIGN KEY (RoomID) REFERENCES room(RoomID),
    FOREIGN KEY (UserID) REFERENCES user(UserID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `favorite` (
    `UserID` int NOT NULL,
    `RoomID` int NOT NULL,
    PRIMARY KEY (UserID, RoomID),
    FOREIGN KEY (RoomID) REFERENCES room(RoomID),
    FOREIGN KEY (UserID) REFERENCES user(UserID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `room` (`Name`, `Occupancy`) VALUES
	('RoomA', 30),
	('RoomB', 10),
	('RoomC', 15),
	('RoomD', 20),
	('RoomE', 21),
	('RoomF', 9),
	('RoomG', 15),
	('RoomH', 16),
	('RoomI', 13),
	('RoomJ', 12);

INSERT INTO `room` (`Name`, `Occupancy`, `Deleted`) VALUES
	('Chamber of Secrets', 1, TRUE);

INSERT INTO `user` (`Email`, `Password`) VALUES
	('JohnDeere@tractor.com', '$2y$10$uk3TPK7OLNsJ4tOOa6zrzu8WvE1AxajSvUoDirQle/u30HPgjQaGO'),
	('JohnSmith@address.com', '$2y$10$uk3TPK7OLNsJ4tOOa6zrzu8WvE1AxajSvUoDirQle/u30HPgjQaGO');
        

INSERT INTO `reservation` (`RoomID`, `UserID`, `StartTime`, `EndTime`, `ResDate`) VALUES
	('1', '1', '0', '15', '2018-12-01'),
	('2', '2', '0', '15', '2018-11-01'),
	('1', '2', '0', '15', '2017-11-01'),
	('2', '2', '0', '15', '2016-11-01'),
	('11', '2', '0', '15', '2016-11-01');


INSERT INTO `feature` (`FName`) VALUES
	('Conference Table'),
	('TV Screen'),
	('Hanging Lights'),
	('Natural Light'),
	('Whiteboard');

INSERT INTO `room_feature` (`RoomID`, `FeatureID`) VALUES
	('1', '1'),
	('1', '5'),
	('2', '1'),
	('2', '2'),
	('3', '2'),
	('3', '3'),
	('3', '4'),
	('4', '1'),
	('4', '2'),
	('4', '3'),
	('4', '4');

INSERT INTO `admin` (`UserID`) VALUES
	('1'),
	('2');


INSERT INTO `favorite` (`UserID`, `RoomID`) VALUES
	('1', '1'),
	('2', '1'),
	('2', '2');
