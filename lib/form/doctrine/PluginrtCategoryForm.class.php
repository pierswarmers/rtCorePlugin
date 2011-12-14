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
 * PluginrtCategoryForm
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
abstract class PluginrtCategoryForm extends BasertCategoryForm
{
  public function setup()
  {
    parent::setup();

    unset($this['created_at'], 
          $this['updated_at']);
    
    // Validators
    $this->setValidator('title', new sfValidatorString(array('max_length' => 255, 'required' => true), array('required' => 'Please enter a descriptive title.')));
        
  }  
}