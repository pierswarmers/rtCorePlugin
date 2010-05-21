<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>
<?php use_helper('I18N', 'gnAdmin') ?>
<?php $routes = $sf_context->getRouting()->getRoutes() ?>

<h1><?php echo __('Search Results') ?></h1>

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
        <?php foreach($pager->getResults() as $gn_index): ?>
        <?php

        $title = $gn_index->getObject();
        $type = '';
        $link = $gn_index->getCleanModel() . 'Admin/edit?id='.$gn_index->getModelId();

        try { $title = $gn_index->getObject()->getTitle(); } catch (Exception $e) { }

        if($gn_index->getCleanModel() === 'sfGuardUser')
        {
          $type = 'Person';
          $link = 'gnGuardUserAdmin/edit?id='.$gn_index->getModelId();
        }
        else
        {
          try { $type = $gn_index->getObject()->getTypeNice(); } catch (Exception $e) { }
        }
        

        
        ?>
        <tr>
          <td><?php echo link_to($title, $link) ?></td>
          <td><?php echo __($type) ?></td>
          <td>
          <ul class="gn-admin-tools">
            <li><?php echo gn_button_edit(url_for($link)) ?></li>
          </ul>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
<?php endif; ?>