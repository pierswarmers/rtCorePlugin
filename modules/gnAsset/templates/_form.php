<?php use_helper('I18N', 'Text') ?>
<?php use_javascript('/gnCorePlugin/js/main.js') ?>
<?php use_javascript('/gnCorePlugin/vendor/jquery/js/jquery.ui.min.js') ?>
<?php use_javascript('/gnCorePlugin/vendor/ajaxupload/ajaxupload.js') ?>
<?php $panel_suffix = isset($panel_suffix) ? $panel_suffix : rand() ?>
<?php $description_text = __('Description goes here...') ?>
<fieldset class="gn-core-upload">
  <legend><?php echo __('Attached Files') ?></legend>
  <?php if($object->isNew()): ?>
  <p><?php echo __('Please create page before adding assets.'); ?></p>
  <?php else: ?>
    <ul class="gn-core-upload-panel clearfix" id="gnCoreUploadPanel<?php echo $panel_suffix ?>">
      <?php foreach($object->getAssets() as $asset): ?>
        <?php include_partial('gnAsset/asset_row', array('asset' => $asset)); ?>
      <?php endforeach; ?>
    </ul>
    <p>
      <button class="button" id="uploadImageButton<?php echo $panel_suffix ?>"><?php echo __('Upload a file') ?></button>
      <span id="gnCoreUploadPanelMessage<?php echo $panel_suffix ?>"></span>
    </p>
    <?php endif; ?>
</fieldset>
<?php echo $form['_csrf_token']->render(); ?>
<?php echo $form['model']->render(); ?>

<?php if(!$object->isNew()): ?>
<script type="text/javascript">
$(document).ready(function() {

  deleteAsset = function(assetId)
  {
    var assetRowId = '#gnAttachedAsset'+assetId;
    $(assetRowId).fadeTo('fast', 0.5);
    $.ajax({
      dataType: 'json',
      data: {
        id : assetId
      },
      url: '<?php echo url_for('@gn_asset_delete?sf_format=json') ?>',
      success: function(data) {
        if(data.status === 'success')
        {
          $(assetRowId).hide();
        }
      }
    });
    return false;
  }

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
            success: function(data) {}
          });
        }
      }
    );
	});
  var button = $('#uploadImageButton<?php echo $panel_suffix ?>');
  var message = $('#gnCoreUploadPanelMessage<?php echo $panel_suffix ?>');
  new AjaxUpload(button,{
    action: '<?php echo url_for('@gn_asset_upload') ?>',
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
      $("#gnCoreUploadPanel<?php echo $panel_suffix ?>").append(response);
      message.text('<?php echo __('Upload complete') ?>').fadeOut(4000);
    }
  });
});
</script>
<?php endif; ?>
