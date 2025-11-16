<?php
class JobCategory {
	private function __construct(
		public int $id,
		public string $name,
	) {}

	public static function all(): array {
		$db = Database::get();
		foreach ($db->query('SELECT * FROM job_category') as $row) {
			$categories[] = new self($row['id'], $row['name']);
		}
		return $categories ?? [];
	}

	public function section_id(): string {
		return "category-" . strtolower(str_replace(' ', '-', $this->name));
	}
}

class JobSalary {
	public function construct(public int $min, public int $max, public string $currency) {}
}

class Job {
	private function __construct(
		public string $id,
		public JobCategory $category,
		public string $company,
		public string $superior,
		public string $name,
		public string $location,
		public JobSalary $salary,
		public string $description,
		public Range $experience,
		public DateTimeImmutable $created,
		public DateTimeImmutable $updated,
	) {}
}
