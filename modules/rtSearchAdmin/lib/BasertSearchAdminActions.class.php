<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasertSearchActions handles search functions.
 *
 * @package    gumnut
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertSearchAdminActions extends sfActions
{
  public function preExecute()
  {
    parent::preExecute();
    rtTemplateToolkit::setBackendTemplateDir();
    sfConfig::set('app_rt_node_title', 'Search');
  }

  /**
   * Return JSON response.
   *
   * @param array $json_values
   * @param sfWebRequest $request
   * @return string
   */
  private function returnJSONResponse($json_values, sfWebRequest $request)
  {
    $this->getResponse()->setContent(json_encode($json_values));
    sfConfig::set('sf_web_debug', false);
    return sfView::NONE;
  }

  public function executeAjaxSearch(sfWebRequest $request)
  {
    $query = Doctrine::getTable('rtIndex')->getBasePublicSearchQuery($request->getParameter('q'), $this->getUser()->getCulture());
    $query->limit(100);
    $rt_indexes = $query->execute();

    $routes = $this->getContext()->getRouting()->getRoutes();

    // sfContext::getInstance()->getController()->genUrl($internal_uri, false);
    // link_to_if(isset($routes[Doctrine_Inflector::tableize($rt_index->getCleanModel()).'_show']),$rt_index->getObject()->getTitle(), Doctrine_Inflector::tableize($rt_index->getCleanModel()).'_show', $rt_index->getObject())
    
    $items = array();

    foreach($rt_indexes as $rt_index)
    {
      $route = Doctrine_Inflector::tableize($rt_index->getCleanModel()).'_show';

      $url = '';

      if(isset($routes[Doctrine_Inflector::tableize($rt_index->getCleanModel()).'_show']))
      {
        $url = sfContext::getInstance()->getController()->genUrl(array('sf_route' => $route, 'sf_subject' => $rt_index->getObject()));
        $url = str_replace('/frontend_dev.php', '', $url);
      }

      $items[] = array(
        'title' => $rt_index->getObject()->getTitle(),
        'link' => $url
      );

    }

    return $this->returnJSONResponse(array('status' => 'success', 'items' => $items), $request);
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $this->setPage($request->getParameter('page', 1));
    $form = new rtSearchForm;
    
    if($request->hasParameter('q'))
    {
      $this->number_of__results = Doctrine::getTable('rtIndex')->getNumberOfMatchedResults($request->getParameter('q'), $this->getUser()->getCulture());

      $form->setDefault('q', $request->getParameter('q', ''));
      $query = Doctrine::getTable('rtIndex')->getBaseSearchQuery($request->getParameter('q'), $this->getUser()->getCulture());
      $pager = new sfDoctrinePager('rtIndex');
      $pager->setPage($this->getPage($request));
      $pager->setQuery($query);
      $pager->init();
      $this->pager = $pager;
    }
    $this->form = $form;
  }

  protected function getPage()
  {
    return $this->getUser()->getAttribute('rtSearch.page', 1, 'frontend');
  }

  protected function setPage($page)
  {
    $this->getUser()->setAttribute('rtSearch.page', $page, 'frontend');
  }
}