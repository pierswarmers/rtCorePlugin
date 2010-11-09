<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * BasertSnippetAdminActions handles snippet admin functions.
 *
 * @package    gumnut
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertSnippetAdminActions extends sfActions
{
  public function preExecute()
  {
    parent::preExecute();
    rtTemplateToolkit::setBackendTemplateDir();
  }

  public function executeIndex(sfWebRequest $request)
  {
    $query = Doctrine::getTable('rtSnippet')->getQuery();
    $query->orderBy('snippet.created_at DESC');

    $this->pager = new sfDoctrinePager(
      'rtSnippet',
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
    $this->addRefererToSession($request);
    $this->form = new rtSnippetForm();

    $title = str_replace(array('-', '-'), ' ', $request->getParameter('collection'));
    $title = ucwords($title);
    
    $this->form->setDefault('title', $title);
    $this->form->setDefault('collection', $request->getParameter('collection'));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new rtSnippetForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($rt_snippet = Doctrine::getTable('rtSnippet')->find(array($request->getParameter('id'))), sprintf('Object rt_snippet does not exist (%s).', $request->getParameter('id')));
    $this->addRefererToSession($request);
    $this->form = new rtSnippetForm($rt_snippet);
  }

  protected function addRefererToSession(sfWebRequest $request)
  {
    if($request->hasParameter('rt-snippet-referer') && $request->getParameter('rt-snippet-referer') !== '')
    {
      $this->getUser()->setAttribute('rt-snippet-referer', $request->getParameter('rt-snippet-referer'));
    }
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($rt_snippet = Doctrine::getTable('rtSnippet')->find(array($request->getParameter('id'))), sprintf('Object rt_snippet does not exist (%s).', $request->getParameter('id')));
    $this->form = new rtSnippetForm($rt_snippet);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($rt_snippet = Doctrine::getTable('rtSnippet')->find(array($request->getParameter('id'))), sprintf('Object rt_snippet does not exist (%s).', $request->getParameter('id')));
    $rt_snippet->delete();
    $this->clearCache();
    $this->redirect('rtSnippetAdmin/index');
  }


  public function executeVersions(sfWebRequest $request)
  {
    $this->rt_snippet = $this->getrtSnippet($request);
    $this->rt_snippet_versions = Doctrine::getTable('rtSnippetVersion')->findById($this->rt_snippet->getId());
  }

  public function executeCompare(sfWebRequest $request)
  {
    $this->rt_snippet = $this->getrtSnippet($request);
    $this->current_version = $this->rt_snippet->version;

    if(!$request->hasParameter('version1') || !$request->hasParameter('version2'))
    {
      $this->getUser()->setFlash('error', 'Please select two versions to compare.', false);
      $this->redirect('rtSnippetAdmin/versions?id='.$this->rt_snippet->getId());
    }

    $this->version_1 = $request->getParameter('version1');
    $this->version_2 = $request->getParameter('version2');
    $this->versions = array();

    $this->versions[1] = array(
      'title' => $this->rt_snippet->revert($this->version_1)->title,
      'content' => $this->rt_snippet->revert($this->version_1)->content,
      'collection' => $this->rt_snippet->revert($this->version_1)->collection,
      'updated_at' => $this->rt_snippet->revert($this->version_1)->updated_at
    );
    $this->versions[2] = array(
      'title' => $this->rt_snippet->revert($this->version_2)->title,
      'content' => $this->rt_snippet->revert($this->version_2)->content,
      'collection' => $this->rt_snippet->revert($this->version_1)->collection,
      'updated_at' => $this->rt_snippet->revert($this->version_1)->updated_at
    );
  }

  public function executeRevert(sfWebRequest $request)
  {
    $this->rt_snippet = $this->getrtSnippet($request);
    $this->rt_snippet->revert($request->getParameter('revert_to'));
    $this->rt_snippet->save();
    $this->getUser()->setFlash('notice', 'Reverted to version ' . $request->getParameter('revert_to'), false);
    $this->clearCache($this->rt_snippet);
    $this->redirect('rtSnippetAdmin/edit?id='.$this->rt_snippet->getId());
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->forward404Unless($referer = $this->getUser()->hasAttribute('rt-snippet-referer'));
    $this->redirect($this->getUser()->getAttribute('rt-snippet-referer'));
  }

  public function getrtSnippet(sfWebRequest $request)
  {
    $this->forward404Unless($rt_snippet = Doctrine::getTable('rtSnippet')->find(array($request->getParameter('id'))), sprintf('Object rt_snippet does not exist (%s).', $request->getParameter('id')));
    return $rt_snippet;
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $rt_snippet = $form->save();
      $this->clearCache($rt_snippet);
      $action = $request->getParameter('rt_post_save_action', 'index');
      
      if($action == 'edit')
      {
        $this->redirect('rtSnippetAdmin/edit?id='.$rt_snippet->getId());
      }
      elseif($action == 'show')
      {
        $this->redirect($this->getUser()->getAttribute('rt-snippet-referer'));
      }

      $this->redirect('rtSnippetAdmin/index');
    }
  }

  public function clearCache($rt_snippet = null)
  {
    $cache = $this->getContext()->getViewCacheManager();
    
    if ($cache)
    {
      if(!is_null($rt_snippet))
      {
        $cache->remove('@sf_cache_partial?module=rtSnippet&action=_snippetPanel&sf_cache_key='.$rt_snippet->getCollection());
      }
      else
      {
        $cache->remove('@sf_cache_partial?module=rtSnippet&action=_snippetPanel&sf_cache_key=*');
      }
    }
  }
}
