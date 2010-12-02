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
 * BasertGuardUserActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertGuardUserActions extends sfActions
{
  /**
   * Set the template.
   */
  public function preExecute()
  {
    rtTemplateToolkit::setFrontendTemplateDir();
    parent::preExecute();
  }

  /**
   * Run the edit screen screen.
   * 
   * @param sfWebRequest $request 
   */
  public function executeEdit(sfWebRequest $request)
  {
    $id = $this->getUser()->getGuardUser()->getId();
    $this->forward404Unless($rt_guard_user = Doctrine::getTable('rtGuardUser')->find(array($id)), sprintf('Object rt_guard_user does not exist (%s).', $id));
    $this->form = $this->getForm($rt_guard_user);
  }

  /**
   * Run update logic for a user.
   * 
   * @param sfWebRequest $request
   */
  public function executeUpdate(sfWebRequest $request)
  {
    $id = $this->getUser()->getGuardUser()->getId();
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    $this->forward404Unless($rt_guard_user = Doctrine::getTable('rtGuardUser')->find(array($id)), sprintf('Object rt_guard_user does not exist (%s).', $id));
    $this->form = new rtGuardUserPublicForm($rt_guard_user);
    $this->form = $this->getForm($rt_guard_user);
    $this->processForm($request, $this->form);
    $this->setTemplate('edit');
  }

  /**
   * Process the form with a set of request data.
   * 
   * @param sfWebRequest $request
   * @param sfForm $form
   */
  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $sf_guard_user = $form->save();

      $action = $request->getParameter('rt_post_save_action', 'index');

      $this->getUser()->setFlash('notice', 'Your account has been updated.');

      $this->redirect('rt_guard_account');
    }
    $this->getUser()->setFlash('default_error', true, false);
  }

  /**
   * Return a form object.
   * 
   * @param sfGuardUser $user
   * @return rtGuardUserPublicForm
   */
  protected function getForm(sfGuardUser $rt_guard_user)
  {
    return new rtGuardUserPublicForm($rt_guard_user);
  }
}
