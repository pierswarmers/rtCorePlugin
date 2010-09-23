<?php use_helper('I18N', 'rtAdmin'); ?>
<form>
  <input type="hidden" name="id" value="<?php echo $asset->getId() ?>" id="rt-asset-edit-id" />
  <p>
    <label  for="rt-asset-edit-title"><?php echo __('Title') ?>:</label><br />
    <input class="text" type="text" name="title" id="rt-asset-edit-title" value="<?php echo $asset->getTitle() ?>" />
  </p>
  <p>
    <label for="rt-asset-edit-description"><?php echo __('Description') ?>:</label><br />
    <textarea name="description" id="rt-asset-edit-description"><?php echo $asset->getDescription() ?></textarea>
  </p>
  <p>
    <label  for="rt-asset-edit-filename"><?php echo __('Filename') ?>:</label><br />
    <input class="text" type="text" name="filename" id="rt-asset-edit-filename" value="<?php echo $asset->getOriginalFilename() ?>" />
  </p>
</form>