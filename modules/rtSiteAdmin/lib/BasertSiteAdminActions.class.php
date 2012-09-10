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
 * BasertSiteAdminActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasertSiteAdminActions extends sfActions
{
  public function preExecute()
  {
    parent::preExecute();
    rtTemplateToolkit::setBackendTemplateDir();
  }

  public function executeIndex(sfWebRequest $request)
  {
    $query = Doctrine::getTable('rtSite')->getQuery();
    $query->orderBy('site.domain DESC');

    $this->pager = new sfDoctrinePager(
      'rtSite',
      $this->getCountPerPage($request)
    );

    $this->pager->setQuery($query);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();

    $this->stats = $this->stats();
  }

  protected function stats()
  {
    // Dates
    $date_now         = date("Y-m-d H:i:s");

    // SQL queries
    $con = Doctrine_Manager::getInstance()->getCurrentConnection();

    $result_sites_total               = $con->fetchAssoc("select count(id) as count from rt_site");
    $result_sites_total_published     = $con->fetchAssoc("select count(id) as count from rt_site where published = 1");

    // Create array
    $stats = array();
    $stats['total']            = $result_sites_total[0] != '' ? $result_sites_total[0] : 0;
    $stats['total_published']  = $result_sites_total_published[0] != '' ? $result_sites_total_published[0] : 0;

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
    $this->addRefererToSession($request);
    $this->form = $this->getForm();

    $title = str_replace(array('-', '-'), ' ', $request->getParameter('collection'));
    $title = ucwords($title);
    
    $this->form->setDefault('title', $title);
    $this->form->setDefault('collection', $request->getParameter('collection'));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = $this->getForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($rt_site = Doctrine::getTable('rtSite')->find(array($request->getParameter('id'))), sprintf('Object rt_site does not exist (%s).', $request->getParameter('id')));
    $this->addRefererToSession($request);
    $this->form = $this->getForm($rt_site);
  }

  protected function addRefererToSession(sfWebRequest $request)
  {
    if($request->hasParameter('rt-site-referer') && $request->getParameter('rt-site-referer') !== '')
    {
      $this->getUser()->setAttribute('rt-site-referer', $request->getParameter('rt-site-referer'));
    }
    else
    {
      $this->removeRefererFromSession();
    }
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($rt_site = Doctrine::getTable('rtSite')->find(array($request->getParameter('id'))), sprintf('Object rt_site does not exist (%s).', $request->getParameter('id')));
    $this->form = $this->getForm($rt_site);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($rt_site = Doctrine::getTable('rtSite')->find(array($request->getParameter('id'))), sprintf('Object rt_site does not exist (%s).', $request->getParameter('id')));
    $rt_site->delete();
    $this->clearCache();
    $this->redirect('rtSiteAdmin/index');
  }

  public function executeVersions(sfWebRequest $request)
  {
    $this->rt_site = $this->getrtSite($request);
    $this->rt_site_versions = Doctrine::getTable('rtSiteVersion')->findById($this->rt_site->getId());
  }

  public function executeCompare(sfWebRequest $request)
  {
    $this->rt_site = $this->getrtSite($request);
    $this->current_version = $this->rt_site->version;

    if(!$request->hasParameter('version1') || !$request->hasParameter('version2'))
    {
      $this->getUser()->setFlash('error', 'Please select two versions to compare.', false);
      $this->redirect('rtSiteAdmin/versions?id='.$this->rt_site->getId());
    }

    $this->version_1 = $request->getParameter('version1');
    $this->version_2 = $request->getParameter('version2');
    $this->versions = array();

    $this->versions[1] = array(
      'title' => $this->rt_site->revert($this->version_1)->title,
      'content' => $this->rt_site->revert($this->version_1)->content,
      'collection' => $this->rt_site->revert($this->version_1)->collection,
      'updated_at' => $this->rt_site->revert($this->version_1)->updated_at
    );
    $this->versions[2] = array(
      'title' => $this->rt_site->revert($this->version_2)->title,
      'content' => $this->rt_site->revert($this->version_2)->content,
      'collection' => $this->rt_site->revert($this->version_1)->collection,
      'updated_at' => $this->rt_site->revert($this->version_1)->updated_at
    );
  }

  public function executeRevert(sfWebRequest $request)
  {
    $this->rt_site = $this->getrtSite($request);
    $this->rt_site->revert($request->getParameter('revert_to'));
    $this->rt_site->save();
    $this->getUser()->setFlash('notice', 'Reverted to version ' . $request->getParameter('revert_to'), false);
    $this->clearCache($this->rt_site);
    $this->redirect('rtSiteAdmin/edit?id='.$this->rt_site->getId());
  }

  public function executeToggle(sfWebRequest $request)
  {
    $rt_site = Doctrine_Core::getTable('rtSite')->find(array($request->getParameter('id')));
    if(!$rt_site)
    {
      $this->status = 'error';
      return sfView::SUCCESS;
    }

    $rt_site->setPublished(!$rt_site->getPublished());
    $this->status = $rt_site->getPublished() ? 'activated' : 'deactivated';
    $rt_site->save();
    $this->clearCache($rt_site);
  }

  protected function removeRefererFromSession()
  {
    $this->getUser()->getAttributeHolder()->remove('rt-site-referer');
  }

  public function executeShow(sfWebRequest $request)
  {
    $target = $this->getUser()->getAttribute('rt-site-referer');

    $this->removeRefererFromSession();

    $this->redirectIf(!is_null($target), $target);

    $this->redirect('/');
  }

  public function getrtSite(sfWebRequest $request)
  {
    $this->forward404Unless($rt_site = Doctrine::getTable('rtSite')->find(array($request->getParameter('id'))), sprintf('Object rt_site does not exist (%s).', $request->getParameter('id')));
    return $rt_site;
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $rt_site = $form->save();
      //$this->clearCache($rt_site);
      $action = $request->getParameter('rt_post_save_action', 'index');
      
      if($action == 'edit')
      {
        $this->redirect('rtSiteAdmin/edit?id='.$rt_site->getId());
      }
      elseif($action == 'show')
      {
        $this->forward('rtSiteAdmin', 'show');
      }

      $this->redirect('rtSiteAdmin/index');
    }
  }

  public function clearCache($rt_site = null)
  {
    return;
    $cache = $this->getContext()->getViewCacheManager();
    
    if ($cache)
    {
      if(!is_null($rt_site))
      {
        $cache->remove('@sf_cache_partial?module=rtSite&action=_sitePanel&sf_cache_key='.$rt_site->getCollection());
      }
      else
      {
        $cache->remove('@sf_cache_partial?module=rtSite&action=_sitePanel&sf_cache_key=*');
      }
    }
  }

  /**
   * @param $rt_site
   * @return rtSiteForm
   */
  protected function getForm($rt_site = null)
  {
    if(!is_null($rt_site)) {
      return new rtSiteForm($rt_site);
    }

    return new rtSiteForm();
  }
}
