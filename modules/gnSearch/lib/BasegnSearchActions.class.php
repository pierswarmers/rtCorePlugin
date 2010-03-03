<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasegnSearchActions handles search functions.
 *
 * @package    gumnut
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasegnSearchActions extends sfActions
{
  public function preExecute()
  {
    parent::postExecute();
    sfConfig::set('app_gn_node_title', 'Search');
  }
  
  public function executeIndex(sfWebRequest $request)
  {
    $this->setPage($request->getParameter('page', 1));
    $form = new gnSearchForm;

    if($request->hasParameter('q'))
    {
      $form->setDefault('q', $request->getParameter('q', ''));
      $query = Doctrine::getTable('gnIndex')->getBaseSearchQuery($request->getParameter('q'), $this->getUser()->getCulture());
      $pager = new sfDoctrinePager('gnIndex');
      $pager->setPage($this->getPage($request));
      $pager->setQuery($query);
      $pager->init();
      $this->pager = $pager;
    }
    $this->form = $form;
  }

  protected function getPage()
  {
    return $this->getUser()->getAttribute('gnSearch.page', 1, 'frontend');
  }

  protected function setPage($page)
  {
    $this->getUser()->setAttribute('gnSearch.page', $page, 'frontend');
  }
}