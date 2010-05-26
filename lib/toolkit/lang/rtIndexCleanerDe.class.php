<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtIndexCleanerDe defines German stopwords.
 *
 * @package    gumnut
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtIndexCleanerDe implements rtIndexCleaner
{
  /**
   * Defines a list of German stop words to be removed from indexed text.
   *
   * @var array $_stopwords
   */
  protected static $_stopwords = array(
    'aber','als','am','an','auch','auf','aus','bei','bin','bis','bist','da',
    'dadurch','daher','darum','das','da�','dass','dein','deine','dem','den',
    'der','des','dessen','deshalb','die','dies','dieser','dieses','doch','dort',
    'du','durch','ein','eine','einem','einen','einer','eines','er','es','euer',
    'eure','f�r','hatte','hatten','hattest','hattet','hier	hinter','ich','ihr',
    'ihre','im','in','ist','ja','jede','jedem','jeden','jeder','jedes','jener',
    'jenes','jetzt','kann','kannst','k�nnen','k�nnt','machen','mein','meine',
    'mit','mu�','mu�t','musst','m�ssen','m��t','nach','nachdem','nein','nicht',
    'nun','oder','seid','sein','seine','sich','sie','sind','soll','sollen',
    'sollst','sollt','sonst','soweit','sowie','und','unser	unsere','unter',
    'vom','von','vor','wann','warum','was','weiter','weitere','wenn','wer',
    'werde','werden','werdet','weshalb','wie','wieder','wieso','wir','wird',
    'wirst','wo','woher','wohin','zu','zum','zur','�ber'
  );

  /**
   * Return a list of German stopwords.
   *
   * @return array
   */
  static public function getStopwords()
  {
    return self::$_stopwords;
  }

  /**
   * Apply German normalizing logic to string.
   *
   * @param array $words
   * @return array
   */
  static public function stemWord($string)
  {
    if(extension_loaded('stem'))
    {
      return stem_german($string);
    }
    return $string;
  }
}