<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnMarkdown defines Spanish stopwords.
 *
 * @package    gumnut
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnMarkdownToolkit extends MarkdownExtra_Parser
{
  /**
   * toHTML is a compliancy based method used in the filtering system.
   *
   * @param string $text
   * @param array $options
   * @return string
   */
  public static function toHTML($text, $options = array())
  {
    self::includeLibraries();

    // include link and abbreviation to text
    $text .= "\n\n".sfConfig::get('project_text_handling_markdown_suffix', '');

    //  return sfConfig::get('project_text_handling_markdown_suffix', '');

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

    // transform [code] blocks to Markdown code blocks
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
    //$html = sfGeshi::parse_mixed($string);
    // Markdown formatting

    
    $html = self::doConvert($string);
    
    // change class for command line stuff
    $html = preg_replace('/<pre><code>\$ /s', '<pre class="command-line"><code>$ ', $html);

    // change class for http:// link
    $html = preg_replace('#<pre><code>http\://#s', '<pre class="url"><code>http://', $html);

    // syntax highlighting
    $html = preg_replace_callback('#<pre><code>(.+?)</code></pre>#s', array('gnMarkdownToolkit', 'geshiHighlighter'), $html);

    return $html;
  }

  /**
   * Proxy method to forward pass string to Gieshi
   *
   * @param unknown_type $matches
   * @return unknown
   */
  private static function geshiHighlighterWithPHPAsDefault($matches)
  {
    return self::geshiHighlighter($matches, 'php');
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
//    if (preg_match('/^\[(.+?)\]\s*(.+)$/s', $matches[1], $match))
//    {
//      $geshi = new sfGeshi(html_entity_decode($match[2]), $match[1]);
//      return $geshi->parse_single();
//    }
//    else
//    {
//      if ($default)
//      {
//        $geshi = new sfGeshi(html_entity_decode($matches[1]), $default);
//        $geshi->enable_classes();
//
//        return $geshi->parse_code();
//      }
//      else
//      {
//        return "<pre><code>".$matches[1].'</pre></code>';
//      }
//    }
  }

  /**
   * Include required libraries
   *
   */
  private static function includeLibraries()
  {
    require_once(sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'sfGeshiPlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'sfGeshi.class.php');
    require_once(sfConfig::get('sf_plugins_dir') . DIRECTORY_SEPARATOR . 'gnCorePlugin' . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'markdown' . DIRECTORY_SEPARATOR . 'markdown.php');
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
        if (!($parser instanceof $class)) {
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