<?php use_helper('I18N') ?>
<?php $routes = $sf_context->getRouting()->getRoutes() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php use_stylesheet('/gnCorePlugin/vendor/blueprint/screen.css') ?>
    <?php use_stylesheet('/gnCorePlugin/vendor/jquery/css/ui/jquery.ui.css') ?>
    <?php use_stylesheet('/gnCorePlugin/css/admin.css') ?>
    <?php use_stylesheet('/gnCorePlugin/css/admin-toolbar.css') ?>
    <?php use_javascript('/gnCorePlugin/vendor/jquery/js/jquery.min.js', 'first') ?>
    <?php use_javascript('/gnCorePlugin/vendor/jquery/js/jquery.ui.min.js', 'first'); ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <div id="gn-admin-container">
      <?php include_component('gnAdmin', 'menu') ?>
      <div id="gn-admin-content">
        <?php echo $sf_content ?>
      </div>
      <div id="gn-admin-tools">
        <h1><?php echo __('Actions') ?></h1>
        <?php echo get_slot('gn-side'); ?>
      </div>
    </div>
  </body>
</html>