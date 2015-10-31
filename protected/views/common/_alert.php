<?php if ($form->hasErrors()): ?>
<?php $errors = $form->getErrors(); ?>
<div class="alert alert-warning">
	<ul>
		<?php foreach ($errors as $error): ?>
		<li><?php echo $error[0]; ?></li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>