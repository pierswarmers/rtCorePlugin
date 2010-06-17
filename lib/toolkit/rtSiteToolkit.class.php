<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtSiteToolkit provides a set of worker methods for dealing with the multi-site separation.
 *
 * @package    gumnut
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtSiteToolkit
{
  /**
   * Simply runs a check on the multi-site configuration setting.
   * 
   * @return boolean
   */
  public static function isMultiSiteEnabled()
  {
    return sfConfig::get('app_rt_enable_multi_site', false);
  }
  
  /**
   * Return the domain and port as a string. For example: www.my-domain.com:8080
   *
   * Note: Only non-port 80 ports will be returned.
   *
   * @param array $source the array source to retrieve URL from, defalt is $_SERVER
   * @return string
   */
  public static function getCurrentDomain(array $source = null)
  {
    if ( $source === null ) $source = $_SERVER;

    $domain = '';

    if(isset($source['HTTP_HOST']))
    {
      $domain = $source['HTTP_HOST'];
    }
    else
    {
      $domain = $source['SERVER_NAME'];
      if ( isset( $source['SERVER_PORT'] ) && $source['SERVER_PORT'] != 80 )
      {
        $domain .= ":{$source['SERVER_PORT']}";
      }
    }

    return self::cleanDomainString($domain);
  }

  /**
   * Cleans the domain string of "www" subdomains as these are concidered to be the same as the
   * bas domain without "www".
   * 
   * @param string $string
   */
  public static function cleanDomainString($string)
  {
    if(substr($string, 0, 4) === 'www.')
    {
      $string = substr($string, 4);
    }

    return $string;
  }

  /**
   * A passing mechanism to provide site aware redirects.
   *
   * @param sfDoctrineRecord $object
   * @param string $route
   */
  public static function siteRedirect(sfDoctrineRecord $object, $route = null)
  {

    $context = sfContext::getInstance();
    
    if(is_null($route))
    {
      $route = $object->getTable()->getTableName() . '_show';
    }

    if(!rtSiteToolkit::isMultiSiteEnabled() || !$object->rtSite || is_null($object->rtSite->getDomain()))
    {
      $context->getController()->redirect($context->getRouting()->generate($route,$object));
    }

    $source = $context->getRequest()->isSecure() ? 'https://' : 'http://';
    $source .= $object->rtSite->getDomain();
    $source .= $context->getRouting()->generate($route,$object);
    $context->getController()->redirect($source);
  }
}