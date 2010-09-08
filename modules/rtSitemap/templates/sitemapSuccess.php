<?php use_helper('I18N', 'Date', 'rtText', 'rtForm', 'rtDate', 'rtSite'); ?>
<?php $routes = $sf_context->getRouting()->getRoutes() ?>

<h2><?php echo __('Sitemap') ?></h2>
<?php include_component('rtSitePage', 'navigation', array('options' => array('render_full' => true))) ?>

<?php if (isset($routes['rt_shop_category_index'])): ?>
  <h2><?php echo __('Your Shop Categories') ?></h2>
  <?php include_component('rtShopCategory', 'navigation') ?>
<?php endif; ?>

<h2><?php echo __('Latest News') ?></h2>
<?php include_component('rtBlogPage', 'latest') ?>