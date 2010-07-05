<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasertGuardUserActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertGuardUserActions extends sfActions
{
  public function preExecute()
  {
    rtTemplateToolkit::setFrontendTemplateDir();
    parent::preExecute();
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $id = $this->getUser()->getGuardUser()->getId();
    $this->forward404Unless($rt_guard_user = Doctrine::getTable('rtGuardUser')->find(array($id)), sprintf('Object rt_guard_user does not exist (%s).', $id));
    $this->form = new rtGuardUserPublicForm($rt_guard_user);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $id = $this->getUser()->getGuardUser()->getId();
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->forward404Unless($rt_guard_user = Doctrine::getTable('rtGuardUser')->find(array($id)), sprintf('Object rt_guard_user does not exist (%s).', $id));
    $this->form = new rtGuardUserPublicForm($rt_guard_user);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $sf_guard_user = $form->save();

      $action = $request->getParameter('rt_post_save_action', 'index');

      $this->redirect('rt_guard_account');
    }
    $this->getUser()->setFlash('default_error', true, false);
  }
}
