<?php if(isset($options) && count($options)): ?>
<select name="<?php echo $name ?>" id="<?php echo $id ?>">
  <option value="">--</option>
  <?php foreach($options as $value => $name): ?>
  <option value="<?php echo $name ?>"><?php echo $name ?></option>
  <?php endforeach; ?>
</select>
<?php else: ?>
<input type="text" name="<?php echo $name ?>" id="<?php echo $id ?>" />
<?php endif; ?>