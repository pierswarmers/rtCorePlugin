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
 */
class rtAddressValidator extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {
    $this->addOption('use_names', false);
  }

  protected function doClean($values)
  {
    $errorSchema = new sfValidatorErrorSchema($this);

    if (!$this->isEmpty($values['address_1']))
    {
      // Run check on all required fields.
      if($this->isEmpty($values['town']))
      {
        $errorSchema->addError(new sfValidatorError($this, 'required'), 'town');
      }
      if(($values['country'] == 'AU' || $values['country'] == 'US') && $this->isEmpty($values['state']))
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
      if($this->getOption('use_names', false))
      {
        if($this->isEmpty($values['first_name']))
        {
          $errorSchema->addError(new sfValidatorError($this, 'required'), 'first_name');
        }
        if($this->isEmpty($values['last_name']))
        {
          $errorSchema->addError(new sfValidatorError($this, 'required'), 'first_name');
        }
      }
    }
    else
    {
      unset($values['address_1']);
    }

    if (count($errorSchema))
    {
      throw new sfValidatorErrorSchema($this, $errorSchema);
    }
    
    return $values;
  }
}
