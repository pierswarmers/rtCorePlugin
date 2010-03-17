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
 * gnMathPublisherToolkit implemets the PhpMathPublisher library.
 *
 * @package    gumnut
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnMathPublisherToolkit
{
  /**
   * Return a string, after replacing Latex math sections with n image equivelant.
   *
   * @param   string  $text
   * @return  string
   */
  static public function transform($text)
  {
    if(trim($text) === '')
    {
      return $text;
    }
    
    // relative from the sf_web_root
    $dir  = sfConfig::get('app_gn_math_cache_dir', '/_math_cache');
    $size = sfConfig::get('app_gn_math_mathpublisher_size', 14);

    if(!is_dir(sfConfig::get('sf_web_dir') . $dir))
    {
      gnAssetToolkit::makeDir(sfConfig::get('sf_web_dir') . $dir);
    }

    $dir = $dir . '/';

    try
    {
      $text = mathfilter($text,$size,$dir);
    }
    catch(Exception $e)
    {
      // eat the exception
    }
    return $text;
  }
}