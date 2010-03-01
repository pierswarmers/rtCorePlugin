<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/../lib/BasegnSearchActions.class.php');

/**
 * gnSearchActions handles search functions.
 *
 * @package    gumnut
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnSearchActions extends BasegnSearchActions
{
  public function preExecute()
  {
    parent::postExecute();
    sfConfig::set('app_gn_node_title', 'Search');
  }
}
