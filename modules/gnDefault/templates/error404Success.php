<?php use_helper('I18N') ?>
<?php use_javascript('/gnCorePlugin/js/jquery-1.4.2.min.js') ?>
<div class="gn-default-404">
  <h1><?php echo __('Error 404: Page not found') ?></h1>
  <p><?php echo __('The page you requested is no longer here... but we think we can help you.') ?></p>

  <p><?php echo __('You may not be able to find this page because of') ?>:</p>

  <ol>
    <li><?php echo __('An out-of-date bookmark/favourite') ?></li>
    <li><?php echo __('A search engine that has an out-of-date listing for us') ?></li>
    <li><?php echo __('A mis-typed address') ?></li>
  </ol>
  <?php if(sfConfig::has('app_gn_admin_email')): ?>
  <h2><?php echo __('Let us know about this') ?></h2>
  <p><?php echo __('In order to improve our service, please inform us of this missing page. We\'ll do our best correct the situation.')?></p>
  <p>
    <button id="gnNotify404Button" class="button positive"><?php echo __('Notify the site administrator!') ?></button>
    <span id="gnNotify404Message"></span>
  </p>
  <script type="text/javascript">
    $(document).ready(function() {
      $('#gnNotify404Button').click(function(){

        if($('#gnNotify404Button').hasClass('sent'))
        {
            return false;
        }

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
</div>