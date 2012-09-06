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
 * rtCorePluginConfiguration runs some initial configuration logic.
 *
 * @package    rtCorePlugin
 * @subpackage config
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtCorePluginConfiguration extends sfPluginConfiguration
{
  const VERSION = '1.0.0';

  /**
   * @see sfPluginConfiguration
   */
  public function initialize()
  {
    rtTemplateToolkit::setBackendTemplateDir();

    if(sfConfig::get('sf_app') === 'frontend')
    {
      $this->dispatcher->connect('routing.load_configuration',
          array($this, 'listenToRoutingLoadConfigurationFrontend'));
    }

    date_default_timezone_set("Australia/Sydney");

    sfConfig::set('sf_default_timezone', sfConfig::get('app_rt_default_timezone', 'Australia/Sydney'));
  }

  /**
   * Enable the required routes for core specific frontend modules.
   *
   * @param sfEvent $event
   */
  public function listenToRoutingLoadConfigurationFrontend(sfEvent $event)
  {
    $routing = $event->getSubject();
    $routing->prependRoute('sf_guard_forgot_password_change', new sfDoctrineRoute('/user/change_password/:unique_key', array(
        'module' => 'rtGuardForgotPassword',
        'action' => 'change'
      ), array(
        'sf_method' => array('get', 'post')
      ), array(
        'model' => 'sfGuardForgotPassword',
        'type' => 'object'
      )));
    $routing->prependRoute('sf_guard_forgot_password',      new sfRoute('/user/forgot_password',          array('module' => 'rtGuardForgotPassword', 'action' => 'index')));
    $routing->prependRoute('rt_guard_user_report_download', new sfRoute('/rtGuardUserAdmin/userReport/user_report.:sf_format', array('module' => 'rtGuardUserAdmin', 'action' => 'userReport')));
    $routing->prependRoute('sf_default_notify_404',         new sfRoute('/default/notify404.:sf_format',  array('module' => 'rtDefault', 'action' => 'notify404')));
    $routing->prependRoute('sf_guard_register',             new sfRoute('/user/register',                 array('module' => 'rtGuardRegister', 'action' => 'index')));
    $routing->prependRoute('rt_guard_account',              new sfRoute('/user/account',                  array('module' => 'rtGuardUser', 'action' => 'edit')));
    $routing->prependRoute('sf_guard_register_success',     new sfRoute('/user/registration_pending',     array('module' => 'rtGuardRegister', 'action' => 'pending')));
    $routing->prependRoute('sf_guard_register_confirm',     new sfRoute('/user/registration_confirm/:id', array('module' => 'rtGuardRegister', 'action' => 'confirm')));
    $routing->prependRoute('sf_guard_signin',               new sfRoute('/user/login',                    array('module' => 'rtGuardAuth', 'action' => 'signin')));
    $routing->prependRoute('sf_guard_signout',              new sfRoute('/user/logout',                   array('module' => 'rtGuardAuth', 'action' => 'signout')));
    $routing->prependRoute('rt_search',                     new sfRoute('/search',                        array('module' => 'rtSearch', 'action' => 'index')));
    $routing->prependRoute('rt_search_ajax',                new sfRoute('/search.:sf_format',             array('module' => 'rtSearchAdmin', 'action' => 'ajaxSearch')));
    $routing->prependRoute('rt_asset_upload',               new sfRoute('/asset/upload',                  array('module' => 'rtAsset', 'action' => 'upload')));
    $routing->prependRoute('rt_asset_create',               new sfRoute('/asset/create',                  array('module' => 'rtAsset', 'action' => 'create')));
    $routing->prependRoute('rt_asset_request',              new sfRoute('/uploads/private/:filename',     array('module' => 'rtAsset', 'action' => 'delivery')));
    $routing->prependRoute('rt_asset_reorder',              new sfRoute('/asset/reorder.:sf_format',      array('module' => 'rtAsset', 'action' => 'reorder')));
    $routing->prependRoute('rt_asset_delete',               new sfRoute('/asset/delete.:sf_format',       array('module' => 'rtAsset', 'action' => 'delete')));
    $routing->prependRoute('rt_sitemap',                    new sfRoute('/sitemap.:sf_format',            array('module' => 'rtSitemap', 'action' => 'index', 'sf_format' => 'html')));
    $routing->prependRoute('rt_comment_enable',             new sfRoute('/comment/enable',                array('module' => 'rtCommentAdmin', 'action' => 'enable')));
    $routing->prependRoute('rt_contact',                    new sfRoute('/contact',                       array('module' => 'rtContact', 'action' => 'contact')));
    $routing->prependRoute('rt_contact_confirmation',       new sfRoute('/contact/confirmation',          array('module' => 'rtContact', 'action' => 'confirmation')));
    $routing->prependRoute('rt_social_email',               new sfRoute('/social/:model/:model_id',       array('module' => 'rtSocial', 'action' => 'email')));

    // API routes
    $routing->prependRoute('rt_guard_user_report_stream',   new sfRoute('/api/users/get/user_report.:sf_format/*', array('module' => 'rtGuardUserAdmin', 'action' => 'downloadReport')));
  }
}