<?php
/*
 * This file is part of the Reditype package.
 *
 * (c) 2009-2010 digital Wranglers <info@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once(dirname(__FILE__).'/listener/rtCommentListener.class.php');

/**
 * rtCommentListener defines some base helpers.
 *
 * @package    rtCorePlugin
 * @subpackage template
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
class rtCommentTemplate extends Doctrine_Template
{
  protected $_options = array(
    'rtComment'       => 'rtComment',
    'commentAlias'    => 'Comments',
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

  /**
   * Set the listners.
   * 
   * @return void
   */
  public function setTableDefinition()
  {
    $this->addListener(new rtCommentListener($this->_options));
  }

  /**
   * Fetch an collection of comments attached to this object.
   * 
   * @return Doctrine_Collection
   */
  public function getComments()
  {
    $holder = $this->getCommentsHolder($this->getInvoker());

    if (!isset($holder) || !$holder->hasNamespace('saved_comments'))
    {
      $comments = Doctrine::getTable('rtComment')->getCommentsForObject($this->getInvoker());
      $holder->add($comments, 'saved_comments');
    }

    return $holder->getAll('saved_comments');
  }

  /**
   * Get average rating value
   *
   * @return float
   */
  public function getOverallRating()
  {
    if($this->getNumberOfComments() === 0)
    {
      return 0;
    }

    $rating = 0;

    foreach($this->getComments() as $comment)
    {
      $rating += $comment->getRating();
    }

    return round($rating / $this->getNumberOfComments(), 1);
  }

  /**
   * @return int
   */
  public function getNumberOfComments()
  {
    return count($this->getComments());
  }
  
  /**
   * Get and/or set the parameter holder.
   * @param $object
   * @return sfNamespacedParameterHolder
   */
  private function getCommentsHolder($object)
  {
    if ((!isset($object->_comments)) || ($object->_comments == null))
    {
      $parameter_holder = new sfNamespacedParameterHolder;
      $object->mapValue('_comments', new $parameter_holder());
    }
    return $object->_comments;
  }
}