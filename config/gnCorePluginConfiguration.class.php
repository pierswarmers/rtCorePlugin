<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnCorePluginConfiguration runs some initial configuration logic.
 *
 * @package    gnCore
 * @subpackage config
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnCorePluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {
    $this->setTemplateDir();
            
    if(sfConfig::get('sf_app') === 'frontend')
    {
      $this->runFrontendConfiguration();
    }
    else
    {
      $this->runBackendConfiguration();
    }

    // Set timezone for local app
    if(sfConfig::has('gn_default_timezone'))
    {
      sfConfig::set('sf_default_timezone', sfConfig::get('gn_default_timezone'));
    }
  }

  /**
   * Run frontend specific configuration logic.
   */
  private function runFrontendConfiguration()
  {
    $this->dispatcher->connect('routing.load_configuration', array($this, 'listenToRoutingLoadConfigurationFrontend'));
  }

  /**
   * Run backend specific configuration logic.
   */
  private function runBackendConfiguration()
  {

  }

  /**
   * Conditionally set the template directory. This can be disabled via configuration.
   */
  private function setTemplateDir()
  {
    if(sfConfig::get('app_gn_set_template_dir', true))
    {
      $template_dir = sfConfig::get('sf_plugins_dir').DIRECTORY_SEPARATOR.'gnCorePlugin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.sfConfig::get('sf_app');
      sfConfig::set('sf_app_template_dir', sfConfig::get('app_gn_template_dir', $template_dir));
    }
  }

  /**
   * Enable the required routes for frontend.
   *
   * @param sfEvent $event
   */
  public function listenToRoutingLoadConfigurationFrontend(sfEvent $event)
  {
    $routing = $event->getSubject();

    $routing->prependRoute('sf_guard_forgot_password', new sfRoute('/user/forgot_password', array('module' => 'gnGuardForgotPassword', 'action' => 'index')));
    $routing->prependRoute('sf_guard_forgot_password_change', new sfDoctrineRoute('/user/forgot_password/:unique_key', array(
      'module' => 'gnGuardForgotPassword',
      'action' => 'change'
    ), array(
      'sf_method' => array('get', 'post')
    ), array(
      'model' => 'sfGuardForgotPassword',
      'type' => 'object'
    )));
    $routing->prependRoute('sf_guard_register', new sfRoute('/user/register', array('module' => 'gnGuardRegister', 'action' => 'index')));
    $routing->prependRoute('sf_guard_signin', new sfRoute('/user/login', array('module' => 'gnGuardAuth', 'action' => 'signin')));
    $routing->prependRoute('sf_guard_signout', new sfRoute('/user/logout', array('module' => 'gnGuardAuth', 'action' => 'signout')));
    $routing->prependRoute('gn_search', new sfRoute('/search', array('module' => 'gnSearch', 'action' => 'index')));
    $routing->prependRoute('gn_search_ajax', new sfRoute('/search.:sf_format', array('module' => 'gnSearch', 'action' => 'ajaxSearch')));
    $routing->prependRoute('gn_asset_upload', new sfRoute('/asset/upload', array('module' => 'gnAsset', 'action' => 'upload')));
    $routing->prependRoute('gn_asset_request', new sfRoute('/uploads/private/:filename', array('module' => 'gnAsset', 'action' => 'delivery')));
    $routing->prependRoute('gn_asset_reorder', new sfRoute('/asset/reorder.:sf_format', array('module' => 'gnAsset', 'action' => 'reorder')));
    $routing->prependRoute('gn_asset_delete', new sfRoute('/asset/delete.:sf_format', array('module' => 'gnAsset', 'action' => 'delete')));
  }
}
?>
