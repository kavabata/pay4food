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
			'bootstrap-responsive',
      'common'
		));
		echo $this->fetch('css');

		echo $this->Html->script(array(
			'jquery',
            'jquery.form',
            'jquery.validate',
            'bootstrap',
            'common'
		));
		echo $this->fetch('script');
	?>
</head>
<body>
	<div class="container">
		<div class="header">
      <div class="logo">
        <div class="left"><?php echo $this->Html->link($this->Html->image('logo.png'),Router::url('/',true),array('escape'=>false));?></div>
        <div class="left margin-left"><br /><?php echo $this->Html->link('Pay For Food',Router::url('/',true));?><br />
          <?php echo __("Someone should pay for that!");?>
        </div>
        <div class="right">
          <a href="https://github.com/kavabata/pay4food/issues" target="_blank"><strong style="color: #FF9CA5;">BUG?</strong></a>
        </div>
        <div class="clear"></div>
      </div>
			<h3 class="muted">
            </h3>
			<div class="navbar">
				<div class="navbar-inner">
					<div class="container">
						<ul class="nav">
							<li class="<?php echo $this->name == 'Transactions' && $this->action == "add"? 'active' : ''; ?>"><a href="/">Dashboard</a></li>
							<li class="<?php echo $this->name == 'Transactions' && $this->action == "payout" ? 'active' : ''; ?>"><a href="/transactions/payout">Payout</a></li>
                            <li class="<?php echo $this->name == 'Users' ? 'active' : ''; ?>"><a href="/users">Users</a></li>
                            <li class="<?php echo $this->name == 'Transactions' && $this->action == "index" ? 'active' : ''; ?>"><a href="/transactions">History</a></li>
                            <?php if(!empty($user_data)): ?><li><a href="/logout">Logout</a></li><?php endif;?>
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
