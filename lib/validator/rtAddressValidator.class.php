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
 * rtAddressValidator
 *
 * @package    rtCorePlugin
 * @subpackage validator
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtAddressValidator extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->addOption('use_names', false);
    $this->addOption('is_optional', true);
    $not_blank = array('address_1', 'town', 'country', 'postcode');
    if($options['use_names'])
    {
      $not_blank = array_merge($not_blank, array('first_name', 'last_name'));
    }
    $this->addOption('not_blank', $not_blank);
  }

  protected function doClean($values)
  {
    $errorSchema = new sfValidatorErrorSchema($this);

    if($this->getOption('is_optional'))
    {
      foreach ($this->getOption('not_blank') as $key => $value)
      {
        if(!$this->isEmpty($values[$value]))
        {
          $this->validate($errorSchema, $values);
          break;
        }
      }
    }
    else
    {
      $this->validate($errorSchema, $values);
    }

    if(count($errorSchema))
    {
      throw new sfValidatorErrorSchema($this, $errorSchema);
    }

    return $values;
  }

  /**
   * Run validation check.
   *
   * @param sfValidatorErrorSchema $errorSchema
   * @param array $values
   */
  private function validate($errorSchema, $values)
  {
    if($this->isEmpty($values['address_1']))
    {
      $errorSchema->addError(new sfValidatorError($this, 'required'), 'address_1');
    }
    if($this->isEmpty($values['town']))
    {
      $errorSchema->addError(new sfValidatorError($this, 'required'), 'town');
    }
    // Not all countries have regions, so this validator is conditional.
    $widget = new rtWidgetFormSelectRegion(array('country' => $values['country']));
    if(count($widget->getRegions()) > 0 && $this->isEmpty($values['state']))
    {
      $errorSchema->addError(new sfValidatorError($this, 'required'), 'state');
    }
    if($this->isEmpty($values['country']))
    {
      $errorSchema->addError(new sfValidatorError($this, 'required'), 'country');
    }
    if($this->isEmpty($values['postcode']))
    {
      $errorSchema->addError(new sfValidatorError($this, 'required'), 'postcode');
    }
    if(!sfConfig::get('app_rt_account_phone_is_optional', true) && $this->isEmpty($values['phone']))
    {
      $errorSchema->addError(new sfValidatorError($this, 'required'), 'phone');
    }

    if($this->getOption('use_names'))
    {
      if($this->isEmpty($values['first_name']))
      {
        $errorSchema->addError(new sfValidatorError($this, 'required'), 'first_name');
      }
      if($this->isEmpty($values['last_name']))
      {
        $errorSchema->addError(new sfValidatorError($this, 'required'), 'last_name');
      }
    }
  }
}