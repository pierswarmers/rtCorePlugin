<?php

use_helper('I18N', 'rtForm', 'rtTemplate');

slot('rt-title', __('Account Details'));

?>

<div class="rt-section rt-guard-user-edit">

  <?php if(sfConfig::get('app_rt_templates_headers_embedded', true)): ?>
  <div class="rt-section-header">
    <h1><?php echo __('Account Details') ?></h1>
  </div>
  <?php endif; ?>

  <div class="rt-section-content">

    <?php rt_get_snippet('rt-guard-user-edit-prefix'); ?>

    <?php include_partial('form', array('form' => $form)) ?>

  </div>
</div>