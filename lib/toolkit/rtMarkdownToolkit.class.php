<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
*/

/**
 * rtMarkdown defines Spanish stopwords.
 *
 * @package    gumnut
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtMarkdownToolkit extends MarkdownExtra_Parser
{
  /**
   * Return a string, after replacing Latex math sections with n image equivelant.
   *
   * @param   string  $text
   * @return  string
   */
  static public function transformBase($text, $options = array())
  {
    self::includeLibraries();
    return self::translateMarkdownToHTML($text, $options = array());
  }

  /**
   * Return the transformed markdown.
   *
   * @param unknown_type $string
   * @param unknown_type $options
   * @return unknown
   */
  public static function translateMarkdownToHTML($string, $options = array())
  {
    $options['convert_entities'] = key_exists('convert_entities', $options) ? $options['convert_entities'] : false;
    $string = html_entity_decode($string, ENT_QUOTES, 'UTF-8');

    if($options['convert_entities'])
    {
      $string = htmlentities($string, ENT_QUOTES, 'UTF-8');
    }

    $lines  = explode("\n", $string);
    $incode = false;
    $string = '';
    
    foreach ($lines as $line)
    {
      if ($incode)
      {
        $line = '    '.html_entity_decode($line, ENT_QUOTES, 'UTF-8');
      }
      if (preg_match('/^\s*\[code\s*([^\]]*?)\]/', $line, $match))
      {
        $incode = true;
        $line   = $match[1] ? "\n\n    [".$match[1]."]" : "\n\n";
      }
      if (strpos($line, '[/code]') !== false)
      {
        $incode = false;
        $line   = ' ';
      }

      $string .= $line."\n";
    }

    $html = self::doConvert($string);
    $html = preg_replace('/<pre><code>\$ /s', '<pre class="command-line"><code>$ ', $html);
    $html = preg_replace('#<pre><code>http\://#s', '<pre class="url"><code>http://', $html);
    $html = preg_replace_callback('#<pre><code>(.+?)</code></pre>#s', array('rtMarkdownToolkit', 'geshiHighlighter'), $html);
    return $html;
  }

  /**
   * Integrate Geshi highlighting into matched blocks
   *
   * @param array $matches
   * @param string $default
   * @return string
   */
  private static function geshiHighlighter($matches, $default = '')
  {
    if (preg_match('/^\[(.+?)\]\s*(.+)$/s', $matches[1], $match))
    {
      //$geshi = new sfGeshi(html_entity_decode($match[2]), $match[1]);
      return sfGeshi::parse_single(html_entity_decode($match[2]), $match[1]);
    }
    if (preg_match('/^\[(.+?)\]\s*(.+)$/s', $matches[1], $match))
    {
      $geshi = new sfGeshi(html_entity_decode($match[2]), $match[1]);
      return $geshi->parse_single();
    }
    else
    {
      if ($default)
      {
        $geshi = new sfGeshi(html_entity_decode($matches[1]), $default);
        $geshi->enable_classes();

        return $geshi->parse_code();
      }
      else
      {
        return "<pre><code>".$matches[1].'</pre></code>';
      }
    }
  }

  /**
   * Include required libraries
   *
   */
  private static function includeLibraries()
  {
    require_once(sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'sfGeshiPlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'sfGeshi.class.php');
    require_once(sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'rtCorePlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'markdown' . DIRECTORY_SEPARATOR . 'markdown.php');
  }

  /**
   * Convert text to HTML
   *
   * This function converts given markdown text to HTML.
   * It's just a convenient static shortcut for sfMarkdown::convert()
   *
   * @param   string  $text
   * @return  string
   * @see     sfMarkdown::convert()
   * @static
   */
  public static function doConvert($text)
  {
    $parser = self::getParserInstance();

    // parse, convert and return
    return $parser->convert($text);
  }

  /**
   * Returns a Markdown Parser instance
   *
   * @return  mixed   Markdown parser instance
   */
  public static function getParserInstance()
  {
    static $parser;
    static $class = __CLASS__;

    // get parser instance
    if (!($parser instanceof $class))
    {
      $parser = new $class;
    }
    
    return $parser;
  }

  /**
   * Convert text to HTML
   *
   * This function converts given markdown text to HTML.
   *
   * @param   string  $text
   * @return  string
   */
  public function convert($text)
  {
    // parse, convert and return
    return $this->transform($text);
  }
}