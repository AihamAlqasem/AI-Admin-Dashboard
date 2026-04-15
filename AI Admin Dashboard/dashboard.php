<?php
session_start();


if (isset($_SESSION['Sessionid'])) {
      $pagetitle = "الرئيسية";
include 'init.php';

?>
 <section id="content">
        <main id="link-wrapper">
            <div class="head-title">
                <div class="left">


                    <h1>لوحة التحكم <i class='fa fa-dashboard'></i></h1>
                    <ul class="breadcrumb">


                        <li>
                            <a href="#">لوحة التحكم</a>


                        </li>
                        <li><i class='fa fa-dashboard'></i></li>
                        <li>


                            <a class="active" href="#">الرئيسية</a>
                        <li><i class='fa fa-home'></i></li>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info" id="link-wrapper">

            <a href="our_work.php">
                    <li>
                        <img src="design/images/cataloge.png" alt="s">
                        <span class="text">
                            <h3><?php echo countData('ow_id','our_work') ?></h3>
                            <p>من أعمالنا</p>
                        </span>
                    </li>
                </a>

            <a href="services.php">
                    <li>
                        <img src="design/images/services.png" alt="s">
                        <span class="text">
                            <h3><?php echo countData('ser_id', 'services') ?></h3>
                            <p>خدماتنا</p>
                        </span>
                    </li>
                </a>

                <a href="banners.php">
                    <li>
                        <img src="design/images/ads_img.jpg" alt="s">
                        <span class="text">
                            <h3><?php echo countData('ban_id', 'banners') ?></h3>
                            <p>البانرات</p>
                        </span>
                    </li>
                </a>


              
                <a href="photo_gallery.php">
                    <li>
                        <img src="design/images/cataloge.png" alt="s">
                        <span class="text">
                            <h3><?php echo countData('pg_id', 'photo_gallery') ?></h3>
                            <p>معرض الصور</p>
                        </span>
                    </li>
                </a>
   
                <a href="products.php">
                    <li>
                        <img src="design/images/product_img.webp" alt="s">
                        <span class="text">
                            <h3><?php echo countData('pro_id', 'products') ?></h3>
                            <p>المنتجات</p>
                        </span>
                    </li>
                </a>

                <a href="category.php?action=Manage">
                    <li>
                        <img src="design/images/category.png" alt="s">
                        <span class="text">
                            <h3><?php echo countData('cat_id', 'categories') ?></h3>
                            <p>الاقسام</p>
                        </span>
                    </li>
                </a>
            </ul>
        </main>
    
    </section>

<?php
}
?>