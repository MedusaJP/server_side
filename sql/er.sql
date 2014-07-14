SET SESSION FOREIGN_KEY_CHECKS=0;

/* Drop Indexes */

DROP INDEX idx_appraiser_id ON feedback;
DROP INDEX idx_evaluatee_id ON feedback;



/* Drop Tables */

DROP TABLE tag;
DROP TABLE seat;
DROP TABLE feedback;
DROP TABLE talk;
DROP TABLE user;
DROP TABLE shop;




/* Create Tables */

CREATE TABLE tag
(
	id bigint unsigned NOT NULL AUTO_INCREMENT,
	name varchar(64) NOT NULL,
	deleted int(1) DEFAULT 0 NOT NULL,
	created_at datetime NOT NULL,
	PRIMARY KEY (id)
);


CREATE TABLE seat
(
	id bigint unsigned NOT NULL AUTO_INCREMENT,
	shop_id bigint unsigned NOT NULL,
	lon decimal(9,6) NOT NULL,
	lat decimal(9,6) NOT NULL,
	promoter_id bigint unsigned NOT NULL,
	applicant_id bigint unsigned NOT NULL,
	image_name varchar(64),
	freetext varchar(256) NOT NULL,
	status int(1) DEFAULT 0 NOT NULL,
	endtime datetime NOT NULL,
	deleted int(1) DEFAULT 0 NOT NULL,
	created_at datetime NOT NULL,
	updated_at datetime,
	PRIMARY KEY (id)
);


CREATE TABLE feedback
(
	id bigint unsigned NOT NULL AUTO_INCREMENT,
	talk_id bigint unsigned NOT NULL,
	appraiser_id bigint unsigned NOT NULL,
	stat int(1) unsigned,
	tag_str varchar(64) NOT NULL,
	evaluatee_id bigint unsigned NOT NULL,
	deleted int(1) NOT NULL,
	created_at datetime NOT NULL,
	updated_at datetime,
	PRIMARY KEY (id)
);


CREATE TABLE user
(
	id bigint unsigned NOT NULL AUTO_INCREMENT,
	name varchar(64) NOT NULL,
	device_id varchar(32),
	apply_status int(1) DEFAULT 0 NOT NULL,
	mailaddress varchar(50) NOT NULL UNIQUE,
	salt char(20) NOT NULL,
	password char(64) NOT NULL,
	img_name varchar(64) DEFAULT 'default.jpg' NOT NULL,
	img_type varchar(32) DEFAULT 'jpeg' NOT NULL,
	locked int(1) DEFAULT 0 NOT NULL,
	twitter_id varchar(50),
	hot_tag_str varchar(64),
	deleted int(1) DEFAULT 0 NOT NULL,
	created_at datetime NOT NULL,
	updated_at datetime,
	PRIMARY KEY (id)
);


CREATE TABLE talk
(
	id bigint unsigned NOT NULL AUTO_INCREMENT,
	shop_id bigint unsigned NOT NULL,
	lon decimal(9,6) NOT NULL,
	lat decimal(9,6),
	promoter_id bigint unsigned NOT NULL,
	applicant_id bigint unsigned NOT NULL,
	freetext varchar(256) NOT NULL,
	image_name varchar(64),
	status int(1) DEFAULT 0 NOT NULL,
	endtime datetime NOT NULL,
	deleted int(1) DEFAULT 0 NOT NULL,
	created_at datetime NOT NULL,
	updated_at datetime,
	PRIMARY KEY (id)
);


CREATE TABLE shop
(
	id bigint unsigned NOT NULL AUTO_INCREMENT,
	name varchar(64) NOT NULL,
	address text NOT NULL,
	lon decimal(9,6) NOT NULL,
	lat decimal(9,6) NOT NULL,
	hot_tag_str varchar(64),
	deleted int(1) DEFAULT 0 NOT NULL,
	created_at datetime NOT NULL,
	updated_at datetime,
	PRIMARY KEY (id)
);



/* Create Foreign Keys */

ALTER TABLE seat
	ADD FOREIGN KEY (promoter_id)
	REFERENCES user (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE talk
	ADD FOREIGN KEY (promoter_id)
	REFERENCES user (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE feedback
	ADD FOREIGN KEY (evaluatee_id)
	REFERENCES user (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE seat
	ADD FOREIGN KEY (applicant_id)
	REFERENCES user (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE talk
	ADD FOREIGN KEY (applicant_id)
	REFERENCES user (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE feedback
	ADD FOREIGN KEY (appraiser_id)
	REFERENCES user (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE feedback
	ADD FOREIGN KEY (talk_id)
	REFERENCES talk (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE talk
	ADD FOREIGN KEY (shop_id)
	REFERENCES shop (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;


ALTER TABLE seat
	ADD FOREIGN KEY (shop_id)
	REFERENCES shop (id)
	ON UPDATE RESTRICT
	ON DELETE RESTRICT
;



/* Create Indexes */

CREATE INDEX idx_appraiser_id USING BTREE ON feedback (appraiser_id ASC);
CREATE INDEX idx_evaluatee_id USING BTREE ON feedback (evaluatee_id ASC);



