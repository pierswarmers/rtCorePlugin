<?php
/*
 * This file is part of the reditype package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtGuardUserAdminActions
 *
 * @package    rtShopPlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtGuardUserAdminActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $query = Doctrine::getTable('rtGuardUser')->createQuery('a');
    $query->orderBy('a.created_at DESC');

    $this->pager = new sfDoctrinePager(
      'rtGuardUser',
      sfConfig::get('app_rt_admin_pagination_limit', 50)
    );

    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new rtGuardUserForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new rtGuardUserForm(new rtGuardUser());

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($sf_guard_user = Doctrine::getTable('rtGuardUser')->find(array($request->getParameter('id'))), sprintf('Object rt_guard_user does not exist (%s).', $request->getParameter('id')));
    $this->form = new rtGuardUserForm($sf_guard_user);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($sf_guard_user = Doctrine::getTable('rtGuardUser')->find(array($request->getParameter('id'))), sprintf('Object rt_guard_user does not exist (%s).', $request->getParameter('id')));
    $this->form = new rtGuardUserForm($sf_guard_user);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($sf_guard_user = Doctrine::getTable('rtGuardUser')->find(array($request->getParameter('id'))), sprintf('Object rt_guard_user does not exist (%s).', $request->getParameter('id')));
    $sf_guard_user->delete();

    $this->redirect('rtGuardUserAdmin/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $sf_guard_user = $form->save();

      $action = $request->getParameter('rt_post_save_action', 'index');

      if($action == 'edit')
      {
        $this->redirect('rtGuardUserAdmin/edit?id='.$sf_guard_user->getId());
      }

      $this->redirect('rtGuardUserAdmin/index');
    }
    $this->getUser()->setFlash('default_error', true, false);
  }
}
