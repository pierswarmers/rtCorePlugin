<?php
/*
 * This file is part of the gumnut package.
 * (c) 2009-2010 Piers Warmers <piers@wranglers.com.au>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * gnIndexCleanerFr defines French stopwords.
 *
 * @package    gumnut
 * @subpackage toolkit
 * @author     Piers Warmers <piers@wranglers.com.au>
 */
class gnIndexCleanerFr implements GnIndexCleaner
{
  /**
   * Defines a list of French stop words to be removed from indexed text.
   *
   * @var array $_stopwords
   */
  protected static $_stopwords = array(
    'alors','au','aucuns','aussi','autre','avant','avec','avoir','bon','car',
    'ce','cela','ces','ceux','chaque','ci','comme','comment','dans','des','du',
    'dedans','dehors','depuis','deux','devrait','doit','donc','dos','droite',
    'd�but','elle','elles','en','encore','essai','est','et','eu','fait','faites',
    'fois','font','force','haut','hors','ici','il','ils','je	juste','la','le',
    'les','leur','l�','ma','maintenant','mais','mes','mine','moins','mon','mot',
    'm�me','ni','nomm�s','notre','nous','nouveaux','ou','o�','par','parce',
    'parole','pas','personnes','peut','peu','pi�ce','plupart','pour','pourquoi',
    'quand','que','quel','quelle','quelles','quels','qui','sa','sans','ses',
    'seulement','si','sien','son','sont','sous','soyez	sujet','sur','ta',
    'tandis','tellement','tels','tes','ton','tous','tout','trop','tr�s','tu',
    'valeur','voie','voient','vont','votre','vous','vu','�a','�taient','�tat',
    '�tions','�t�','�tre'
  );

  /**
   * Return a list of French stopwords.
   *
   * @return array
   */
  static public function getStopwords()
  {
    return self::$_stopwords;
  }

  /**
   * Apply French normalizing logic to string.
   *
   * @param array $words
   * @return array
   */
  static public function stemWord($string)
  {
    if(extension_loaded('stem'))
    {
      return stem_french($string);
    }
    return $string;
  }
}