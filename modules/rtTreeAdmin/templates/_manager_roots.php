<?php use_helper('rtAdmin') ?>

  <table cellspacing="0">
    <thead>
      <tr>
        <th><?php echo ucfirst($field);?> </th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td>
          <form id="<?php echo strtolower($model);?>_root_create" action="<?php echo url_for('rtTreeAdmin/Add_root');?>" method="post">
            <input type="text" id="<?php echo strtolower($model);?>_<?php echo $field;?>" value="" name="<?php echo strtolower($model);?>[<?php echo $field;?>]"/>
            <input type="hidden" name="model" value="<?php echo $model;?>"/>
          </form>
        <td>
          <ul class="rt-admin-tools">
            <li><button type="submit" id="createTree" ><?php echo __('Create new root page');?></button></li>
          </ul>

        <script type="text/javascript">


          $(document).ready(function(){

            $('#createTree').button({ icons: { primary: 'ui-icon-plus' } }).click(function(){
              $('#<?php echo strtolower($model);?>_root_create').submit();
            });

          });
        </script>
        </td>
      </tr>
    </tfoot>
    <tbody>
      <?php foreach ($roots as $i => $root): ?>
      <tr>
        <td class="sf_admin_text sf_admin_list_td_<?php echo $field ?>"><?php echo $root->$field ?></td>
        <td>
          <ul class="rt-admin-tools">
            <li><?php echo rt_ui_button(__('Open this tree'), $sf_request->getParameter('module') . '/' . $sf_request->getParameter('action') . '?root=' . $root->id, 'arrow-1-e') ?></li>
          </ul>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

<?php echo javascript_tag();?>
$(document).ready(function(e){
    $('#<?php echo strtolower($model);?>_root_create').submit(function(e){
        e.preventDefault();
        var src = $(this).find('.actionImage').attr('src');
        $(this).find('.actionImage').attr('src', '/sfJqueryTreeDoctrineManagerPlugin/css/throbber.gif');
        $.post( $(this).attr('action'), $(this).serialize(), function(){
            document.location.reload();
        } );
    });
});
<?php echo end_javascript_tag();?>
