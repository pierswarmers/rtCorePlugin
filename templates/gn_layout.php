<?php use_helper('I18N') ?>
<?php $routes = $sf_context->getRouting()->getRoutes() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php use_stylesheet('/gnCorePlugin/vendor/blueprint/screen.css', 'first') ?>
    <?php use_stylesheet('/gnCorePlugin/css/main.css', 'first') ?>
    <?php use_javascript('/gnCorePlugin/vendor/jquery/js/jquery.min.js') ?>
    <?php use_javascript('/gnCorePlugin/vendor/jquery-ui/js/jquery-ui.min.js', 'last'); ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <?php if (isset($routes['gn_blog_page_feed'])): ?>
    <?php echo auto_discovery_link_tag('rss', '@gn_blog_page_feed?format=rss') ?>
    <?php echo auto_discovery_link_tag('atom', '@gn_blog_page_feed?format=atom') ?>
    <?php endif; ?>
  </head>
  <body>
    <?php require_once(dirname(__FILE__).'/gn_admin_header.php'); ?>
    <div id="gn-header">
      <div class="container">
        <div id="gn-tagline">
          <span id="gn-tagline-name"><?php echo sfConfig::get('app_gn_title', 'Gumnut') ?></span>
          <span id="gn-tagline-module-title"> / <?php echo !is_null(sfConfig::get('app_gn_node_title')) ? sprintf('<span id="gn-tagline-location">%s</span>',sfConfig::get('app_gn_node_title')) : '' ?></span>
        </div>
        <ul id="gn-component-nav">
          <?php if (isset($routes['gn_site_page_index'])): ?>
              <li><?php echo link_to(__('Site'), 'gnSitePage/index') ?></li>
          <?php endif; ?>
          <?php if (isset($routes['gn_blog_page_index'])): ?>
              <li><?php echo link_to(__('Blog'), 'gnBlogPage/index') ?></li>
          <?php endif; ?>
          <?php if (isset($routes['gn_wiki_page_index'])): ?>
              <li><?php echo link_to(__('Wiki'), 'gnWikiPage/index') ?></li>
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
    <div class="container" id="gn-page">
      <div id="gn-content" class="span-15 append-1">
        <?php echo $sf_content ?>
      </div>
      <div id="gn-side" class="span-7 prepend-1 last">
        <?php echo get_slot('gn-side'); ?>
        <?php if (isset($routes['gn_search']) && !has_slot('gn-side')): ?>
        <?php include_partial('gnSearch/form', array('form' => new gnSearchForm())) ?>
        <?php endif; ?>
        <?php //include_component('gnSitePage', 'navigation', array('options' => array('include_root' => false, 'limit_lower' => 1, 'limit_upper' => 2))) ?>
        <?php include_component('gnSitePage', 'navigation') ?>
      </div>
    </div>
    <?php require_once(dirname(__FILE__).'/gn_footer.php'); ?>
    <!--gn-admin-holder-->
  </body>
</html>