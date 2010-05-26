<?php

class gnAdminToolbarFilter extends sfFilter
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

    $groups = $user->getGuardUser()->getGroups();

    $groups_names = array();

    foreach ($groups as $group)
    {
      $groups_names[] = $group->getName();
    }

    if(!$user->isAuthenticated() || !in_array(sfConfig::get('app_gn_admin_group', 'admin'), $groups_names))
    {
      return;
    }

    $css = '<link rel="stylesheet" type="text/css" media="screen" href="/gnCorePlugin/css/admin-toolbar.css" />';

    if (function_exists('use_helper'))
    {
      use_helper('Partial', 'I18n');
      $toolbar = get_component('gnAdmin', 'menu');
      $response = $this->getContext()->getResponse();
      $response->setContent(str_ireplace('</body>', $toolbar.'</body>',$response->getContent()));
      $response->setContent(str_ireplace('<body>', $css.'<body>',$response->getContent()));
    }
  }
}