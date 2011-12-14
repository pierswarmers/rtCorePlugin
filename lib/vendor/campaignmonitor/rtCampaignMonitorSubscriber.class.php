<?php

/*
 * This file is part of the rtCorePlugin package.
 * 
 * (c) 2006-2010 digital Wranglers <steercms@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/lib/csrest_subscribers.php');

/**
 * rtCampaignMonitorSubscriber - Adding a subscriber, unsubscribing, etc.
 *
 * @package    rtCorePlugin
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtCampaignMonitorSubscriber
{
  private $_log;
  private $_response_code;
  private $_response_message;
//  private $_list_id;
//  private $_api_key;
  private $_wrap;
  private $_options;

  /**
   * Constructor function
   *
   * @throws sfException
   */
  public function __construct($options = array())
  {
    $options['resubscribe'] = isset($options['resubscribe']) ? $options['resubscribe'] : true;
    $options['api_key']     = isset($options['api_key']) ? $options['api_key'] : sfConfig::get('app_campaignmonitor_api_key');
    $options['list_id']     = isset($options['list_id']) ? $options['list_id'] : sfConfig::get('app_campaignmonitor_list_id');

    // Check for API key
    if(is_null($options['api_key']))
    {
      throw new sfException('Campaignmonitor API key is not set or is empty. Please check.');
    }

    // Check for list ID
    if(is_null($options['list_id']))
    {
      throw new sfException('Campaignmonitor list is not set or is empty. Please check.');
    }

    $this->_options = $options;

    // Instanciate wrapper
    $this->_wrap = new CS_REST_Subscribers($this->_options['list_id'], $this->_options['api_key']);
  }

  /**
   * Subscribe function
   *
   * @param rtGuardUser $user
   * @throws sfException
   */
  public function subscribe(rtGuardUser $user)
  {
    $address = $this->getUserBillingAddress($user);

    $customFields = array();
    $customFields[] = array('Key' => 'firstname','Value' => $user->getFirstName());
    $customFields[] = array('Key' => 'lastname','Value' => $user->getLastName());

    if($address)
    {
      $customFields[] = array('Key' => 'postcode','Value' => $address->getPostcode());
      $customFields[] = array('Key' => 'state','Value' => $address->getState());
      $customFields[] = array('Key' => 'country','Value' => $address->getCountry());
    }

    return $this->call('add', array(
      'EmailAddress' => $user->getEmailAddress(),
      'Name' => $user->getFirstName(),
      'CustomFields' => $customFields,
      'Resubscribe' => $this->_options['resubscribe']  // TODO: Decide if TRUE should be really default!?
    ));
  }

  /**
   * Return billing address of rtGuardUser
   * 
   * @param rtGuardUser $user
   * @return rtAddress
   */
  private function getUserBillingAddress(rtGuardUser $user)
  {
    return Doctrine::getTable('rtAddress')->getAddressForModelAndIdAndType('rtGuardUser',$user->getId(),'billing');
  }

  /**
   * Get member details function
   *
   * @param rtGuardUser $user
   * @throws sfException
   */
  public function getDetails(rtGuardUser $user)
  {
    return $this->call('get', $user->getEmailAddress());
  }

  /**
   * Get member history function
   *
   * @param rtGuardUser $user
   * @throws sfException
   */
  public function getHistory(rtGuardUser $user)
  {
    return $this->call('get_history', $user->getEmailAddress());
  }

  /**
   * Unsubscribe function
   *
   * @param rtGuardUser $user
   * @throws sfException
   */
  public function unsubscribe(rtGuardUser $user)
  {
    return $this->call('unsubscribe', $user->getEmailAddress());
  }

  /**
   *
   * @param string $method
   * @param mixed $param
   * @return mixed returns content body on success or fals on error.
   * @throws sfException
   */
  protected function call($method, $param)
  {
    $result = $this->_wrap->$method($param);
    $response = $result->response;
    $this->setLog($response);

    if($this->isApiError($result->http_status_code))
    {
      throw new sfException('CampaignMonitor API failed with: '. $result->http_status_code . ' - ' . $response->Message);
    }

    if($result->was_successful())
    {
      return $response;
    }

    $this->setResponseCode($response->Code);
    $this->setResponseMessage($response->Message);
    return false;
  }

  /**
   * Check for core API errors
   *
   * @return Boolean True if found
   */
  protected function isApiError($string)
  {
    return in_array($string, array(400,401,404,500));
  }

  /**
   * Get response code
   *
   * @return Code
   */
  public function getResponseCode() {
    return $this->_response_code;
  }

  /**
   * Set response code
   *
   * @param  String $string
   * @return void
   */
  public function setResponseCode($string) {
    $this->_response_code = $string;
  }

  /**
   * Get response message
   *
   * @return Code
   */
  public function getResponseMessage() {
    return $this->_response_message;
  }

  /**
   * Set response message
   *
   * @param  String $string
   * @return void
   */
  public function setResponseMessage($string) {
    $this->_response_message = $string;
  }

  /**
   * Get log data
   *
   * @return mixed Log data
   */
  public function getLog($serialized = true) {
    //return $serialized ? serialize($this->_log) : $this->_log;
    return $this->_log;
  }

  /**
   * Set log data
   *
   * @param mixed Log data
   */
  public function setLog($value) {
    $this->_log = $value;
  }
}
?>
