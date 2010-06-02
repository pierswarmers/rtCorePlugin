<?php $routes = sfContext::getInstance()->getRouting()->getRoutes(); ?>
<div id="rt-admin-toolbar">
  <div id="rt-admin-toolbar-handle">+</div>
  <div id="rt-admin-toolbar-content">
    <div id="rt-admin-toolbar-menu">
      <h1><?php echo __('Administration Tools') ?></h1>
      <div id="rt-admin-toolbar-search">
        <form action="<?php echo url_for('rtSearchAdmin/index') ?>" method="get">
          <input type="text" name="q" value="<?php echo $sf_request->getParameter('q') ?>" />
        </form>
      </div>
      <h2><?php echo __('General Content') ?></h2>
      <ul>
        <li><a href="<?php echo url_for('rtSitePageAdmin/index') ?>"><?php echo __('Site Pages') ?></a></li>
        <li><a href="<?php echo url_for('rtBlogPageAdmin/index') ?>"><?php echo __('Blog Posts') ?></a></li>
        <li><a href="<?php echo url_for('rtWikiPageAdmin/index') ?>"><?php echo __('Wiki Pages') ?></a></li>
      </ul>
      <h2><?php echo __('Users And Security') ?></h2>
      <ul>
        <li><a href="<?php echo url_for('rtGuardUserAdmin/index') ?>"><?php echo __('User Listing') ?></a></li>
        <li><a href="<?php echo url_for('rtGuardGroupAdmin/index') ?>"><?php echo __('Groups') ?></a></li>
        <li><a href="<?php echo url_for('rtGuardPermissionAdmin/index') ?>"><?php echo __('Permissions') ?></a></li>
      </ul>
      <?php if(isset($routes['rt_shop_product_show'])): ?>
      <h2><?php echo __('Shop and Products') ?></h2>
      <ul>
        <li><a href="<?php echo url_for('rtShopProductAdmin/index') ?>"><?php echo __('Products') ?></a></li>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    function toggleAdminContent(){
      var menu = $('#rt-admin-toolbar');
      if(!menu.hasClass('show')) {
        menu.addClass('show', 100);
        toggleAdminMenu();
      } else {
        toggleAdminMenu();
        menu.removeClass('show', 50);
      }
      return false;
    };

    function toggleAdminMenu(){
      $("#rt-admin-toolbar-menu").toggle();
    };

    $("#rt-admin-toolbar-handle").click(function() { toggleAdminContent(); });
  });
</script>