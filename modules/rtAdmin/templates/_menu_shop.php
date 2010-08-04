<?php $routes = sfContext::getInstance()->getRouting()->getRoutes(); ?>
<?php if(isset($routes['rt_shop_product_show'])): ?>
<h2><?php echo __('Shop and Products') ?></h2>
<ul>
  <li><?php echo link_to(__('Products'), 'rtShopProductAdmin/index') ?></li>
  <li><?php echo link_to(__('Categories'), 'rtShopCategoryAdmin/index') ?></li>
  <li><?php echo link_to(__('Attributes'), 'rtShopAttributeAdmin/index') ?></li>
  <li><?php echo link_to(__('Promotions'), 'rtShopPromotionAdmin/index') ?></li>
  <li><?php echo link_to(__('Vouchers'), 'rtShopVoucherAdmin/index') ?></li>
  <li><?php echo link_to(__('Orders'), 'rtShopOrderAdmin/index') ?></li>
</ul>
<?php endif; ?>