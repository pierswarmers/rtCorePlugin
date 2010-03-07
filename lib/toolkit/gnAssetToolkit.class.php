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
   * Return an array containing extension to mime type pairs
   * @return array
   */
  static public function getMimeTypes()
  {
    return array(
      "ez" => "application/andrew-inset",
      "hqx" => "application/mac-binhex40",
      "cpt" => "application/mac-compactpro",
      "doc" => "application/msword",
      "bin" => "application/octet-stream",
      "dms" => "application/octet-stream",
      "lha" => "application/octet-stream",
      "lzh" => "application/octet-stream",
      "exe" => "application/octet-stream",
      "class" => "application/octet-stream",
      "so" => "application/octet-stream",
      "dll" => "application/octet-stream",
      "oda" => "application/oda",
      "pdf" => "application/pdf",
      "ai" => "application/postscript",
      "eps" => "application/postscript",
      "ps" => "application/postscript",
      "smi" => "application/smil",
      "smil" => "application/smil",
      "wbxml" => "application/vnd.wap.wbxml",
      "wmlc" => "application/vnd.wap.wmlc",
      "wmlsc" => "application/vnd.wap.wmlscriptc",
      "bcpio" => "application/x-bcpio",
      "vcd" => "application/x-cdlink",
      "pgn" => "application/x-chess-pgn",
      "cpio" => "application/x-cpio",
      "csh" => "application/x-csh",
      "dcr" => "application/x-director",
      "dir" => "application/x-director",
      "dxr" => "application/x-director",
      "dvi" => "application/x-dvi",
      "spl" => "application/x-futuresplash",
      "gtar" => "application/x-gtar",
      "hdf" => "application/x-hdf",
      "js" => "application/x-javascript",
      "skp" => "application/x-koan",
      "skd" => "application/x-koan",
      "skt" => "application/x-koan",
      "skm" => "application/x-koan",
      "latex" => "application/x-latex",
      "nc" => "application/x-netcdf",
      "cdf" => "application/x-netcdf",
      "sh" => "application/x-sh",
      "shar" => "application/x-shar",
      "swf" => "application/x-shockwave-flash",
      "sit" => "application/x-stuffit",
      "sv4cpio" => "application/x-sv4cpio",
      "sv4crc" => "application/x-sv4crc",
      "tar" => "application/x-tar",
      "tcl" => "application/x-tcl",
      "tex" => "application/x-tex",
      "texinfo" => "application/x-texinfo",
      "texi" => "application/x-texinfo",
      "t" => "application/x-troff",
      "tr" => "application/x-troff",
      "roff" => "application/x-troff",
      "man" => "application/x-troff-man",
      "me" => "application/x-troff-me",
      "ms" => "application/x-troff-ms",
      "ustar" => "application/x-ustar",
      "src" => "application/x-wais-source",
      "xhtml" => "application/xhtml+xml",
      "xht" => "application/xhtml+xml",
      "zip" => "application/zip",
      "au" => "audio/basic",
      "snd" => "audio/basic",
      "mid" => "audio/midi",
      "midi" => "audio/midi",
      "kar" => "audio/midi",
      "mpga" => "audio/mpeg",
      "mp2" => "audio/mpeg",
      "mp3" => "audio/mpeg",
      "aif" => "audio/x-aiff",
      "aiff" => "audio/x-aiff",
      "aifc" => "audio/x-aiff",
      "m3u" => "audio/x-mpegurl",
      "ram" => "audio/x-pn-realaudio",
      "rm" => "audio/x-pn-realaudio",
      "rpm" => "audio/x-pn-realaudio-plugin",
      "ra" => "audio/x-realaudio",
      "wav" => "audio/x-wav",
      "pdb" => "chemical/x-pdb",
      "xyz" => "chemical/x-xyz",
      "bmp" => "image/bmp",
      "gif" => "image/gif",
      "ief" => "image/ief",
      "jpeg" => "image/jpeg",
      "jpg" => "image/jpeg",
      "jpe" => "image/jpeg",
      "png" => "image/png",
      "tiff" => "image/tiff",
      "tif" => "image/tif",
      "djvu" => "image/vnd.djvu",
      "djv" => "image/vnd.djvu",
      "wbmp" => "image/vnd.wap.wbmp",
      "ras" => "image/x-cmu-raster",
      "pnm" => "image/x-portable-anymap",
      "pbm" => "image/x-portable-bitmap",
      "pgm" => "image/x-portable-graymap",
      "ppm" => "image/x-portable-pixmap",
      "rgb" => "image/x-rgb",
      "xbm" => "image/x-xbitmap",
      "xpm" => "image/x-xpixmap",
      "xwd" => "image/x-windowdump",
      "igs" => "model/iges",
      "iges" => "model/iges",
      "msh" => "model/mesh",
      "mesh" => "model/mesh",
      "silo" => "model/mesh",
      "wrl" => "model/vrml",
      "vrml" => "model/vrml",
      "css" => "text/css",
      "html" => "text/html",
      "htm" => "text/html",
      "asc" => "text/plain",
      "txt" => "text/plain",
      "rtx" => "text/richtext",
      "rtf" => "text/rtf",
      "sgml" => "text/sgml",
      "sgm" => "text/sgml",
      "tsv" => "text/tab-seperated-values",
      "wml" => "text/vnd.wap.wml",
      "wmls" => "text/vnd.wap.wmlscript",
      "etx" => "text/x-setext",
      "xml" => "text/xml",
      "xsl" => "text/xml",
      "mpeg" => "video/mpeg",
      "mpg" => "video/mpeg",
      "mpe" => "video/mpeg",
      "qt" => "video/quicktime",
      "mov" => "video/quicktime",
      "mxu" => "video/vnd.mpegurl",
      "avi" => "video/x-msvideo",
      "movie" => "video/x-sgi-movie",
      "ice" => "x-conference-xcooltalk"
    );
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
    $options['inflate'] = isset($options['inflate']) ? $options['inflate'] : true;
    $options['quality'] = isset($options['quality']) ? $options['quality'] : 75;
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