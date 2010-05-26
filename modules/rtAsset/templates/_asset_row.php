<?php use_helper('I18N', 'Text') ?>
<li id="rtAttachedAsset<?php echo $asset->getId() ?>" class="rt-core-upload-item <?php echo ($asset->isImage()) ? 'thumbnail' : 'other' ?>">
  <div class="rt-core-upload-thumb">
    <div>
      <?php if($asset->isImage()): ?>
        <img src="<?php echo rtAssetToolkit::getThumbnailPath($asset->getSystemPath(), array('maxWidth' => 26, 'maxHeight' => 26)) ?>" />
      <?php else: ?>
        <img src="<?php echo '/rtCorePlugin/images/mime-types/' . rtAssetToolkit::translateExtensionToBase($asset->getOriginalFilename()) . '.png' ?>" />
      <?php endif; ?>
    </div>
  </div>
  <div class="rt-core-upload-metadata">
    <?php echo truncate_text($asset->getOriginalFilename(),30); ?><br />
    <span><?php echo rtAssetToolkit::getFormattedBytes($asset->getFilesize()); ?></span>
  </div>
<?php

$open = '[';
$close = sprintf('](asset:%s)', $asset->getOriginalFilename());

if($asset->isImage())
{
  $open = '![';
  $close = sprintf('](asset:%s|right|200,400)', $asset->getOriginalFilename());
}

?>
  <span class="delete" onclick="deleteAsset('<?php echo $asset->getId() ?>')">&times;</span>
  <span onclick="$.markItUp({openWith: '<?php echo $open ?>',closeWith:'<?php echo $close ?>',placeHolder:'Description goes here...' });" class="insert" >&nbsp;</span>
</li>