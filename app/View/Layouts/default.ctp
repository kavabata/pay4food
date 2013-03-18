<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Developer">
    <meta name="robots" content="noindex, nofollow">

	<?php
		echo $this->Html->meta('icon');

		echo $this->fetch('meta');

		echo $this->Html->css(array(
			'bootstrap',
			'bootstrap-responsive'
		));
		echo $this->fetch('css');

		echo $this->Html->script(array(
			'jquery',
			'bootstrap'
		));
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="container">
		<div class="header">
			<h3 class="muted">Pay For Food</h3>
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
							<li class="<?php echo $this->name == 'Pages' ? 'active' : ''; ?>"><a href="/">Home</a></li>
							<li class="<?php echo $this->name == 'Users' ? 'active' : ''; ?>"><a href="/users">Users</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div class="container">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
</body>
</html>
