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
 * BasertAdminActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertAdminActions extends sfActions
{
  public function executeClearCache(sfWebRequest $request)
  {
    $sf_root_cache_dir = sfConfig::get('sf_cache_dir');
    rtAssetToolkit::recursiveDelete($sf_root_cache_dir. DIRECTORY_SEPARATOR .'frontend');
    $this->redirect($request->getReferer());
  }
  
  public function executeStateInput(sfWebRequest $request)
  {
    sfConfig::set('sf_debug', false);

    $this->id      = $request->getParameter('id');
    $this->name    = $request->getParameter('name');
    $this->country = $request->getParameter('country');

    $widget = new rtWidgetFormSelectRegion(array('add_empty' => '--', 'country' => $this->country));
    $this->options = $widget->getRegions();
  }
}