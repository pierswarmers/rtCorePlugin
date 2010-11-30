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
 * BasertSearchForm
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertSearchForm extends BaseForm
{
  public function setup()
  {
    $this->widgetSchema['q'] = new sfWidgetFormInput();
    $this->validatorSchema['q'] = new sfValidatorString();
    $this->widgetSchema->setLabel('q','Enter some keywords');
    $this->widgetSchema->setNameFormat('%s');
  }
}