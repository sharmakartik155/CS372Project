CREATE TABLE Users (
	user_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	user_id INT NOT NULL AUTO_INCREMENT,
	user_salt VARCHAR(255) NOT NULL,
	user_hash VARCHAR(255) NOT NULL,
	user_alias VARCHAR(255) NOT NULL UNIQUE,
	user_email VARCHAR(255) NOT NULL UNIQUE,
	user_birth DATE NOT NULL,
	user_image VARCHAR(255) NOT NULL DEFAULT '../users/_default.png',
	PRIMARY KEY (user_id)
);

CREATE TABLE Questions (
	post_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	post_id INT NOT NULL AUTO_INCREMENT,
	post_user_id INT NOT NULL,
	post_content_head VARCHAR(256) NOT NULL DEFAULT 'ERROR: IS_EMPTY',
	post_content_body VARCHAR(2048) NOT NULL DEFAULT 'ERROR: IS_EMPTY',
	PRIMARY KEY (post_id),
	FOREIGN KEY (post_user_id) REFERENCES Users (user_id)
);

CREATE TABLE Answers (
	reply_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	reply_id INT NOT NULL AUTO_INCREMENT,
	reply_user_id INT NOT NULL,
	reply_post_id INT NOT NULL,
	reply_content_body VARCHAR(2048) NOT NULL DEFAULT 'ERROR: IS_EMPTY',
	PRIMARY KEY (reply_id),
	FOREIGN KEY (reply_user_id) REFERENCES Users(user_id),
	FOREIGN KEY (reply_post_id) REFERENCES Questions(post_id)
);

CREATE TABLE Votes (
	vote_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	vote_id INT NOT NULL AUTO_INCREMENT,
	vote_user_id INT NOT NULL,
	vote_reply_id INT NOT NULL,
	vote_up bit NOT NULL DEFAULT 0,
	vote_dn bit NOT NULL DEFAULT 0,
	PRIMARY KEY (vote_id),
	FOREIGN KEY (vote_user_id) REFERENCES Users(user_id),
	FOREIGN KEY (vote_reply_id) REFERENCES Answers(reply_id),
	UNIQUE KEY (vote_user_id, vote_reply_id)
);





INSERT INTO Users (user_email, user_alias, user_birthdate, user_password)
VALUES ('shane@ottenbreit.com', 'shaneottenbreit', '1971-04-13', 'password0');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password)
VALUES ('stephanie@ottenbreit.com', 'stephanieottenbreit', '1972-02-18', 'password0');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password)
VALUES ('john@ottenbreit.com', 'johnottenbreit', '1997-09-03', 'password0');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password)
VALUES ('philip@ottenbreit.com', 'philipottenbreit', '1999-03-06', 'password0');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password)
VALUES ('peter@ottenbreit.com', 'peterottenbreit', '2000-12-13', 'password0');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password)
VALUES ('lucia@ottenbreit.com', 'luciaottenbreit', '2003-05-07', 'password0');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password)
VALUES ('gemma@ottenbreit.com', 'gemmaottenbreit', '2005-08-08', 'password0');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password)
VALUES ('aimee@ottenbreit.com', 'aimeeottenbreit', '2007-12-20', 'password0');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password)
VALUES ('william@ottenbreit.com', 'williamottenbreit', '2009-12-25', 'password0');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password)
VALUES ('smottens@ottenbreit.com', 'smottens', '2000-01-01', 'password0');

INSERT INTO Questions (post_user_id, post_content_head, post_content_body)
VALUES (1, 'Why is the sky blue?', 'Also, why are roses red?');

INSERT INTO Answers (reply_user_id, reply_post_id, reply_content_body)
VALUES (1, 1, 'Sometimes life just be like that.');

INSERT INTO Votes (vote_user_id, vote_reply_id, vote_up, vote_dn)
VALUES (1,1,false,true);


SELECT * FROM Questions ORDER BY post_timestamp DESC LIMIT 5;

SELECT *
FROM Users
WHERE user_alias='philipottenbreit' AND user_password='password';






















































