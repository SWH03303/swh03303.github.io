<?php
$label = $data[0] ?? $data['label'];
$name = $data[1] ?? $data['name'];
$type = $data[2] ?? $data['type'] ?? 'text';
$persist = $data[3] ?? $data['persist'] ?? ($type == 'text');
$required = $data[4] ?? $data['required'] ?? true;

$value = (Request::is_post() && $persist)? Request::param($name) : null;
$value = is_null($value)? '' : ' value="' . html_sanitize($value) . '"';

global $_input_counter;
$_input_counter = is_null($_input_counter)? 0 : $_input_counter;
$id = 'input-auto-' . ($_input_counter += 1);
$required = $required? ' required' : '';

echo <<<TEXT
	<div class="flex">
		<label for="$id">$label</label>
		<input id="$id" class="fill" type="$type" name="$name"$value$required>
	</div>
TEXT;
?>
