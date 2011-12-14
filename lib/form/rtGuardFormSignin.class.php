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
 * rtAssetUploadForm handles the asset attachment form used in the admin area.
 *
 * @package    rtCorePlugin
 * @subpackage form
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtGuardFormSignin extends sfGuardFormSignin
{
  public function setup()
  {
    parent::setup();

    $this->getWidgetSchema()->setFormFormatterName(sfConfig::get('app_rt_public_form_formatter_name', 'RtList'));

    $this->widgetSchema['username']->setLabel('Your email address');
    $this->widgetSchema['password']->setLabel('Your password');
    
    $this->widgetSchema->setHelp('remember', 'Not for use on public or shared computers');

    if (sfConfig::get('app_sf_guard_plugin_allow_login_with_email', true))
    {
//      $this->widgetSchema->setHelp( 'username',   'Eg: jenny@example.com or jenny123');
    }
  }
}
?>
