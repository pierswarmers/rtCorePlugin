<?php use_helper('I18N', 'rtAdmin', 'Text') ?>

<h1><?php echo __('Listing Categories') ?></h1>

<?php slot('rt-tools') ?>
  <?php include_partial('rtAdmin/standard_modal_tools', array('object' => new rtCategory))?>
<?php end_slot(); ?>

<?php include_partial('rtAdmin/flashes') ?>

<table>
  <thead>
    <tr>
      <th><?php echo __('Title') ?></th>
      <th><?php echo __('Position') ?></th>
      <th><?php echo __('Actions') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $rt_category): ?>
    <tr>
      <td><a href="<?php echo url_for('rtCategoryAdmin/edit?id='.$rt_category->getId()) ?>"><?php echo $rt_category->getTitle() ?></a></td>
      <td><?php echo $rt_category->getPosition() ?></td>
      <td>
        <ul class="rt-admin-tools">
          <!-- <li><?php //echo rt_button_show(url_for('rtCategoryAdmin/show?id='.$rt_category->getId())) ?></li> -->
          <li><?php echo rt_button_edit(url_for('rtCategoryAdmin/edit?id='.$rt_category->getId())) ?></li>
          <li><?php echo rt_button_delete(url_for('rtCategoryAdmin/delete?id='.$rt_category->getId())) ?></li>
        </ul>
      </td>      
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('rtAdmin/pagination', array('pager' => $pager)); ?>