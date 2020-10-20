/* IMPLEMENTED - BEGIN */

/* IMPLEMENTED - END */






/* TESTING - BEGIN */

CREATE TABLE Users (
	user_timestamp 			TIMESTAMP DEFAULT CURRENT_TIMESTAMP, /* creation of user account */
	user_id 			INT NOT NULL AUTO_INCREMENT,
	
	user_salt 			VARCHAR(255) NOT NULL, /* local .JS hash with email salt to send secure over http */
	user_hash 			VARCHAR(255) NOT NULL, /* password, after processing */
	
	user_alias			 VARCHAR(255) NOT NULL UNIQUE,
	user_email 			VARCHAR(255) NOT NULL UNIQUE,
	user_image 			VARCHAR(255) NOT NULL DEFAULT '../users/_default.png',
	
	PRIMARY KEY (user_id)
);

/* TESTING - END */






/* DRAFT - BEGIN */

CREATE TABLE Links (
	link_timestamp 			TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	link_id 			INT NOT NULL AUTO_INCREMENT,
	link_path 			VARCHAR(255) NOT NULL UNIQUE, 			/* try {random hash} catch(collision) {repeat} */
	
	link_owner 			INT NOT NULL,
	
	link_hash 			VARCHAR(255) NOT NULL,
	link_editor 			INT NOT NULL, 					/* on insert, set to owner */
	link_version 			INT NOT NULL,
	
	PRIMARY KEY (link_id),
	FOREIGN KEY (link_last_lock) 	REFERENCES Users(user_id),
	FOREIGN KEY (link_last_lock) 	REFERENCES Users(user_id),
);

CREATE TABLE Files (
	file_timestamp 			TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	file_id 			INT NOT NULL AUTO_INCREMENT,
	file_path 			VARCHAR(255) NOT NULL,
	file_parent_link		INT NOT NULL,
	
	file_title 			VARCHAR(255) NOT NULL DEFAULT '',
	file_privacy 			BYTE NOT NULL, 					/* (0:private 1:protected 2:unlisted 3:public)  */
	file_content 			TEXT NOT NULL, 					/* 64KB of storage for our JSON document object */
	file_hash			VARCHAR(255) NOT NULL,	
	
	PRIMARY KEY (file_id),
	FOREIGN KEY (file_path) 	REFERENCES Links(link_path),
);

CREATE TABLE Permissions (
	permission_timestamp 			TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	permission_id 			INT NOT NULL AUTO_INCREMENT,
	access_user_id INT NOT NULL,
	access_document_id INT NOT NULL,
	
	is_owner BOOL NOT NULL DEFAULT FALSE,

	edit_current BOOL NOT NULL DEFAULT FALSE,
	
	view_actions BOOL NOT NULL DEFAULT FALSE,
	view_archive BOOL NOT NULL DEFAULT FALSE,
	view_current BOOL NOT NULL DEFAULT FALSE,
	
	export_actions BOOL NOT NULL DEFAULT FALSE,
	export_archive BOOL NOT NULL DEFAULT FALSE,
	export_current BOOL NOT NULL DEFAULT FALSE,
	
	change_access BOOL NOT NULL DEFAULT FALSE,
	restore_archive	BOOL NOT NULL DEFAULT FALSE,
	comment_current BOOL NOT NULL DEFAULT FALSE,

	PRIMARY KEY (access_id),
	FOREIGN KEY (access_user_id) REFERENCES Users(user_id),
	FOREIGN KEY (access_document_id) REFERENCES Documents(document_id)
);

/* DRAFT - END */






/* REFERENCE TABLES - NOT USER EDITABLE - BEGIN */

CREATE TABLE Themes (
	theme_id 			INT NOT NULL AUTO_INCREMENT,
	
	theme_title 			VARCHAR(64) NOT NULL,
	theme_font 			VARCHAR(16) NOT NULL DEFAULT 'Arial',
	theme_background 		VARCHAR(16) NOT NULL DEFAULT 'white', 			/* css interpretable color */
	theme_text_color 		VARCHAR(16) NOT NULL DEFAULT 'black',
	theme_note_color		VARCHAR(16) NOT NULL DEFAULT 'grey',
	
	PRIMARY KEY (format_id)
);

INSERT INTO Themes (theme_title, theme_font, theme_background, theme_text_color, theme_note_color) VALUES ('Default', 'arial', 'white', 'black', grey);

/* REFERENCE TABLES - NOT USER EDITABLE - END */






