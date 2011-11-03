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
 * PluginrtGuardUser
 *
 * @package    rtCorePlugin
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
abstract class PluginrtGuardUser extends BasertGuardUser
{
  public function getTypeNice()
  {
    return 'Person';
  }

  /**
   * extend the parent method by adding a null, or blank check on username, adding a default value.
   *
   * @param Doctrine_Connection $conn     optional connection parameter
   * @throws Exception                    if record is not valid and validation is active
   * @return void
   */
  public function save(Doctrine_Connection $conn = null)
  {
    if($this->isNew() && (trim($this->username) === '' || is_null($this->username)))
    {
      $this->username = 'user-' . substr(md5(rand() . date(DATE_RFC822)), 0, 8);
    }

    parent::save($conn);
  }
}