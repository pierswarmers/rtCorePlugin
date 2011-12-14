<?php use_helper('I18N') ?>
<p><?php echo __('Hi') . ' ' . $user->getFirstName() ?>,</p>
<p><?php echo __('Your registration has been confirmed and you can now') ?> <a href="<?php echo url_for('sf_guard_signin', array(), array('absolute' => true)) ?>"><?php echo __('sign-in') ?></a>.</p>
<?php if(isset($password)): ?>
<p><strong><?php echo __('PS. For your records, you can sign-in using the following') ?></strong>:</p>
<p>
  <?php echo __('Email address') ?>: <code><?php echo $user->getEmailAddress() ?></code><br />
  <?php echo __('Password') ?>: <code><?php echo $password ?></code>
</p>
<?php endif; ?>