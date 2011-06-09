<?php

use_helper('I18N', 'rtForm', 'rtTemplate');

slot('rt-title', __('Registration Pending'));

?>

<div class="rt-section rt-guard-register-pending">

  <?php if(sfConfig::get('app_rt_templates_headers_embedded', true)): ?>
  <div class="rt-section-header">
    <h1><?php echo __('Registration Pending') ?></h1>
  </div>
  <?php endif; ?>

  <div class="rt-section-content">

    <?php rt_get_snippet('rt-guard-register-pending-prefix', __('You have successfully registered and your account is pending activation. An email will be sent when the account has been activated.')); ?>

  </div>
</div>