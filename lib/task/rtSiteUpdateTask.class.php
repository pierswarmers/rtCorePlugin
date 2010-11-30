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
class rtSiteUpdateTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('domain', sfCommandArgument::REQUIRED, 'The current domain - including subdomain (if other than www) and port (if other than 80), e.g. sub1.my-domain.com:8081'),
      new sfCommandArgument('newdomain', sfCommandArgument::REQUIRED, 'The new domain - including subdomain (if other than www) and port (if other than 80), e.g. sub1.my-domain.com:8081'),
      new sfCommandArgument('title', sfCommandArgument::REQUIRED, 'The new title of the site, e.g. My Awesome Site'),
      new sfCommandArgument('reference_key', sfCommandArgument::REQUIRED, 'The new key this site will be used to refer to, e.g. mysite1')
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));

    $this->namespace = 'rt';
    $this->name = 'update-site';
    $this->briefDescription = 'Updates an site';

    $this->detailedDescription = <<<EOF
The [rt:create-site|INFO] task updates a site:

  [./symfony rt:create-site my-domain.com my-new-domain.com|INFO]

Subdomain (if other than www) and port (if other than 80), e.g. sub1.my-domain.com:8081 should also be included in definition.
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $rt_site = Doctrine::getTable('rtSite')->findOneByDomain($arguments['domain']);
    if($rt_site)
    {
      $rt_site->setDomain($arguments['newdomain']);
      $rt_site->setTitle($arguments['title']);
      $rt_site->setReferenceKey($arguments['reference_key']);
      $rt_site->save();
      $this->logSection('rt', sprintf('Updated site "%s" to new domain "%s"', $arguments['domain'], $arguments['newdomain']));
    }
    else
    {
      $this->logSection('rt', sprintf('Couldn\'t find site "%s" to update', $arguments['domain']));
    }
  }
}