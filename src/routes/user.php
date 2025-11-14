<?php
if (!Session::has_user()) { Router::return(); }

$user = Session::user();
$applicant = $user->applicant();

render_page(['profile'], [
	'title' => 'Profile',
	'style' => 'profile',
	'user' => $user,
	'applicant' => $applicant,
]);
