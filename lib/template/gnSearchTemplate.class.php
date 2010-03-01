<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/listener/GnSearchListener.class.php');

/**
 * gnSearchListener defines some base helpers.
 *
 * @package    gumnut
 * @subpackage template
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnSearchTemplate extends Doctrine_Template
{
  protected $_options = array(
    'indexClass'      => 'gnIndex',
    'indexAlias'      => 'Index',
    'cascadeDelete'   => true,
    'fields'          => array()
  );
  
  public function __construct(array $options = array())
  {
    $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);

    if (!isset($this->_options['connection']))
    {
      $this->_options['connection'] = Doctrine_Manager::connection();
    }
  }
  
  public function setTableDefinition()
  {
    $this->addListener(new gnSearchListener($this->_options));
  }

  /**
   * Retrieve a list columns to be indexed.
   *
   * @return array
   */
  public function getSearchFields()
  {
    return $this->getOption('fields');
  }

  /**
   * Returns the indexable words.
   *
   * @return string
   */
  public function getSearchBlob($lang = null)
  {
    $fields = $this->getSearchFields();
    $blob = '';
    foreach($fields as $field)
    {
      $blob .= $this->getInvoker()->get($field) . ' ';
    }
    return trim($blob);
  }

  /**
   * Save the indexable words into the index.
   *
   * @return array
   */
  public function getSearchIndexArray()
  {
    return gnIndexToolkit::getStemmedWordsFromString(
      $this->getSearchBlob(),
      $this->getLang()
    );
  }

  /**
   * Get or set the language to the default culture value
   *
   * @return string
   */
  public function getLang()
  {
    if(substr(get_class($this->getInvoker()), -11) === 'Translation')
    {
      return trim($this->getInvoker()->lang);
    }
    return sfConfig::get('sf_default_culture');
  }

  /**
   * Clear the index for this object.
   *
   * @return void
   */
  public function clearIndex()
  {
    Doctrine::getTable('gnIndex')->clearIndexForObject($this->getInvoker());
  }
}