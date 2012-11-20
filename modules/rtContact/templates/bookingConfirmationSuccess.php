<?php use_helper('I18N', 'rtForm', 'rtTemplate'); ?>

<?php slot('rt-title') ?>
<?php echo __('Booking Sent') ?>
<?php end_slot(); ?>

<?php echo rt_get_snippet('rt-booking-confirmation-prefix', 'Thank you for your enquiry, we\'ll be in touch shortly.'); ?>