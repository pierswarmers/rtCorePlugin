<?php

/** @var rtCommentForm $form */

use_helper('I18N', 'rtForm');
use_stylesheets_for_form($form);
use_javascripts_for_form($form)

?>
<?php slot('rt-title', __('Comments')) ?>
<div class="rt-section rt-comment">
  <div class="rt-section-content">
    <?php include_component('rtComment', 'form', array('form' => $form, 'rating_enabled' => $rating_enabled)) ?>
  </div>
</div>