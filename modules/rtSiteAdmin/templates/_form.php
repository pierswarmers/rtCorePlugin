<?php use_helper('I18N', 'rtForm') ?>
<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<?php slot('rt-tools') ?>
<?php include_partial('rtAdmin/standard_modal_tools', array('show_route_handle' => 'admin', 'object' => $form->getObject()))?>
<?php end_slot(); ?>

<?php slot('rt-side') ?>
<?php include_component('rtAsset', 'form', array('object' => $form->getObject())) ?>
<h2>Banner &amp; Logo</h2>

<p>The banner and logo used for venues are simply attached assets. The first one in the list will be used as the banner, the second as the logo.</p>

<?php end_slot(); ?>

<form id ="rtAdminForm" action="<?php echo url_for('rtSiteAdmin/'.($form->getObject()->isNew() ? 'create' : 'update').(!$form->getObject()->isNew() ? '?id='.$form->getObject()->getId() : '')) ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
    <?php echo $form->renderHiddenFields() ?>
    <input type="hidden" name="rt_post_save_action" value="edit" />
    <?php if (!$form->getObject()->isNew()): ?>
        <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>
    <table>
        <tbody>
        <?php echo $form->renderGlobalErrors() ?>
        <?php echo render_form_row($form['title']); ?>
        <?php echo render_form_row($form['sub_title']); ?>
        <?php echo render_form_row($form['type']); ?>
        <?php echo render_form_row($form['position']); ?>
        <?php echo render_form_row($form['public_url']); ?>
        <?php echo render_form_row($form['content']); ?>
        </tbody>
    </table>
    <div class="rt-admin-toggle-panel smallEditor">
        <h2><?php echo __('Brief Description') ?></h2>
        <table class="rt-admin-toggle-panel-content">
            <tbody>
            <?php echo render_form_row($form['content_summery']); ?>
            </tbody>
        </table>
    </div>

    <div class="rt-admin-toggle-panel smallEditor">
        <h2><?php echo __('SEO &amp; Tracking') ?></h2>
        <table class="rt-admin-toggle-panel-content">
            <tbody>
            <?php echo render_form_row($form['meta_title_suffix']); ?>
            <?php echo render_form_row($form['meta_keyword_suffix']); ?>
            </tbody>
        </table>
    </div>

    <div class="rt-admin-toggle-panel">
        <h2><?php echo __('Physical Address') ?></h2>
        <?php include_partial('address_form', array('form' => $form['billing_address'])); ?>
    </div>

    <div class="rt-admin-toggle-panel smallEditor">
        <h2><?php echo __('Contact Forms') ?></h2>
        <table class="rt-admin-toggle-panel-content">
            <tbody>
            <?php echo render_form_row($form['email_contact_address']); ?>
            <?php echo render_form_row($form['email_contact_response']); ?>
            </tbody>
        </table>
    </div>

    <div class="rt-admin-toggle-panel smallEditor">
        <h2><?php echo __('Booking Forms') ?></h2>
        <table class="rt-admin-toggle-panel-content">
            <tbody>
            <?php echo render_form_row($form['email_booking_address']); ?>
            <?php echo render_form_row($form['email_booking_response']); ?>
            </tbody>
        </table>
    </div>

    <div class="rt-admin-toggle-panel">
        <h2><?php echo __('Social Media Locations') ?></h2>
        <table class="rt-admin-toggle-panel-content">
            <tbody>
            <?php echo render_form_row($form['facebook_url']); ?>
            <?php echo render_form_row($form['twitter_url']); ?>
            <?php echo render_form_row($form['youtube_url']); ?>
            </tbody>
        </table>
    </div>

    <div class="rt-admin-toggle-panel">
        <h2><?php echo __('Template Include') ?></h2>
        <table class="rt-admin-toggle-panel-content">
            <tbody>
            <?php echo render_form_row($form['html_snippet_suffix']); ?>
            </tbody>
        </table>
    </div>

    <div class="rt-admin-toggle-panel">
        <h2><?php echo __('Publish Status') ?></h2>
        <table class="rt-admin-toggle-panel-content">
            <tbody>
            <?php echo render_form_row($form['published']); ?>
            </tbody>
        </table>
    </div>

    <div class="rt-admin-toggle-panel">
        <h2><?php echo __('Advanced') ?></h2>
        <table class="rt-admin-toggle-panel-content">
            <tbody>
            <?php echo render_form_row($form['reference_key']); ?>
            <?php echo render_form_row($form['domain']); ?>
            </tbody>
        </table>
    </div>

</form>
