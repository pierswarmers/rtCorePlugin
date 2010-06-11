<?php $routes = sfContext::getInstance()->getRouting()->getRoutes(); ?>
<div id="rt-admin-toolbar">
  <div id="rt-admin-toolbar-handle">+</div>
  <div id="rt-admin-toolbar-content">
    <div id="rt-admin-toolbar-menu">
      <h1><?php echo __('Administration Tools') ?></h1>
      <div id="rt-admin-toolbar-search">
        <form action="<?php echo url_for('rtSearchAdmin/index') ?>" method="get">
          <input type="text" name="q" id="rtAdminSearch" value="<?php echo $sf_request->getParameter('q') ?>" />
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
        <li><a href="<?php echo url_for('rtShopCategoryAdmin/index') ?>"><?php echo __('Categories') ?></a></li>
        <li><a href="<?php echo url_for('rtShopAttributeAdmin/index') ?>"><?php echo __('Attributes') ?></a></li>
        <li><a href="<?php echo url_for('rtShopPromotionAdmin/index') ?>"><?php echo __('Promotions') ?></a></li>
        <li><a href="<?php echo url_for('rtShopVoucherAdmin/index') ?>"><?php echo __('Vouchers') ?></a></li>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    /* Search Bar */
    var searchDefault = "Search...";
    var searchBox = $("#rtAdminSearch");
    if(searchBox.attr("value") == "") searchBox.attr("value", searchDefault);
    searchBox.focus(function(){
      if($(this).attr("value") == searchDefault) $(this).attr("value", "");
    });
    searchBox.blur(function(){
      if($(this).attr("value") == "") $(this).attr("value", searchDefault);
    });

    
    function rtToggleAdminContent(){
      var menu = $('#rt-admin-toolbar');
      if(!menu.hasClass('show')) {
        menu.addClass('show');
        rtToggleAdminMenu();
      } else {
        rtToggleAdminMenu();
        menu.removeClass('show');
      }
      return false;
    };

    $('.rt-admin-edit-tools-trigger').hover(function(){
      $(this).parent('div.rt-admin-edit-tools-panel').addClass('highlight');
    },function(){
      $(this).parent('div.rt-admin-edit-tools-panel').removeClass('highlight');
    }).click(function(){ $(this).parent('div.rt-admin-edit-tools-panel').removeClass('highlight'); });

    function rtToggleAdminMenu(){
      $("#rt-admin-toolbar-menu").toggle();
    };

    $("#rt-admin-toolbar-handle").click(function() { rtToggleAdminContent(); });
  });
</script>