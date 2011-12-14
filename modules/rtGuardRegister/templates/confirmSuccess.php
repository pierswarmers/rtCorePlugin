<?php

use_helper('I18N', 'rtForm', 'rtTemplate');

slot('rt-title', __('Registration Confirmed'));

?>

<div class="rt-section rt-guard-register-confirm">

  <?php if(sfConfig::get('app_rt_templates_headers_embedded', true)): ?>
  <div class="rt-section-header">
    <h1><?php echo __('Registration Confirmed') ?></h1>
  </div>
  <?php endif; ?>

  <div class="rt-section-content">

    <?php rt_get_snippet('rt-guard-register-confirm-prefix', sprintf('<p>%s</p>', __('The user "%1%" has been activated and an email has been sent to notify them of this.', array('%1%' => $user->getName())))); ?>

  </div>
</div>