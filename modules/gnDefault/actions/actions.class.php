<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/../lib/BasegnDefaultActions.class.php');

/**
 * gnDefaultActions handles the default sytem pages: 404 etc..
 *
 * @package    gumnut
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnDefaultActions extends BasegnDefaultActions
{
  public function preExecute()
  {
    parent::postExecute();
    sfConfig::set('app_gn_node_title', '404: Page not found');
  }
}
