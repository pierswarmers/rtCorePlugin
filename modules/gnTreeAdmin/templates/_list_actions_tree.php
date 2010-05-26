<ul class="gn-admin-tools">
  <li><button disabled="disabled" type="submit" class="nodeinteraction createnode ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon"><span class="ui-button-icon-primary ui-icon ui-icon-plus"></span><span class="ui-button-text"><?php echo __('Create new item inside selected');?></span></button></li>
  <li><button disabled="disabled" type="submit" class="nodeinteraction deletenode ui-button ui-widget ui-state-default ui-corner-all ui-button-text-icon"><span class="ui-button-icon-primary ui-icon ui-icon-trash"></span><span class="ui-button-text"><?php echo __('Delete selected item');?></span></button></li>
</ul>

<?php echo javascript_tag();?>
    $(document).ready(function(){

    $('.createnode').click(function(e){
        var t = $.tree.focused(); 
        if(t.selected) {
            gnTreeAdminPluginCreateNew<?php echo $model;?> = true;
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
<?php echo end_javascript_tag();?>