<?php

/**
 * gnGuardPermissionAdmin actions.
 *
 * @package    symfony
 * @subpackage gnGuardPermissionAdmin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class gnGuardPermissionAdminActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->sf_guard_permissions = Doctrine::getTable('sfGuardPermission')
      ->createQuery('a')
      ->execute();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new gnGuardPermissionAdminForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new gnGuardPermissionAdminForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($sf_guard_permission = Doctrine::getTable('sfGuardPermission')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_permission does not exist (%s).', $request->getParameter('id')));
    $this->form = new gnGuardPermissionAdminForm($sf_guard_permission);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($sf_guard_permission = Doctrine::getTable('sfGuardPermission')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_permission does not exist (%s).', $request->getParameter('id')));
    $this->form = new gnGuardPermissionAdminForm($sf_guard_permission);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($sf_guard_permission = Doctrine::getTable('sfGuardPermission')->find(array($request->getParameter('id'))), sprintf('Object sf_guard_permission does not exist (%s).', $request->getParameter('id')));
    $sf_guard_permission->delete();

    $this->redirect('gnGuardPermissionAdmin/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $sf_guard_permission = $form->save();

      $this->redirect('gnGuardPermissionAdmin/index');
    }
  }
}
