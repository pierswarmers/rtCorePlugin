<?php use_helper('I18N') ?>
<?php use_javascript('/rtCorePlugin/vendor/jquery/js/jquery.min.js') ?>

<?php slot('rt-title') ?>
<?php echo __('Oops! Page not found') ?>
<?php end_slot(); ?>

<div class="rt-section-content">

<p><strong><?php echo __('Did you type the URL?') ?></strong></p>

<p>
  <?php echo __('You may have typed the address (URL) incorrectly. Check it to make sure you\'ve got the exact right spelling, capitalization, etc.') ?>
</p>
<p><strong><?php echo __('Did you follow a link from somewhere?') ?></strong> </p>
<p><?php echo __('If you reached this page from another part of this site, please let us so we can correct our mistake.') ?> </p>
<p><?php echo __('Links from other sites can sometimes be outdated or misspelled. Let us know and we can try to contact the other site in order to fix the problem.') ?></p>
<?php if(sfConfig::has('app_rt_admin_email')): ?>
<p><?php echo __('In order to improve our service, please inform us of this missing page. We\'ll do our best correct the situation.')?></p>
<p>
  <button id="rtNotify404Button" class="button positive"><?php echo __('Let us know about this missing page!') ?></button>
  <span id="rtNotify404Message"></span>
</p>

<script type="text/javascript">
  $(document).ready(function() {
    $('#rtNotify404Button').click(function(){

      if ($('#rtNotify404Button').hasClass('sent')) return false;

      $('#rtNotify404Button').addClass('sent').fadeTo('fast', 0.5);
      $('#rtNotify404Message').addClass('loading').html('<?php echo __('Sending notification...') ?>');

      var strReferrer=document.referrer.toLowerCase();
      if (location.href.indexOf("noreferrer=true")>=0) strReferrer="";

      $.ajax({
        url: '<?php echo url_for('@sf_default_notify_404?sf_format=json') ?>',
        dataType: 'json',
        data: {
          url: location.href,
          referer: strReferrer
        },
        complete: function(data)
        {
          $('#rtNotify404Message').removeClass('loading').addClass('success').html('<?php echo __('Notification sent, thanks!') ?> ');
        }
      });

    });
  });
</script>
<?php endif; ?>
<p><strong><?php echo __('What\'s next') ?></strong></p>
<ul class="sfTIconList">
  <li class="sfTLinkMessage"><a href="javascript:history.go(-1)"><?php echo __('Back to previous page') ?></a></li>
  <li class=""><?php echo link_to(__('Go to Homepage'), '@homepage') ?></li>
  <li class=""><?php echo link_to(__('Try searching for the page you\'re after'), '@rt_search') ?></li>
</ul>
</div>