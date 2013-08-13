<?php

use_helper('I18N', 'rtText', 'rtTemplate');

$width = isset($options['width']) ? $options['width'] : 1000;
$height = isset($options['height']) ? $options['height'] : 1000;

$snippets = $sf_data->getRaw('snippets');

/** @var $snippets Doctrine_Collection */
if ($snippets && count($snippets) && $snippets->get(0)->getPrimaryImage()) {
//    echo get_class();
//    echo rt_thumbnail($snippets->get(0), $width, $height);


//    echo $snippets->get(0)->getPrimaryImage()->getWebPath();

    echo rtAssetToolkit::getThumbnailPath($snippets->get(0)->getPrimaryImage()->getSystemPath(), array('maxHeight' => $width, 'maxWidth' => $height));
} else {
    echo 'asd';
}
