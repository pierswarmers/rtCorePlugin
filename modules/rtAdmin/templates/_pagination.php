<?php

$params          = isset($params)          ? $params          : '';
$item            = isset($item)            ? $item            : 'product';
$item_name       = isset($item_name)       ? $item_name       : 'category';
$titles_first    = isset($titles_first)    ? $titles_first    : 'First';
$titles_previous = isset($titles_previous) ? $titles_previous : 'Previous';
$titles_last     = isset($titles_last)     ? $titles_last     : 'Last';
$titles_next     = isset($titles_next)     ? $titles_next     : 'Next';
$arrows_enabled  = isset($arrows_enabled)  ? $arrows_enabled  : false;
$arrows_lft      = isset($arrows_lft)      ? $arrows_lft      : '&lang;';
$arrows_rgt      = isset($arrows_rgt)      ? $arrows_rgt      : '&rang;';
$info_enabled    = isset($info_enabled)    ? $info_enabled    : false;

?>
<?php if ($pager->haveToPaginate()): ?>
<div class="rt-pager rt-container">
  <ul>
    <li class="pager-first-page<?php echo $pager->getPage() == $pager->getFirstPage() ? ' here' : '' ?>">
      <a href="<?php echo '?page=1'.$params ?>"><?php echo $arrows_enabled ? $arrows_lft.$arrows_lft : '' ?> <?php echo __($titles_first) ?></a>
    </li>
    <li class="pager-previous-page<?php echo $pager->getPage() == $pager->getFirstPage() ? ' here' : '' ?>">
      <a href="<?php echo '?page='.$pager->getPreviousPage().$params ?>"><?php echo $arrows_enabled ? $arrows_lft : '' ?> <?php echo __($titles_previous) ?></a>
    </li>
    <li class="pager-last-page<?php echo $pager->getPage() == $pager->getLastPage() ? ' here' : '' ?>">
      <a href="<?php echo '?page='.$pager->getLastPage().$params ?>"><?php echo __($titles_last) ?> <?php echo $arrows_enabled ? $arrows_rgt.$arrows_rgt : '' ?></a>
    </li>
    <li class="pager-next-page<?php echo $pager->getPage() == $pager->getLastPage() ? ' here' : '' ?>">
      <a href="<?php echo '?page='.$pager->getNextPage().$params ?>"><?php echo __($titles_next) ?> <?php echo $arrows_enabled ? $arrows_rgt : '' ?></a>
    </li>
    <li class="pages">
      <ul>
        <?php
          foreach ($pager->getLinks() as $page):
            $class = 'page-'.$page;
            $class .= $pager->getPage() == $page ? ' here' : '';
            $class .= $pager->getLastPage() == $page ? ' last' : '';
          ?>
          <li class="<?php echo $class ?>">
            <a href="<?php echo '?page='.$page.$params ?>"><?php echo $page ?></a>
          </li>
        <?php endforeach; ?>
      </ul>
    </li>
  </ul>
  <?php endif; ?>
  <?php if($info_enabled): ?>
  <p class="rt-pager-information">
    <span class="rt-pager-items">
      <strong><?php echo count($pager) ?></strong>
      <?php echo $item; echo (count($pager) > 1) ? "'s" : ""; ?> in this <?php echo $item_name; ?>
    </span>
    <span class="rt-pager-counter">
      <?php if ($pager->haveToPaginate()): ?>
        - page <strong><?php echo $pager->getPage() ?>/<?php echo $pager->getLastPage() ?></strong>
      <?php endif; ?>
    </span>
  </p>
</div>
<?php endif; ?>