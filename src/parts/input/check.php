<?php
$label = $D[0] ?? $D['label'];
$name = $D[1] ?? $D['name'] ?? label_to_name($label);
$persist = $D['persist'] ?? true;
$default = $D['default'] ?? false;
$required = $D['required'] ?? false;

$checked = (Request::is_post() && $persist)? Request::param($name) : null;
$checked = is_null($checked)? $default : $checked;

$id = input_id()[1];
$required = $required? ' required' : '';
$checked = $checked? ' checked' : '';

echo <<<TEXT
<div class="flex">
	<input id="$id" type="checkbox" name="$name"$checked$required>
	<label for="$id" class="fill">$label</label>
</div>
TEXT;
