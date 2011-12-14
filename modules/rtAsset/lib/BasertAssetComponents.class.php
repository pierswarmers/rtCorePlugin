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
 * BasertAssetComponents
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertAssetComponents extends sfComponents
{
  public function executeForm()
  {
    $this->form = new rtAssetUploadForm();
  }
  
  public function executePrimary()
  {
    
  }
}