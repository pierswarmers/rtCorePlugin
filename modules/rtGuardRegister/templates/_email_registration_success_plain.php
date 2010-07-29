<?php use_helper('I18N') ?>
<?php echo __('Hi') . ' ' . $user->getFirstName() ?>,

<?php echo __('Your registration has been confirmed and you can now sign-in') ?>:

<?php echo url_for('sf_guard_signin', array(), array('absolute' => true)) ?>
<?php if(isset($password)): ?> 

<?php echo __('For your records') ?>:

<?php echo __('Username') ?>: <?php echo $user->getUsername() ?> 
<?php echo __('Password') ?>: <?php echo $password ?>
<?php endif; ?> 

<?php if($voucher): ?>
<?php echo __('Welcome voucher worth') ?> <?php echo $voucher->getReductionValueFormatted() ?>:

<?php echo __('Your welcome voucher has been created and can be used with the following code') ?>: #<?php echo $voucher->getCode() ?>
<?php endif; ?>