<?php
/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * Heavily based on the workings in sfJqueryTreeDoctrineManager.
 *
 * Many thanks to the hard work of:
 * - Gregory Schurgast <michkinn@gmail.com> and,
 * - Gordon Franke <info@nevalon.de>
 *
 * Copyright (c) 2009-2010 Gregory Schurgast
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and
 * associateddocumentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 */

/**
 * BasegnTreeAdminActions.
 *
 * @package    gumnut
 * @subpackage modules
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class BasegnTreeAdminActions extends sfActions
{
  public function getTree($model, $rootId = null)
  {
    $tree = Doctrine_Core::getTable($model)->getTree();

    $options = array();
    if($rootId !== null)
    {
      $options['root_id'] = $rootId;
    }

    return $tree->fetchTree($options);
  }

  public function executeAdd_child()
  {
    $parent_id = $this->getRequestParameter('parent_id');
    $model = $this->getRequestParameter('model');
    $field = $this->getRequestParameter('field');
    $value = $this->getRequestParameter('value');
    $record = Doctrine_Core::getTable($model)->find($parent_id);

    $child = new $model;
    $child->set($field, $value);
    $record->getNode()->addChild($child);

    $this->json = json_encode($child->toArray());

    $this->getResponse()->setHttpHeader('Content-type', 'application/json');
    $this->setTemplate('json');
  }

  public function executeAdd_root()
  {
    $model = $this->getRequestParameter('model');
    $data = $this->getRequestParameter( strtolower($model) );
    $tree = $this->getTree($model);

    $root = new $model;
    $root->synchronizeWithArray( $data );
		$root->save();

    Doctrine_Core::getTable($model)->getTree()->createRoot($root);
    $this->records = $this->getTree($model);

    $this->json = json_encode($root->toArray());
    $this->getResponse()->setHttpHeader('Content-type', 'application/json');
    $this->setTemplate('json');
  }

  public function executeEdit_field()
  {
    $id = $this->getRequestParameter('id');
    $model = $this->getRequestParameter('model');
    $field = $this->getRequestParameter('field');
    $value = $this->getRequestParameter('value');

    $record = Doctrine_Core::getTable($model)->find($id);
    $record->set($field, $value);
    $record->save();

    $this->json = json_encode($record->toArray());
    $this->getResponse()->setHttpHeader('Content-type', 'application/json');
    $this->setTemplate('json');
  }

  public function executeDelete()
  {
    $id = $this->getRequestParameter('id');
    $model = $this->getRequestParameter('model');

    $record = Doctrine_Core::getTable($model)->find($id);
    $record->getNode()->delete();
    $this->json = json_encode(array());
    $this->getResponse()->setHttpHeader('Content-type', 'application/json');
    $this->setTemplate('json');
  }

  public function executeMove()
  {
    $id = $this->getRequestParameter('id');
    $to_id = $this->getRequestParameter('to_id');
    $model = $this->getRequestParameter('model');
    $movetype = $this->getRequestParameter('movetype');

    $record = Doctrine_Core::getTable($model)->find($id);
    $dest = Doctrine_Core::getTable($model)->find($to_id);

    if( $movetype == 'inside' )
    {
      //$prev = $record->getNode()->getPrevSibling();
      $record->getNode()->moveAsLastChildOf($dest);
    }
    else if( $movetype == 'after' )
    {
      $record->getNode()->moveAsNextSiblingOf($dest);
    }

    else if( $movetype == 'before' )
    {
      //$next = $record->getNode()->getNextSibling();
      $record->getNode()->moveAsPrevSiblingOf($dest);
    }
    $this->json = json_encode($record->toArray());
    $this->getResponse()->setHttpHeader('Content-type', 'application/json');
    $this->setTemplate('json');
  }
}
