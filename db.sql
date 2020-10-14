/* untested, work-in-progress */

CREATE TABLE Users (
	user_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	user_id INT NOT NULL AUTO_INCREMENT,
	user_salt VARCHAR(255) NOT NULL,
	user_hash VARCHAR(255) NOT NULL,
	user_alias VARCHAR(255) NOT NULL UNIQUE,
	user_email VARCHAR(255) NOT NULL UNIQUE,
	user_image VARCHAR(255) NOT NULL DEFAULT '../users/_default.png',
	PRIMARY KEY (user_id)
);

CREATE TABLE Documents (
	document_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	document_id INT NOT NULL AUTO_INCREMENT,
	document_urlhash VARCHAR(255) NOT NULL UNIQUE,
	document_version INT NOT NULL DEFAULT 0,
	document_options VARCHAR(255) NOT NULL DEFAULT 'ERROR: DOCUMENT_OPTIONS_EMPTY',
	document_content TEXT NOT NULL,
	PRIMARY KEY (document_id)
);

CREATE TABLE Archives (
	archive_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	archive_id INT NOT NULL AUTO_INCREMENT,
	old_document_timestamp TIMESTAMP NOT NULL,
	old_document_id INT NOT NULL,
	old_document_urlhash VARCHAR(255) NOT NULL,
	old_document_version INT NOT NULL,
	old_document_options VARCHAR(255) NOT NULL,
	old_document_content TEXT NOT NULL,
	PRIMARY KEY (archive_id),
	FOREIGN_KEY (old_document_id) REFERENCES Documents(document_id)
);

CREATE TABLE Access (
	access_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	access_id INT NOT NULL AUTO_INCREMENT,
	access_user_id INT NOT NULL,
	access_document_id INT NOT NULL,
	access_options VARCHAR(255) NOT NULL DEFAULT 'ERROR: ACCESS_OPTIONS_EMPTY',
	PRIMARY KEY (access_id),
	FOREIGN KEY (access_user_id) REFERENCES Users(user_id),
	FOREIGN KEY (access_document_id) REFERENCES Documents(document_id)
);

/*
	not useful, but I need to create prototype INSERT / UPDATE statements as part of this work
	INSERT INTO Users (user_email, user_alias, user_birthdate, user_password)
	VALUES ('pkottenbreit@gmail.com', 'pkottenbreit', '2000-01-01', '01234567');
*/
