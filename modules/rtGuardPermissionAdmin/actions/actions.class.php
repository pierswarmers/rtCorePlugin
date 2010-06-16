<?php

/**
 * rtGuardPermissionAdmin actions.
 *
 * @package    symfony
 * @subpackage rtGuardPermissionAdmin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class rtGuardPermissionAdminActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->sf_guard_permissions = Doctrine::getTable('sfGuardPermission')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new rtGuardPermissionAdminForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new rtGuardPermissionAdminForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($sf_guard_permission = Doctrine::getTable('sfGuardPermission')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_permission does not exist (%s).', $request->getParameter('id')));
    $this->form = new rtGuardPermissionAdminForm($sf_guard_permission);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($sf_guard_permission = Doctrine::getTable('sfGuardPermission')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_permission does not exist (%s).', $request->getParameter('id')));
    $this->form = new rtGuardPermissionAdminForm($sf_guard_permission);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($sf_guard_permission = Doctrine::getTable('sfGuardPermission')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_permission does not exist (%s).', $request->getParameter('id')));
    $sf_guard_permission->delete();

    $this->redirect('rtGuardPermissionAdmin/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $sf_guard_permission = $form->save();

      $action = $request->getParameter('rt_post_save_action', 'index');

      if($action == 'edit')
      {
        $this->redirect('rtGuardPermissionAdmin/edit?id='.$sf_guard_permission->getId());
      }

      $this->redirect('rtGuardPermissionAdmin/index');
    }
    $this->getUser()->setFlash('default_error', true, false);
  }
}
