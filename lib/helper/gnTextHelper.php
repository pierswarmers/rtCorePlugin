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
 * @param strinf $markdown
 * @return string
 */
function markdown_to_html($markdown, $object = null)
{
  if(!is_null($object))
  {
    gn_text_helper_object($object);

    global $object;
    $patterns = array(
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
      //$markdown = preg_replace($pattern, "replaceImagesInText(\$array,$1,\$foo)", $markdown);
      $markdown =  preg_replace_callback($pattern, $user_func, $markdown);
    }

  }

  return gnMarkdownToolkit::toHTML($markdown);
}

function markup_images_in_text($matches)
{
  $class = isset($matches[3]) ? $matches[3] : '';
  $asset = gn_text_helper_object()->getAssetByName($matches[2]);
  if($asset)
  {
    return image_tag($asset->getWebPath(), array('class' => $class, 'alt' => $matches[1]));
  }
  return '<small class="asst-link-error">[[asset:' . $matches[2] . ']]?</small>';
}

function markup_links_in_text($matches)
{
  $asset = gn_text_helper_object()->getAssetByName($matches[2]);
  if($asset)
  {
    return link_to1($matches[1], $asset->getWebPath());
  }
  return '<small class="asst-link-error">[[asset:' . $matches[2] . ']]?</small>';
}

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

    $string .= '<div class="clearfix">'."\n".'<a class="prevPage browse left"></a>' . "\n";
    $string .= '<div id="gnGalleryScrollable'.$rand.'" class="scrollable">'."\n".'<div id="gnGalleryScrollableTriggers'.$rand.'" class="items">' . "\n";
    foreach($assets as $asset)
    {
      if($asset->isImage())
      {
        $string .= link_to1(image_tag(gnAssetToolkit::getThumbnailPath($asset->getSystemPath(), array('maxHeight' => 100, 'maxWidth' => 400))), $asset->getWebPath())  . "\n";
      }
    }
    $string .= "</div>\n";
    $string .= "</div>\n";
    $string .= '<a class="nextPage browse right"></a>'."\n";
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
      $("#gnGalleryScrollable$rand").scrollable({size:4})

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
