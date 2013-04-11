<?php use_helper('I18N', 'rtAdmin') ?>

<h1><?php echo __('Listing Sites') ?></h1>

<?php slot('rt-tools') ?>

<?php include_partial('rtAdmin/standard_modal_tools', array('object' => new rtSite))?>

<h2><?php echo __('Sites Summary') ?></h2>
<dl class="rt-admin-summary-panel clearfix">
  <dt class="rt-admin-primary"><?php echo __('Total') ?></dt>
  <dd class="rt-admin-primary"><?php echo $stats['total']['count'] ?></dd>
  <dt><?php echo __('Published') ?></dt>
  <dd><?php echo $stats['total_published']['count'] ?></dd>
</dl>
<?php end_slot(); ?>

<?php include_partial('rtAdmin/flashes') ?>

<script type="text/javascript">
  $(function() {
    enablePublishToggle('<?php echo url_for('rtSiteAdmin/toggle') ?>');
  });
</script>

<table>
  <thead>
    <tr>
      <th>Domain</th>
      <th>Key</th>
      <th>Published</th>
      <th>Created at</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $k_site): ?>
    <tr>
      <td><a href="<?php echo url_for('rtSiteAdmin/edit?id='.$k_site->getId()) ?>"><?php echo $k_site->getDomain() ?></a></td>
      <td><?php echo $k_site->getReferenceKey() ?></td>
      <td class="rt-admin-publish-toggle">
        <?php echo rt_nice_boolean($k_site->getPublished()) ?>
        <div style="display:none;"><?php echo $k_site->getId() ?></div>
      </td>
      <td><?php echo $k_site->getCreatedAt() ?></td>
      <td>
        <ul class="rt-admin-tools">
          <li><?php echo rt_button_edit('rtSiteAdmin/edit?id='.$k_site->getId()) ?></li>
          <li><?php echo rt_button_delete('rtSiteAdmin/delete?id='.$k_site->getId()) ?></li>
        </ul>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('rtAdmin/pagination', array('pager' => $pager)); ?>