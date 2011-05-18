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
 * PluginrtAddressForm
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtAddressPublicForm extends rtAddressForm
{
  public function setup()
  {
    parent::setup();

    if($this->isAddressModeSimple())
    {
      unset($this['instructions']);
    }
  }

  /**
   * Is the form configured in
   *
   * @return bool
   */
  public function isAddressModeSimple()
  {
    return sfConfig::get('app_rt_account_address_is_simple', true);
  }
}
