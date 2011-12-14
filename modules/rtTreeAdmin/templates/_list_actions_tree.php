
<ul class="rt-admin-tools">
  <li><button id="createNode"><?php echo __('Create new item inside selected');?></button></li>
  <li><button id="deleteNode"><?php echo __('Delete selected item');?></button></li>
</ul>
<script type="text/javascript">

  $(document).ready(function(){

    $("#createNode").button({ icons: { primary: 'ui-icon-plus' } }).click(function(){
      var t = $.tree.focused();
      if(t.selected) {
          rtTreeAdminPluginCreateNew<?php echo $model;?> = true;
          t.create();
      } else {
          alert("Select a node first");
      }
    });

    $("#deleteNode").button({ icons: { primary: 'ui-icon-plus' } }).click(function(){
      var t = $.tree.focused();
      if(t.selected) {
         if ( t.parent(t.selected) == -1){
          alert("<?php echo __('forbidden to remove root node');?>")
         }else{
          t.remove();
          }
      }
      else {
          alert("Select a node first");
      }
    });

    })
</script>