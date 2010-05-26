<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtCorePluginConfiguration runs some initial configuration logic.
 *
 * @package    rtCore
 * @subpackage config
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtCorePluginConfiguration extends sfPluginConfiguration
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
    if(sfConfig::has('app_rt_default_timezone'))
    {
      sfConfig::set('sf_default_timezone', sfConfig::get('app_rt_default_timezone'));
    }
  }

  /**
   * Run frontend specific configuration logic.
   */
  private function runFrontendConfiguration()
  {
    $this->dispatcher->connect('routing.load_configuration', array($this, 'listenToRoutingLoadConfigurationFrontend'));
    //$this->dispatcher->connect('view.cache.filter_content', array($this, 'configureWebDebugToolbar'));
  }

  public function configureWebDebugToolbar(sfEvent $event)
  {
    $user = $event->getSubject()->getContext()->getUser();
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
    rtTemplateToolkit::setBackendTemplateDir();
  }

  /**
   * Enable the required routes for frontend.
   *
   * @param sfEvent $event
   */
  public function listenToRoutingLoadConfigurationFrontend(sfEvent $event)
  {
    $routing = $event->getSubject();

    $routing->prependRoute('sf_guard_forgot_password', new sfRoute('/user/forgot_password', array('module' => 'rtGuardForgotPassword', 'action' => 'index')));
    $routing->prependRoute('sf_guard_forgot_password_change', new sfDoctrineRoute('/user/forgot_password/:unique_key', array(
      'module' => 'rtGuardForgotPassword',
      'action' => 'change'
    ), array(
      'sf_method' => array('get', 'post')
    ), array(
      'model' => 'sfGuardForgotPassword',
      'type' => 'object'
    )));
    $routing->prependRoute('sf_default_notify_404', new sfRoute('/default/notify404.:sf_format', array('module' => 'rtDefault', 'action' => 'notify404')));
    $routing->prependRoute('sf_guard_register', new sfRoute('/user/register', array('module' => 'rtGuardRegister', 'action' => 'index')));
    $routing->prependRoute('sf_guard_register_success', new sfRoute('/user/registration_pending', array('module' => 'rtGuardRegister', 'action' => 'pending')));
    $routing->prependRoute('sf_guard_register_confirm', new sfRoute('/user/registration_confirm/:id', array('module' => 'rtGuardRegister', 'action' => 'confirm')));
    $routing->prependRoute('sf_guard_signin', new sfRoute('/user/login', array('module' => 'rtGuardAuth', 'action' => 'signin')));
    $routing->prependRoute('sf_guard_signout', new sfRoute('/user/logout', array('module' => 'rtGuardAuth', 'action' => 'signout')));
    $routing->prependRoute('rt_search', new sfRoute('/search', array('module' => 'rtSearch', 'action' => 'index')));
    $routing->prependRoute('rt_search_ajax', new sfRoute('/search.:sf_format', array('module' => 'rtSearchAdmin', 'action' => 'ajaxSearch')));
    $routing->prependRoute('rt_asset_upload', new sfRoute('/asset/upload', array('module' => 'rtAsset', 'action' => 'upload')));
    $routing->prependRoute('rt_asset_request', new sfRoute('/uploads/private/:filename', array('module' => 'rtAsset', 'action' => 'delivery')));
    $routing->prependRoute('rt_asset_reorder', new sfRoute('/asset/reorder.:sf_format', array('module' => 'rtAsset', 'action' => 'reorder')));
    $routing->prependRoute('rt_asset_delete', new sfRoute('/asset/delete.:sf_format', array('module' => 'rtAsset', 'action' => 'delete')));
  }
}