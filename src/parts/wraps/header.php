<?php
function render_nav() {
	$cur = Request::path();
	$routes = [
		'' => 'Home',
		'jobs' => 'Listings',
		'apply' => 'Application',
		'about' => 'About',
	];
	foreach ($routes as $path => $disp) {
		$is_cur = ($cur == $path)? ' class="current-page"' : '';
		echo "<li><a href=\"/$path\"$is_cur>$disp</a></li>";
	}
} ?>
<header class="flex">
	<nav id="global-navigation" class="fill flex">
		<ul class="fill flex flex-o">
			<?php render_nav() ?>
			<li class="fill"></li>
		</ul>
	</nav>
</header>
