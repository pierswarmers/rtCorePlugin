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
 * rtGuardUserAdminActions
 *
 * @package    rtCorePlugin
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtGuardUserAdminActions extends sfActions
{
  /**
   * Create user report
   *
   * Formats are: web, csv, xml and json
   *
   * @param sfWebRequest $request
   */
  public function executeUserReport(sfWebRequest $request)
  {
    $fields = 'u.id,u.first_name,u.last_name,u.email_address,u.username,u.is_active,u.is_super_admin,u.last_login,u.date_of_birth,u.company,u.url,u.created_at,u.updated_at';
    $fieldnames = preg_replace('/[\$.]/', '_', $fields);
    $this->key_order = explode(',', $fieldnames);
    $q = Doctrine_Query::create()->from('rtGuardUser u');
    $q->select($fields)
      ->orderBy('u.created_at, u.last_name');
    $users = $q->execute(array(), Doctrine_Core::HYDRATE_SCALAR);
    $this->users = $users;

    // Prepare user data for xml and json
    if($this->getRequest()->getParameter('sf_format') === 'xml' || $this->getRequest()->getParameter('sf_format') === 'json')
    {
      $query = Doctrine_Query::create()->from('rtAddress a');
      $query->select('a.*')
        ->andWhere('a.model = ?', 'rtGuardUser');
      $user_addresses = $query->execute(array(), Doctrine_Core::HYDRATE_SCALAR);

      $clean_users = array();
      $clean_addresses = array();

      foreach($this->users as $user)
      {
        $clean_users[$user['u_id']] = $user;
      }
      foreach($user_addresses as $address)
      {
        $clean_addresses[$address['a_model_id']][] = $address;
      }

      $users_with_addresses = array();
      foreach($clean_users as $ukey => $user)
      {
        $users_with_addresses[$ukey] = $user;
        if(isset($clean_addresses[$ukey]))
        {
          foreach($clean_addresses[$ukey] as $akey => $address)
          {
            $users_with_addresses[$ukey]['u_addresses'][$address['a_type']] = $address;
          }
        }
      }
      $this->users = $users_with_addresses;
    }
    
    // CSV header
    if($this->getRequest()->getParameter('sf_format') === 'csv')
    {
      // Clean first and last name
      $this->users = array();
      foreach($users as $key => $user)
      {
        $this->users[$key] = $user;
        $this->users[$key]['u_first_name'] = preg_replace('/[^a-zA-Z_ -]/s', '', $user['u_first_name']);
        $this->users[$key]['u_last_name'] = preg_replace('/[^a-zA-Z_ -]/s', '', $user['u_last_name']);
      }
      
      $response = $this->getResponse();
      $response->setHttpHeader('Last-Modified', date('r'));
      $response->setContentType("application/octet-stream");
      $response->setHttpHeader('Cache-Control','no-store, no-cache');
      if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
      {
        $response->setHttpHeader('Content-Disposition','inline; filename="order_report.csv"');
      }
      else
      {
        $response->setHttpHeader('Content-Disposition','attachment; filename="order_report.csv"');
      }

      $this->setLayout(false);
    }

    // Pager
    $this->pager = new sfDoctrinePager(
      'rtGuardUser',
      $this->getCountPerPage($request)
    );
    $this->pager->setQuery($q);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  /**
   * Prepare user selection for dropdown populations
   *
   * @param sfWebRequest $request
   * @return json
   */
  public function executeUserSelect(sfWebRequest $request)
  {
    $this->getResponse()->setContentType('application/json');

    $query = Doctrine::getTable('rtIndex')->getBaseSearchQuery($request->getParameter('q'), $this->getUser()->getCulture());
    $query->andWhere('i.model = ?', 'rtGuardUser');
    $query->limit($request->getParameter('limit'));
    $users_raw = $query->execute();

    $users = array();
    foreach ($users_raw as $user)
    {
      $users[$user->getModelId()] = (string) $user;
    }

    return $this->renderText(json_encode($users));
  }

  public function executeIndex(sfWebRequest $request)
  {
    $query = Doctrine::getTable('rtGuardUser')->createQuery('a');
    $query->orderBy('a.created_at DESC');

    $this->pager = new sfDoctrinePager(
      'rtGuardUser',
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

  public function executeToggle(sfWebRequest $request)
  {
    $sf_guard_user = Doctrine_Core::getTable('rtGuardUser')->find(array($request->getParameter('id')));
    if(!$sf_guard_user)
    {
      $this->status = 'error';
      return sfView::SUCCESS;
    }

    $sf_guard_user->setIsActive(!$sf_guard_user->getIsActive());
    $this->status = $sf_guard_user->getIsActive() ? 'activated' : 'deactivated';
    $sf_guard_user->save();
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
