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
 * rtAdminToolbarFilter handles a small toolbar filter for administrators.
 *
 * @package    rtCorePlugin
 * @subpackage filter
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtAdminToolbarFilter extends sfFilter
{
  /**
   * Executes the filter chain, returning the response content with an additional admin toolbar.
   * 
   * @param sfFilterChain $filterChain
   */
  public function execute(sfFilterChain $filterChain)
  {
    $filterChain->execute();
    $user = sfContext::getInstance()->getUser();
    $sf_format = sfContext::getInstance()->getRequest()->getParameter('sf_format');
    if (($sf_format !== '' && !is_null($sf_format)) ||
        !$user->isAuthenticated() ||
        !$user->hasPermission(sfConfig::get('app_rt_admin_menu_credential', 'show_admin_menu')))
    {
      return;
    }

    if (function_exists('use_helper'))
    {
      $css = '<link rel="stylesheet" type="text/css" media="screen" href="/rtCorePlugin/css/admin-toolbar.css" />';
      $js  = '<script type="text/javascript" src="/rtCorePlugin/vendor/jquery/js/jquery.min.js"></script>';
      
      use_helper('Partial', 'I18N');
      
      $toolbar = get_component('rtAdmin', 'menu');
      $response = $this->getContext()->getResponse();
      $response->setContent(str_ireplace('<!--rt-admin-holder-->', $toolbar,$response->getContent()));
      $response->setContent(str_ireplace('</head>', $css.'</head>',$response->getContent()));

      if (!preg_match("/jquery/i", $response->getContent()))
      {
        $response->setContent(str_ireplace('</head>', $js.'</head>',$response->getContent()));
      }
    }
  }
}