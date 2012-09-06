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
 * PluginrtSite
 *
 * @package    rtCorePlugin
 * @subpackage model
 * @author     Piers Warmers <piers@wranglers.com.au>
 * @author     Konny Zurcher <konny@wranglers.com.au>
 */
abstract class PluginrtSite extends BasertSite
{
    public function construct()
    {
        parent::construct();

        if ($this->isNew()) {
            $this->setHtmlSnippetSuffix(
                "

<!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
<script>
    var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
    (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
    g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
    s.parentNode.insertBefore(g,s)}(document,'script'));
</script>

          "
            );
        }

    }

    public function __toString()
    {
        return $this->title;
    }

    public function getTypeNice()
    {
        return 'Site';
    }

    public function delete(Doctrine_Connection $conn = null)
    {
        $postion = $this->getPosition();

        parent::delete();

        $this->adjustPositions($postion);
    }


    /**
     * Adjust positions when item was deleted
     *
     * @param Integer $from_position
     */
    private function adjustPositions($from_position)
    {
        $q = Doctrine_Query::create()
            ->update('rtSite page')
            ->set('page.position', 'page.position - 1')
            ->andWhere('page.position > ?', $from_position);

        $q->execute();
    }

}