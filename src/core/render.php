<?php
function render(string $component) {
	global $opts;
	require COMPONENTS_DIR . "/$component.php";
}

function render_page(array|callable|string $content, array $g_opts = []) {
	global $opts; $opts = $g_opts;

	render('wraps/top');
	if (is_string($content)) { echo "$content"; }
	elseif (is_array($content)) { foreach ($content as $c) { render($c); }}
	else { $content(); }
	render('wraps/bottom');
}
