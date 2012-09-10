<?php use_helper('I18N', 'rtAdmin'); ?>
<form>
  <input type="hidden" name="id" value="<?php echo $asset->getId() ?>" id="rt-asset-edit-id" />
  <p>
    <label  for="rt-asset-edit-title"><?php echo __('Title') ?>:</label><br />
    <input class="text" type="text" name="title" id="rt-asset-edit-title" value="<?php echo $asset->getTitle() ?>" />
  </p>
  <p>
    <label  for="rt-asset-edit-target-url"><?php echo __('Target URL') ?>:</label><br />
    <input class="text" type="text" name="target_url" id="rt-asset-edit-target-url" value="<?php echo $asset->getTargetUrl() ?>" />
  </p>
  <p>
    <label for="rt-asset-edit-description"><?php echo __('Description') ?>:</label><br />
    <textarea name="description" id="rt-asset-edit-description"><?php echo $asset->getDescription() ?></textarea>
  </p>
  <p>
    <label  for="rt-asset-edit-filename"><?php echo __('Filename') ?>:</label><br />
    <input class="text" type="text" name="filename" id="rt-asset-edit-filename" value="<?php echo $asset->getOriginalFilename() ?>" />
  </p>
  <?php if($asset->isTextEditable()) { ?>
  <p>
    <label for="rt-asset-edit-content"><?php echo __('File Content') ?>:</label><br />
    <textarea name="content" id="rt-asset-edit-content"><?php echo $asset->getFileContent() ?></textarea>
  </p>
  <?php } ?>
</form>