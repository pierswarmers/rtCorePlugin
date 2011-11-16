<ul class="rt-admin-tools">
  <li><button type="submit" class=" createnode ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon"><span class="ui-button-icon-primary ui-icon ui-icon-plus"></span><span class="ui-button-text"><?php echo __('Create new item inside selected');?></span></button></li>
  <li><button type="submit" class=" deletenode ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon"><span class="ui-button-icon-primary ui-icon ui-icon-trash"></span><span class="ui-button-text"><?php echo __('Delete selected item');?></span></button></li>
</ul>

<ul class="rt-admin-tools">
</ul>
<script type="text/javascript">
    $(document).ready(function(){

<!--$("#rtPrimaryTools .cancel").button({-->
<!--  icons: { primary: 'ui-icon-cancel' }-->
<!--}).click(function(){ document.location.href='--><?php //echo url_for($controller.'/index') ?><!--'; });-->
<!---->

    $('.createnode').click(function(e){
        var t = $.tree.focused(); 
        if(t.selected) {
            rtTreeAdminPluginCreateNew<?php echo $model;?> = true;
            t.create();
        } 
        else {
            alert("Select a node first");
        }

    });
                
    $('.deletenode').click(function(e){
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