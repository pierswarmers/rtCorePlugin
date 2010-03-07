<?php use_javascript('/gnCorePlugin/vendor/jquery/js/jquery-ui-1.8rc3.custom.min.js') ?>
<?php use_dynamic_javascript('/gnCorePlugin/vendor/ajaxupload/ajaxupload.js')?>
<?php $panel_suffix = isset($panel_suffix) ? $panel_suffix : rand() ?>

<h3><?php echo __('Asset Collection') ?></h3>

<div class="gn-form-row">
  <ul class="gn-core-upload-panel clearfix" id="gnCoreUploadPanel<?php echo $panel_suffix ?>">
    <?php foreach($object->getAssets() as $asset): ?>
    <li id="<?php echo $asset->getId() ?>" class="gn-core-upload-item"><img src="<?php echo gnAssetToolkit::getThumbnailPath($asset->getSystemPath(), array('maxWidth' => 150, 'maxHeight' => 50, 'minHeight' => 50, 'minWidth' => 50)) ?>" /></li>
    <?php endforeach; ?>
  </ul>
  <p>
    <button class="button" id="uploadImageButton<?php echo $panel_suffix ?>"><?php echo __('Upload a file') ?></button>
    <span id="gnCoreUploadPanelMessage<?php echo $panel_suffix ?>"></span>
  </p>
</div>

<?php echo $form['_csrf_token']->render(); ?>
<?php echo $form['model']->render(); ?>

<script type="text/javascript">
$(document).ready(function() {
	$(function() {
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
            success: function(data) {
              //alert(data.say);
            }
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
        $('<li id="'+ response.asset_id +'" class="gn-core-upload-item"></li>').appendTo(
          '#gnCoreUploadPanel<?php echo $panel_suffix ?>'
        ).html('<img src="'+ response.location +'" />');
      }
    }
  });
});
</script>