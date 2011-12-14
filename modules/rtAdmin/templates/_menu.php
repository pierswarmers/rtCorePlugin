<?php $routes = sfContext::getInstance()->getRouting()->getRoutes(); ?>
<div id="rt-admin-toolbar">
  <div id="rt-admin-toolbar-handle">+</div>
  <div id="rt-admin-toolbar-content">
    <div id="rt-admin-toolbar-menu">
      <h1>
        <span><?php echo __('RediType - A fully managed content editing and delivery system') ?></span>
        <?php echo link_to('&times;', 'sf_guard_signout', array(), array('class' => 'rt-admin-toolbar-signout', 'title' => __('Sign out of your session'))) ?>
        <?php echo link_to(__('Clear Cache'), '/rtAdmin/clearCache', array('class' => 'rt-admin-toolbar-clear-cache', 'title' => __('Refresh the site cache'))) ?>
        <?php echo link_to(__('Documentation'), 'http://user.reditype.com', array('class' => 'rt-admin-toolbar-help', 'title' => __('Go to Reditype documentation'))) ?>
        <?php echo link_to(__('Site Homepage'), 'homepage', array(), array('class' => 'rt-admin-toolbar-homepage', 'title' => __('Go to site home'))) ?>
      </h1>
      <div id="rt-admin-toolbar-search">
        <form action="<?php echo url_for('rtSearchAdmin/index') ?>" method="get">
          <input type="text" name="q" id="rtAdminSearch" value="<?php echo $sf_request->getParameter('q') ?>" />
        </form>
      </div>

      <?php include_partial('rtAdmin/menu_prefix') ?>

      <?php include_partial('rtAdmin/menu_content') ?>

      <?php include_partial('rtAdmin/menu_security') ?>
      
      <?php include_partial('rtAdmin/menu_shop') ?>
      
      <?php include_partial('rtAdmin/menu_suffix') ?>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    /* Search Bar */
    var searchDefault = "<?php echo __('Search') ?>...";
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