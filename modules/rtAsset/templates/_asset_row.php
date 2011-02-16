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
    <span>
      <?php echo rtAssetToolkit::getFormattedBytes($asset->getFilesize()); ?> - 
      <a href="#" class="edit-button" onclick="editAsset('<?php echo $asset->getId() ?>', '<?php echo $asset->getOriginalFilename() ?>')">edit</a>
    </span>
  </div>
<?php

$open = '[';
$close = sprintf('](asset:%s)', $asset->getOriginalFilename());

if($asset->isImage())
{
  $open = '![';
  $close = sprintf('](asset:%s%s)', $asset->getOriginalFilename(), sfConfig::get('app_rt_asset_image_link_suffix', '|right|200,400'));
}
elseif($asset->getExtension() == 'html')
{
  $open = '![';
  $close = sprintf('](asset:%s)', $asset->getOriginalFilename());
}
elseif($asset->isSwf())
{
  $open = '![';
  $close = sprintf('](asset:%s%s)', $asset->getOriginalFilename(), sfConfig::get('app_rt_asset_swf_link_suffix', '|500,400'));
}

?>
  <span class="delete" onclick="deleteAsset('<?php echo $asset->getId() ?>')">&times;</span>
  <span onclick="$.markItUp({openWith: '<?php echo $open ?>',closeWith:'<?php echo $close ?>',placeHolder:'<?php echo (trim($asset->getTitle()) !== '') ? $asset->getTitle() : __('Description goes here') . '...' ?>' });" class="insert" >&nbsp;</span>
</li>