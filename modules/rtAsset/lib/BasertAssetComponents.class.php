<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasertSearchActions handles search functions.
 *
 * @package    gumnut
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