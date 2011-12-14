<?php

use_helper('I18N', 'rtForm', 'rtTemplate');

slot('rt-title', __('Contact Us'));

use_stylesheets_for_form($form);
use_javascripts_for_form($form);

?>


<div class="rt-section rt-contact">

  <?php if(sfConfig::get('app_rt_templates_headers_embedded', true)): ?>
  <div class="rt-section-header">
    <h1><?php echo __('Contact Us') ?></h1>
  </div>
  <?php endif; ?>
  
  <div class="rt-section-content">

    <?php rt_get_snippet('rt-contact-prefix', 'Feel free to send through any comments, queries or concerns. We\'ll get back to you shortly.'); ?>

    <form action="<?php echo url_for('rt_contact') ?>" method="post" class="rt-compact">
      <?php echo $form->renderHiddenFields() ?>
      <fieldset>
        <ul class="rt-form-schema">
          <?php echo $form; ?>
        </ul>
      </fieldset>
      <p class="rt-section-tools-submit"><button type="submit"><?php echo __('Submit your comment') ?></button></p>
    </form>
    
  </div>

</div>