<?php
/*
 * This file is part of the reditype package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtGuardGroupAdminActions
 *
 * @package    rtShopPlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtGuardGroupAdminActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $query = Doctrine::getTable('sfGuardGroup')->createQuery('a');
    $query->orderBy('a.created_at DESC');

    $this->pager = new sfDoctrinePager(
      'sfGuardGroup',
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
    $this->form = new rtGuardGroupAdminForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new rtGuardGroupAdminForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($sf_guard_group = Doctrine::getTable('sfGuardGroup')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_group does not exist (%s).', $request->getParameter('id')));
    $this->form = new rtGuardGroupAdminForm($sf_guard_group);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($sf_guard_group = Doctrine::getTable('sfGuardGroup')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_group does not exist (%s).', $request->getParameter('id')));
    $this->form = new rtGuardGroupAdminForm($sf_guard_group);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($sf_guard_group = Doctrine::getTable('sfGuardGroup')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_group does not exist (%s).', $request->getParameter('id')));
    $sf_guard_group->delete();

    $this->redirect('rtGuardGroupAdmin/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $sf_guard_group = $form->save();

      $action = $request->getParameter('rt_post_save_action', 'index');

      if($action == 'edit')
      {
        $this->redirect('rtGuardGroupAdmin/edit?id='.$sf_guard_group->getId());
      }

      $this->redirect('rtGuardGroupAdmin/index');
    }
    $this->getUser()->setFlash('default_error', true, false);
  }
}
