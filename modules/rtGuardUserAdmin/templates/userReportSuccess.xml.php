<?php $users = $sf_data->getRaw('users') ?>
<?xml version="1.0" encoding="ISO-8859-1"?>
<userReport xmlns="http://www.reditype.com">
  <?php foreach($users as $user): ?>
    <user>
      <u_id><?php echo $user['u_id'] ?></u_id>
      <u_first_name><?php echo $user['u_first_name'] ?></u_first_name>
      <u_last_name><?php echo $user['u_last_name'] ?></u_last_name>
      <u_email_address><?php echo $user['u_email_address'] ?></u_email_address>
      <u_username><?php echo $user['u_username'] ?></u_username>
      <u_is_active><?php echo $user['u_is_active'] ?></u_is_active>
      <u_is_super_admin><?php echo $user['u_is_super_admin'] ?></u_is_super_admin>
      <u_last_login><?php echo $user['u_last_login'] ?></u_last_login>
      <u_date_of_birth><?php echo $user['u_date_of_birth'] ?></u_date_of_birth>
      <u_company><?php echo $user['u_company'] ?></u_company>
      <u_url><?php echo $user['u_url'] ?></u_url>
      <u_created_at><?php echo $user['u_created_at'] ?></u_created_at>
      <u_updated_at><?php echo $user['u_updated_at'] ?></u_updated_at>
      <u_addresses>
        <?php if(isset($user['u_addresses'])): ?>
          <?php foreach($user['u_addresses'] as $key => $address): ?>
            <<?php echo $key ?>>
              <a_id><?php echo $address['a_id'] ?></a_id>
              <a_model_id><?php echo $address['a_model_id'] ?></a_model_id>
              <a_model><?php echo $address['a_model'] ?></a_model>
              <a_first_name><?php echo $address['a_first_name'] ?></a_first_name>
              <a_last_name><?php echo $address['a_last_name'] ?></a_last_name>
              <a_type><?php echo $address['a_type'] ?></a_type>
              <a_care_of><?php echo $address['a_care_of'] ?></a_care_of>
              <a_address_1><?php echo $address['a_address_1'] ?></a_address_1>
              <a_address_2><?php echo $address['a_address_2'] ?></a_address_2>
              <a_town><?php echo $address['a_town'] ?></a_town>
              <a_state><?php echo $address['a_state'] ?></a_state>
              <a_postcode><?php echo $address['a_postcode'] ?></a_postcode>
              <a_country><?php echo $address['a_country'] ?></a_country>
              <a_phone><?php echo $address['a_phone'] ?></a_phone>
              <a_instructions><?php echo $address['a_instructions'] ?></a_instructions>
              <a_created_at><?php echo $address['a_created_at'] ?></a_created_at>
              <a_updated_at><?php echo $address['a_updated_at'] ?></a_updated_at>
            </<?php echo $key ?>>
          <?php endforeach; ?>
        <?php endif; ?>
      </u_addresses>
    </user>
  <?php endforeach; ?>
</userReport>