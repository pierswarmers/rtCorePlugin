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

if($sf_request->hasParameter('show_more'))
{
    $params = $params . '&show_more=';
}

?>
<?php if ($pager->haveToPaginate()): ?>




    <ul class="pagination">
        <li class="arrow unavailable"><a href="">&laquo;</a></li>
        <li class="current"><a href="">1</a></li>
        <li><a href="">2</a></li>
        <li><a href="">3</a></li>
        <li><a href="">4</a></li>
        <li class="unavailable"><a href="">&hellip;</a></li>
        <li><a href="">12</a></li>
        <li><a href="">13</a></li>
        <li class="arrow"><a href="">&raquo;</a></li>
    </ul>





    <ul class="pagination">
        <li class="rt-pager-first<?php echo $pager->getPage() == $pager->getFirstPage() ? ' unavailable' : '' ?>">
            <a href="<?php echo '?page=1'.$params ?>"><?php echo $arrows_enabled ? $arrows_lft.$arrows_lft : '' ?> <?php echo __($titles_first) ?></a>
        </li>
        <?php
        foreach ($pager->getLinks() as $page):
            $class = 'page-'.$page;
            $class .= $pager->getPage() == $page ? ' current' : '';
            ?>
            <li class="<?php echo $class ?>">
                <a href="<?php echo '?page='.$page.$params ?>"><?php echo $page ?></a>
            </li>
        <?php endforeach; ?>
        <li class="arrow<?php echo $pager->getPage() == $pager->getLastPage() ? ' unavailable' : '' ?>">
            <a href="<?php echo '?page='.$pager->getNextPage().$params ?>"><?php echo __($titles_next) ?> <?php echo $arrows_enabled ? $arrows_rgt : '' ?></a>
        </li>
    </ul>
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
    <?php endif; ?>
<?php endif; ?>