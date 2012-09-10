<?php foreach($object->getAssets() as $asset): ?>
    <?php include_partial('rtAsset/asset_row', array('asset' => $asset)); ?>
<?php endforeach; ?>