<?php use_helper('I18N', 'rtForm') ?>
<table class="rt-admin-toggle-panel-content">
  <tbody>
    <?php echo render_form_row($form['address_1']); ?>
    <?php echo render_form_row($form['address_2']); ?>
    <?php echo render_form_row($form['town']); ?>
    <?php echo render_form_row($form['country']); ?>
    <?php echo render_form_row($form['state']); ?>
    <?php echo render_form_row($form['postcode']); ?>
    <?php echo render_form_row($form['phone']); ?>
    <?php echo render_form_row($form['instructions']); ?>
  </tbody>
</table>
<script type="text/javascript">
  $(function() {
    $('#rt_guard_user_<?php echo $form->getName()?>_country').change(function() {

      var holder =  $('#rt_guard_user_<?php echo $form->getName()?>_state').parent();

      holder.html('<span class="loading">Loading states...</span>');
      $('#rt_guard_user_<?php echo $form->getName()?>_state').remove();
      $.ajax({
        type: "POST",
        url: '<?php echo url_for('rtAdmin/stateInput') ?>',
        data: ({
          country : $(this).find('option:selected').attr('value'),
          id      : 'rt_guard_user_<?php echo $form->getName()?>_state',
          name    : 'rt_guard_user[<?php echo $form->getName()?>][state]'
        }),
        dataType: "html",
        success: function(data) {
          holder.html(data);
        }
      });
    });
  });
</script>