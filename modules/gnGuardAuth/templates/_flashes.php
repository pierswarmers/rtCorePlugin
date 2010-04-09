<?php if ($sf_user->hasFlash('notice')): ?>
  <p class="success"><?php echo $sf_user->getFlash('notice') ?></p>
<?php elseif ($sf_user->hasFlash('error')): ?>
  <p class="error"><?php echo $sf_user->getFlash('error') ?></p>
<?php endif; ?>