<?php
/*
 * This file is part of the steercms package.
 * 
 * (c) digital Wranglers <steercms@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtSiteCreate provides a cli task to create new sites..
 *
 * @package    Reditype
 * @subpackage task
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtSiteCreateTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('domain', sfCommandArgument::REQUIRED, 'The domain - including subdomain (if other than www) and port (if other than 80), e.g. sub1.my-domain.com:8081'),
      new sfCommandArgument('title', sfCommandArgument::REQUIRED, 'The title of the site, e.g. My Awesome Site'),
      new sfCommandArgument('reference_key', sfCommandArgument::REQUIRED, 'The key this site will be used to refer to, e.g. mysite1')
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));

    $this->namespace = 'rt';
    $this->name = 'create-site';
    $this->briefDescription = 'Creates a new site';

    $this->detailedDescription = <<<EOF
The [rt:create-site|INFO] task creates a site:

  [./symfony rt:create-site my-domain.com|INFO]

Subdomain (if other than www) and port (if other than 80), e.g. sub1.my-domain.com:8081 can also be included in definition.
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $rt_site = Doctrine::getTable('rtSite')->findOneByDomain($arguments['domain']);

    if(!$rt_site)
    {
      $rt_site = new rtSite();
      $rt_site->setDomain($arguments['domain']);
      $rt_site->setTitle($arguments['title']);
      $rt_site->setReferenceKey($arguments['reference_key']);
      $rt_site->save();
      $this->logSection('rt', sprintf('Created site "%s"', $arguments['domain']));
    }
    else
    {
      $this->logSection('rt', sprintf('Site "%s" already existed so nothing to do', $arguments['domain']));
    }
  }
}