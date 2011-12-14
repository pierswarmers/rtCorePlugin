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
 * rtSiteNavigator provides a generic navigation object to work with
 * heirachical data.
 *
 * @package    rtCorePlugin
 * @subpackage navigation
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtNavigation
{
  private $root = null;
  private $active = null;
  private $options = array();
  public static $tree = null;
  public static $hash = null;

  protected abstract function buildNavigation();

  public function __construct($root, $active, $options = array())
  {
    $this->root = $root;
    $this->active = $active;
    $this->options = $options;
  }

  public function traverse(&$tree)
  {
    foreach($tree as $pos => &$node)
    {
      if( isset($node['children']) && count($node['children']) )
        $this->traverse($node['children']);

      if($node['lft'] < $this->active['lft'] && $node['rgt'] > $this->active['rgt'])
      {
        $node['ancestor'] = true;
        foreach($tree as $pos => &$peer)
        {
          if($peer != $node)
          {
            $peer['ancestor-peer'] = true;
          }
        }
      }
    }
  }
}
?>
