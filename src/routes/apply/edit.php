<?php
if (!Session::has_user()) { Router::redirect('user/login'); }

$errors = [];
if (Request::is_post()) {
	$first_name = ucfirst(Request::param('first-name'));
	$last_name = ucfirst(Request::param('last-name'));
	$dob = DateTimeImmutable::createFromFormat(DATE_FORMAT, Request::param('dob'));
	$gender = Gender::tryFrom(Request::param('gender'));
	$street = Request::param('street');
	$town = Request::param('town');
	$state = State::from_abbr(Request::param('state'));
	$postcode = Request::param('postcode');
	$phone = Request::param('phone');
	$background = parse_bool(Request::param('background'));
	$felony = parse_bool(Request::param('felony'));
	$veteran = parse_bool(Request::param('veteran'));

	if (!Csrf::check()) { $errors[] = 'Invalid CSRF token'; }
	if (strlen($first_name) > 20) { $errors[] = 'First name is too long'; }
	elseif (empty($first_name)) { $errors[] = 'First name must not be empty'; }
	if (!ctype_alpha($first_name)) { $errors[] = 'First name must contain only letters'; }
	if (strlen($last_name) > 20) { $errors[] = 'Last name is too long'; }
	elseif (empty($last_name)) { $errors[] = 'Last name must not be empty'; }
	if (!ctype_alpha($last_name)) { $errors[] = 'Last name must contain only letters'; }
	if ($dob === false) { $errors[] = 'Invalid date of birth'; }
	if (is_null($gender)) { $errors[] = 'Invalid gender option'; }
	if (strlen($street) > 40) { $errors[] = 'Street name is too long'; }
	elseif (empty($street)) { $errors[] = 'Street name must not be empty'; }
	if (!ctype_graph($street)) { $errors[] = 'Street name contains invalid character'; }
	if (strlen($town) > 40) { $errors[] = 'Town name is too long'; }
	elseif (empty($town)) { $errors[] = 'Town name must not be empty'; }
	$pc_valid = strlen($postcode) == 4 && ctype_digit($postcode);
	if (!$pc_valid) { $errors[] = 'Postcode must contain exactly 4 digits'; }
	if (!ctype_graph($town)) { $errors[] = 'Town name contains invalid character'; }
	if (is_null($state)) { $errors[] = 'Invalid Australian state abbreviation'; }
	elseif ($pc_valid && !$state->has_postcode(intval($postcode)))
		{ $errors[] = "Postcode is outside of the selected state's allocated range"; }
	if (strlen($phone) > 12) { $errors[] = 'Phone number is too long'; }
	if (!ctype_digit(str_replace(' ', '', $phone)))
		{ $errors[] = 'Phone number must contain only digits or spaces'; }
	if (is_null($background)) { $errors[] = 'Background check question must be answered'; }
	if (is_null($felony)) { $errors[] = 'Felony question must be answered'; }
	if (is_null($veteran)) { $errors[] = 'Veteran question must be answered'; }
	if (!empty($errors)) { goto end_post; }
}
end_post:

render_page(['forms/applicant'], [
	'title' => 'Applicant Personal Info',
	'style' => 'apply_personal',
	'errors' => $errors,
]);
