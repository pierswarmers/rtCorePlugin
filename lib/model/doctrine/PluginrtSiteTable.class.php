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
 * PluginrtSiteTable
 *
 * @package    rtCorePlugin
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class PluginrtSiteTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object PluginrtSiteTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('PluginrtSite');
    }
}