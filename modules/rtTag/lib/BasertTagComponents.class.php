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
 * BasertTagComponents
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class BasertTagComponents extends sfComponents
{
  public function executeCloud(sfWebRequest $request)
  {
    $limit = 50;
    if($this->getVar('options'))
    {
      $options = $this->getVar('options');
      $limit = $options['limit'];
    }

    $tags = PluginTagTable::getPopulars(null,array('limit' => $limit));

    $this->tags = $tags;
  }
}