<?php

use_helper('I18N', 'rtForm', 'rtTemplate');

slot('rt-title', __('Sitemap'));

?>

<div class="rt-section rt-sitemap">

  <?php if(sfConfig::get('app_rt_templates_headers_embedded', true)): ?>
  <div class="rt-section-header">
    <h1><?php echo __('Sitemap') ?></h1>
  </div>
  <?php endif; ?>

  <div class="rt-section-content">

    <h2><?php echo __('General Pages') ?></h2>
    <?php include_component('rtSitePage', 'navigation', array('options' => array('render_full' => true))) ?>

  </div>
</div>