<?php use_helper('I18N') ?>
<?php use_javascript('/gnCorePlugin/js/jquery-1.4.2.min.js') ?>
<div class="gn-default-404">

  <h1><?php echo __('Oops! Page not found') ?></h1>

  <dl>
    <dt><?php echo __('Did you type the URL?') ?></dt>
    <dd><?php echo __('You may have typed the address (URL) incorrectly. Check it to make sure you\'ve got the exact right spelling, capitalization, etc.') ?></dd>

    <dt><?php echo __('Did you follow a link from somewhere?') ?></dt>
    <dd>
    <p><?php echo __('If you reached this page from another part of this site, please let us so we can correct our mistake.') ?></p>
    <p><?php echo __('Links from other sites can sometimes be outdated or misspelled. Let us know and we can try to contact the other site in order to fix the problem.') ?></p>
    <?php if(sfConfig::has('app_gn_admin_email')): ?>
    <p><?php echo __('In order to improve our service, please inform us of this missing page. We\'ll do our best correct the situation.')?></p>

      <button id="gnNotify404Button" class="button positive"><?php echo __('Let us know about this missing page!') ?></button>
      <span id="gnNotify404Message"></span>

    <script type="text/javascript">
      $(document).ready(function() {
        $('#gnNotify404Button').click(function(){

          if ($('#gnNotify404Button').hasClass('sent')) return false;

          $('#gnNotify404Button').addClass('sent').fadeTo('fast', 0.5);
          $('#gnNotify404Message').addClass('loading').html('<?php echo __('Sending notification...') ?>');

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
              $('#gnNotify404Message').addClass('success').html('<?php echo __('Notification sent, thanks!') ?> ');
            }
          });

        });
      });
    </script>
    <?php endif; ?>
    </dd>
    <dt><?php echo __('What\'s next') ?></dt>
    <dd>
      <ul class="sfTIconList">
        <li class="sfTLinkMessage"><a href="javascript:history.go(-1)"><?php echo __('Back to previous page') ?></a></li>
        <li class=""><?php echo link_to(__('Go to Homepage'), '@homepage') ?></li>
        <li class=""><?php echo link_to(__('Try searching for the page you\'re after'), '@gn_search') ?></li>
      </ul>
    </dd>
  </dl>

</div>