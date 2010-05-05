<?php
require_once dirname(__FILE__).'/../bootstrap/unit.php';

$t = new lime_test(6);

$configuration = ProjectConfiguration::getApplicationConfiguration( 'frontend', 'test', true);

new sfDatabaseManager($configuration);

$t->is(gnSiteToolkit::cleanDomainString('www.domain.com'), 'domain.com', '::cleanDomainString() Got the correct value.');
$t->is(gnSiteToolkit::cleanDomainString('www.www-domain.com'), 'www-domain.com', '::cleanDomainString() Got the correct value.');
$t->is(gnSiteToolkit::cleanDomainString('sub1.domain.com'), 'sub1.domain.com', '::cleanDomainString() Got the correct value.');
$t->is(gnSiteToolkit::cleanDomainString('sub2.www.domain.com'), 'sub2.www.domain.com', '::cleanDomainString() Got the correct value.');

$t->is(gnSiteToolkit::isMultiSiteEnabled(), sfConfig::get('app_gn_enable_multi_site'), '::isMultiSiteEnabled() Got the correct value at default.');
sfConfig::set('app_gn_enable_multi_site', true);
$t->is(gnSiteToolkit::isMultiSiteEnabled(), true, '::isMultiSiteEnabled() Got the correct value after alteration.');



