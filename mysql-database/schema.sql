CREATE TABLE IF NOT EXISTS mail_storage (
	user_uid VARCHAR(50) NOT NULL,
	domain VARCHAR(15) NOT NULL,
	path VARCHAR(100) NOT NULL,
	
	PRIMARY KEY(user_uid)
	) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS calendars (
	cal_cod INT UNSIGNED NOT NULL AUTO_INCREMENT,
        owner VARCHAR(50) NOT NULL,
        public_name VARCHAR(150) NOT NULL,
        private_name VARCHAR(150) NOT NULL,
        date INT NOT NULL,
	
	UNIQUE(owner,private_name),
        PRIMARY KEY(cal_cod)
	) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS jobs (
	job_cod INT UNSIGNED NOT NULL AUTO_INCREMENT,
        date INT NOT NULL,
        backup_date INT NOT NULL,
	type ENUM ('cal','mail') NOT NULL,
	status VARCHAR(20) NOT NULL,
        orderby VARCHAR(50) NOT NULL,
        owner VARCHAR(50) NOT NULL,
	domain VARCHAR(50) NOT NULL,
        source VARCHAR(250) NOT NULL,
        name VARCHAR(250) NOT NULL,
	ip varchar(16) DEFAULT '0' NOT NULL,
	info VARCHAR(255) NULL,

	PRIMARY KEY(job_cod)
	) ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS `ci_sessions` (
	session_id varchar(40) DEFAULT '0' NOT NULL,
	session_start int(10) unsigned DEFAULT 0 NOT NULL,
	session_last_activity int(10) unsigned DEFAULT 0 NOT NULL,
	session_ip_address varchar(16) DEFAULT '0' NOT NULL,
	session_user_agent varchar(50) NOT NULL,
	session_data text default '' NOT NULL,
	
	PRIMARY KEY (session_id)
	);
