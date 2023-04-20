<ul class="pagination home-product__pagination">
    <?php
        if($current_page > 1) {
            $prev_page = $current_page - 1;
    ?>
        <li class="pagination-item">
            <a href="?per_page=<?=$item_per_page?>&pages=<?=$prev_page?>" class="pagination-item__link">
                <i class="pagination-item__icon fas fa-angle-left"></i>
            </a>
        </li>
    <?php
        }
    ?>

    <?php
        for ($num = 1 ; $num <= $totalPages ; $num++) {
            if($num != $current_page){
    ?>
        <li class="pagination-item">
            <a href="?per_page=<?=$item_per_page?>&pages=<?=$num?>" class="pagination-item__link"><?=$num?></a>                               
        </li>
    <?php
            }else {
    ?>
        <li class="pagination-item pagination-item--active">
            <a href="?per_page=<?=$item_per_page?>&pages=<?=$num?>" class="pagination-item__link"><?=$num?></a>                               
        </li>
    <?php
            }
        }
    ?>        

    <?php
        if($current_page <= $totalPages - 1) {
            $next_page = $current_page + 1;
    ?>
        <li class="pagination-item">
            <a href="?per_page=<?=$item_per_page?>&pages=<?=$next_page?>" class="pagination-item__link">
                <i class="pagination-item__icon fas fa-angle-right"></i>
            </a>       
        </li>
    <?php
        }
    ?>
</ul>