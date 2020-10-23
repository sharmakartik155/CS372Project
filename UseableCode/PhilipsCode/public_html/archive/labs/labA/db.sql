CREATE TABLE Users (
	user_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	user_id INT NOT NULL AUTO_INCREMENT,
	user_email VARCHAR(255) NOT NULL UNIQUE,
	user_alias VARCHAR(255) NOT NULL UNIQUE,
	user_birthdate DATE NOT NULL,
	user_password VARCHAR(255) NOT NULL,
	user_img_url VARCHAR(255) NOT NULL DEFAULT '../images/default.png',
	PRIMARY KEY (user_id)
);

CREATE TABLE Questions (
	post_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	post_id INT NOT NULL AUTO_INCREMENT,
	post_user_id INT NOT NULL,
	post_content_head VARCHAR(255) NOT NULL DEFAULT 'Error_001',
	post_content_body VARCHAR(2048) NOT NULL DEFAULT 'Error_001',
	PRIMARY KEY (post_id),
	FOREIGN KEY (post_user_id) REFERENCES Users (user_id)
);

CREATE TABLE Answers (
	reply_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	reply_id INT NOT NULL AUTO_INCREMENT,
	reply_user_id INT NOT NULL,
	reply_post_id INT NOT NULL,
	reply_content_body VARCHAR(2048) NOT NULL DEFAULT 'Error_001',
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
	FOREIGN KEY (vote_reply_id) REFERENCES Answers(reply_id)
);


INSERT INTO Users (user_email, user_alias, user_birthdate, user_password, user_img_url)
VALUES ('john@ottenbreit.com', 'johnottenbreit', '1997-09-03', 'password', '../images/default.png');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password, user_img_url)
VALUES ('philip@ottenbreit.com', 'philipottenbreit', '1999-03-06', 'password', '../images/default.png');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password, user_img_url)
VALUES ('peter@ottenbreit.com', 'peterottenbreit', '2000-12-13', 'password', '../images/default.png');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password, user_img_url)
VALUES ('lucia@ottenbreit.com', 'luciaottenbreit', '2003-05-07', 'password', '../images/default.png');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password, user_img_url)
VALUES ('gemma@ottenbreit.com', 'gemmaottenbreit', '2005-08-08', 'password', '../images/default.png');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password, user_img_url)
VALUES ('aimee@ottenbreit.com', 'aimeeottenbreit', '2007-12-20', 'password', '../images/default.png');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password, user_img_url)
VALUES ('william@ottenbreit.com', 'williamottenbreit', '2009-12-25', 'password', '../images/default.png');
INSERT INTO Users (user_email, user_alias, user_birthdate, user_password, user_img_url)
VALUES ('smottens@ottenbreit.com', 'smottens', '2000-01-01', 'password', '../images/default.png');

INSERT INTO Questions (post_user_id, post_content_head, post_content_body)
VALUES (2, 'Question Title', 'Question Details');

INSERT INTO Answers (reply_user_id, reply_post_id, reply_content_body)
VALUES (3, 2, 'Answer Details');

INSERT INTO Votes (vote_user_id, vote_reply_id, vote_up, vote_dn)
VALUES (3,3,false,true);


SELECT * FROM Questions ORDER BY post_timestamp DESC LIMIT 5;

SELECT *
FROM Users
WHERE user_alias='philipottenbreit' AND user_password='password';

--"GIVEN id_user, RETURN (* Questions FROM id_user AND

--			SELECT
--				- * FROM Questions WHERE id_post_user = id_user
--					- id_post
--					- id_post_user
--					- post_timestamp
--					- post_content_head
--					- post_content_body
--						- * FROM Answers WHERE id_reply_post = id_post
--							- id_reply
--							- id_reply_user
--							- reply_timestamp
--							- reply_content_body
--								- * FROM Votes WHERE id_vote_reply = id_reply
--									- vote_direction

--returns all of a user's questions
SELECT U.user_alias, U.user_img_url, Q.post_id, Q.post_timestamp, Q.post_content_head, Q.post_content_body, A.reply_id, A.reply_timestamp, A.reply_content_body, SUM(V.vote_up) AS up_votes, SUM(V.vote_dn) AS dn_votes
SELECT U.user_alias, U.user_img_url, Q.post_id, Q.post_timestamp, Q.post_content_head, Q.post_content_body
FROM Questions Q
INNER JOIN Users U ON Q.post_user_id = '1'
JOIN Answers A ON A.reply_post_id = Q.post_id
JOIN Votes V ON V.vote_reply_id = A.reply_id;







