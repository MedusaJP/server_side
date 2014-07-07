SET SESSION FOREIGN_KEY_CHECKS=0;

DROP INDEX idx_appraiser_id ON feedback;
DROP INDEX idx_evaluatee_id ON feedback;


DROP TABLE feedback;
DROP TABLE talk;
DROP TABLE seat;
DROP TABLE shop;
DROP TABLE tag;
DROP TABLE user;



CREATE TABLE shop
(
	id bigint unsigned NOT NULL,
	name varchar(64) NOT NULL,
	address text NOT NULL,
	lon decimal(9,6) NOT NULL,
	lat decimal(9,6) NOT NULL,
	hot_tag_str varchar(64),
	deleted int(1) DEFAULT 0 NOT NULL,
	created_at datetime DEFAULT NOW() NOT NULL,
	updated_at datetime,
	PRIMARY KEY (id)
);


CREATE TABLE tag
(
	id bigint unsigned NOT NULL AUTO_INCREMENT,
	name varchar(64) NOT NULL,
	deleted int(1) DEFAULT 0 NOT NULL,
	created_at datetime DEFAULT NOW() NOT NULL,
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
	created_at datetime DEFAULT NOW() NOT NULL,
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
	created_at datetime DEFAULT NOW() NOT NULL,
	updated_at datetime,
	PRIMARY KEY (id)
);


CREATE TABLE user
(
	id bigint unsigned NOT NULL AUTO_INCREMENT,
	mailaddress varchar(50) NOT NULL UNIQUE,
	salt char(20) NOT NULL,
	password char(64) NOT NULL,
	locked int(1) DEFAULT 0 NOT NULL,
	twitter_id varchar(50),
	hot_tag_str varchar(64),
	deleted int(1) DEFAULT 0 NOT NULL,
	created_at datetime DEFAULT NOW() NOT NULL,
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
	created_at datetime DEFAULT NOW() NOT NULL,
	updated_at datetime,
	PRIMARY KEY (id)
);

CREATE INDEX idx_appraiser_id USING BTREE ON feedback (appraiser_id ASC);
CREATE INDEX idx_evaluatee_id USING BTREE ON feedback (evaluatee_id ASC);



