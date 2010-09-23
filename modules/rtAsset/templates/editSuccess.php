<?php use_helper('I18N', 'rtAdmin'); ?>
<form>
  <input type="hidden" name="id" value="<?php echo $asset->getId() ?>" id="rt-asset-edit-id" />
  <p>
    <label  for="rt-asset-edit-title"><?php echo __('Title') ?>:</label><br />
    <input class="text" type="text" name="title" id="rt-asset-edit-title" value="<?php echo $asset->getTitle() ?>" />
  </p>
  <p>
    <label for="rt-asset-edit-description"><?php echo __('Description') ?>:</label><br />
    <textarea name="description"  id="rt-asset-edit-description"><?php echo $asset->getDescription() ?></textarea>
  </p>
  <p>
    <label  for="rt-asset-edit-copyright"><?php echo __('Copyright') ?>:</label><br />
    <input class="text" type="text" name="copyright" id="rt-asset-edit-copyright" value="<?php echo $asset->getCopyright() ?>" />
  </p>
  <p>
    <label  for="rt-asset-edit-author"><?php echo __('Author') ?>:</label><br />
    <input class="text" type="text" name="author" id="rt-asset-edit-author" value="<?php echo $asset->getAuthor() ?>" />
  </p>
</form>