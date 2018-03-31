create table users (
	UID int,
	userName varchar(50),
	pssword varchar(50),
	dateJoined date,
	isAdmin boolean NOT NULL,
	isBanned boolean NOT NULL,
	billingAddress varchar(100),
    PRIMARY KEY (userName)
    );

create table projectsOwnership (
	projectName varchar(100) NOT NULL,
	projectDescription varchar(1000),
	startDate date NOT NULL,
	endDate date NOT NULL,
	projectID varchar(50),
	ownerName varchar(10)NOT NULL,
	targetAmount int NOT NULL CHECK (targetAmount > 0),
	progress int NOT NULL CHECK (progress >= 0),
	category varchar(20),
	projectStatus varchar(10),
	PRIMARY KEY (projectID, ownerName),
	FOREIGN KEY (ownerName) REFERENCES users(userName));

create table investments (
	amount int NOT NULL CHECK (amount > 0),
	dateInvested date NOT NULL,
	investmentID varchar(100),
	investorName varchar(50) NOT NULL,
	investmentType varchar(50) NOT NULL,
	projectID varchar(50) NOT NULL,
	ownerName varchar(50) NOT NULL,
    CONSTRAINT chk_InvestmentType CHECK (investmentType IN ('eNETS', 'Paypal', 'Credit Card')),
	PRIMARY KEY (investmentID),
	FOREIGN KEY (projectID, ownerName) REFERENCES projectsOwnership(projectID, ownerName)
	on delete cascade,
	FOREIGN KEY (investorName) REFERENCES users(userName)
	on delete cascade);


INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('1', 'Bob', '12345', date '2018-02-01', false, false, 'Blk 1, Yishun St 20, 15-32');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('2', 'Alice', '12345', date '2018-02-02', false, false, 'Blk 2, Ang Mo Kio St 1, 08-23');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('3', 'Charles', '12345', date '2018-02-02', false, true, 'Blk 3, Yio Chu Kang St 2, 1-20');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('4', 'David', '12345', date '2018-02-03', true, false, 'Blk 4, Toa Payoh St 61, 12-23');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('5', 'Elton', '12345', date '2018-02-03', true, false, 'Blk 5, Lim Chu Kang, 5-02');


INSERT INTO projectsOwnership(projectName, projectDescription, startDate, endDate, projectID, ownerName, targetAmount, progress, category, projectStatus)
values ('Seeking funding for startup', 'new start up involved in property technology', date '2018-02-10', date '2018-03-10', 1, 'Bob', 10000, 0, 'Start Ups funding', 'ACTIVE');

INSERT INTO projectsOwnership(projectName, projectDescription, startDate, endDate, projectID, ownerName, targetAmount, progress, category, projectStatus)
values ('Seeking funding for mobile app', 'mobile app called instagram', date '2018-02-15', date '2018-06-15', '1', 'Alice', 50000, 0, 'Mobile App Funding', 'ACTIVE');

INSERT INTO projectsOwnership(projectName, projectDescription, startDate, endDate, projectID, ownerName, targetAmount, progress, category, projectStatus)
values ('Seeking funding for building new hospital', 'TTS hospital', date '2018-02-20', date '2018-07-20', '2', 'Bob', 1000000, 0, 'Others', 'ACTIVE');


INSERT INTO investments(amount, dateInvested, investmentid, investorName, investmentType, projectID, ownerName)
values (500, date '2018-02-23', '2', 'Bob', 'eNETS', '1', 'Alice');

INSERT INTO investments(amount, dateInvested, investmentid, investorName, investmentType, projectID, ownerName)
values (500, date '2018-02-23', '1', 'David', 'Paypal', '1', 'Alice');