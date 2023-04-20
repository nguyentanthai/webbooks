<?php 
include 'admin/db_connect.php'; 

if(isset($_POST['key'])){
    $search = $_POST['key'];
}else{
    $search = '';
}
$sql_pro = "SELECT * FROM books WHERE title LIKE '%".$search."%'";
$query_pro = mysqli_query($conn,$sql_pro);

?>

<style>
    #cat-list li{
        cursor: pointer;
        font-size: 14px;
    }
       #cat-list li:hover {
        color: var(--primary-color);
        /* border-left: 5px solid; */
        right: -4px;
    }
    .prod-item p{
        margin: unset;
    }
    .bid-tag {
    position: absolute;
    right: .5em;
    }

    .price__product {
        margin-left : 8px;
    }

    .copper__character {
        font-size : 16px;
    }
</style>
<?php 
$cid = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
?>
<div class="contain-fluid grid wide">
    <div class="row sm-gutter app__contain--banner">
        <div class="col l-8 m-0 c-0">
            <div class="splide">
                <div class="splide__track">
                        <ul class="splide__list">
                            <li class="splide__slide"><img src="./assets/img/1.jpg" alt="" class="banner-image"></li>
                            <li class="splide__slide"><img src="./assets/img/2.png" alt="" class="banner-image"></li>
                            <li class="splide__slide"><img src="./assets/img/3.png" alt="" class="banner-image"></li>
                            <li class="splide__slide"><img src="./assets/img/4.png" alt="" class="banner-image"></li>
                            <li class="splide__slide"><img src="./assets/img/5.png" alt="" class="banner-image"></li>
                            <li class="splide__slide"><img src="./assets/img/6.jpg" alt="" class="banner-image"></li>
                        </ul>
                </div>
                <div class="splide__progress">
                    <div class="splide__progress__bar">
                    </div>
                </div>
            </div>
        </div>

        <div class="col l-4 m-0 c-0">
            <img src="./assets/img/hbanner_img1.png" alt="" class="sub__banner-image">
            <img src="./assets/img/hbanner_img3.png" alt="" class="sub__banner-image mg-t-5">
        </div>
    </div>
    <div class="row sm-gutter app__contain pad-bot-0">
        <div class="col l-2 m-0 c-0">
            <div class="card app__category">
                <div class="card-header">Danh mục</div>
                <div class="card-body category-list">
                    <ul class='list-group' id='cat-list'>
                        <li class='list-group-item' data-id='all' data-href="index.php?page=home&category_id=all">Tất Cả</li>
                        <?php
                            $cat = $conn->query("SELECT * FROM categories order by name asc");
                            while($row=$cat->fetch_assoc()):
                                $cat_arr[$row['id']] = $row['name'];
                            ?>
                        <li class='list-group-item' data-id='<?php echo $row['id'] ?>' data-href="index.php?page=home&category_id=<?php echo $row['id'] ?>"><?php echo ucwords($row['name']) ?></li>

                        <?php endwhile; ?>
                    </ul>

                </div>
            </div>
        </div>
        <div class="col l-10 m-12 c-12">
            <div class="home-filter hide-on-mobile-tablet">
                <span class="home-filter__label">Sắp xếp theo</span>
                <button class="home-filter__btn btn-filter btn--nomals">Phổ biến</button>
                <button class="home-filter__btn btn-filter btn--primary">Mới nhất</button>
                <button class="home-filter__btn btn-filter btn--nomals">Bán chạy</button>

                <div class="select-input">
                    <span class="select-input__label">Giá</span>
                    <i class="select-input__icon fas fa-angle-down"></i>
                    
                    <!-- List option -->
                    <ul class="select-input__list">
                        <li class="select-input__item">
                            <a href="" class="select-input__link">Giá: Thấp đến cao</a>
                        </li>
                        <li class="select-input__item">
                            <a href="" class="select-input__link">Giá: Cao đến thấp</a>                                   
                        </li>
                        
                    </ul>
                </div>               
            </div>

            <div class="card product__contain">
                <div class="row sm-gutter">
                    <?php
                        $where = "";
                        $item_per_page = !empty($_GET['per_page'])?$_GET['per_page']:20;
                        $current_page = !empty($_GET['pages'])?$_GET['pages']:1;
                        $offset = ($current_page - 1) * $item_per_page; 
                        if($cid > 0){
                            $where  = " where CONCAT('[',REPLACE(category_ids,',','],['),']') LIKE '%[".$cid."]%'  ";
                        }
                        $books = $conn->query("SELECT * from books $where order by title asc LIMIT  ".$item_per_page. " OFFSET " .$offset );
                        $bookss = $conn->query("SELECT * from books $where order by title asc");
                        $booksss = $bookss->num_rows;
                        $totalPages = ceil($booksss / $item_per_page);
                        if($cid == 'all'){
                            $books = $conn->query("SELECT * from books order by title asc LIMIT " .$item_per_page. " OFFSET " .$offset);
                            $bookss = $conn->query("SELECT * from books order by title asc");
                            $booksss = $bookss->num_rows;
                            $totalPages = ceil($booksss / $item_per_page);
                        }
                        if($books->num_rows <= 0){
                            echo "<center><h4><i>Sách không có sẵn.</i></h4></center>";
                        }
                        while($row=$books->fetch_assoc()):
                        ?>

                            <?php
                                if($search){
                            ?>
                                <?php
                                while($row = mysqli_fetch_array($query_pro)){
                                ?>
                                <div class="col l-2-4 c-6 col home-product__contain">
                                    <a href="view_book.php?id=<?php echo $row['id'] ?>"  class="card view_prod card-product" data-id="<?php echo $row['id'] ?>">
                                        <div class="product__list">
                                            <div class="home-product-item__img" style= "background-image: url(admin/assets/uploads/<?php echo $row['image_path'] ?>);"></div>
                                                <div class="prod-item">
                                                    <h4 class="home-product-item__name"><?php echo $row['title'] ?></h4>
                                                    <div class="home-product-item__sub-information">
                                                        <div class="home-product-item__price-current">
                                                            <span class="price__product"><?php echo number_format($row['price']) ?></span>
                                                            <span class="copper__character">₫</span>
                                                        </div>
                                                        <?php
                                                          $qry = $conn->query("SELECT SUM(qty) AS 'booksold' FROM `order_list` WHERE book_id = ".$row['id']);
                                                          foreach($qry->fetch_array() as $k => $val){
                                                              $$k = $val;
                                                          }
                                                        ?>
                                                        <span class="books-sole">Đã bán <?php echo isset($booksold) ? $booksold : '0' ?></span>
                                                    </div>
                                                </div>
                                        </div>
                                    </a>
                                    <a href="view_book.php?id=<?php echo $row['id'] ?>" class="view_prod view__product--link" data-id="<?php echo $row['id'] ?>">
                                        <div class="home__product-information" >
                                            <p>Xem thông tin sản phẩm</p>
                                        </div>
                                    </a>
                                </div>
                                <?php
                                }
                                ?> 
                            <?php
                            }else {
                            ?>
                                <div class="col l-2-4 c-6 col home-product__contain">
                                    <a href="view_book.php?id=<?php echo $row['id'] ?>" class="card view_prod card-product" data-id="<?php echo $row['id'] ?>">
                                        <div class="product__list">
                                            <div class="home-product-item__img" style= "background-image: url(admin/assets/uploads/<?php echo $row['image_path'] ?>);"></div>
                                                <div class="prod-item">
                                                    <h4 class="home-product-item__name"><?php echo $row['title'] ?></h4>
                                                    <div class="home-product-item__sub-information">
                                                        <div class="home-product-item__price-current">
                                                            <span class="price__product"><?php echo number_format($row['price']) ?></span>
                                                            <span class="copper__character">₫</span>
                                                        </div>
                                                        <?php
                                                          $qry = $conn->query("SELECT SUM(qty) AS 'booksold' FROM `order_list` WHERE book_id = ".$row['id']);
                                                          foreach($qry->fetch_array() as $k => $val){
                                                              $$k = $val;
                                                          }
                                                        ?>
                                                        <span class="books-sole">Đã bán <?php echo isset($booksold) ? $booksold : '0' ?></span>
                                                    </div>
                                                </div>
                                        </div>
                                    </a>
                                    <a href="view_book.php?id=<?php echo $row['id'] ?>" class="view_prod view__product--link" data-id="<?php echo $row['id'] ?>">
                                        <div class="home__product-information" >
                                            <p>Xem thông tin sản phẩm</p>
                                        </div>
                                    </a>
                                </div>
                            <?php
                            }
                            ?> 
                    <?php endwhile; ?>
                </div>
            </div>
            
            <?php
                include 'pagination.php'
            ?>
        </div>
    </div>
</div>
       
<script>
    $('#cat-list li').click(function(){
        location.href = $(this).attr('data-href')
    })
     $('#cat-list li').each(function(){
        var id = '<?php echo $cid > 0 ? $cid : 'all' ?>';
        if(id == $(this).attr('data-id')){
            $(this).addClass('active')
        }
    })
     $('.view_prod').click(function(){
        uni_modal_right('Thông tin sách','view_prod.php?id='+$(this).attr('data-id'))
     })

     var splide = new Splide( '.splide', {
        autoplay    : true,
        rewind      : true,
        pauseOnHover: false,
        pauseOnFocus: false,
    } );
    splide.mount();
</script>