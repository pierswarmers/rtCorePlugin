<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

require(dirname(__FILE__)."/../vendor/mathpublisher/mathpublisher.class.php");

/**
 * gnCodeCogsToolkit uses the Code Cogs <http://www.codecogs.com/> rendering system to provide
 * true Latex math support.
 *
 * @package    gumnut
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnCodeCogsToolkit
{
  /**
   * Return a string, after replacing Latex math sections with n image equivelant.
   *
   * @param   string  $text
   * @return  string
   */
  static public function transform($text)
  {
    $regs = array();
    $text = preg_replace_callback('/\[math\](.*?)\[\/math\]/i', array('self', 'returnImage'), $text);
    return $text;
  }

  static public function returnImage($matches)
  {
    $formula = $matches[1];
    $dir = self::getCacheDir();
    $filename = sprintf('%s.png', md5($formula));   
    $base_uri = sfConfig::get('app_gn_math_codecogs_uri', 'http://latex.codecogs.com/png.latex?');
    $full_uri = $base_uri.htmlspecialchars($formula);

    // TODO: file_get_contents() used in the cache logic below encodes in a format not supported by the CodeCogs renderer.
    return sprintf('<img alt="%s" src="%s" />', $formula, $full_uri);

    if(!file_exists($dir. DIRECTORY_SEPARATOR . $filename))
    {
      $base_uri = sfConfig::get('app_gn_math_codecogs_uri', 'http://latex.codecogs.com/png.latex?');
      $rendered_image = file_get_contents($full_uri);
      if($rendered_image)
      {
        file_put_contents($dir.DIRECTORY_SEPARATOR.$filename, $rendered_image);
      }
      else
      {
        // if image rendering failed, gracefully return a blank string.
        return '';
      }
    }
    
    $web_path = sfConfig::get('app_gn_math_cache_dir', '/_math_cache') . '/' . $filename;
    return sprintf('<img alt="%s" src="%s" />', $formula, $web_path);
  }

  static private function getCacheDir()
  {
    $dir  = sfConfig::get('app_gn_math_cache_dir', '/_math_cache');

    if(!is_dir(sfConfig::get('sf_web_dir') . $dir))
    {
      gnAssetToolkit::makeDir(sfConfig::get('sf_web_dir') . $dir);
    }
    
    return sfConfig::get('sf_web_dir') . $dir;
  }
}