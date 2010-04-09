<?php use_helper('I18N') ?>
<h1><?php echo __('Registration Confirmed') ?></h1>
<?php include_partial('gnGuardAuth/flashes')?>
<p><?php echo __('The user "%1%" has been activated and an email has been sent to notify them of this', array('%1%' => $user->getName())) ?>.</p>
