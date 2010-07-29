<?php use_helper('I18N') ?>
<p><?php echo __('Hi') . ' ' . $user->getFirstName() ?>,</p>
<p><?php echo __('Your registration has been confirmed and you can now') ?> <a href="<?php echo url_for('sf_guard_signin', array(), array('absolute' => true)) ?>"><?php echo __('sign-in') ?></a>.</p>
<?php if(isset($password)): ?>
<p><strong><?php echo __('For your records') ?></strong>:</p>
<p>
  <?php echo __('Username') ?>: <code><?php echo $user->getUsername() ?></code><br />
  <?php echo __('Password') ?>: <code><?php echo $password ?></code>
</p>
<?php endif; ?>
<?php if($voucher): ?>
<p><strong><?php echo __('Welcome voucher worth') ?> <?php echo $voucher->getReductionValueFormatted() ?></strong>:</p>
<p><?php echo __('Your welcome voucher has been created and can be used with the following code') ?>: #<?php echo $voucher->getCode() ?></p>
<?php endif; ?>