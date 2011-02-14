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
  private $_export_user_fieldnames = 'id,first_name,last_name,email_address,username,is_super_admin,is_active,last_login,date_of_birth,company,url,created_at,updated_at';

  /**
   * Return a list of table fieldnames (user and address tables only)
   *
   * @return array
   */
  private function getUserAddressFieldnameList()
  {
    $user_fieldnames    = $this->_export_user_fieldnames;
    $address_fieldnames = Doctrine::getTable('rtAddress')->getFieldNames();
    $keys               = array();
    //$keys               = array_merge($keys, explode(',',$user_fieldnames));

    // Add user prefix
    $temp_key           = array();
    foreach(explode(',',$user_fieldnames) as $key => $value)
    {
      $temp_key[]       = 'u_'.$value;
    }
    $keys               = array_merge($keys, $temp_key);

    // Add billing address prefix
    $temp_key           = array();
    foreach($address_fieldnames as $key => $value)
    {
      $temp_key[]       = 'billing_a_'.$value;
    }
    $keys               = array_merge($keys, $temp_key);

    // Add shipping address prefix
    $temp_key           = array();
    foreach($address_fieldnames as $key => $value)
    {
      $temp_key[]       = 'shipping_a_'.$value;
    }
    $keys               = array_merge($keys, $temp_key);
    
    return $keys;
  }

  /**
   * Return address array with empty values
   * 
   * @param string $prefix (e.g. billing or shipping)
   * @return array
   */
  private function getPlaceholderExportAddress($prefix)
  {
    // Get all fieldnames
    $address_fieldnames = Doctrine::getTable('rtAddress')->getFieldNames();

    // Adde prefix to fieldnames
    $fieldnames = array();
    foreach($address_fieldnames as $key => $value)
    {
      $fieldnames[$prefix.'_a_'.$value] = " ";
    }

    return $fieldnames;
  }

  /**
   * Return clean values for use in CSV export
   *
   * @param string $value
   * @return string
   */
  private function cleanExportValue($value)
  {
    $value = str_replace(',', '', $value);
    $value = preg_replace('/[^@.+:\/a-zA-Z0-9_ -]/s', '', $value);
    return $value;
  }

  /**
   * Create user report
   *
   * Formats are: web, csv, xml and json
   *
   * @param sfWebRequest $request
   */
  public function executeUserReport(sfWebRequest $request)
  {
    // Get fieldnames from tables
    $this->keys = $this->getUserAddressFieldnameList();

    // Users
    $q = Doctrine_Query::create()->from('rtGuardUser u');
    $q->select($this->_export_user_fieldnames);
    $q->orderBy('u.created_at, u.last_name');
    $users = $q->execute(array(), Doctrine_Core::HYDRATE_SCALAR);

    // Users with addresses as array
    $users_with_addresses = $this->getUsersWithAddressesArray($users);
    $this->users = $users_with_addresses;

    // CSV header
    if($this->getRequest()->getParameter('sf_format') === 'csv')
    { 
      $this->values = array();
      $i=0;
      foreach($users_with_addresses as $user)
      {
        // Go through the user data values
        foreach($user as $key => $value)
        {
          if($key !== 'u_addresses')
          {
            $this->values[$i][$key]  = (!is_null($value) && $value !== '') ? $this->cleanExportValue($value) : " ";
          }
        }

        // Check if user has address/addresses and act accordingly
        if(array_key_exists('u_addresses', $user))
        {
          if(array_key_exists('shipping',$user['u_addresses']) && array_key_exists('billing',$user['u_addresses']))
          {
            // User has shipping and billing address
            foreach($user['u_addresses'] as $key => $value)
            {
              // Address values
              foreach($user['u_addresses']['billing'] as $key => $value)
              {
                $key   = 'billing_' . $key;
                $this->values[$i][$key]  = (!is_null($value) && $value !== '') ? $value : " ";
              }
              foreach($user['u_addresses']['shipping'] as $key => $value)
              {
                $key   = 'shipping_' . $key;
                $this->values[$i][$key]  = (!is_null($value) && $value !== '') ? $value : " ";
              }
            }
          }
          elseif(array_key_exists('shipping',$user['u_addresses']))
          {
            // Use dummy billing address with spaces as values
            $this->values[$i] =  array_merge($this->values[$i],$this->getPlaceholderExportAddress('billing'));
            // User has shipping address only
            foreach($user['u_addresses']['shipping'] as $key => $value)
            {
              $key   = 'shipping_' . $key;
              $this->values[$i][$key]  = (!is_null($value) && $value !== '') ? $value : " ";
            }
          }
          else
          {
            // User has billing address only
            foreach($user['u_addresses']['billing'] as $key => $value)
            {
              $key   = 'billing_' . $key;
              $this->values[$i][$key]  = (!is_null($value) && $value !== '') ? $value : " ";
            }
            // Use dummy billing address with spaces as values
            $this->values[$i] = array_merge($this->values[$i],$this->getPlaceholderExportAddress('shipping'));
          }

        }
        else
        {
          // User has no billing address, use dummy address with spaces as values
          $this->values[$i] =  array_merge($this->values[$i],$this->getPlaceholderExportAddress('billing'));
          
          // User has no shipping address, use dummy address with spaces as values
          $this->values[$i] =  array_merge($this->values[$i],$this->getPlaceholderExportAddress('shipping'));
        }
        $i++;
      }
    }

    // Set order report headers for export files
    if(in_array($this->getRequest()->getParameter('sf_format'), array('csv','xml','json')))
    {
      // Report filename: user_report_[year|month|day].[csv/xml/json]
      $this->setReportHeader($this->getRequest()->getParameter('sf_format'), 'user_report_'.date('Ymd'));
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
   * Return array of users combined with billing and shipping addresses
   *
   * @param Doctrine_Collection $users
   * @return Array
   */
  protected function getUsersWithAddressesArray($users)
  {
    // Addresses for users
    $query = Doctrine_Query::create()->from('rtAddress a');
    $query->select('a.*')
          ->andWhere('a.model = ?', 'rtGuardUser');

    $user_addresses = $query->execute(array(), Doctrine_Core::HYDRATE_SCALAR);

    $clean_users     = array();
    $clean_addresses = array();

    foreach($users as $user)
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
      // Clean values to prevent export errors
      foreach($user as $key => $value)
      {
        $users_with_addresses[$ukey][$key] = $this->cleanExportValue($value);
      }
      if(isset($clean_addresses[$ukey]))
      {
        foreach($clean_addresses[$ukey] as $key => $address)
        {
          // Clean values to prevent export errors
          foreach($address as $key => $value)
          {
            $users_with_addresses[$ukey]['u_addresses'][$address['a_type']][$key] = $this->cleanExportValue($value);
          }
        }
      }
    }
    return $users_with_addresses;
  }

  /**
   * Set headers for csv, xml and json exports
   *
   * @param String $sf_format
   */
  protected function setReportHeader($sf_format, $filename = 'user_report')
  {
    $response = $this->getResponse();
    // Format switch
    switch ($sf_format) {
      case 'csv':
        $response->setHttpHeader('Last-Modified', date('r'));
        $response->setContentType("application/octet-stream");
        $response->setHttpHeader('Cache-Control','no-store, no-cache');
        $response->setHttpHeader('Content-Disposition','attachment; filename="'.$filename.'.csv"');
        break;
      case 'xml':
        $response->setHttpHeader('Content-Disposition','attachment; filename="'.$filename.'.xml"');
        break;
      case 'json':
        $response->setHttpHeader('Content-Disposition','attachment; filename="'.$filename.'.json"');
        break;
    }
  }

  /**
   * API: Return XML or JSON stream of users
   *
   * @param sfWebRequest $request
   * @return Mixed
   */
  public function executeDownloadReport(sfWebRequest $request)
  {
    $response = $this->getResponse();

    // 403 - Access denied
    if(!rtApiToolkit::grantApiAccess($request->getParameter('auth')))
    {
      $response->setHeaderOnly(true);
      $response->setStatusCode(403);
      return sfView::NONE;
    }

    // Users
    $q = Doctrine_Query::create()->from('rtGuardUser u');
    $q->select($this->_export_user_fieldnames);

    // With from date
    if($request->hasParameter('date_from') && $request->getParameter('date_from') !== '')
    {
      $q->andWhere('u.created_at >= ?', urldecode($request->getParameter('date_from')));
    }

    // With to date
    if($request->hasParameter('date_to') && $request->getParameter('date_to') !== '')
    {
      $q->andWhere('u.created_at <= ?', urldecode($request->getParameter('date_to')));
    }

    $q->orderBy('u.created_at, u.last_name');
    $users = $q->execute(array(), Doctrine_Core::HYDRATE_SCALAR);

    // Users with addresses as array
    $this->users = $this->getUsersWithAddressesArray($users);

    if(in_array($this->getRequest()->getParameter('sf_format'), array('xml','json')))
    {
      $this->setLayout(false);
    }
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

    $this->stats = $this->stats();
  }

  private function stats()
  {
    // Dates
    $first_next_month = date('Y-m-d H:i:s',mktime(00,00,00,(date("n")+1 <= 12) ? date("n")+1 : 1 ,1,(date("n")+1 <= 12) ? date("Y") : date("Y")+1));
    $first_this_month = date('Y-m-d H:i:s',mktime(00,00,00,date("n"),1,date("Y")));
    $first_last_month = date('Y-m-d H:i:s',mktime(00,00,00,(date("n") != 1) ? date("n")-1 : 12,1,(date("n") != 1) ? date("Y") : date("Y")-1));

    // SQL queries
    $con = Doctrine_Manager::getInstance()->getCurrentConnection();

    $result_users_total               = $con->fetchAssoc("select count(id) as count from sf_guard_user");
    $result_users_total_active        = $con->fetchAssoc("select count(id) as count from sf_guard_user where is_active = 1");
    $result_users_total_admin         = $con->fetchAssoc("select count(id) as count from sf_guard_user where is_super_admin = 1");
    $result_users_total_unused        = $con->fetchAssoc("select count(id) as count from sf_guard_user where last_login Is Null");
    $result_users_added_current_month = $con->fetchAssoc("select count(id) as count from sf_guard_user where created_at > '".$first_this_month."' and created_at < '".$first_next_month."'");

    // Create array
    $stats = array();
    $stats['total']         = $result_users_total[0] != '' ? $result_users_total[0] : 0;
    $stats['total_active']  = $result_users_total_active[0] != '' ? $result_users_total_active[0] : 0;
    $stats['total_admin']   = $result_users_total_admin[0] != '' ? $result_users_total_admin[0] : 0;
    $stats['total_unused']  = $result_users_total_unused[0] != '' ? $result_users_total_unused[0] : 0;
    $stats['month_current'] = $result_users_added_current_month[0] != '' ? $result_users_added_current_month[0] : 0;

    return $stats;
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
