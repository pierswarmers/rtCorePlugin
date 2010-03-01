<?php use_helper('I18N') ?>
<?php $routes = $sf_context->getRouting()->getRoutes() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php use_stylesheet('/gnCorePlugin/css/main.css') ?>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
  </head>
  <body>
    <div id="gn-container">
      <div id="gn-header">
        <ul id="gn-component-nav">
          <?php if (isset($routes['sf_guard_signin']) && isset($routes['sf_guard_signout'])): ?>
          <?php if (!$sf_user->isAuthenticated()): ?>
              <li class="right"><?php echo link_to(__('Login'), '@sf_guard_signin') ?></li>
            <?php else: ?>
              <li class="right"><?php echo link_to('&times; '.__('Logout'), '@sf_guard_signout') ?></li>
            <?php endif; ?>
          <?php endif; ?>
          <?php if (isset($routes['gn_search'])): ?>
          <li class="right"><?php echo link_to(__('Search'), '@gn_search') ?></li>
          <?php endif; ?>
          <?php if (isset($routes['gn_page_index'])): ?>
              <li><?php echo link_to(__('Wiki'), 'gnPage/index') ?></li>
          <?php endif; ?>
        </ul>
        <div id="gn-logo">
          <?php echo sfConfig::get('app_gn_title', $sf_response->getTitle()) ?> /
          <?php echo !is_null(sfConfig::get('app_gn_node_title')) ? sprintf('<span>%s</span>',sfConfig::get('app_gn_node_title')) : '' ?>
        </div>
      </div>
      <div id="gn-content">
        <div class="gn-inner">
          <?php echo $sf_content ?>
        </div>
      </div>
      <div id="gn-side">
        <div class="gn-inner">
          <?php echo get_slot('tools'); ?>
        </div>
      </div>
      <div id="gn-footer">
        &nbsp;
      </div>
    </div>
  </body>
</html>