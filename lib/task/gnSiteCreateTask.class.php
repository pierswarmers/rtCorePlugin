<?php

/*
 * This file is part of the steercms package.
 * (c) digital Wranglers <steercms@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnSiteCreate provides a cli task to create new sites..
 *
 * @package    gumnut
 * @subpackage task
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnSiteCreateTask extends sfBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('domain', sfCommandArgument::REQUIRED, 'The domain - including subdomain (if other than www) and port (if other than 80), e.g. sub1.my-domain.com:8081')
    ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', null),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));

    $this->namespace = 'gn';
    $this->name = 'create-site';
    $this->briefDescription = 'Creates a new site';

    $this->detailedDescription = <<<EOF
The [gn:create-site|INFO] task creates a site:

  [./symfony gn:create-site my-domain.com|INFO]

Subdomain (if other than www) and port (if other than 80), e.g. sub1.my-domain.com:8081 can also be included in definition.
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);

    $gn_site = Doctrine::getTable('gnSite')->findOneByDomain($arguments['domain']);

    if(!$gn_site)
    {
      $gn_site = new gnSite();
      $gn_site->setDomain($arguments['domain']);
      $gn_site->save();
      $this->logSection('gn', sprintf('Created site "%s"', $arguments['domain']));
    }
    else
    {
      $this->logSection('gn', sprintf('Site "%s" already existed so nothing to do', $arguments['domain']));
    }
  }
}