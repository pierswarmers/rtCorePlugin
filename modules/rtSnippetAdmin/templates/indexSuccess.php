<?php use_helper('I18N', 'rtAdmin') ?>

<h1><?php echo __('Listing Snippets') ?></h1>

<?php slot('rt-tools') ?>
<?php include_partial('rtAdmin/standard_modal_tools', array('object' => new rtSnippet))?>
<?php end_slot(); ?>

<?php include_partial('rtAdmin/flashes') ?>

<table>
  <thead>
    <tr>
      <th>Title</th>
      <th>Collection</th>
      <th>Version</th>
      <th>Published</th>
      <th>Created at</th>
      <th>&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($rt_snippets as $rt_snippet): ?>
    <tr>
      <td><a href="<?php echo url_for('rtSnippetAdmin/edit?id='.$rt_snippet->getId()) ?>"><?php echo $rt_snippet->getTitle() ?></a></td>
      <td><?php echo $rt_snippet->getCollection() ?></td>
      <td><?php echo link_to_if($rt_snippet->version > 1, $rt_snippet->version, 'rtSnippetAdmin/versions?id='.$rt_snippet->getId()) ?></td>
      <td><?php echo rt_nice_boolean($rt_snippet->getPublished()) ?></td>
      <td><?php echo $rt_snippet->getCreatedAt() ?></td>
      <td>
        <ul class="rt-admin-tools">
          <li><?php echo rt_button_edit('rtSnippetAdmin/edit?id='.$rt_snippet->getId()) ?></li>
          <li><?php echo rt_button_delete('rtSnippetAdmin/delete?id='.$rt_snippet->getId()) ?></li>
        </ul>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
