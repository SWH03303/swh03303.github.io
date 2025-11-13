<?php
function render(string $component, ?array $data = null) {
	global $_g_data;
	if (is_null($data)) { $data = $_g_data; }
	require Dirs::COMPONENTS . "/$component.php";
}

function render_page(array|callable|string $content, array $data = []) {
	global $_g_data;
	$_g_data = $data;

	render('wraps/top');
	if (is_string($content)) { echo "$content"; }
	elseif (is_array($content)) { foreach ($content as $c) { render($c); }}
	else { $content(); }
	render('wraps/bottom');
}
