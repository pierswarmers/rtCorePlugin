<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php use_helper('I18N', 'rtAdmin') ?>
<?php $routes = $sf_context->getRouting()->getRoutes() ?>

<h1><?php echo __('Search Results') ?></h1>

<?php include_partial('rtAdmin/flashes') ?>

<?php if(isset($pager)): ?>
  <?php if(count($pager) > 0): ?>
    <table>
      <thead>
        <tr>
          <th><?php echo __('Title') ?></th>
          <th><?php echo __('Type') ?></th>
          <th>&nbsp;</th>
        </tr>
      </thead>
        <tbody>
        <?php foreach($pager->getResults() as $rt_index): ?>
        <?php

        $title = $rt_index->getObject();
        $type = '';
        $link = $rt_index->getCleanModel() . 'Admin/edit?id='.$rt_index->getModelId();

        try { $title = $rt_index->getObject()->getTitle(); } catch (Exception $e) { }

        if($rt_index->getCleanModel() === 'sfGuardUser')
        {
          $type = 'Person';
          $link = 'rtGuardUserAdmin/edit?id='.$rt_index->getModelId();
        }
        else
        {
          try { $type = $rt_index->getObject()->getTypeNice(); } catch (Exception $e) { }
        }
        

        
        ?>
        <tr>
          <td><?php echo link_to($title, $link) ?></td>
          <td><?php echo __($type) ?></td>
          <td>
          <ul class="rt-admin-tools">
            <li><?php echo rt_button_edit(url_for($link)) ?></li>
          </ul>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
<?php endif; ?>