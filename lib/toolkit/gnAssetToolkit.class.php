<?php

/*
 * This file is part of the steercms package.
 * (c) digital Wranglers <steercms@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnAssetToolkit provides a generic set of file system tools.
 *
 * @package    gumnut
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnAssetToolkit
{
  /**
   * Create a new directory.
   *
   * This method creates a new directory at a given $location, then sets the permissions.
   *
   * An $options array can be included. Settings available are:
   *
   * - mode, permissions for new file (defaults to 0775)
   *
   * @param string $location
   * @param array $options
   */
  static public function makeDir($location, $options = array())
  {
    $options['mode'] = key_exists('mode',$options) ? $options['mode'] : 0775;
    $options['recursive'] = key_exists('recursive',$options) ? $options['recursive'] : true;

    if(is_dir($location))
    {
      return;
    }

    mkdir($location,$options['mode'], $options['recursive']);
    //chmod($location, $options['mode']);
  }

  /**
   * Create a new file or update an existing.
   *
   * An $options array can be included. Settings available are:
   *
   * - mode, permissions for new file (defaults to 0664)
   *
   * @param string $location
   * @param string $content
   * @param array $options
   */
  static public function putContents($location, $contents, $options = array())
  {
    $options['mode'] = key_exists('mode',$options) ? $options['mode'] : 0664;
    file_put_contents($location, $contents);
    chmod($location, $options['mode']);
  }

  /**
   * Alias of SteerCmsAssetTools::cleanFilename().
   *
   * @param string $string
   * @return string
   * @see gnAssetToolkit::cleanFilename()
   */
  public static function sanitizeName($string)
  {
    return self::cleanFilename($string);
  }

  /**
   * Recursively Deletes
   *
   * This method recursively deletes the provided $path from the files system,
   * and it does so with extreme enthusiasm.
   *
   * <strong>Warning</strong>: be careful when using this method: make sure
   * it's being executed with appropriate permissions and the $path parameter
   * is carefully controlled.
   *
   * @param string $path
   * @return void
   */
  static public function recursiveDelete( $path)
  {
    $sourcePath = realpath( $path );

    if(!$sourcePath)
    {
      return;
    }

    if(is_file($sourcePath) || is_link($sourcePath))
    {
      if (@unlink($sourcePath) === false)
      {
        throw new sfException('recursiveDelete() failed when trying to unlink file $path - '. $sourcePath);
      }
      return;
    }

    $dir = @dir( $sourcePath );

    if ( !$dir )
    {
      return;
      //throw new sfException( "Failed to read " . $sourcePath );
    }

    while ( ( $item = $dir->read() ) !== false )
    {
      if( $item == '.' || $item == '..' )
      {
        continue;
      }
      self::recursiveDelete( $sourcePath . DIRECTORY_SEPARATOR . $item );
    }

    if ( !@rmdir( $path ) )
    {
      throw new sfException('recursiveDelete() failed when trying to remove directory $path - '. $path);
    }
  }

  /**
   * Recursively Copy
   *
   * This method recursively copies from the provided $source to the $destination.
   *
   * An $options array can be included. Settings available are:
   *
   * - overwrite, if an existing file exists, should it be overwritten (defaults to false)
   * - dirMode, permissions for new directory (defaults to 0775)
   * - fileMode, permissions for new file (defaults to 0664)
   *
   * @param string $source
   * @param string $destination
   * @param array $options
   * @return void
   */
  static public function recursiveCopy( $source, $destination, Array $options = array() )
  {
    // Set some default values
    $options['overwrite'] = key_exists('overwrite',$options) ? $options['overwrite'] : false;
    $options['dirMode'] = key_exists('dirMode',$options) ? $options['dirMode'] : 0775;
    $options['fileMode'] = key_exists('fileMode',$options) ? $options['fileMode'] : 0664;

    // Check $source exists
    if ( !is_file( $source ) && !is_dir( $source ) )
    {
      throw new sfException( 'recursiveCopy() failed becuase the $source - ' . $source );
    }

    // Ignore non readable files as $source
    if ( !is_readable( $source ) )
    {
      return;
    }

    // $destination shouldn't exist unless we are in $overwrite mode
    if ( is_file( $destination ) || is_dir( $destination ) )
    {
      if ( $options['overwrite'] === true )
      {
        self::recursiveDelete( $destination );
      }
      else
      {
        throw new sfException( 'recursiveCopy() failed becuase an existing file or directory is already at $destination - ' . $source );
      }
    }

    // Start copying
    if ( is_file( $source ) )
    {
      copy( $source, $destination );
      chmod( $destination, $options['fileMode'] );
      return;
    }
    elseif ( is_dir( $source ) )
    {
      mkdir( $destination );
      chmod( $destination, $options['dirMode'] );
    }

    $directory = opendir( $source );

    while( $file = readdir( $directory ) )
    {
      if ($file == '.' || $file == '..')
      {
        continue;
      }
      self::recursiveCopy(
      sprintf( "%s%s%s", $source, DIRECTORY_SEPARATOR, $file ),
      sprintf( "%s%s%s", $destination, DIRECTORY_SEPARATOR, $file ) );
    }
  }
  
  /**
   * Safely Rename
   *
   * This method renames with provided $source to the $destination.
   *
   * An $options array can be included. Settings available are:
   *
   * - overwrite, if an existing file exists, should it be overwritten (defaults to false)
   *
   * @param string $source
   * @param string $destination
   * @param array $options
   * @return void
   */
  static public function safeRename( $source, $destination, Array $options = array() )
  {
    // Set some default values
    $options['overwrite'] = key_exists('overwrite',$options) ? $options['overwrite'] : false;

    // Check $source exists
    if ( !is_file( $source ) && !is_dir( $source ) )
    {
      throw new sfException( 'safeRename() failed failed to find $source - ' . $source );
    }

    // $destination shouldn't exist unless we are in $overwrite mode
    if ( is_file( $destination ) || is_dir( $destination ) )
    {
      if ( $options['overwrite'] === true )
      {
        self::recursiveDelete( $destination );
      }
      else
      {
        throw new sfException( 'recursiveCopy() failed becuase an existing file or directory is already at $destination - ' . $source );
      }
    }

    // rename
    if ( @rename(  $source, $destination ) === false )
    {
      throw new sfException( 'rename() failed for' . $source .'->'.$destination );
    }
  }

  /*
   * Take a string, and return it, cleaned of any characters which might cause trouble
   * in a filesystem or uri sense.
   *
   * Please Note: mostly stolen from Francois', sfSimpleBlogTools.class.php :D
   * Visit Symfony project site for the full run-down.
   *
   * @param string $string
   * @param boolean $to_lc should the returned string be forced to lower case
   */
  static public function cleanFilename($string, $to_lc = false)
  {
    // strip all non word chars
    //$string = preg_replace('/\W/', ' ', $string);

    // replace all white space sections with an underscore
    $string = preg_replace('/\ +/', '-', $string);

    // trim dashes
    $string = preg_replace('/\-$/', '', $string);
    $string = preg_replace('/^\-/', '', $string);

    // trim underscores
    $string = preg_replace('/\-$/', '', $string);
    $string = preg_replace('/^\-/', '', $string);

    // remove double ..
    $string = preg_replace('/\.\./', '', $string);

    $string = preg_replace("/[^-_a-zA-Z0-9.s]/", "", $string);

    if($string == "")
    {
      throw new sfException('Invallid filename returned from cleaning function');
    }

    if ($to_lc)
    {
      $string = strtolower($string);
    }

    return $string;
  }

  /**
   * Check if a file is text based by its extension
   *
   * @param string $slug
   * @return boolean
   */
  static public function isTextFile($slug)
  {
    return in_array(self::getExtension($slug), SteerCmsConfiguration::get('app_steer_cms_text_extensions'));
  }

  /**
   * Return the extension from a given filename
   *
   * @param string $filename
   * @return string
   */
  static public function getExtension($filename)
  {
    return strtolower(str_replace(".", "", strrchr( $filename, "." )));
  }

  /**
   * Return the mime type from a given filename
   *
   * @param string $filename
   * @return string
   */
  static public function getMimeTypeFromName($filename)
  {
    $mimetypes = self::getMimeTypes();
    $ext = self::getExtension($filename);

    if(array_key_exists($ext, $mimetypes))
    {
      return $mimetypes[$ext];
    }
    else
    {
      return 'text/plain';
    }
  }

  /**
   * Return a list of common web mime-types.
   *
   * Note: this list is intended to be concise rather than exhastive.
   *
   * @return array
   */
  static public  function getCommonMimeTypes()
  {
    return array(
      // multi-purpose
      'application/javascript',
      'application/ogg',
      'application/pdf',
      'application/xhtml+xml',
      'application/xml-dtd',
      'application/json',
      'application/zip',
      'application/postscript',
      // audio
      'audio/basic',
      'audio/mp4',
      'audio/mpeg',
      'audio/ogg',
      'audio/vorbis',
      'audio/x-ms-wma',
      'audio/vnd.rn-realaudio',
      'audio/vnd.wave',
      // image
      'image/gif',
      'image/jpeg',
      'image/pjpeg',
      'image/png',
      'image/svg+xml',
      'image/tiff',
      'image/x-png',
      'image/vnd.microsoft.icon',
      // message
      'message/http',
      // text
      'text/css',
      'text/csv',
      'text/html',
      'text/javascript',
      'text/plain',
      'text/xml',
      // video
      'video/mpeg',
      'video/mp4',
      'video/ogg',
      'video/quicktime',
      'video/x-ms-wmv',
      // vnd
      'application/msword',
      'application/vnd.oasis.opendocument.text',
      'application/vnd.oasis.opendocument.spreadsheet',
      'application/vnd.oasis.opendocument.presentation',
      'application/vnd.oasis.opendocument.graphics',
      'application/vnd.ms-excel',
      'application/vnd.ms-powerpoint',
      'application/vnd.mozilla.xul+xml',
      // x
      'application/x-www-form-urlencoded',
      'application/x-dvi',
      'application/x-gzip',
      'application/x-gtar',
      'application/x-javascript',
      'application/x-latex',
      'application/x-shockwave-flash',
      'application/x-stuffit',
      'application/x-rar-compressed',
      'application/x-tar'
    );
  }

  public static function translateExtensionToBase($filename)
  {
    $ext = self::getExtension($filename);

    $types = array(
      // ms-word
      'docx' => 'doc',
      'docm' => 'doc',
      'dotx' => 'doc',
      'dotm' => 'doc',
      'dotm' => 'doc',
      'doc'  => 'doc',
      // ms-excel
      'xlsx' => 'xsl',
      'xlsm' => 'xsl',
      'xltx' => 'xsl',
      'xltm' => 'xsl',
      'xlsb' => 'xsl',
      'xlam' => 'xsl',
      'xls' => 'xls',
      // ms-powerpoint
      'pptx' => 'ppt',
      'pptm' => 'ppt',
      'potx' => 'ppt',
      'potm' => 'ppt',
      'ppam' => 'ppt',
      'ppsx' => 'ppt',
      'ppsm' => 'ppt',
      'ppt' => 'ppt',
      // adobe-flash
      'fla' => 'swf',
      'flv' => 'swf',
      'swf' => 'swf',
      // generic code
      'js'  => 'code',
      'css' => 'code',
      'json' => 'code',
      // archives
      'zip' => 'archive',
      'gz' => 'archive',
      'tgz' => 'archive',
      'rar' => 'archive',
      'jar' => 'archive',
      // pictures
      'ai' => 'picture',
      'bmp' => 'picture',
      'tiff' => 'picture',
      // film
      'mov' => 'film',
      'mp4' => 'film',
      'avi' => 'film',
      'wmv' => 'film',
      // music
      'mp3' => 'music',
      'mpeg' => 'music',
      // other
      'php' => 'php',
      'c' => 'c',
      'h' => 'h',
      'java' => 'java',
      'html' => 'html',
      'xhtml' => 'html',
      'psd' => 'psd',
      'svg' => 'svg',
      'xml' => 'xml',
      'xslt' => 'xml',
      'rss' => 'xml',
      'json' => 'script',
      'pdf' => 'pdf'
    );

    if(isset($types[$ext]))
    {
      return $types[$ext];
    }
    return 'plain';
  }

  /**
   * Return the path a a valid thumbnail.
   *
   * @param string $file_path
   * @param array $options
   */
  public static function getThumbnailPath($file_path, $options = array())
  {
    $options['maxWidth'] = isset($options['maxWidth']) ? $options['maxWidth'] : 150;
    $options['maxHeight'] = isset($options['maxHeight']) ? $options['maxHeight'] : 150;
    $options['dir'] = isset($options['dir']) ? $options['dir'] : sfConfig::get('app_asset_thumbnail_dir', '/_thumbnail_cache');
    $options['scale'] = isset($options['scale']) ? $options['scale'] : true;
    $options['inflate'] = isset($options['inflate']) ? $options['inflate'] : false;
    $options['quality'] = isset($options['quality']) ? $options['quality'] : 80;
    $options['targetMime'] = isset($options['targetMime']) ? $options['targetMime'] : null;
    $options['adapterClass'] = isset($options['adapterClass']) ? $options['adapterClass'] : null;
    $options['adapterOptions'] = isset($options['adapterOptions']) ? $options['adapterOptions'] : array();

    $full_thumbnail_dir = sfConfig::get('sf_web_dir').$options['dir'];
    $size_store_dir = DIRECTORY_SEPARATOR . $options['maxWidth'] . 'x' . $options['maxHeight'];
    $sub_web_dir = str_replace(sfConfig::get('sf_web_dir'), '', $file_path);

    $target = $full_thumbnail_dir . $size_store_dir .$sub_web_dir;

    if(!is_dir(dirname($target)))
    {
      mkdir(dirname($target),0777,true);
    }

    if(!file_exists($target))
    {
      // Process the thumbnail.
      $thumbnail = new sfThumbnail($options['maxWidth'], $options['maxHeight'], $options['scale'], $options['inflate'], $options['quality'], $options['adapterClass'],$options['adapterOptions']);
      $thumbnail->loadFile($file_path);
      $thumbnail->save($target, $options['targetMime']);
    }

    return $options['dir'] . $size_store_dir . $sub_web_dir;
  }
}