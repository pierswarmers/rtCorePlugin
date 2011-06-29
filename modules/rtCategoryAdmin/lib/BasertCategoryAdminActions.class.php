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
 * BasertCategoryAdminActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class BasertCategoryAdminActions extends sfActions
{
  public function preExecute()
  {
    parent::preExecute();
    rtTemplateToolkit::setBackendTemplateDir();
  }

  public function getrtCategory(sfWebRequest $request)
  {
    $this->forward404Unless($rt_category = Doctrine_Core::getTable('rtCategory')->find(array($request->getParameter('id'))), sprintf('Object rt_category does not exist (%s).', $request->getParameter('id')));
    return $rt_category;
  }  
  
  public function executeIndex(sfWebRequest $request)
  {
    $query = Doctrine::getTable('rtCategory')->getQuery();
    $query->orderBy('c.created_at DESC');

    $this->pager = new sfDoctrinePager(
      'rtCategory',
      $this->getCountPerPage($request)
    );

    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  private function getCountPerPage(sfWebRequest $request)
  {
    $count = sfConfig::get('app_rt_admin_pagination_limit', 50);
    if($request->hasParameter('show_more'))
    {
      $count = sfConfig::get('app_rt_admin_pagination_per_page_multiple', 2) * $count;
    }

    return $count;
  }  
  
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new rtCategoryForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new rtCategoryForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $rt_category = $this->getrtCategory($request);
    $this->form = new rtCategoryForm($rt_category);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $rt_category = $this->getrtCategory($request);
    $this->form = new rtCategoryForm($rt_category);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $rt_category = $this->getrtCategory($request);
    $rt_category->delete();

    $this->redirect('rtCategoryAdmin/index');
  }
  
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $rt_category = $form->save();
      
      $action = $request->getParameter('rt_post_save_action', 'index');
      if($action == 'edit')
      {
        $this->redirect('rtCategoryAdmin/edit?id='.$rt_category->getId());
      }
      elseif($action == 'show')
      {
        $this->forward('rtCategoryAdmin', 'show');
      }

      $this->redirect('rtCategoryAdmin/index');      
    }
  }
}
