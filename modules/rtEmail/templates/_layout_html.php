<?php use_helper('I18N') ?>
<?php include_partial('rtEmail/styles') ?>
<?php include_partial('rtEmail/header') ?>
<div class="container">
  <?php echo isset($content) ? $sf_data->getRaw('content') : '' ?>
</div>
<?php include_partial('rtEmail/footer') ?>