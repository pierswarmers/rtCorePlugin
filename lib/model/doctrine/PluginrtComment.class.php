<?php
/*
 * This file is part of the reditype package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * PluginrtComment
 *
 * @package    reditype
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
abstract class PluginrtComment extends BasertComment
{
  public function __toString() 
  {
    $string = strip_tags($this->getContent());

    $mbstring = extension_loaded('mbstring');
    if($mbstring)
    {
     @mb_internal_encoding(mb_detect_encoding($string));
    }

    $substr = ($mbstring) ? 'mb_substr' : 'substr';

    $truncate_text = $substr($string, 0, 100);
    
    return $truncate_text . '... [' . strip_tags($this->getAuthorName()) . ']' ;
  }
  
  public function getTypeNice()
  {
    return 'Comment';
  }

  /**
   * Retrieve the attached parent object.
   *
   * @return Doctrine_Record returns the parent object
   */
  public function getObject()
  {
    $object = Doctrine::getTable($this->getModel())->findOneById($this->getModelId());

    return $object;
  }
}