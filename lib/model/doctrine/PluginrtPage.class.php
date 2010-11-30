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
 * PluginrtPage
 *
 * @package    rtCorePlugin
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
abstract class PluginrtPage extends BasertPage
{
  public function construct()
  {
    parent::construct();

    if($this->isNew())
    {
      $this->setPublishedFrom(date('Y-m-d H:i:s'));
    }
  }

  /**
   * Undelete a soft deleted object.
   *
   * @param Doctrine_Connection $conn
   * @return void
   */
  public function undelete(Doctrine_Connection $conn = null)
  {
    $this->setDeletedAt(null);
    parent::save($conn);
  }

  /**
   * Extends the base published check to include date range settings.
   *
   * @return  boolean
   */
  public function isPublished()
  {
    $published = $this->getPublished();

    if($published)
    {
      $published = $this->isPublishedNow();
    }

    return $published;
  }

  /**
   * Checks if a the published from and to dates are true for "now".
   * 
   * @return boolean
   */
  public function isPublishedNow()
  {
    $from_ok = false;

    if ( is_null($this->getPublishedFrom()) || $this->getPublishedFrom() === '')
    {
      $from_ok = true;
    }
    else
    {
      $from_ok = time() > strtotime( $this->getPublishedFrom() ) ? true : false;
    }

    $to_ok = false;

    if ( is_null($this->getPublishedTo()) || $this->getPublishedTo() === '')
    {
      $to_ok = true;
    }
    else
    {
      $to_ok = time() < strtotime( $this->getPublishedTo() ) ? true : false;
    }

    return ($from_ok && $to_ok);
  }

  /**
   * Return all attached string, imploded into a comma separated string.
   * 
   * @return string
   */
  public function getTagsAsString()
  {
    return implode(', ', $this->getTags());
  }
}