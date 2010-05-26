<?php

/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * rtIndexCleanerEs defines Spanish stopwords.
 *
 * @package    gumnut
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtIndexToolkit
{
  /**
   * Return a string with html tags, special charecters and puctuation removed.
   *
   * @param  string $string
   * @return string
   */
  static public function getCleanedString($string)
  {
    $string = strip_tags($string);
    $string = preg_replace('/[\'`�"]/', '', $string);
    $string = Doctrine_Inflector::unaccent($string);
    $string = preg_replace('/[^A-Za-z0-9]/', ' ', $string);
    $string = preg_replace('/\s\s+/', ' ', trim($string));
    $string = strtolower($string);
    return $string;
  }

  /**
   * Retrieve an array of cleaned words from a string.
   *
   * @param text input
   * @return array
   */
  static public function getWordsFromString($string)
  {
    $string = self::getCleanedString($string);

    return explode(' ', $string);
  }

  /**
   * Retrieve a cleaned array of words from a string. This will remove all stopwords.
   *
   * @param string $string
   * @param string $lang
   * @return array
   */
  static public function getCleanedWordsFromString($string, $lang)
  {
    $words = self::getWordsFromString($string);

    $words = self::removeStopwordsFromArray($words, $lang);

    return $words;
  }

  /**
   * Retrieve an array of stemmed words from a string.
   *
   * @param string $string
   * @param string $lang
   * @return array
   */
  static public function getStemmedWordsFromString($string, $lang)
  {
    $words = self::getCleanedWordsFromString($string, $lang);

    $words = self::stemWordsInArray($words, $lang);

    return $words;
  }

  /**
   *
   * @param string $lang
   * @return mixed string of class name on success, otherwise false
   */
  static public function getIndexCleanerClass($lang)
  {
    $class_name = 'rtIndexCleaner' . ucfirst($lang);
    if(class_exists($class_name))
    {
      return $class_name;
    }
    return false;
  }

  /**
   * Removes stopwords from an array of words. Exact matches are required, so this
   * method would typically be used in conjuction with SteerCmsSearchAnalyzer::getCleanedString().
   *
   * @param array $words
   * @param string $lang
   * @return array
   */
  static public function removeStopwordsFromArray($words, $lang)
  {
    $class_name = self::getIndexCleanerClass($lang);
    
    if(!$class_name)
    {
      return $words;
    }

    $stop_words = call_user_func(array($class_name, 'getStopwords'));
    
    foreach($words as $i => $word)
    {
      if(in_array($word, $stop_words) || strlen($word) < 2)
      {
        unset($words[$i]);
      }
    }
    return $words;
  }

  /**
   * Return an array of words, each moved back to it's stemmed origin.
   *
   * @param  array $words
   * @param  string $lang
   * @return array
   */
  static public function stemWordsInArray($words, $lang)
  {
    $class_name = self::getIndexCleanerClass($lang);
    
    foreach($words as $i => $word)
    {
      if(strlen($word) > 2)
      {
        $words[$i] = call_user_func(array($class_name, 'stemWord'), $word);
      }
    }
    return $words;
  }
}