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
   * Is this asset a web image.
   *
   * @return boolean
   */
  public function isImage()
  {
    $ext = rtAssetToolkit::getExtension($this->getOriginalFilename());

    if(in_array($ext, sfConfig::get('app_rt_web_image_extensions', array('gif','jpg','jpeg','png'))))
    {
      return true;
    }
    return false;
  }
  
  /**
   * Is this asset a flash file.
   *
   * @return boolean
   */
  public function isSwf()
  {
    return rtAssetToolkit::getExtension($this->getOriginalFilename()) === 'swf';
  }

  /**
   * Returns the files extension: pdf or png etc...
   * 
   * @return string
   */
  public function getExtension($force_to_lowercase = true)
  {
    if($force_to_lowercase)
    {
      return strtolower(rtAssetToolkit::getExtension($this->getOriginalFilename()));
    }
    
    return rtAssetToolkit::getExtension($this->getOriginalFilename());
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

  /**
   * Retrieve the files content.
   *
   * @return string
   */
  public function getFileContent()
  {
    return file_get_contents($this->getSystemPath());
  }

  /**
   * Retrieve the files content.
   *
   * @param strinf $string
   * @return string
   */
  public function setFileContent($content)
  {
    return file_put_contents($this->getSystemPath(), $content);
  }

  /**
   * Is a file editable as text.
   *
   * @return boolean
   */
  public function isTextEditable()
  {
    return in_array($this->getExtension(), array('txt', 'html', 'htm', 'xhtml', 'xml', 'yml', 'json', 'css', 'rst'));
  }

  /**
   * Enhance the defult deletion to include removal of any static files.
   * 
   * @param Doctrine_Connection $conn
   */
  public function delete(Doctrine_Connection $conn = null)
  {
    unlink($this->getSystemPath());

    $target = sfConfig::get('sf_web_dir') . sfConfig::get('app_asset_thumbnail_dir', '/uploads/_thumbnail_cache');

    $thumbs = sfFinder::type('file')->name($this->getFilename())->in($target);

    foreach ($thumbs as $thumb)
    {
      unlink($thumb);
    }

    parent::delete($conn);
  }
}