<?php
if (!Session::has_user()) { Router::redirect('user/login'); }
$user = Session::user();
if (is_null($user->applicant())) {
	render_page(['forms/applicant'], [
		'title' => 'Applicant Personal Info',
	]);
	exit;
}

render_page(['apply'], ['title' => 'Application Submission', 'style' => 'apply']);
