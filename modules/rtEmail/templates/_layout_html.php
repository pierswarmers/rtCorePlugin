<?php use_helper('I18N') ?>
<?php include_partial('rtEmail/styles') ?>
<div class="header">
  <?php include_partial('rtEmail/header') ?>
</div>
<div class="content">
  <?php echo isset($content) ? $sf_data->getRaw('content') : '' ?>
</div>
<div class="footer">
  <?php include_partial('rtEmail/footer') ?>
</div>