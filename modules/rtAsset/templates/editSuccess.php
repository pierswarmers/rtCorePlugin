<?php use_helper('I18N', 'rtAdmin'); ?>
<script type="text/javascript" src="/rtCorePlugin/vendor/jquery/js/jquery.min.js"></script>
<h2><?php echo __('Edit Asset') ?></h2>
<form id="rtAssetEdit" class="rt-asset" method="post">
  <input type="hidden" name="id" value="<?php echo ($sf_request->hasParameter('id')) ? $sf_request->getParameter('id') : '' ?>" id="id" />
  <p>
    <label for="title"><?php echo __('Title') ?>:</label><br />
    <input class="text" type="text" name="title" id="rt_asset_form_title" />
  </p>
  <p>
    <label for="description"><?php echo __('Description') ?>:</label><br />
    <textarea rows="3" cols="30" class="short" name="description" id="rt_asset_form_description"></textarea>
  </p>
  <span class="error" style="display:none;"></span>
  <p><button type="submit" class="button medium positive"><?php echo __('Save') ?></button></p>
</form>
<script type="text/javascript">
  $(document).ready(function() {
    $('button').click(function() {
      $('#rtAssetEdit').submit(function() {
        if ($(".text").val() != "" && $(".short").val() != "") {
          return true;
        }
        $("span.error").text("Please provide a title and a description.").show().fadeOut(3000);
        return false;
      });
    });
  });
</script>