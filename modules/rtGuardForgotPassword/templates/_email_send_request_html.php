<?php use_helper('I18N') ?>
<p><?php echo __('Hi %first_name%', array('%first_name%' => $user->getFirstName()), 'sf_guard') ?>,</p>
<p><?php echo __('This e-mail is being sent because you requested information on how to reset your password.', null, 'sf_guard') ?></p>
<p><?php echo __('You can change your password by clicking the below link which is only valid for 24 hours:', null, 'sf_guard') ?></p>
<p><?php echo link_to(__('Click to change password', null, 'sf_guard'), 'sf_guard_forgot_password_change', array('unique_key' => $forgot_password->unique_key), array('absolute' => true)) ?></p>