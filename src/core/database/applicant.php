<?php
enum Gender: string {
	case Male = 'm';
	case Female = 'f';
	case Other = '?';
}

class Applicant {
	private function __construct(
		public string $first_name,
		public string $last_name,
		public DateTimeImmutable $dob,
		public Gender $gender,
		public bool $can_check_background,
		public bool $is_convict,
		public bool $is_veteran,
		public string $street,
		public string $town,
		public string $state,
		public string $postcode,
		public string $phone,
	) {}

	public static function from_user(User $user): ?self {
		$db = Database::get();
		$rows = $db->query('SELECT * FROM user_applicant WHERE id = ?', [$user->id()]);
		if (is_null($rows) || empty($rows)) { return null; }
		$row = $rows[0];
		$dob = DateTimeImmutable::createFromFormat('Y-m-d', $row['dob']);
		return new self(
			$row['first_name'],
			$row['last_name'],
			$dob,
			Gender::from($row['gender']),
			$row['can_check_background'],
			$row['is_convict'],
			$row['is_veteran'],
			$row['street'],
			$row['town'],
			$row['state'],
			$row['postcode'],
			$row['phone'],
		);
	}
}
