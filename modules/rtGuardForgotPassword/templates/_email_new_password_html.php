<?php use_helper('I18N') ?>
<p><?php echo __('Hi %first_name%', array('%first_name%' => $user->getFirstName()), 'sf_guard') ?>,</p>
<p><?php echo __('Below is your username and new password:') ?></p>
<p>
  <?php echo __('Username', null, 'sf_guard') ?>: <?php echo $user->getUsername() ?><br />
  <?php echo __('Password', null, 'sf_guard') ?>: <?php echo $password ?>
</p>