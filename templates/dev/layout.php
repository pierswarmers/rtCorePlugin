<!doctype html>

<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <meta name="author" content="digital Wranglers">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">
  
  <?php //use_stylesheet('/rtCorePlugin/vendor/blueprint/screen.css') ?>
  <?php //use_stylesheet('/rtCorePlugin/vendor/blueprint/print.css', '', array('media' => 'print')) ?>
  <?php use_stylesheet('/rtCorePlugin/vendor/jquery/css/ui/jquery.ui.css') ?>
  <?php use_stylesheet('/rtCorePlugin/css/dev/admin-main.css') ?>
  <?php use_stylesheet('/rtCorePlugin/css/admin-toolbar.css') ?>
  <?php use_stylesheet('/rtCorePlugin/css/admin-print.css', '', array('media' => 'print')) ?>
  <?php use_javascript('/rtCorePlugin/vendor/jquery/js/jquery.min.js', 'first') ?>
  <?php use_javascript('/rtCorePlugin/vendor/jquery/js/jquery.ui.min.js', 'first'); ?>
  <?php use_javascript('/rtCorePlugin/js/admin-main.js', 'last') ?>
    
  <?php include_title(); include_stylesheets(); include_javascripts(); ?>

</head>

<body>
  <div id="rt-admin-container">
    
    <?php include_component('rtAdmin', 'menu') ?>
    
    <div id="rt-admin-content">
    
      <?php echo $sf_content ?>

    </div>
    
    <div id="rt-admin-tools">

      <h1><?php echo __('Actions') ?></h1>
    
      <?php echo get_slot('rt-tools'); ?>
      
      <?php echo get_slot('rt-side'); ?>
      
    </div>
    
  </div> <!-- end of #rt-admin-container -->
  
</body>

</html>