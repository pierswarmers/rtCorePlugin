<?php

/*
 * This file is part of the symfony package.
 * (c) Fabien Potencier <fabien.potencier@symfony-project.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * sfWidgetFormJQueryDate represents a date widget rendered by JQuery UI.
 *
 * This widget needs JQuery and JQuery UI to work.
 *
 * @package    symfony
 * @subpackage widget
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfWidgetFormJQueryDate.class.php 30755 2010-08-25 11:14:33Z fabien $
 */
class rtWidgetFormJQueryDateTime extends sfWidgetFormInput
{
    public function render($name, $value = null, $attributes = array(), $errors = array())
    {
        $string = parent::render($name, $value, $attributes, $errors);

        $id = $this->generateId($name);

        $js = <<<EOF
<script>
    $(function(){

        $('#$id').datetimepicker({dateFormat: "yy/mm/dd", timeFormat: 'hh:mm'});

    });
</script>
EOF;

        return $string . $js;
    }


    public function getJavaScripts()
    {
        return array(
            '/rtCorePlugin/vendor/jquery/js/jquery.min.js',
            '/rtCorePlugin/vendor/jquery/js/jquery.ui.min.js',
            '/rtCorePlugin/vendor/timepicker/jquery-ui-timepicker-addon.js',
            '/rtCorePlugin/vendor/timepicker/jquery-ui-sliderAccess.js',
        );
    }

    /**
     * Return the required stylesheets for this widget.
     *
     * @return array
     */
    public function getStylesheets()
    {
        return array(
            '/rtCorePlugin/vendor/timepicker/jquery-ui-timepicker-addon.css' => 'screen'
        );
    }
}
