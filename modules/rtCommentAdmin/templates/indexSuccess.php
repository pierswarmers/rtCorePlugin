<?php use_helper('I18N', 'rtAdmin') ?>

<h1><?php echo __('Listing Comments') ?></h1>

<?php include_partial('rtAdmin/flashes') ?>

<script type="text/javascript">
  $(function() {
    var enableTxt = '<?php echo __('enable') ?>';
    var disableTxt = '<?php echo __('disable') ?>';
    
    $("td.rt-toggle span").click(function(){
      if($(this).hasClass('loading')) {
        return;
      }

      $(this).removeClass('ui-icon-check');
      $(this).removeClass('ui-icon-close');

      $(this).addClass('loading');
      
      // ajax call to toggle action
      var commentId = $(this).next('div').html();
      var spanElement = $(this);

      $.ajax({
        url: '<?php echo url_for('rtCommentAdmin/toggle') ?>',
        data: { id: commentId },
        success: function(data) {
          spanElement.removeClass('loading');
          if(data == 'activated') {
            spanElement.addClass('ui-icon-check');
          } else {
            spanElement.addClass('ui-icon-close');
          }
        }
      });

    });
  });
</script>

<table>
  <thead>
    <tr>
      <th><?php echo __('Author name') ?></th>
      <th><?php echo __('Enabled') ?></th>
      <th><?php echo __('Created at') ?></th>
      <th><?php echo __('Actions') ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($pager->getResults() as $rt_comment): ?>
    <tr>
      <td><a href="<?php echo url_for('rtCommentAdmin/edit?id='.$rt_comment->getId()) ?>"><?php echo $rt_comment->getAuthorName() ?></a></td>
      <td class="rt-toggle">
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
    <tr>
      <td>&nbsp;</td>
      <td colspan="3"><?php echo strip_tags($rt_comment->getContent()) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<?php include_partial('rtAdmin/pagination', array('pager' => $pager)); ?>