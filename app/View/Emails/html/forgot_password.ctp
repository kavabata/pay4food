Dear <?php echo $username; ?>,
<br /><br />
You can reset your password by clicking the link below. You will be taken to the site to update it directly. 

<br /><br />
<?php
echo $this->Html->link(
    'Let Me Reset My Password!',
    $this->Html->url(array('controller' => 'users', 'action' => 'get_new_password', $hash), true)
);
?>
<br /><br />
For security purposes, the above link will expire in 24 hours.<br /><br />
Pay4Food