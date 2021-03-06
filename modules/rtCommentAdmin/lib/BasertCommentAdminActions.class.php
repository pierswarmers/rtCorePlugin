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
 * BasertCommentAdminActions
 *
 * @package    rtCorePlugin
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

    $this->stats = $this->stats();
  }

  private function stats()
  {
    // SQL queries
    $con = Doctrine_Manager::getInstance()->getCurrentConnection();

    $result_comments_total            = $con->fetchAssoc("select count(id) as count from rt_comment");
    $result_comments_total_enabled    = $con->fetchAssoc("select count(id) as count from rt_comment where is_active = 1");
    $result_comments_total_disabled   = $con->fetchAssoc("select count(id) as count from rt_comment where is_active = 0");

    // Create array
    $stats = array();
    $stats['total']           = $result_comments_total[0] != '' ? $result_comments_total[0] : 0;
    $stats['total_enabled']   = $result_comments_total_enabled[0] != '' ? $result_comments_total_enabled[0] : 0;
    $stats['total_disabled']  = $result_comments_total_disabled[0] != '' ? $result_comments_total_disabled[0] : 0;

    return $stats;
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

    $this->clearObjectCache($rt_comment);

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
    $this->clearObjectCache($rt_comment);
    $this->getUser()->setFlash('notice', 'Comment was enabled.');
    $this->redirect('rtCommentAdmin/edit?id='.$rt_comment->getId());
  }

  public function executeToggle(sfWebRequest $request)
  {
    $rt_comment = Doctrine_Core::getTable('rtComment')->find(array($request->getParameter('id')));
    if(!$rt_comment)
    {
      $this->status = 'error';
      return sfView::SUCCESS;
    }

    $rt_comment->setIsActive(!$rt_comment->getIsActive());
    $this->status = $rt_comment->getIsActive() ? 'activated' : 'deactivated';
    $rt_comment->save();
    $this->clearObjectCache($rt_comment);
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($rt_comment = Doctrine::getTable('rtComment')->find(array($request->getParameter('id'))), sprintf('Object rt_comment does not exist (%s).', $request->getParameter('id')));

    $object = Doctrine::getTable($rt_comment->getModel())->find($rt_comment->getModelId());

    rtSiteToolkit::siteRedirect($object);
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $rt_comment = $form->save();

      $this->clearObjectCache($form->getObject());

      $action = $request->getParameter('rt_post_save_action', 'index');

      if($action == 'edit')
      {
        $this->redirect('rtCommentAdmin/edit?id='.$rt_comment->getId());
      }
      elseif($action == 'show')
      {
        $object = Doctrine::getTable($form->getObject()->getModel())->find($form->getObject()->getModelId());

        rtSiteToolkit::siteRedirect($object);
      }

      $this->redirect('rtCommentAdmin/index');
    }

    $this->getUser()->setFlash('default_error', true, false);
  }

  protected function clearObjectCache(rtComment $rt_comment)
  {
    $cache_class = $rt_comment->getModel() . 'CacheToolkit';

    if(class_exists($cache_class))
    {
      call_user_func($cache_class.'::clearCache', $rt_comment->getObject());
    }
  }
}