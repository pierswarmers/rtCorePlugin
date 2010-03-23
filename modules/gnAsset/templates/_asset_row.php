<?php use_helper('I18N', 'Text') ?>
<li id="gnAttachedAsset<?php echo $asset->getId() ?>" class="gn-core-upload-item <?php echo ($asset->isImage()) ? 'thumbnail' : 'other' ?>">
  <div class="gn-core-upload-thumb">
    <div>
      <?php if($asset->isImage()): ?>
        <img src="<?php echo gnAssetToolkit::getThumbnailPath($asset->getSystemPath(), array('maxWidth' => 26, 'maxHeight' => 26)) ?>" />
      <?php else: ?>
        <img src="<?php echo '/gnCorePlugin/images/mime-types/' . gnAssetToolkit::translateExtensionToBase($asset->getOriginalFilename()) . '.png' ?>" />
      <?php endif; ?>
    </div>
  </div>
  <div class="gn-core-upload-metadata">
    <?php echo truncate_text($asset->getOriginalFilename(),30); ?><br />
    <span><?php echo gnAssetToolkit::getFormattedBytes($asset->getFilesize()); ?></span>
  </div>
  <span class="delete" onclick="deleteAsset('<?php echo $asset->getId() ?>')">&times;</span>
  <span class="insert" onclick="injectTextIntoCurrent('<?php echo $asset->isImage() ? '!' : '' ?>[<?php echo __('Description goes here...'); ?>](asset:<?php echo $asset->getOriginalFilename() ?><?php echo $asset->isImage() ? '|right|200,300' : '' ?>)')">&nbsp;</span>
</li>