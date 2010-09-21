<?php use_helper('I18N') ?>
<?php $routes = $sf_context->getRouting()->getRoutes() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php use_stylesheet('/rtCorePlugin/vendor/blueprint/screen.css', 'first') ?>
    <?php use_stylesheet('/rtCorePlugin/css/main.css', 'first') ?>
    <?php if(isset($routes['rt_shop_category_index'])) { use_stylesheet('/rtShopPlugin/css/main.css', 'last'); } ?>
    <?php use_javascript('/rtCorePlugin/vendor/jquery/js/jquery.min.js') ?>
    <?php use_javascript('/rtCorePlugin/vendor/jquery/js/jquery.ui.min.js', 'last'); ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <?php if (isset($routes['rt_blog_page_feed'])): ?>
    <?php echo auto_discovery_link_tag('rss', '@rt_blog_page_feed?format=rss') ?>
    <?php echo auto_discovery_link_tag('atom', '@rt_blog_page_feed?format=atom') ?>
    <?php endif; ?>
  </head>
  <body>
    <?php require_once(dirname(__FILE__).'/rt_admin_header.php'); ?>
    <div id="rt-header">
      <div class="container">
        <div id="rt-tagline">
          <span id="rt-tagline-name"><?php echo sfConfig::get('app_rt_title', 'Gumnut') ?></span>
          <span id="rt-tagline-module-title"> / <?php echo !is_null(sfConfig::get('app_rt_node_title')) ? sprintf('<span id="rt-tagline-location">%s</span>',sfConfig::get('app_rt_node_title')) : '' ?></span>
        </div>
        <ul id="rt-component-nav">
          <?php if (isset($routes['rt_site_page_index'])): ?>
              <li><?php echo link_to(__('Site'), 'rtSitePage/index') ?></li>
          <?php endif; ?>
          <?php if (isset($routes['rt_blog_page_index'])): ?>
              <li><?php echo link_to(__('Blog'), 'rtBlogPage/index') ?></li>
          <?php endif; ?>
          <?php if (isset($routes['rt_wiki_page_index'])): ?>
              <li><?php echo link_to(__('Wiki'), 'rtWikiPage/index') ?></li>
          <?php endif; ?>
          <?php if (isset($routes['sf_guard_signin']) && isset($routes['sf_guard_signout'])): ?>
            <?php if (!$sf_user->isAuthenticated()): ?>
              <li><?php echo link_to(__('Login'), '@sf_guard_signin') ?></li>
            <?php else: ?>
              <li><?php echo link_to('&times; '.__('Logout'), '@sf_guard_signout') ?></li>
            <?php endif; ?>
          <?php endif; ?>
        </ul>
      </div>
    </div>
    <div class="container" id="rt-page">
      <div id="rt-content" class="span-15 append-1">
        <?php include_partial('rtAdmin/flashes_public') ?>
        <?php echo $sf_content ?>
      </div>
      <div id="rt-side" class="span-7 prepend-1 last">
        <?php echo get_slot('rt-side'); ?>
        <?php if (isset($routes['rt_search']) && !has_slot('rt-side')): ?>
        <?php include_partial('rtSearch/form', array('form' => new rtSearchForm())) ?>
        <?php endif; ?>
        <?php if (isset($routes['rt_site_page_index'])): ?>
        <?php include_component('rtSitePage', 'navigation', array('options' => array('render_full' => false))) ?>
        <?php endif; ?>
        <?php if (isset($routes['rt_blog_page_index'])): ?>
        <h2><?php echo __('Latest News') ?></h2>
        <?php include_component('rtBlogPage', 'latest') ?>
        <h2><?php echo __('Archive') ?></h2>
        <?php include_component('rtBlogPage', 'archive') ?>        
        <?php endif; ?>
        <h2><?php echo __('Tag Cloud') ?></h2>
        <?php include_component('rtTag', 'cloud', array('options' => array('limit' => 10))) ?>
        <?php if (isset($routes['rt_shop_order_cart'])): ?>
        <h2><?php echo __('Your Shopping Cart') ?></h2>
        <?php include_partial('rtShopOrder/cart_mini') ?>
        <?php endif; ?>
        <?php if (isset($routes['rt_shop_category_index'])): ?>
        <?php include_component('rtShopCategory', 'navigation') ?>
        <?php endif; ?>
      </div>
    </div>
    <?php require_once(dirname(__FILE__).'/rt_footer.php'); ?>
    <!--rt-admin-holder-->
  </body>
</html>