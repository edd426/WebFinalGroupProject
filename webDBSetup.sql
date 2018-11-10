



CREATE TABLE IF NOT EXISTS `room` (
    `RoomID` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `Name` tinytext NOT NULL,
    `Occupancy` int NOT NULL
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


INSERT INTO `room` (`Name`, `Occupancy`) VALUES
	('RoomA', 25),
	('RoomB', 50),
	('RoomC', 75),
	('RoomD', 100);

INSERT INTO `user` (`Email`, `Password`) VALUES
	('JohnDeere@tractor.com', 'iluvtractors'),
	('JohnSmith@address.com', 'johnsmith');
        

INSERT INTO `reservation` (`RoomID`, `UserID`, `StartTime`, `EndTime`, `ResDate`) VALUES
	('1', '1', '0', '15', '2018-12-01'),
	('2', '2', '0', '15', '2018-11-01');


INSERT INTO `feature` (`FName`) VALUES
	('Oxygen'),
	('Butler'),
	('Fireplace'),
	('X-men Poster'),
	('Whiteboard');

INSERT INTO `room_feature` (`RoomID`, `FeatureID`) VALUES
	('1', '1'),
	('2', '1'),
	('3', '1'),
	('4', '5'),
	('3', '5'),
	('2', '5');

INSERT INTO `admin` (`UserID`) VALUES
	('1'),
	('2');
