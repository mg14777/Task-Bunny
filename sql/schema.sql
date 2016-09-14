CREATE TABLE IF NOT EXISTS client (
	id SERIAL PRIMARY KEY,
	email VARCHAR(256) NOT NULL UNIQUE,
	password VARCHAR(256) NOT NULL
);

CREATE TABLE IF NOT EXISTS privilege (
	client_id INT REFERENCES client(id) ON DELETE CASCADE,
	level VARCHAR(5) CHECK(level = 'user' OR level = 'admin'),
	PRIMARY KEY (client_id)
);

CREATE TABLE IF NOT EXISTS task_category (
	id SERIAL PRIMARY KEY,
	title VARCHAR(64),
	description VARCHAR (256)
);

CREATE TABLE IF NOT EXISTS task (
	id SERIAL PRIMARY KEY,
	creator INT REFERENCES client(id) ON DELETE CASCADE,
	category INT REFERENCES task_category(id) ON DELETE CASCADE,
	start_time DATE,
	end_time DATE,
	location VARCHAR(256),
	description VARCHAR(256),
	CHECK(end_time >= start_time)
);

CREATE TABLE IF NOT EXISTS tasker (
	helper INT REFERENCES client(id) ON DELETE CASCADE,
	task_id INT REFERENCES task(id) ON DELETE CASCADE,
	PRIMARY KEY (helper, task_id)
);