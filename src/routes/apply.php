<?php
Session::require_user();
if (is_null(Session::user()->applicant())) { Router::redirect('apply/edit'); }

$job_id = Request::param('id');
if (is_null($job_id)) { Router::redirect('jobs?msg=choose_first'); }

$errors = [];
if (Request::is_post()) {
}
end_post:

render_page(function() use ($errors) {
	$info = Session::user()?->applicant();

	echo <<<'TEXT'
	<section id="application-header" class="flex-y flex-o">
		<h1>Application Submission</h1>
		<p>To apply for a job, please fill the following form.<p>
	</section>
	TEXT;
	render('errors', $errors);
	echo '<form id="application-form" class="flex-y box" action="formtest.php" method="post" enctype="multipart/form-data">';

	$start_date_msg = 'When are you available to start in case you are selected for employment?';

	render('input', 'Desired Salary');
	render('input', $start_date_msg, 'start-date', type: 'date', vertical: true);
	render('input/radio', 'Time', options: [
		'full' => 'Full-time',
		'part' => 'Part-time',
		'temp' => 'Temporary',
	]);
	render('input', 'Additional supporting documents (resume, certificates, e.t.c.)', 'documents',
		type: 'file',
		vertical: true,
	);
	render('input/submit');

	echo '</form>';
},
	title: 'Application Submission',
	style: 'apply',
);
