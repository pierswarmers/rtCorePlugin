<?php

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

    if(!$user->isAuthenticated())
    {
      return;
    }

    $groups_names = array();

    foreach ($user->getGuardUser()->getGroups() as $group)
    {
      $groups_names[] = $group->getName();
    }

    if(!in_array(sfConfig::get('app_rt_admin_group', 'admin'), $groups_names))
    {
      return;
    }

    if (function_exists('use_helper'))
    {
      $css = '<link rel="stylesheet" type="text/css" media="screen" href="/rtCorePlugin/css/admin-toolbar.css" />';
      $js = '<script type="text/javascript" src="/rtCorePlugin/vendor/jquery/js/jquery.min.js"></script>';
      //$js .= '<script type="text/javascript" src="/rtCorePlugin/vendor/jquery/js/jquery.ui.min.js"></script>';
      
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