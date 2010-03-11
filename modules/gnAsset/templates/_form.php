<?php use_javascript('/gnCorePlugin/vendor/jquery/js/jquery-ui-1.8rc3.custom.min.js') ?>
<?php use_dynamic_javascript('/gnCorePlugin/vendor/ajaxupload/ajaxupload.js')?>
<?php $panel_suffix = isset($panel_suffix) ? $panel_suffix : rand() ?>

<fieldset>
  <legend><?php echo __('Asset Collection') ?></legend>
  <p><?php echo __('Files to be linked to this page can be added here. Once uploaded you can drag them to change the order they appear.') ?></p>
    <ul class="gn-core-upload-panel clearfix" id="gnCoreUploadPanel<?php echo $panel_suffix ?>">
      <?php foreach($object->getAssets() as $asset): ?>
      <li id="<?php echo $asset->getId() ?>" class="gn-core-upload-item <?php echo ($asset->isImage()) ? 'thumbnail' : 'other' ?>">
        <span class="delete">&times;</span>
        <?php if($asset->isImage()): ?>
          <img src="<?php echo gnAssetToolkit::getThumbnailPath($asset->getSystemPath(), array('maxWidth' => 150, 'maxHeight' => 50, 'minHeight' => 50, 'minWidth' => 50)) ?>" />
        <?php else: ?>
          <img src="<?php echo '/gnCorePlugin/images/mime-types/' . gnAssetToolkit::translateExtensionToBase($asset->getOriginalFilename()) . '.png' ?>" />
          <?php echo $asset->getOriginalFilename(); ?>
        <?php endif; ?>
      </li>
      <?php endforeach; ?>
    </ul>
    <p>
      <button class="button" id="uploadImageButton<?php echo $panel_suffix ?>"><?php echo __('Upload a file') ?></button>
      <span id="gnCoreUploadPanelMessage<?php echo $panel_suffix ?>"></span>
    </p>
</fieldset>
<?php echo $form['_csrf_token']->render(); ?>
<?php echo $form['model']->render(); ?>

<script type="text/javascript">
$(document).ready(function() {

  var addDeleteAction = function(item) {
    $(item).parent().fadeTo('fast', 0.5);
    $.ajax({
      dataType: 'json',
      data: {
        id : $(item).parent().attr('id')
      },
      url: '<?php echo url_for('@gn_asset_delete?sf_format=json') ?>',
      success: function(data) {
        if(data.status === 'success')
        {
          $('#'+data.id).hide();
        }
      }
    });
    return false;
  }

	$(function() {
    $('#gnCoreUploadPanel<?php echo $panel_suffix ?> .delete').click(function() {
      addDeleteAction(this);
    });
		$("#gnCoreUploadPanel<?php echo $panel_suffix ?>").sortable(
      {
        opacity      : 0.7,
        update : function (event, ui) {
          $.ajax({
            dataType: 'json',
            data: {
              order : $('#gnCoreUploadPanel<?php echo $panel_suffix ?>').sortable('toArray')
            },
            url: '<?php echo url_for('@gn_asset_reorder?sf_format=json') ?>',
            success: function(data) {}
          });
        }
      }
    );
	});
  var button = $('#uploadImageButton<?php echo $panel_suffix ?>');
  var message = $('#gnCoreUploadPanelMessage<?php echo $panel_suffix ?>');
  new AjaxUpload(button,{
    action: '<?php echo url_for('@gn_asset_upload?sf_format=json') ?>',
    name: 'gn_asset[filename]',
    data: {
      'gn_asset[model_id]'   : '<?php echo $object->getId() ?>',
      'gn_asset[model]'      : '<?php echo get_class($sf_data->getRaw('object')) ?>',
      'gn_asset[_csrf_token]': '<?php echo $form['_csrf_token']->getValue(); ?>'
    },
    onSubmit : function(file, ext){
      message.text('<?php echo __('Uploading') ?>').fadeIn(0);
      this.disable();
    },
    onComplete: function(file, response){
      this.enable();
      var response = jQuery.parseJSON(response);
      message.addClass(response.status).text(response.message).fadeOut(4000);
      if(response.status === 'success')
      {
        var name = '';
        if(response.type === 'other')
        {
          name = ' ' + file;
        }
        $('<li id="'+ response.asset_id +'" class="gn-core-upload-item '+ response.type +'"></li>').appendTo(
          '#gnCoreUploadPanel<?php echo $panel_suffix ?>'
        ).html('<span class="delete">&times;</span><img src="'+ response.location +'" />' + name);
        $('li#'+ response.asset_id +' span.delete').click(function() {
          addDeleteAction(this);
        });
      }
    }
  });
});
</script>