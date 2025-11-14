<?php
$acc = $data['user']->account();
$apl = $data['applicant'];
$new = is_null($apl);
?>
<h1>Hi, <?= html_sanitize($acc->display) ?></h1>
<article id="account-container" class="box flex-y">
	<div class="flex">
		<h2>Account Info</h1>
		<div class="fill"></div>
		<a class="edit-btn flex-y" href="/user/edit">Edit</a>
	</div>
	<div id="account-info">
		<span>Email:</span>
		<span><?= html_sanitize($acc->email) ?></span>
		<span>Created at:</span>
		<span><?= $acc->created->format(DATETIME_FORMAT) ?></span>
		<span>Updated at:</span>
		<span><?= $acc->updated->format(DATETIME_FORMAT) ?></span>
		<span>Is manager:</span>
		<span><?= $acc->is_manager? 'Yes' : 'No' ?></span>
	</div>
</article>
<article id="applicant-container" class="box flex-y">
	<div class="flex">
		<h2>Applicant Info</h1>
		<div class="fill"></div>
		<a class="edit-btn flex-y" href="<?= $new? '/apply' : '/apply/edit' ?>">
			<?= $new? 'Apply' : 'Edit' ?>
		</a>
	</div>
	<?php if (is_null($apl)): ?>
		<span id="no-applicant-message">
			You currently have not created your application profile. To make one, please click the
			<span class="important">"Apply"</span> button above!
		</span>
	<?php else: ?>
		<div id="applicant-info">
		</div>
	<?php endif; ?>
</article>
