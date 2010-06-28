<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    symfony
 * @subpackage plugin
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardValidatorUser.class.php 25546 2009-12-17 23:27:55Z Jonathan.Wage $
 */
class rtAddressValidator extends sfValidatorBase
{
  public function configure($options = array(), $messages = array())
  {

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
