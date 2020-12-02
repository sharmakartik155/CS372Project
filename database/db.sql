CREATE TABLE Users (
	user_created 		TIMESTAMP DEFAULT CURRENT_TIMESTAMP, /* creation of user account */
	user_id 		INT NOT NULL AUTO_INCREMENT,
	
	user_salt 		VARCHAR(255) NOT NULL, /* local .JS hash with email salt to send secure over http */
	user_hash 		VARCHAR(255) NOT NULL, /* password, after processing */
	
	user_alias		VARCHAR(255) NOT NULL UNIQUE,
	user_email 		VARCHAR(255) NOT NULL UNIQUE,
	user_image 		VARCHAR(255) NOT NULL DEFAULT '../users/_default.png',
	
	user_theme		VARCHAR(255) NOT NULL DEFAULT 'background: #121212; color: #EEEEEE;',
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
	doc_content 		TEXT NOT NULL, 				/* 64KB */
	doc_hash		VARCHAR(255) NOT NULL,

	PRIMARY KEY (doc_id),
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


