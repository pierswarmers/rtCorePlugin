<?php use_helper('I18N', 'rtForm') ?>
<ul class="rt-form-schema">
  <li class="rt-form-row">
    <?php echo $form['address_1']->renderLabel() ?>
    <div class="rt-form-field">
      <?php echo $form['address_1']->renderError() ?>
      <?php echo $form['address_1'] ?>
      <?php echo $form['address_1']->renderHelp() ?>
    </div>
  </li>
  <li class="rt-form-row">
    <?php echo $form['address_2']->renderLabel() ?>
    <div class="rt-form-field">
      <?php echo $form['address_2']->renderError() ?>
      <?php echo $form['address_2'] ?>
      <?php echo $form['address_2']->renderHelp() ?>
    </div>
  </li>
  <li class="rt-form-row">
    <?php echo $form['town']->renderLabel() ?>
    <div class="rt-form-field">
      <?php echo $form['town']->renderError() ?>
      <?php echo $form['town'] ?>
      <?php echo $form['town']->renderHelp() ?>
    </div>
  </li>
  <li class="rt-form-row">
    <?php echo $form['country']->renderLabel() ?>
    <div class="rt-form-field">
      <?php echo $form['country']->renderError() ?>
      <?php echo $form['country'] ?>
      <?php echo $form['country']->renderHelp() ?>
    </div>
  </li>
  <li class="rt-form-row">
    <?php echo $form['state']->renderLabel() ?>
    <div class="rt-form-field">
      <?php echo $form['state']->renderError() ?>
      <?php echo $form['state'] ?>
      <?php echo $form['state']->renderHelp() ?>
    </div>
  </li>
  <li class="rt-form-row">
    <?php echo $form['postcode']->renderLabel() ?>
    <div class="rt-form-field">
      <?php echo $form['postcode']->renderError() ?>
      <?php echo $form['postcode'] ?>
      <?php echo $form['postcode']->renderHelp() ?>
    </div>
  </li>
  <li class="rt-form-row">
    <?php echo $form['phone']->renderLabel() ?>
    <div class="rt-form-field">
      <?php echo $form['phone']->renderError() ?>
      <?php echo $form['phone'] ?>
      <?php echo $form['phone']->renderHelp() ?>
    </div>
  </li>
  <li class="rt-form-row">
    <?php echo $form['instructions']->renderLabel() ?>
    <div class="rt-form-field">
      <?php echo $form['instructions']->renderError() ?>
      <?php echo $form['instructions'] ?>
      <?php echo $form['instructions']->renderHelp() ?>
    </div>
  </li>
</ul>
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