<?php use_helper('I18N') ?>
<?php echo __('Hi') . ' ' . $user->getFirstName() ?>,

<?php echo __('Your registration has been confirmed and you can now sign-in') ?>:

<?php echo url_for('sf_guard_signin', array(), array('absolute' => true)) ?>
<?php if(isset($password)): ?> 

 --

 <?php echo __('PS. For your records, you can sign-in using the following') ?>:

 <?php echo __('Email address') ?>: <?php echo $user->getEmailAddress() ?>
 <?php echo __('Password') ?>: <?php echo $password ?>
<?php endif; ?>