<?php use_helper('I18N', 'rtAdmin', 'Text') ?>

<h1><?php echo __('Listing Comments') ?></h1>

<?php slot('rt-tools') ?>
<h2><?php echo __('Comments Summary') ?></h2>
<dl class="rt-admin-summary-panel clearfix">
  <dt class="rt-admin-primary"><?php echo __('Total') ?></dt>
  <dd class="rt-admin-primary"><?php echo $stats['total']['count'] ?></dd>
  <dt><?php echo __('Enabled') ?></dt>
  <dd><?php echo $stats['total_enabled']['count'] ?></dd>
  <dt><?php echo __('Disabled') ?></dt>
  <dd><?php echo $stats['total_disabled']['count'] ?></dd>
</dl>
<?php end_slot(); ?>

<?php include_partial('rtAdmin/flashes') ?>

<script type="text/javascript">
  $(function() {
    enablePublishToggle('<?php echo url_for('rtCommentAdmin/toggle') ?>');
  });
</script>

<table>
  <thead>
    <tr>
      <th><?php echo __('Details') ?></th>
      <th><?php echo __('Enabled') ?></th>
      <th><?php echo __('Created at') ?></th>
      <th><?php echo __('Actions') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $rt_comment): ?>
    <tr>
      <td>
        <a href="<?php echo url_for('rtCommentAdmin/edit?id='.$rt_comment->getId()) ?>"><?php echo $rt_comment->getAuthorName() ?></a>:<br />
        <?php echo truncate_text(strip_tags($rt_comment->getContent()), 100) ?>
      </td>
      <td class="rt-admin-publish-toggle">
        <?php echo rt_nice_boolean($rt_comment->getIsActive()) ?>
        <div style="display:none;"><?php echo $rt_comment->getId() ?></div>
      </td>
      <td><?php echo $rt_comment->getCreatedAt() ?></td>
      <td>
        <ul class="rt-admin-tools">
          <li><?php echo rt_button_edit(url_for('rtCommentAdmin/edit?id='.$rt_comment->getId())) ?></li>
          <li><?php echo rt_button_delete(url_for('rtCommentAdmin/delete?id='.$rt_comment->getId())) ?></li>
        </ul>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('rtAdmin/pagination', array('pager' => $pager)); ?>