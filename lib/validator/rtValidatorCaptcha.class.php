<?php

/*
 * This file is part of the rtShopPlugin package.
 *
 * (c) 2006-2011 digital Wranglers <steercms@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtValidatorCaptcha
 *
 * @package    rtCorePlugin
 * @subpackage validators
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtValidatorCaptcha extends sfValidatorBase
{
  /**
   * Configures the current validator
   *
   * Available options:
   *
   *  * invalid:   Error message
   * 
   * @param array $options
   * @param array $messages
   */
  protected function configure($options = array(), $messages = array())
  {
  }

  /**
   * Validate response
   * 
   * @param string $value
   * @return string
   */
  protected function doClean($value)
  {
    $clean = (string) $value;

    $passphrase = sfContext::getInstance()->getUser()->getAttribute('rt_captcha_passphrase');
    $passphrase = explode(',', $passphrase);

    if (!in_array(strtolower($value), $passphrase))
    {
      throw new sfValidatorError($this, 'invalid', array('value' => $value, 'invalid' => $this->getOption('invalid')));
    }

    return $clean;
  }
}