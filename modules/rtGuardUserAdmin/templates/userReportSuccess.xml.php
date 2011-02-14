<?php $users = $sf_data->getRaw('users') ?>
<?xml version="1.0" encoding="ISO-8859-1"?>
<userReport xmlns="http://www.reditype.com">
  <?php foreach($users as $user): ?>
    <user>
      <?php foreach ($user as $key => $value): ?>
        <?php if ($key !== 'u_addresses'): ?>
          <<?php echo $key ?>><?php echo $value ?></<?php echo $key ?>>
        <?php endif; ?>
      <?php endforeach; ?>
      <?php if(isset($user['u_addresses'])): ?>
        <u_addresses>
          <?php foreach($user['u_addresses'] as $key => $address): ?>
            <<?php echo $key ?>>
              <?php foreach($address as $akey => $avalue): ?>
                <<?php echo $akey ?>><?php echo $avalue ?></<?php echo $akey ?>>
              <?php endforeach; ?>
            </<?php echo $key ?>>
          <?php endforeach; ?>
        </u_addresses>
      <?php else: ?>
        <u_addresses/>
      <?php endif; ?>
    </user>
  <?php endforeach; ?>
</userReport>