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
 * BasertSearchActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertSearchActions extends rtController
{
  public function preExecute()
  {
    parent::preExecute();
    sfConfig::set('app_rt_node_title', 'Search');
  }

  public function executeIndex(sfWebRequest $request)
  {
    rtTemplateToolkit::setFrontendTemplateDir();
    $this->setPage($request->getParameter('page', 1));
    $form = new rtSearchForm;

    if($request->hasParameter('q'))
    {
      //$this->number_of__results = Doctrine::getTable('rtIndex')->getNumberOfMatchedResults($request->getParameter('q'), $this->getUser()->getCulture());

      $form->setDefault('q', $request->getParameter('q', ''));
      $query = Doctrine::getTable('rtIndex')->getBasePublicSearchQuery($request->getParameter('q'), $this->getUser()->getCulture());
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