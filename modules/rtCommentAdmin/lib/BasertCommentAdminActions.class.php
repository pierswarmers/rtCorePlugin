<?php
/*
 * This file is part of the reditype package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasertCommentAdminActions
 *
 * @package    reditype
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class BasertCommentAdminActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $query = Doctrine::getTable('rtComment')->getQuery();
    $query->orderBy('c.created_at DESC');

    $this->pager = new sfDoctrinePager(
      'rtComment',
      $this->getCountPerPage($request)
    );

    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  protected function getCountPerPage(sfWebRequest $request)
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
    $this->form = new rtCommentForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new rtCommentForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($rt_comment = Doctrine_Core::getTable('rtComment')->find(array($request->getParameter('id'))), sprintf('Object rt_comment does not exist (%s).', $request->getParameter('id')));
    if(class_exists($rt_comment->getModel()))
    {
      $this->forward404Unless($this->parent_model = Doctrine::getTable($rt_comment->getModel())->findOneById($rt_comment->getModelId()));
    }
    $this->form = new rtCommentForm($rt_comment);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($rt_comment = Doctrine_Core::getTable('rtComment')->find(array($request->getParameter('id'))), sprintf('Object rt_comment does not exist (%s).', $request->getParameter('id')));
    $this->form = new rtCommentForm($rt_comment);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($rt_comment = Doctrine_Core::getTable('rtComment')->find(array($request->getParameter('id'))), sprintf('Object rt_comment does not exist (%s).', $request->getParameter('id')));
    $rt_comment->delete();

    $this->redirect('rtCommentAdmin/index');
  }

  /**
   * Enable comment
   *
   * @param sfWebRequest $request
   */
  public function executeEnable(sfWebRequest $request)
  {
    $this->forward404Unless($rt_comment = Doctrine_Core::getTable('rtComment')->find(array($request->getParameter('id'))), sprintf('Object rt_comment does not exist (%s).', $request->getParameter('id')));
    $rt_comment->setIsActive(true);
    $rt_comment->save();

    $this->getUser()->setFlash('notice', 'Comment was enabled.',false);

    $this->redirect('rtCommentAdmin/edit?id='.$rt_comment->getId());
  }

  public function executeToggle(sfWebRequest $request)
  {
    $this->forward404Unless($rt_comment = Doctrine_Core::getTable('rtComment')->find(array($request->getParameter('id'))), sprintf('Object rt_comment does not exist (%s).', $request->getParameter('id')));
    $rt_comment->setIsActive(!$rt_comment->getIsActive());
    $this->status = $rt_comment->getIsActive() ? 'activated' : 'deactivated';
    $rt_comment->save();
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $rt_comment = $form->save();

      $action = $request->getParameter('rt_post_save_action', 'index');

      if($action == 'edit')
      {
        $this->redirect('rtCommentAdmin/edit?id='.$rt_comment->getId());
      }

      $this->redirect('rtCommentAdmin/index');
    }

    $this->getUser()->setFlash('default_error', true, false);
  }
}