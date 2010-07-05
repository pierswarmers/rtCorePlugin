<?php use_helper('I18N', 'rtForm') ?>
<table class="rt-admin-toggle-panel-content">
  <tbody>
    <?php echo $form ?>
  </tbody>
</table>
<script type="text/javascript">
  $(function() {
    $('#rt_shop_order_<?php echo $form->getName()?>_country').change(function() {

      var holder =  $('#rt_shop_order_<?php echo $form->getName()?>_state').parent();

      holder.html('<span class="loading">Loading states...</span>');
      $('#rt_shop_order_<?php echo $form->getName()?>_state').remove();
      $.ajax({
        type: "POST",
        url: '<?php echo url_for('rtAdmin/stateInput') ?>',
        data: ({
          country : $(this).find('option:selected').attr('value'),
          id      : 'rt_shop_order_<?php echo $form->getName()?>_state',
          name    : 'rt_shop_order_[<?php echo $form->getName()?>][state]'
        }),
        dataType: "html",
        success: function(data) {
          holder.html(data);
        }
      });
    });
  });
</script>