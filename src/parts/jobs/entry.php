<article class="flex-y flex-o box">
	<div class="flex-y listing-front">
		<h2><?= html_sanitize($data['name']) ?></h2>
		<p class="job-location"><?= $data['location'] ?></p>
		<p class="job-salary">
			<?= $data['salary_min'] ?>
			~
			<?= $data['salary_max'] ?>
			<?= $data['salary_currency'] ?>
			/ year
		</p>
	</div>
	<details class="flex-y employment-details">
		<summary></summary><hr>
		<p class="job-ident"><?= $data['id'] ?></p>
		<p class="job-company"><?= html_sanitize($data['company']) ?></p>
		<p class="job-superior"><?= html_sanitize($data['superior']) ?></p>
		<p class="job-description flex-y"><?= html_sanitize($data['description']) ?></p>
		<div class="job-essentials"></div>
		<ul>
			<li class="job-langs"><?= html_sanitize($data['requirements']['langs']) ?>.</li>
			<li class="job-frameworks"><?= html_sanitize($data['requirements']['tools']) ?>.</li>
			<li class="job-experience"><?= $data['exp_min'] ?> ~ <?= $data['exp_max'] ?> years.</li>
		</ul>
		<div class="job-preferences"></div>
		<ul>
			<?php
			foreach ($data['requirements']['opts'] as $opt) {
				$pref = html_sanitize($opt);
				echo "<li>$pref.</li>";
			}
			?>
		</ul>
		<a class="job-apply-btn" href="/apply.html"></a>
	</details>
</article>
