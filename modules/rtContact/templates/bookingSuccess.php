<?php

use_helper('I18N', 'rtForm', 'rtTemplate');

slot('rt-title', __('Bookings'));

use_stylesheets_for_form($form);
use_javascripts_for_form($form);

?>


<div class="rt-section rt-contact">

  <?php if(sfConfig::get('app_rt_templates_headers_embedded', true)): ?>
  <div class="rt-section-header">
    <h1><?php echo __('Bookings') ?></h1>
  </div>
  <?php endif; ?>
  
  <div class="rt-section-content">

    <?php rt_get_snippet('rt-booking-prefix', 'Please send through your booking details. We\'ll get back to you shortly.'); ?>

    <form action="<?php echo url_for('rt_booking') ?>" method="post" class="rt-compact formstyle">
      <?php echo $form->renderHiddenFields() ?>
      <fieldset>
        <ul class="rt-form-schema">
          <?php echo $form; ?>
        </ul>
      </fieldset>
      <p class="rt-section-tools-submit"><button type="submit"><?php echo __('Submit your enquiry') ?></button></p>
    </form>
    
  </div>

</div>