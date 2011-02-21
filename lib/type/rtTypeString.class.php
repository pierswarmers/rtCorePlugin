<?php
/*
 * This file is part of the Reditype package.
 *
 * (c) 2009-2010 digital Wranglers <info@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtTypeString provides an object for handling enhanced string in Reditype. Typically
 * these strings require additional formatting using Markdown etc...
 *
 * Example:
 * <code>
 * # Create an rtTypeString instance and echo it's markdown encoded value
 * $string = new rtTypeString("Some text...");
 * echo $string->transform();
 * </code>
 * 
 * @package    rtCorePlugin
 * @subpackage type
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtTypeString 
{
  /**
   * @var string
   */
  private $_string;
  
  /**
   * @var array
   */
  private $_options = array();
  
  /**
   * Requires the string to be instanciated
   * 
   * @param type $string 
   */
  public function __construct($string, $options = array()) 
  {
    $this->_string = $string;
    $this->_options['object']           = key_exists('object', $options) ? $options['object'] : false;
    $this->_options['section']          = key_exists('section', $options) ? $options['section'] : 'all';
    
    if(!in_array($this->_options['section'], array('all', 'head', 'body')))
    {
      throw new sfException('Unknown section '.$this->_options['section'].', must be one of: all, head, body');
    }
    
    $this->_options['convert_entities'] = key_exists('convert_entities', $options) ? $options['convert_entities'] : false;
  }
  
  /**
   * Returns the original string
   * 
   * @return string
   */
  public function __toString() 
  {
    return $this->transform();
  }
  
  /**
   * Currently this method acts as a proxy to self::transformMarkdown()
   * 
   * @todo Enhance to provide configarable transform type support
   * @see self::transformMarkdown()
   * @return string
   */
  public function transform()
  {
    $string = $this->getSection($this->_string, $this->_options['section']);
    
    $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');
    
    if($this->_options['convert_entities'])
    {
      $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
    }
    
    $string = $this->transformExtendedMarkdown($string);
    $string = $this->transformMarkdown($string);
    $string = $this->transformGeshi($string);

    return $string;
  }
  
  /**
   * Returns the appropriate section of the text block.
   * 
   * @param string $string 
   * @return string
   */
  protected function getSection($string, $section = 'all')
  {
    if($section === 'all' || ($section !== 'head' && $section !== 'body'))
    {
      return str_replace(sfConfig::get('app_rt_content_section_delimiter', '////'), '', $string);;
    }
    
    $sections = explode(sfConfig::get('app_rt_content_section_delimiter', '////'), $string);
    
    if($section === 'head')
    {
      return $sections[0];
    }
    elseif($section === 'body' && isset($section[1]))
    {
      return $sections[1];
    }
    else
    {
      return implode($sections);
    }
  }
  
  /**
   * Returns a string, encoded with Markdown Extra and SmartyPants Typographer.
   * 
   * @see http://michelf.com/projects/php-markdown/extra/
   * @see http://michelf.com/projects/php-smartypants/typographer/
   * @param string $string
   * @return string
   */
  protected function transformMarkdown($string)
  {
		require_once(dirname(__FILE__).'/../vendor/markdown/markdown.php');
		require_once(dirname(__FILE__).'/../vendor/smartypants/smartypants.php');
    
    $lines  = explode("\n", $string);
    $incode = false;
    $string = '';
    
    foreach ($lines as $line)
    {
      if ($incode)
      {
        $line = '    '.html_entity_decode($line, ENT_QUOTES, 'UTF-8');
      }
      if (preg_match('/^\s*\[code\s*([^\]]*?)\]/', $line, $match))
      {
        $incode = true;
        $line   = $match[1] ? "\n\n    [".$match[1]."]" : "\n\n";
      }
      if (strpos($line, '[/code]') !== false)
      {
        $incode = false;
        $line   = ' ';
      }

      $string .= $line."\n";
    }
    
    $string = Markdown($string);
    $string = SmartyPants($string);
    
    return $string;
  }
  
  /**
   * Returns a string, encoded with Markdown Extra and SmartyPants Typographer.
   * 
   * @see http://michelf.com/projects/php-markdown/extra/
   * @see http://michelf.com/projects/php-smartypants/typographer/
   * @param string $string
   * @return string
   */
  protected function transformGeshi($string)
  {
		require_once(sfConfig::get('sf_plugins_dir').'/sfGeshiPlugin/lib/sfGeshi.class.php');
    
    $string = preg_replace('/<pre><code>\$ /s', '<pre class="command-line"><code>$ ', $string);
    $string = preg_replace('#<pre><code>http\://#s', '<pre class="url"><code>http://', $string);
    $string = preg_replace_callback('#<pre><code>(.+?)</code></pre>#s', array($this, 'transformGeshiBlock'), $string);
    $string = str_replace('&nbsp;</pre>', '</pre>', $string);
    
    return $string;
  }
  
  /**
   * Transforms a given block into HTML using Geshi syntax highlighting.
   * 
   * @param string $string
   * @return string
   */
  protected function transformGeshiBlock($matches, $default = '')
  {
    if (preg_match('/^\[(.+?)\]\s*(.+)$/s', $matches[1], $match))
    {
      return sfGeshi::parse_single(html_entity_decode($match[2]), $match[1]);
    }
    
    if ($default)
    {
      $geshi = new sfGeshi(html_entity_decode($matches[1]), $default);
      $geshi->enable_classes();

      return $geshi->parse_code();
    }
    
    return "<pre><code>".$matches[1].'</pre></code>';
  }
  
  /**
   * Return the string with appropriate markup for asset linking.
   * 
   * @param string $string
   * @return string
   */
  protected function transformExtendedMarkdown($string)
  {
    if(!$this->_options['object'])
    {
      return $string;
    }
    
    $patterns = array(
      '/!\[(\w.+)\]\(snippet:([A-Za-z0-9.\-_]+)\)/i'                                    => '_markupSnippetInText',
      '/!\[(\w.+)\]\(asset:([A-Za-z0-9.\-_]+).swf\|([0-9]+),([0-9]+)\)/i'               => '_markupSwfInText',
      '/!\[(\w.+)\]\(asset:([A-Za-z0-9.\-_]+).html\)/i'                                 => '_markupHtmlInText',
      '/!\[(\w.+)\]\(asset:([A-Za-z0-9.\-_]+)\|([a-zA-Z0-9_-]+)\|([0-9]+),([0-9]+)\)/i' => '_markupImagesInText',
      '/!\[(\w.+)\]\(asset:([A-Za-z0-9.\-_]+)\|([0-9]+),([0-9]+)\)/i'                   => '_markupImagesInText',
      '/!\[(\w.+)\]\(asset:([A-Za-z0-9.\-_]+)\|([a-zA-Z0-9_-]+)\)/i'                    => '_markupImagesInText',
      '/!\[(\w.+)\]\(asset:([A-Za-z0-9.\-_]+)\)/i'                                      => '_markupImagesInText',
      '/\[(\w.+)\]\(asset:([A-Za-z0-9.\-_]+)\)/i'                                       => '_markupAssetLinksInText',
      '/\[(\w.+)\]\(([A-Za-z0-9:\=?&\/.\-_]+)\)/i'                                      => '_markupBasicLinksInText',
      '/\[gallery\]/i'                                                                  => '_markupGalleriesInText',
      '/\[(gallery):([A-Za-z0-9.\-_,]+)\]/i'                                            => '_markupGalleriesInText',
      '/\[docs\]/i'                                                                     => '_markupDocsInText',
      '/\[(docs):([A-Za-z0-9.\-_,]+)\]/i'                                               => '_markupDocsInText',
      '/!\[([A-Za-z0-9 \-_]+)\]/i'                                                       => '_markupGenericsInText',
      '/\[\/\]/i'                                                                       => '_markupClosuresInText'
    );

    foreach($patterns as $pattern => $callback_function)
    {
      $string =  preg_replace_callback($pattern, array($this, $callback_function), $string);
    }
    
    return $string;
  }

  /**
   * Replace occurances of markdown swf tag with html swf embed tag pointing at attached asset.
   *
   * @param array $matches
   * @return string
   */
  protected function _markupSwfInText($matches)
  { 
    $alt = $matches[1];
    $filename = $matches[2] . '.swf';
    $width    = $matches[3];
    $height   = $matches[4];
    
    $asset = $this->_options['object']->getAssetByName($filename);
    
    if($asset && $asset->isSwf())
    {
      sfContext::getInstance()->getResponse()->addJavascript('/rtCorePlugin/vendor/swfobject/swfobject.js', 'last');
      
      $alt_asset = $this->_options['object']->getAssetByName($alt);
      
      if($alt_asset && $alt_asset->isImage())
      {
        $alt = image_tag(
          rtAssetToolkit::getThumbnailPath($alt_asset->getSystemPath(), array('maxHeight' => $height, 'maxWidth' => $width))
        );
      }
      
      $id = 'swfObject'.rand();
      $path = $asset->getWebPath();
      $string = sprintf('<div class="rt-flash-container" id="%s">%s</div>', $id, $alt);
      
      $string .= <<< EOS

<script type="text/javascript">
  swfobject.embedSWF("$path", "$id", "$width", "$height", "9.0.0");
</script>   
EOS;
      
      return $string;
    }

    return '<small class="asst-link-error">[asset:' . $filename . ']?</small>';
  }


  /**
   * Replace occurances of markdown swf tag with html swf embed tag pointing at attached asset.
   *
   * @param array $matches
   * @return string
   */
  protected function _markupHtmlInText($matches)
  {
    $filename = $matches[2] . '.html';

    $asset = $this->_options['object']->getAssetByName($filename);

    if($asset && strtolower($asset->getExtension()) == 'html')
    {
      return file_get_contents($asset->getSystemPath());
    }

    return '<small class="asst-link-error">[asset:' . $filename . ']?</small>';
  }


  /**
   * Replace occurances of markdown snippet includes with the snippet content.
   *
   * @param array $matches
   * @return string
   */
  protected function _markupSnippetInText($matches)
  {
    $collection = $matches[2];

    $snippet = Doctrine::getTable('rtSnippet')->findOneByCollection($collection);

    if(!$snippet)
    {
      return '<small class="asst-link-error">[snippet:' . $collection . ']?</small>';
    }

    // check for cicular references
    $o_collection = '';

    try
    {
      $o_collection = $this->_options['object']->getCollection();

      if($o_collection == $collection)
      {
        return 'Circular reference found!';
      }
    } catch (Exception $e)
    {
      // do nothing, just pass on.
    }

    $text = new rtTypeString($snippet->getContent(), array('object' => $snippet));

    return $text->transform();
  }
  
  /**
   * Replace occurances of markdown image tag with html image tag pointing at attached asset.
   *
   * @param array $matches
   * @return string
   */
  protected function _markupImagesInText($matches)
  {
    $class = '';
    $resize_to = array('maxHeight' => sfConfig::get('app_rt_asset_max_height', 600), 'maxWidth' => sfConfig::get('app_rt_asset_max_width',590));

    if(count($matches) == 6)
    {
      // we have both class and dimensions.
      $class = $matches[3];
      $resize_to = array('maxWidth' => $matches[4], 'maxHeight' => $matches[5]);
    }
    elseif(count($matches) == 5)
    {
      // we have dimensions only
      $resize_to = array('maxWidth' => $matches[3], 'maxHeight' => $matches[4]);
    }
    elseif(count($matches) == 4)
    {
      // we have a class only
      $class = $matches[3];
    }

    $asset = $this->_options['object']->getAssetByName($matches[2]);

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
  protected function _markupAssetLinksInText($matches)
  {
    $asset = $this->_options['object']->getAssetByName($matches[2]);
    if($asset)
    {
      return link_to1($matches[1], $asset->getWebPath());
    }
    return '<small class="asst-link-error">[asset:' . $matches[2] . ']?</small>';
  }

  /**
   * Replace occurances of markdown link tag with html link tag pointing at attached asset.
   *
   * @param array $matches
   * @return string
   */
  protected function _markupBasicLinksInText($matches)
  {
    return link_to1($matches[1], $matches[2]);
  }

  /**
   * Replace occurances of gallery tag with list of attached assets.
   *
   * @param array $matches
   * @return string
   */
  protected function _markupGalleriesInText($matches)
  {
    $config = sfConfig::get('app_rt_gallery');

    if(!isset($config['javascripts']))
    {
      $config['javascripts'] = array('/rtCorePlugin/vendor/jquery/js/jquery.min.js',
                                     '/rtCorePlugin/js/frontend-gallery.js');
    }

    foreach ($config['javascripts'] as $file)
    {
      use_javascript($file);
    }

    if(!isset($config['stylesheets']))
    {
      $config['stylesheets'] = array(
          '/rtCorePlugin/css/frontend-gallery.css'
      );
    }

    foreach ($config['stylesheets'] as $file)
    {
      use_stylesheet($file);
    }

    $string = '';
    $rand = rand();

    $assets = $this->_options['object']->getAssets();

    if(isset($matches[2]))
    {
      $asset_names = explode(',', $matches[2]);
      $assets = array();

      foreach($asset_names as $name)
      {
        $asset = $this->_options['object']->getAssetByName($name);
        if($asset)
        {
          $assets[] = $asset;
        }
      }
    }

    if(count($assets) > 0)
    {
      $rand = rand();

      $string .= '<div class="rt-gallery-holder"><ul class="rt-gallery">'."\n";
      foreach($assets as $asset)
      {

        if($asset->isImage())
        {
          $img_preview_height = isset($config['markdown_preview']['max_height']) ? $config['markdown_preview']['max_height'] : 100;
          $img_preview_width = isset($config['markdown_preview']['max_width']) ? $config['markdown_preview']['max_width'] : 400;

          $img_full_height = isset($config['markdown_full']['max_height']) ? $config['markdown_full']['max_height'] : 600;
          $img_full_width = isset($config['markdown_full']['max_width']) ? $config['markdown_full']['max_width'] : 1000;

          $thumb_location_web = rtAssetToolkit::getThumbnailPath($asset->getSystemPath(), array('maxHeight' => $img_preview_height, 'maxWidth' => $img_preview_width));
          $thumb_location_sys = sfConfig::get('sf_web_dir') . $thumb_location_web;

          $title = $asset->getTitle() ? $asset->getTitle() : '';

          $resize_to = array('maxHeight' => $img_full_height, 'maxWidth' => $img_full_width);

          $info = '';

          if(trim($asset->getTitle()) != '')
          {
            $info = sprintf('<h3>%s</h3>', $asset->getTitle());
          }

          if(trim($asset->getDescription()) != '')
          {
            $info .= rtMarkdownToolkit::transformBase($asset->getDescription());
          }

          $string .= sprintf(
                       '<li><a href="%s" title="%s" rel="gallery-group-%s">%s</a><div>%s</div></li>',
                       rtAssetToolkit::getThumbnailPath($asset->getSystemPath(), $resize_to),
                       $title,
                       $rand,
                       image_tag($thumb_location_web, array('alt' => $title)),
                       $info
                     );
        }
      }
      $string .= "</ul>\n</div>\n";

    }

    return $string;
  }

  /**
   * Replace occurances of generic tags with div tag with class set to match value.
   *
   * @param array $matches
   * @return string
   */
  protected function _markupGenericsInText($matches)
  {
    return sprintf('<div class="%s" markdown=1><div class="rt-generic-inner" markdown=1>', $matches[1]);
  }

  /**
   * Replace occurances of generic closure tags with div closing tag.
   *
   * @param array $matches
   * @return string
   */
  protected function _markupClosuresInText($matches)
  {
    return '</div></div>';
  }

  /**
   * Replace occurances of docs tag with list of attached assets.
   *
   * @param array $matches
   * @return string
   */
  protected function _markupDocsInText($matches)
  {
    $string = '';

    $assets = $this->_options['object']->getAssets();

    if(isset($matches[2]))
    {
      $asset_names = explode(',', $matches[2]);
      $assets = array();

      foreach($asset_names as $name)
      {
        $asset = $this->_options['object']->getAssetByName($name);
        if($asset)
        {
          $assets[] = $asset;
        }
      }
    }

    if(count($assets) > 0)
    {
      $string .= '<div class="rt-docs-holder"><ul class="rt-docs">';
      foreach($assets as $asset)
      {
        if($asset->isImage())
        {
          continue;
        }
        
        $title = trim($asset->getTitle()) !== '' ? $asset->getTitle() : $asset->getOriginalFilename();

        $description = '';
        
        if(trim($asset->getDescription()) !== '')
        {
          $description = rtMarkdownToolkit::transformBase($asset->getDescription());
        }
        $string .= sprintf(
                     '<li class="rt-docs-%s"><p class="rt-docs-title">%s%s</p>%s</li>',
                     $asset->getExtension(),
                     link_to($title,$asset->getWebPath()),
                     sprintf(' <span>(%s)</span>', rtAssetToolkit::getFormattedBytes($asset->getFilesize())),
                     $description
                   );
      }
      $string .= "\n</ul>\n</div>\n";
    }

    return $string;
  }
}