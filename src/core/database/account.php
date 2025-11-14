<?php
class Account {
	private function __construct(
		public int $id,
		public string $display,
		public DateTimeImmutable $created,
		public DateTimeImmutable $updated,

		public string $email,
		public bool $is_manager,
	) {}

	// NOTE: Hidden method, use `User::account` instead
	public static function _from_user(string $email): ?self {
		$db = Database::get();
		$row = $db->query('SELECT * FROM user WHERE email = ?', [$email])[0];
		$mgr = !empty($db->query('SELECT 1 FROM user_manager WHERE id = ?', [$row['id']]));
		return new self(
			$row['id'],
			$row['display'],
			new DateTimeImmutable($row['created'], new DateTimeZone('UTC')),
			new DateTimeImmutable($row['updated'], new DateTimeZone('UTC')),
			$email,
			$mgr,
		);
	}
}
