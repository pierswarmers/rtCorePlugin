<?php use_helper('I18N') ?>
<?php if ($sf_user->hasFlash('notice')): ?>
  <p class="rt-flash-message notice"><?php echo html_entity_decode($sf_user->getFlash('notice')) ?></p>
<?php elseif ($sf_user->hasFlash('success')): ?>
  <p class="rt-flash-message success"><?php echo html_entity_decode($sf_user->getFlash('success')) ?></p>
<?php elseif ($sf_user->hasFlash('error')): ?>
  <p class="rt-flash-message error"><?php echo html_entity_decode($sf_user->getFlash('error')) ?></p>
<?php elseif ($sf_user->hasFlash('default_error')): ?>
  <p class="rt-flash-message error"><?php echo __('One or more errors were detected - please see below for details.') ?></p>
<?php endif; ?>