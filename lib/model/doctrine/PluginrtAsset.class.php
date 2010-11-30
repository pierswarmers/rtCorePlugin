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
 * PluginrtAsset
 *
 * @package    rtCorePlugin
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
abstract class PluginrtAsset extends BasertAsset
{
  /**
   * Is this asset an web image.
   *
   * @return boolean
   */
  public function isImage()
  {
    $ext = rtAssetToolkit::getExtension($this->getOriginalFilename());

    if(in_array($ext, sfConfig::get('app_rt_web_image_extensions', array('gif','jpg','png'))))
    {
      return true;
    }
    return false;
  }

  public function getSystemPath()
  {
    return sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . $this->getFilename();
  }

  public function getWebPath()
  {
    $full_path = sfConfig::get('sf_upload_dir') . $this->getSubContainer() . DIRECTORY_SEPARATOR . $this->getFilename();

    return str_replace(sfConfig::get('sf_web_dir'), '', $full_path);
  }

  public function getSubContainer()
  {
    $sub_container = '';

    if($this->getProtected())
    {
      $sub_container = sfConfig::get('app_rt_asset_protected_dir', 'protected');
    }
    else
    {
      $sub_container = sfConfig::get('app_rt_asset_public_dir', '');
    }

    if($sub_container === '' || is_null($sub_container))
    {
      return '';
    }

    return DIRECTORY_SEPARATOR . $sub_container;
  }

  /**
   * Retrieve the attached parent object.
   *
   * @return Doctrine_Record returns the parent object
   */
  public function getObject()
  {
    $object = Doctrine::getTable($this->getModel())->findOneById($this->getModelId());

    return $object;
  }
}