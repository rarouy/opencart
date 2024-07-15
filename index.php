<!DOCTYPE html>
<html lang="">
<?php include 'Connect.php';?>
<head>
    <!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title Tag  -->
    <title>Eshop - eCommerce HTML5 Template.</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/favicon.png">
    <!-- Web Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- StyleSheet -->

    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="css/magnific-popup.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Fancybox -->
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="css/themify-icons.css">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="css/niceselect.css">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="css/animate.css">
    <!-- Flex Slider CSS -->
    <link rel="stylesheet" href="css/flex-slider.min.css">
    <!-- Owl Carousel -->
    <link rel="stylesheet" href="css/owl-carousel.css">
    <!-- Slicknav -->
    <link rel="stylesheet" href="css/slicknav.min.css">

    <!-- Eshop StyleSheet -->
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="style.css">
 
    <link rel="stylesheet" href="css/responsive.css">

</head>


<body class="js">
<?php include 'include/headerindex.php';?>
<section class="hero-slider">
        <!-- Single Slider -->
        <div class="single-slider" style=" display: none;">
</div>

    <!-- End Small Banner -->

    <!-- Start Product Area -->
    <div class="product-area section" style="margin-top: -100px;">
        <div class="container">
          
            <div class="row">
                <div class="col-12">
                    <div class="product-info">
                   
                        <div class="tab-content" id="myTabContent">
                            <!-- Start Single Tab -->
                            <div class="tab-pane fade show active" id="man" role="tabpanel">
                                <div class="tab-single">
                                    <div class="row">
              
                                    

                                    <?php
           if (isset($_REQUEST['search_btn'])) {
              $search_query = $_REQUEST['txtsearch'];
            if (!empty($search_query)) {
           $sql = "SELECT tbl_pro.*, tbl_cat.* FROM tbl_pro JOIN tbl_cat ON tbl_pro.cat_id = tbl_cat.cat_id WHERE tbl_pro.pro_name LIKE '%$search_query%'  OR tbl_cat.cat_name LIKE '%$search_query%'";
        
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($rowpro = $result->fetch_assoc()) {
                        echo '<div class="col-xl-3 col-lg-4 col-md-4 col-12">
                <div class="single-product">
                    <div class="product-img" style="border: solid 1px rgb(240, 240, 240);  border-top-left-radius: 5px;
                      border-top-right-radius: 5px;">
                        <a href="product-details.html">
                            <img class="default-img" style="width: 262px; height: 270px;" src="images/'.$rowpro['pro_img'].'" alt="#">
                            <img class="hover-img" style="width: 262px; height: 270px;"  src="images/'.$rowpro['pro_img'].'" alt="#">
                        </a>
                        <div class="button-head">
                            <div class="product-action">
                                <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#">
                                    <i class="ti-eye"></i><span>Quick Shop</span>
                                </a>
                                <a title="Wishlist" href="#">Total Selling : </span></a>
                                <a title="Compare" href="#">100</span></a>
                            </div>
                            <div class="product-action-2">
                                <a title="Add to cart" style="padding-left: 5px;" href="#">Add to cart<i class="fas fa-shopping-cart"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="product-content" style="padding-left:5px;background-color: #F7941D; margin-top:-2px;  border-bottom-left-radius: 5px;
                      border-bottom-right-radius: 5px;">
                       <a href="product-details.html">'.$rowpro['pro_name'].'</a>   <span style="display: flex;">$'.$rowpro['pro_price'].'</span>
                    </div>
                </div>
            </div>';
                    }
                  
                } else {
                    echo '<h1 style="text-align: center; margin-left:45%; margin-top:15%; border: 2px solid black;">No Data</h1>';
                }
            } elseif(empty($search_query)){
               
                $sql = "SELECT * FROM `tbl_pro`";
                $qrselect = $conn->query($sql);
                if ($qrselect->num_rows > 0) {
                    while ($rowpro = $qrselect->fetch_assoc()) {
                        echo '<div class="col-xl-3 col-lg-4 col-md-4 col-12">
                <div class="single-product">
                    <div class="product-img" style="border: solid 1px rgb(240, 240, 240);  border-top-left-radius: 5px;
                      border-top-right-radius: 5px;">
                        <a href="product-details.html">
                            <img class="default-img" style="width: 262px; height: 270px;px;" src="images/'.$rowpro['pro_img'].'" alt="#">
                            <img class="hover-img" style="width: 262px; height: px;"  src="images/'.$rowpro['pro_img'].'" alt="#">
                        </a>
                        <div class="button-head">
                            <div class="product-action">
                                <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#">
                                    <i class="ti-eye"></i><span>Quick Shop</span>
                                </a>
                                <a title="Wishlist" href="#"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                                <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                            </div>
                            <div class="product-action-2">
                                <a title="Add to cart" style="padding-left: 5px;" href="#">Add to cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="product-content" style="padding-left:5px;background-color: #F7941D; margin-top:-2px;  border-bottom-left-radius: 5px;
                      border-bottom-right-radius: 5px;">
                       <a href="product-details.html">'.$rowpro['pro_name'].'</a>   <span style="display: flex;">$'.$rowpro['pro_price'].'</span>
                    </div>
                </div>
            </div>';
            
                    }
                }
                include 'include/footer.php';
            }
        
        } else {
          $sql = "SELECT * FROM `tbl_pro`";
    $qrselect = $conn->query($sql);
if ($qrselect->num_rows > 0) {
    while ($rowpro = $qrselect->fetch_assoc()) {
        echo '<div class="col-xl-3 col-lg-4 col-md-4 col-12">
                <div class="single-product">
                    <div class="product-img" style="border: solid 1px rgb(240, 240, 240);  border-top-left-radius: 5px;
                      border-top-right-radius: 5px;">
                        <a href="product-details.html">
                            <img class="default-img" style="width: 262px; height: 270px;" src="images/'.$rowpro['pro_img'].'" alt="#">
                            <img class="hover-img" style="width: 262px; height: 270px;"  src="images/'.$rowpro['pro_img'].'" alt="#">
                        </a>
                        <div class="button-head">
                            <div class="product-action">
                                <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#">
                                    <i class="ti-eye"></i><span>Quick Shop</span>
                                </a>
                                <a title="Wishlist" href="#"><i class="ti-heart"></i><span>Add to Wishlist</span></a>
                                <a title="Compare" href="#"><i class="ti-bar-chart-alt"></i><span>Add to Compare</span></a>
                            </div>
                            <div class="product-action-2">
                                <a title="Add to cart" style="padding-left: 5px;" href="#">Add to cart</a>
                            </div>
                        </div>
                    </div>
                    <div class="product-content" style="padding-left:5px;background-color: #F7941D; margin-top:-2px;  border-bottom-left-radius: 5px;
                      border-bottom-right-radius: 5px;">
                       <a href="product-details.html">'.$rowpro['pro_name'].'</a>   <span style="display: flex;">$'.$rowpro['pro_price'].'</span>
                    </div>
                </div>
            </div>';
          
    }
   include 'include/footer.php';
} else {
    echo '<h1 style="text-align: center; margin-left:45%; margin-top:15%; border: 2px solid black;">No Data</h1>';
}
        } 

        
        // end of php
        ?> 


                                      
                                        
                             


                                    </div>
                                </div>
                            </div>
                            <!--/ End Single Tab -->
                            <!-- Start Single Tab -->
                                   

  

    <!-- Start Shop Home List  -->
   

    <!-- End Shop Home List  -->

    <!-- Start Shop Blog  -->
    
    <!-- /End Footer Area -->

    <!-- Jquery -->
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery-migrate-3.0.0.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <!-- Popper JS -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Color JS -->
    <script src="js/colors.js"></script>
    <!-- Slicknav JS -->
    <script src="js/slicknav.min.js"></script>
    <!-- Owl Carousel JS -->
    <script src="js/owl-carousel.js"></script>
    <!-- Magnific Popup JS -->
    <script src="js/magnific-popup.js"></script>
    <!-- Fancybox JS -->
    <script src="js/facnybox.min.js"></script>
    <!-- Waypoints JS -->
    <script src="js/waypoints.min.js"></script>
    <!-- Countdown JS -->
    <script src="js/finalcountdown.min.js"></script>
    <!-- Nice Select JS -->
    <script src="js/nicesellect.js"></script>
    <!-- Ytplayer JS -->
    <script src="js/ytplayer.min.js"></script>
    <!-- Flex Slider JS -->
    <script src="js/flex-slider.js"></script>
    <!-- ScrollUp JS -->
    <script src="js/scrollup.js"></script>
    <!-- Onepage Nav JS -->
    <script src="js/onepage-nav.min.js"></script>
    <!-- Easing JS -->
    <script src="js/easing.js"></script>
    <!-- Active JS -->
    <script src="js/active.js"></script>
</body>

</html>
<script>
    // JavaScript to make header sticky and change background color on scroll
    window.addEventListener('scroll', function() {
        var header = document.querySelector('.header.shop');
        var scrollPosition = window.scrollY || document.documentElement.scrollTop;

        if (scrollPosition > 50) { // Adjust the scroll position as needed
            header.classList.add('sticky');
        } else {
            header.classList.remove('sticky');
        }
    });
</script>
