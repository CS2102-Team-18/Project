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
	FOREIGN KEY (ownerName) REFERENCES users(userName)
	on update cascade);

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
	on delete cascade
	on update cascade,
	FOREIGN KEY (investorName) REFERENCES users(userName)
	on delete cascade
	on update cascade);


INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('1', 'Bob', '12345678', date '2018-02-01', false, false, 'Blk 1, Yishun St 20, 15-32');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('2', 'Alice', '12345678', date '2018-02-02', false, false, 'Blk 2, Ang Mo Kio St 1, 08-23');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('3', 'Charles', '12345678', date '2018-02-02', false, true, 'Blk 3, Yio Chu Kang St 2, 1-20');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('4', 'David', '12345678', date '2018-02-03', false, false, 'Blk 4, Toa Payoh St 61, 12-23');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('6', 'Fred', '12345678', date '2018-02-03', false, false, 'Blk 15, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('7', 'Greg', '12345678', date '2018-02-03', false, false, 'Blk 25, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('8', 'Hillary', '12345678', date '2018-02-03', false, false, 'Blk 35, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('9', 'Ian', '12345678', date '2018-02-03', false, false, 'Blk 45, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('10', 'John', '12345678', date '2018-02-03', false, false, 'Blk 55, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('11', 'Konghee', '12345678', date '2018-02-03', false, false, 'Blk 65, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('12', 'lauren', '12345678', date '2018-02-03', false, false, 'Blk 75, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('13', 'max', '12345678', date '2018-02-03', false, false, 'Blk 85, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('14', 'Noel', '12345678', date '2018-02-03', false, false, 'Blk 95, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('15', 'Opasd', '12345678', date '2018-02-03', false, false, 'Blk 15, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('16', 'Prince', '12345678', date '2018-02-03', false, false, 'Blk 25, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('17', 'Queen', '12345678', date '2018-02-03', false, false, 'Blk 35, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('18', 'Rabak', '12345678', date '2018-02-03', false, false, 'Blk 45, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('19', 'Steven', '12345678', date '2018-02-03', false, false, 'Blk 55, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('20', 'Ted', '12345678', date '2018-02-03', false, false, 'Blk 65, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('21', 'Umbridge', '12345678', date '2018-02-03', false, false, 'Blk 75, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('22', 'Violin', '12345678', date '2018-02-03', false, false, 'Blk 85, Lim Chu Kang, 5-02');

INSERT INTO users(UID, userName, pssword, dateJoined, isAdmin, isBanned, billingAddress)
values ('23', 'wilson', '12345678', date '2018-02-03', false, false, 'Blk 95, Lim Chu Kang, 5-02');



INSERT INTO projectsOwnership(projectName, projectDescription, startDate, endDate, projectID, ownerName, targetAmount, progress, category, projectStatus)
values ('Seeking funding for startup', 'new start up involved in property technology', date '2018-02-10', date '2018-03-10', 1, 'Bob', 10000, 0, 'Start Ups funding', 'ACTIVE');

INSERT INTO projectsOwnership(projectName, projectDescription, startDate, endDate, projectID, ownerName, targetAmount, progress, category, projectStatus)
values ('Seeking funding for mobile app', 'mobile app called instagram', date '2018-02-15', date '2018-06-15', '1', 'Alice', 50000, 1000, 'Mobile App Funding', 'ACTIVE');

INSERT INTO projectsOwnership(projectName, projectDescription, startDate, endDate, projectID, ownerName, targetAmount, progress, category, projectStatus)
values ('Seeking funding for building new hospital', 'TTS hospital', date '2018-02-20', date '2018-07-20', '2', 'Bob', 1000000, 0, 'Others', 'ACTIVE');

INSERT INTO projectsOwnership(projectName, projectDescription, startDate, endDate, projectID, ownerName, targetAmount, progress, category, projectStatus)
values ('Building a new software app', 'Need some funding to rent a server', date '2018-02-20', date '2018-07-20', '1', 'Ted', 1000, 0, 'Mobile App Funding', 'ACTIVE');

INSERT INTO projectsOwnership(projectName, projectDescription, startDate, endDate, projectID, ownerName, targetAmount, progress, category, projectStatus)
values ('New robot funding', 'I need funds to build a robot', date '2018-02-21', date '2018-07-20', '2', 'Ted', 1000000, 0, 'Others', 'ACTIVE');

INSERT INTO projectsOwnership(projectName, projectDescription, startDate, endDate, projectID, ownerName, targetAmount, progress, category, projectStatus)
values ('New game idea', 'Need funding for this new game called AAA', date '2018-04-02', date '2018-10-20', '2', 'Alice', 1000000, 0, 'Mobile App Funding', 'ACTIVE');

INSERT INTO projectsOwnership(projectName, projectDescription, startDate, endDate, projectID, ownerName, targetAmount, progress, category, projectStatus)
values ('Fund my world tour please', 'I hope to travel the world by walking', date '2018-03-25', date '2018-07-20', '1', 'David', 5000, 0, 'Others', 'ACTIVE');

INSERT INTO projectsOwnership(projectName, projectDescription, startDate, endDate, projectID, ownerName, targetAmount, progress, category, projectStatus)
values ('Creating a band', 'Need some funding for band instruments', date '2018-01-24', date '2018-07-20', '2', 'David', 1000, 0, 'Others', 'ACTIVE');

INSERT INTO projectsOwnership(projectName, projectDescription, startDate, endDate, projectID, ownerName, targetAmount, progress, category, projectStatus)
values ('Food delivery startup', 'fund my food delivery start up', date '2018-02-23', date '2018-07-20', '3', 'David', 1000000, 0, 'Others', 'ACTIVE');

INSERT INTO projectsOwnership(projectName, projectDescription, startDate, endDate, projectID, ownerName, targetAmount, progress, category, projectStatus)
values ('handicraft project funding', 'Appreciate it if you could fund this small project', date '2018-02-20', date '2018-05-20', '3', 'Alice', 200, 0, 'Others', 'ACTIVE');


INSERT INTO investments(amount, dateInvested, investmentid, investorName, investmentType, projectID, ownerName)
values (500, date '2018-02-23', '2', 'Bob', 'eNETS', '1', 'Alice');

INSERT INTO investments(amount, dateInvested, investmentid, investorName, investmentType, projectID, ownerName)
values (500, date '2018-02-23', '1', 'David', 'Paypal', '1', 'Alice');


