<?php use_helper('I18N') ?>
<?php if ($sf_user->hasFlash('notice')): ?>
  <p class="success"><?php echo $sf_user->getFlash('notice') ?></p>
<?php elseif ($sf_user->hasFlash('error')): ?>
  <p class="error"><?php echo $sf_user->getFlash('error') ?></p>
<?php elseif ($sf_user->hasFlash('default_error')): ?>
  <p class="error"><?php echo __('One or more errors were detected - please see below for details.') ?></p>
<?php endif; ?>