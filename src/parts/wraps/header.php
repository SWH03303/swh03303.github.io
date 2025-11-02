<?php function render_nav() {
	$cur = Request::path();
	$routes = [
		'' => 'Home',
		'jobs' => 'Listings',
		'apply' => 'Application',
		'about' => 'About',
	];
	foreach ($routes as $path => $disp) {
		$is_cur = ($cur == $path)? ' class="current-page"' : '';
		echo "<a href=\"/$path\"$is_cur>$disp</a>";
	}
} ?>
<header class="flex">
	<nav id="global-navigation" class="fill flex"><?php render_nav() ?></nav>
	<a href="mailto:info@duoordxe.com.au">Contact Us</a>
</header>
