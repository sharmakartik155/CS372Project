CREATE TABLE Users (
	user_created 		TIMESTAMP DEFAULT CURRENT_TIMESTAMP, /* creation of user account */
	user_id 		INT NOT NULL AUTO_INCREMENT,
	
	user_salt 		VARCHAR(255) NOT NULL, /* local .JS hash with email salt to send secure over http */
	user_hash 		VARCHAR(255) NOT NULL, /* password, after processing */
	
	user_alias		VARCHAR(255) NOT NULL UNIQUE,
	user_email 		VARCHAR(255) NOT NULL UNIQUE,
	user_image 		VARCHAR(255) NOT NULL DEFAULT '../users/_default.png',
	
	user_theme		INT NOT NULL DEFAULT 0,
	user_font_size		INT NOT NULL DEFAULT 11,
	
	PRIMARY KEY (user_id)
);

CREATE TABLE Docs (
	doc_created 		TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	doc_id 			INT NOT NULL AUTO_INCREMENT,
	
	doc_path 		VARCHAR(255) NOT NULL UNIQUE,		/* try {random hash} catch(collision) {repeat} */
	doc_creator		INT NOT NULL,
	
	doc_editor		INT,
	doc_requestor		INT,

	doc_title 		VARCHAR(255) NOT NULL DEFAULT 'My Doc',
	doc__content 		TEXT NOT NULL, 				/* 64KB */
	doc__hash		VARCHAR(255) NOT NULL,

	PRIMARY KEY (doc__id),
	FOREIGN KEY (doc_creator) REFERENCES Users(user_id),
	FOREIGN KEY (doc_editor) REFERENCES Users(user_id),
	FOREIGN KEY (doc_requestor) REFERENCES Users(user_id)
);

CREATE TABLE Access (
	access_added 		TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	access_id		INT NOT NULL AUTO_INCREMENT,
	
	access_doc		INT NOT NULL,
	access_user		INT NOT NULL,
	
	PRIMARY KEY (access_id),
	FOREIGN KEY (access_doc) REFERENCES Docs(doc_id),
	FOREIGN KEY (access_user) REFERENCES Users(user_id)
);



CREATE TABLE Themes (
	theme_id 	INT NOT NULL AUTO_INCREMENT,
	name 		VARCHAR(64) NOT NULL,
	font 		VARCHAR(16) NOT NULL DEFAULT 'Arial',
	bkgd 		VARCHAR(16) NOT NULL DEFAULT 'white', 			/* css interpretable color */
	color 		VARCHAR(16) NOT NULL DEFAULT 'black',

	PRIMARY KEY (theme_id)
);

INSERT INTO Themes (bkgd, color, name, font) VALUES ('#FFFFFF', '#000000', 'norm', 'Times New Roman');
INSERT INTO Themes (bkgd, color, name, font) VALUES ('#121212', '#EEEEEE', 'dark', 'Times New Roman');
INSERT INTO Themes (bkgd, color, name, font) VALUES ('#242424', '#EEEEEE', 'dusk', 'Times New Roman');
INSERT INTO Themes (bkgd, color, name, font) VALUES ('#36342b', '#c76312', 'rustic', 'Times New Roman');
INSERT INTO Themes (bkgd, color, name, font) VALUES ('#143D59', '#F4B41A', 'heaven', 'Times New Roman');
INSERT INTO Themes (bkgd, color, name, font) VALUES ('#293250', '#6DD47E', 'oceans', 'Times New Roman');







