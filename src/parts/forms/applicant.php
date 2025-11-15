<section id="application-header" class="flex-y flex-o">
	<h1>Personal Info Submission</h1>
	<p>
		Before submitting EOIs, you must first provide some information about yourself,
		which will be reflected on <span class="important">all</span> of your future EOIs.
	</p>
	<p>You can always update these data in the <span class="important">Profile</span> page.</p>
</section>
<form class="box flex-y" method="post">
	<?php
		render('input', ['First Name', 'first-name']);
		render('input', ['Last Name', 'last-name']);
		render('input', ['Date of Birth', 'dob', 'date', 'persist' => true]);
		render('input/select', ['Gender', 'gender', [
			'm' => 'Male (he/him)',
			'f' => 'Female (she/her)',
			'x' => 'Non-binary (they/them)',
			'?' => 'Prefer not to say',
		]]);
		render('csrf');
	?>
	<button type="submit">Submit</button>
</form>
