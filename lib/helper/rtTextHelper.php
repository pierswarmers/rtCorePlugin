<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtTextHelper defines some base helpers.
 *
 * @package    gumnut
 * @subpackage helper
 * @author     Piers Warmers <piers@wranglers.com.au>
 */

/**
 * Converts a mardown string into HTML
 *
 * @see rtMarkdown::toHTML()
 * @param strinf $text
 * @return string
 */
function markdown_to_html($text, $object = null, $summary = false)
{
  if(!is_null($object))
  {
    if($summary)
    {
      $sections = explode(sfConfig::get('app_rt_content_section_delimiter', '////'), $text);

      if(isset($sections[0]))
      {
        $text = $sections[0];
      }
    }
    else
    {
      $text = str_replace(sfConfig::get('app_rt_content_section_delimiter', '////'), '', $text);
    }

    rt_text_helper_object($object);

    if(sfConfig::get('app_rt_text_support_latex_enabled', true))
    {
      $text = rtCodeCogsToolkit::transform($text);
    }
    else
    {
      $text = rtMathPublisherToolkit::transform($text);
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

//  $text = sfGeshi::parse_mixed(html_entity_decode($text, ENT_QUOTES));
//
//  $md_parser = new MarkdownExtra_Parser();
//
//  $text = $md_parser->transform($text);
//  return $text;

  return rtMarkdownToolkit::transformBase($text);
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
  $resize_to = array('maxHeight' => sfConfig::get('app_rt_asset_max_height', 600), 'maxWidth' => sfConfig::get('app_rt_asset_max_width',590));

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
  
  $asset = rt_text_helper_object()->getAssetByName($matches[2]);
  
  if($asset && $asset->isImage())
  {
    if(isset($matches[4]) && isset($matches[5]))
    {
      $resize_to = array('maxWidth' => $matches[4], 'maxHeight' => $matches[5]);
    }
    return image_tag(
      rtAssetToolkit::getThumbnailPath($asset->getSystemPath(), $resize_to),
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
  $asset = rt_text_helper_object()->getAssetByName($matches[2]);
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
//  img_preview: { max_width: 800, max_height: 500 }
//  img_full: { max_width: 800, max_height: 500 }
//  javascripts: [/myCustomPlugin/js/gallery.js]
//  stylesheets: [/myCustomPlugin/css/gallery.css]

  $config = sfConfig::get('app_rt_gallery');
  
  if(!isset($config['javascripts']))
  {
    $config['javascripts'] = array(
        '/rtCorePlugin/vendor/jquery/js/jquery.min.js',
        '/rtCorePlugin/js/gallery.js'
    );
  }

  foreach ($config['javascripts'] as $file)
  {
    use_javascript($file);
  }

  if(!isset($config['stylesheets']))
  {
    $config['stylesheets'] = array(
        '/rtCorePlugin/css/gallery.css'
    );
  }

  foreach ($config['stylesheets'] as $file)
  {
    use_stylesheet($file);
  }

  $string = '';
  $rand = rand();
  
  $assets = rt_text_helper_object()->getAssets();

  if(isset($matches[2]))
  {
    $asset_names = explode(',', $matches[2]);
    $assets = array();

    foreach($asset_names as $name)
    {
      $asset = rt_text_helper_object()->getAssetByName($name);
      if($asset)
      {
        $assets[] = $asset;
      }
    }
  }

  if(count($assets) > 0)
  {
    $rand = rand();

    $string .= '<ul class="rt-gallery">'."\n";
    foreach($assets as $asset)
    {
      
      if($asset->isImage())
      {
        $img_preview_height = isset($config['img_preview']['max_height']) ? $config['img_preview']['max_height'] : 100;
        $img_preview_height_width = isset($config['img_preview']['max_width']) ? $config['img_preview']['max_width'] : 400;

        $img_full_height = isset($config['img_full']['max_height']) ? $config['img_full']['max_height'] : 800;
        $img_full_height_width = isset($config['img_full']['max_width']) ? $config['img_full']['max_width'] : 1000;

        
        $thumb_location_web = rtAssetToolkit::getThumbnailPath($asset->getSystemPath(), array('maxHeight' => $img_preview_height, 'maxWidth' => $img_preview_height_width));
        $thumb_location_sys = sfConfig::get('sf_web_dir') . $thumb_location_web;

        $image_data = getimagesize($thumb_location_sys);

//        $offset_left = ($image_data[0]/2+10-$image_data[0])/2;
//        $offset_top = ($image_data[1]/2+10-$image_data[1])/2;

        $title = $asset->getTitle() ? $asset->getTitle() : '';
        
        $resize_to = array('maxHeight' => $img_full_height, 'maxWidth' => $img_full_height_width);
        $string .= '<li><a href="'. rtAssetToolkit::getThumbnailPath($asset->getSystemPath(), $resize_to) .'" title="'.$title.'" rel="gallery-group-' . $rand . '">' . image_tag($thumb_location_web, array('alt' => $title)) . '</a></li>' . "\n";
      }
    }
    $string .= "</ul>\n";

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

  $assets = rt_text_helper_object()->getAssets();

  if(isset($matches[2]))
  {
    $asset_names = explode(',', $matches[2]);
    $assets = array();

    foreach($asset_names as $name)
    {
      $asset = rt_text_helper_object()->getAssetByName($name);
      if($asset)
      {
        $assets[] = $asset;
      }
    }
  }

  if(count($assets) > 0)
  {
    $string .= '<ul class="rt-docs-listing">';
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

function rt_text_helper_object($object = false) {
    static $object_store = null;
    if ($object) {
        $object_store = $object;
    }
    return $object_store;
}
