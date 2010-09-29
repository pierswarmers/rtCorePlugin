<?php use_helper('I18N', 'rtAdmin') ?>

<h1><?php echo __('Listing Comments') ?></h1>

<?php include_partial('rtAdmin/flashes') ?>

<table>
  <thead>
    <tr>
      <th><?php echo __('Enabled') ?></th>
      <th><?php echo __('Author name') ?></th>
      <th><?php echo __('Author name') ?></th>
      <th><?php echo __('Attached to') ?></th>
      <th><?php echo __('Created at') ?></th>
      <th><?php echo __('Actions') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $rt_comment): ?>
    <tr>
      <td><?php echo rt_nice_boolean($rt_comment->getIsActive()) ?></td>
      <td><a href="<?php echo url_for('rtCommentAdmin/edit?id='.$rt_comment->getId()) ?>"><?php echo $rt_comment->getAuthorName() ?></a></td>
      <td><?php echo $rt_comment->getAuthorEmail() ?></td>
      <td><?php
        if(class_exists($rt_comment->getModel()))
        {
          $parent_model = Doctrine::getTable($rt_comment->getModel())->findOneById($rt_comment->getModelId());
          echo ($parent_model) ? link_to($parent_model,$rt_comment->getModel().'Admin/edit?id='.$parent_model->getId()) : __('...');
        }
      ?></td>
      <td><?php echo $rt_comment->getCreatedAt() ?></td>
      <td>
        <ul class="rt-admin-tools">
          <li><?php echo rt_button_boolean(url_for('rtCommentAdmin/enable?id='.$rt_comment->getId())) ?></li>
          <li><?php echo rt_button_edit(url_for('rtCommentAdmin/edit?id='.$rt_comment->getId())) ?></li>
          <li><?php echo rt_button_delete(url_for('rtCommentAdmin/delete?id='.$rt_comment->getId())) ?></li>
        </ul>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('rtAdmin/pagination', array('pager' => $pager)); ?>