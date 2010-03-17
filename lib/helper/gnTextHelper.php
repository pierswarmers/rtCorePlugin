<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnTextHelper defines some base helpers.
 *
 * @package    gumnut
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 */

/**
 * Converts a mardown string into HTML
 *
 * @see gnMarkdown::toHTML()
 * @param strinf $text
 * @return string
 */
function markdown_to_html($text, $object = null)
{
  if(!is_null($object))
  {
    gn_text_helper_object($object);

    if(sfConfig::get('app_gn_text_support_latex_enabled', true))
    {
      $text = gnCodeCogsToolkit::transform($text);
    }
    else
    {
      $text = gnMathPublisherToolkit::transform($text);
    }
    
    $patterns = array(
    '/!\[(\w.+)\]\(asset:([A-Za-z0-9.\-_]+)\|([a-zA-Z0-9_-]+)\|([0-9]+),([0-9]+)\)/i' => 'markup_images_in_text',
    '/!\[(\w.+)\]\(asset:([A-Za-z0-9.\-_]+)\|([0-9]+),([0-9]+)\)/i' => 'markup_images_in_text',
    '/!\[(\w.+)\]\(asset:([A-Za-z0-9.\-_]+)\|([a-zA-Z0-9_-]+)\)/i' => 'markup_images_in_text',
    '/!\[(\w.+)\]\(asset:([A-Za-z0-9.\-_]+)\)/i' => 'markup_images_in_text',
    '/\[(\w.+)\]\(asset:([A-Za-z0-9.\-_]+)\)/i' => 'markup_links_in_text',
    '/\[gallery\]/i' => 'markup_galleries_in_text',
    '/\[(gallery):([A-Za-z0-9.\-_,]+)\]/i' => 'markup_galleries_in_text',
    '/\[docs\]/i' => 'markup_docs_in_text',
    '/\[(docs):([A-Za-z0-9.\-_,]+)\]/i' => 'markup_docs_in_text'
    );

    foreach($patterns as $pattern => $user_func)
    {
      $text =  preg_replace_callback($pattern, $user_func, $text);
    }

  }

  return gnMarkdownToolkit::transformBase($text);
}

/**
 * Replace occurances of markdown image tag with html image tag pointing at attached asset.
 *
 * @param array $matches
 * @return string
 */
function markup_images_in_text($matches)
{
  $class = '';
  $resize_to = array('maxHeight' => sfConfig::get('app_gn_asset_inline_height', 600), 'maxWidth' => sfConfig::get('app_gn_asset_inline_width',590));

  if(count($matches) == 6)
  {
    // we have class and dimensions.
    $class = $matches[3];
    $resize_to = array('maxWidth' => $matches[4], 'maxHeight' => $matches[5]);
  }
  elseif(count($matches) == 5)
  {
    // we have dimensions
    $resize_to = array('maxWidth' => $matches[3], 'maxHeight' => $matches[4]);
  }
  elseif(count($matches) == 4)
  {
    // we have class only
    $class = $matches[3];
  }
  
  $asset = gn_text_helper_object()->getAssetByName($matches[2]);
  
  if($asset && $asset->isImage())
  {
    if(isset($matches[4]) && isset($matches[5]))
    {
      $resize_to = array('maxWidth' => $matches[4], 'maxHeight' => $matches[5]);
    }
    return image_tag(
      gnAssetToolkit::getThumbnailPath($asset->getSystemPath(), $resize_to),
      array('class' => $class, 'alt' => $matches[1])
    );
  }
  return '<small class="asst-link-error">[asset:' . $matches[2] . ']?</small>';
}

/**
 * Replace occurances of markdown link tag with html link tag pointing at attached asset.
 *
 * @param array $matches
 * @return string
 */
function markup_links_in_text($matches)
{
  $asset = gn_text_helper_object()->getAssetByName($matches[2]);
  if($asset)
  {
    return link_to1($matches[1], $asset->getWebPath());
  }
  return '<small class="asst-link-error">[asset:' . $matches[2] . ']?</small>';
}

/**
 * Replace occurances of gallery tag with list of attached assets.
 *
 * @param array $matches
 * @return string
 */
function markup_galleries_in_text($matches)
{
  $string = '';

  $assets = gn_text_helper_object()->getAssets();

  if(isset($matches[2]))
  {
    $asset_names = explode(',', $matches[2]);
    $assets = array();

    foreach($asset_names as $name)
    {
      $asset = gn_text_helper_object()->getAssetByName($name);
      if($asset)
      {
        $assets[] = $asset;
      }
    }
  }

  if(count($assets) > 0)
  {
    use_javascript('/gnCorePlugin/vendor/jquery/js/jquery-1.4.2.min.js');
    use_javascript('/gnCorePlugin/vendor/jquery/js/jquery.tools.min.js', 'last');
    use_stylesheet('/gnCorePlugin/vendor/jquery/css/tools/jquery.tools.css');
    $rand = rand();

    $string .= '<div class="clearfix"></div><div class="clearfix gn-inline-panel">'."\n".'<a class="prevPage browse left"></a>' . "\n";
    $string .= '<div id="gnGalleryScrollable'.$rand.'" class="scrollable">'."\n".'<div id="gnGalleryScrollableTriggers'.$rand.'" class="items">' . "\n";
    foreach($assets as $asset)
    {
      
      if($asset->isImage())
      {
        $title = $asset->getTitle() ? $asset->getTitle() : $asset->getOriginalFilename();
        $resize_to = array('maxHeight' => sfConfig::get('app_gn_asset_lightbox_expanded_height', 600), 'maxWidth' => sfConfig::get('app_gn_asset_lightbox_expanded_width',800));
        $string .= '<a href="'. gnAssetToolkit::getThumbnailPath($asset->getSystemPath(), $resize_to) .'" title="'.$title.'">' . image_tag(gnAssetToolkit::getThumbnailPath($asset->getSystemPath(), array('maxHeight' => 100, 'maxWidth' => 400)), array('alt' => $title)) . '</a>' . "\n";
      }
    }
    $string .= "</div>\n";
    $string .= "</div>\n";
    $string .= '<a class="nextPage browse right"></a>'."\n";
    $string .= "<div class=\"navi\"></div>\n";
    $string .= "</div>\n";

    $string .= <<<EOS
<div class="simple_overlay" id="gnGallery$rand">
    <a class="prev">prev</a>
    <a class="next">next</a>
    <div class="info"></div>
    <div class="progress"></div>
</div>

<script type="text/javascript">
  $(function() {
      $("#gnGalleryScrollable$rand").scrollable({size:4, keyboard:false}).mousewheel();

  $("#gnGalleryScrollableTriggers$rand a").overlay({
      target: '#gnGallery$rand',
      expose: '#f1f1f1'
  }).gallery({
      speed: 800
  });
  });
</script>
EOS;
  }

  return $string;
}

/**
 * Replace occurances of docs tag with list of attached assets.
 *
 * @param array $matches
 * @return string
 */
function markup_docs_in_text($matches)
{
  $string = '';

  $assets = gn_text_helper_object()->getAssets();

  if(isset($matches[2]))
  {
    $asset_names = explode(',', $matches[2]);
    $assets = array();

    foreach($asset_names as $name)
    {
      $asset = gn_text_helper_object()->getAssetByName($name);
      if($asset)
      {
        $assets[] = $asset;
      }
    }
  }

  if(count($assets) > 0)
  {
    $string .= '<ul class="gn-docs-listing">';
    foreach($assets as $asset)
    {
      if(!$asset->isImage())
      {
        $string .= '<li>'.link_to1($asset->getOriginalFilename(),$asset->getWebPath()).'</li>';
      }
    }
    $string .= '</ul>';
  }

  return $string;
}

function gn_text_helper_object($object = false) {
    static $object_store = null;
    if ($object) {
        $object_store = $object;
    }
    return $object_store;
}
