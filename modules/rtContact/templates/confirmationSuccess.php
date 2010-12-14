<?php use_helper('I18N') ?>

<?php slot('rt-title') ?>
<?php echo __('Confirmation') ?>
<?php end_slot(); ?>

<?php include_component('rtSnippet','snippetPanel', array('collection' => 'rt-contact-confirmation-prefix','sf_cache_key' => 'rt-contact-confirmation-prefix', 'default' => __('Thank you for your enquiry, we\'ll be in touch shortly.'))); ?>