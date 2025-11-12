<?php
$dname = null;
$email = null;
$on_post = function() use (&$dname, &$email): array {
	$dname = Request::param('dname');
	$email = Request::param('email');
	$pass1 = Request::param('pass1');
	$pass2 = Request::param('pass2');

	return [];
};
$errors = Request::is_post()? $on_post() : [];

render_page(['forms/signup'], [
	'title' => 'Sign up',
	'dname' => $dname,
	'email' => $email,
]);
