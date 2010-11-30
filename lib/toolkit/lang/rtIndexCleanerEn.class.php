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
 * rtStopWordsEn defines English stopwords.
 *
 * @package    rtCorePlugin
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class rtIndexCleanerEn implements rtIndexCleaner
{
  /**
   * Defines a list of English stop words to be removed from indexed text.
   *
   * @var array $_stopwords
   */
  protected static $_stopwords = array(
    '0','1','2','3','4','5','6','7','8','9','a','about','after','all','almost',
    'along','also','although','amp','an','and','another','any','are','area',
    'arent','around','as','at','available','back','be','because','been','before',
    'being','best','better','bit','both','but','by','c','came','can','capable',
    'could','course','d','dan','decided','did','didn','different','div','do',
    'doesn','don','down','e','each','easily','easy','either','end','enough',
    'even','every','few','find','for','found','from','get','go','going','got',
    'gt','had','has','have','he','her','here','how','i','if','in','into','is',
    'isn','it','just','know','last','left','li','like','little','ll','look',
    'lot','lt','m','made','make','many','mb','me','menu','might','mm','more',
    'most','much','my','name','nbsp','need','no','not','now','number','of','off',
    'old','on','one','only','or','other','our','out','over','place','point','so',
    'some','something','special','still','stuff','such','sure','t','take','than',
    'that','the','their','them','then','there','these','they','thing','things',
    'think','this','those','though','through','time','to','today','together',
    'too','took','two','up','us','ve','very','want','was','way','we','well',
    'went','were','what','when','where','which','while','who','will','with',
    'would','yet','you','your','yours'
  );

  /**
   * Return a list of English stopwords.
   *
   * @return array
   */
  static public function getStopwords()
  {
    return self::$_stopwords;
  }

  /**
   * Apply English normalizing logic to string.
   *
   * @param array $words
   * @return array
   */
  static public function stemWord($string)
  {
    if(extension_loaded('stem'))
    {
      return stem_english($string);
    }
    return $string;
  }
}