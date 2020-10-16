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
	document_user_lock INT DEFAULT null,
	document_format INT NOT NULL DEFAULT 0,

	document_version INT NOT NULL DEFAULT 0,

	document_title VARCHAR(255) NOT NULL DEFAULT '',
	document_access byte NOT NULL DEFAULT 0, /* (0:private 1:protected 2:unlisted 3:public)  */
	document_content TEXT NOT NULL, /* 64KB of storage for our JSON document object */
	/* document_options VARCHAR(255) NOT NULL, */ /* I dislike the 'options' approach. Better to make explicit if needed. */

	PRIMARY KEY (document_urlhash),
	FOREIGN KEY (document_user_lock) REFERENCES Users(user_id),
	FOREIGN KEY (document_format) REFERENCES Formats(format_id)
);

CREATE TABLE Formats (
	format_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	format_id INT NOT NULL AUTO_INCREMENT,
	
	format_title VARCHAR(255) NOT NULL,
	format_fontfamily VARCHAR(255) NOT NULL DEFAULT 'Arial',
	format_fontsize INT NOT NULL DEFAULT 11, /* at first, no support for decimal/float font sizes */
	format_background VARCHAR(255) NOT NULL DEFAULT 'linen', /* preliminary plan is to store as CSS interpretable value, either #000000 or color */
	format_textcolour VARCHAR(255) NOT NULL DEFAULT 'black',
	
	PRIMARY KEY (format_id)
);

INSERT INTO Formats (format_title, format_fontfamily, format_fontsize, format_background, format_textcolour)
VALUES ('Default', 'Arial', 11, 'linen', 'black'); /* initialize the default values, verbose to provide template for future additions */

CREATE TABLE Archives (
	archive_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	archive_id INT NOT NULL AUTO_INCREMENT,
	
	/* NEEDS TO BE UPDATED TO REFLECT NEW DOCUMENT CHANGES, and change to URL_HASH unique primary key*/
	
	old_document_timestamp TIMESTAMP NOT NULL,
	old_document_urlhash VARCHAR(255) NOT NULL,
	old_document_version INT NOT NULL,
	old_document_options VARCHAR(255) NOT NULL,
	old_document_content TEXT NOT NULL,
	
	PRIMARY KEY (archive_id),
	FOREIGN KEY (old_document_urlhash) REFERENCES Documents(document_urlhash)
);

CREATE TABLE Access (
	access_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	access_id INT NOT NULL AUTO_INCREMENT,
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

CREATE TABLE Actions (
	action_timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	action_id INT NOT NULL AUTO_INCREMENT,
	action_user_id INT NOT NULL,
	action_document_id INT NOT NULL,
	
	action_type byte NOT NULL DEFAULT 0, /* (0:create 1:delete 2:rename 3:soft_edit 4: hard_edit 5:restore 6:lock 7:unlock)  */
	
	action_information_1 VARCHAR(255) NOT NULL DEFAULT '', /* varies based on action... rename:old_title ; hard_edit:archive_id ; restore:from_version */
	action_information_2 VARCHAR(255) NOT NULL DEFAULT '', /* varies based on action... rename:new_title ; hard_edit:current_id ; restore:to_version */
	
	PRIMARY KEY (action_id),
	FOREIGN KEY (action_user_id) REFERENCES Users(user_id),
	FOREIGN KEY (action_document_id) REFERENCES Documents(document_id)
)
