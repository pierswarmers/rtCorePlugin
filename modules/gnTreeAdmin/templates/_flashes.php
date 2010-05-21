<?php if ($sf_user->hasFlash('notice')): ?>
  <p class="notice"><?php echo __($sf_user->getFlash('notice'), array(), 'sf_admin') ?></p>
<?php endif; ?>

<?php if ($sf_user->hasFlash('error')): ?>
  <p class="error"><?php echo __($sf_user->getFlash('error'), array(), 'sf_admin') ?></p>
<?php endif; ?>
