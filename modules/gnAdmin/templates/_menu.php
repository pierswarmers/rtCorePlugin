<div id="gn-admin-toolbar">
  <div id="gn-admin-toolbar-handle">+</div>
  <div id="gn-admin-toolbar-content">
    <div id="gn-admin-toolbar-menu">
      <h1><?php echo __('Administration Tools') ?></h1>
      <div id="gn-admin-toolbar-search">
        <form action="<?php echo url_for('gnSearchAdmin/index') ?>" method="get">
          <input type="text" name="q" value="<?php echo $sf_request->getParameter('q') ?>" />
        </form>
      </div>
      <h2><?php echo __('General Content') ?></h2>
      <ul>
        <li><a href="<?php echo url_for('gnSitePageAdmin/index') ?>"><?php echo __('Site Pages') ?></a></li>
        <li><a href="<?php echo url_for('gnBlogPageAdmin/index') ?>"><?php echo __('Blog Posts') ?></a></li>
        <li><a href="<?php echo url_for('gnWikiPageAdmin/index') ?>"><?php echo __('Wiki Pages') ?></a></li>
      </ul>
      <h2><?php echo __('Users And Security') ?></h2>
      <ul>
        <li><a href="<?php echo url_for('gnGuardUserAdmin/index') ?>"><?php echo __('User Listing') ?></a></li>
        <li><a href="<?php echo url_for('gnGuardGroupAdmin/index') ?>"><?php echo __('Groups') ?></a></li>
        <li><a href="<?php echo url_for('gnGuardPermissionAdmin/index') ?>"><?php echo __('Permissions') ?></a></li>
      </ul>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    function toggleAdminContent(){
      var menu = $('#gn-admin-toolbar');
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
      $("#gn-admin-toolbar-menu").toggle();
    };

    $("#gn-admin-toolbar-handle").click(function() { toggleAdminContent(); });
  });
</script>