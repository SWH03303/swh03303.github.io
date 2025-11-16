-- Lock based on email address regardless of whether the email is associated with an account or not.
CREATE TABLE user_lock (
	email TEXT PRIMARY KEY,
	total INTEGER NOT NULL
		DEFAULT 1,
	last DATETIME NOT NULL
		DEFAULT current_timestamp
) WITHOUT ROWID;
