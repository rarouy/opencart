<?php include 'Connect.php';

session_start();
$username = $_SESSION['NAME'];

$userRole = $_SESSION['USERROLE'];
if(!isset($_SESSION['HELLO'])){
  header("location: login.php");
}
if(isset($_REQUEST['out'])){
  session_destroy();
  session_commit();
  header("location: login.php");
}
$category = isset($_GET['category']) ? $_GET['category'] : '';
$search_query = isset($_REQUEST['txtsearch']) ? $_REQUEST['txtsearch'] : '';

$sql = "SELECT tbl_pro.*, tbl_cat.* FROM tbl_pro JOIN tbl_cat ON tbl_pro.cat_id = tbl_cat.cat_id";
$sqlfooterimg = "SELECT pro_img from tbl_pro Where pro_id = 1";
if (!empty($category) || !empty($search_query)) {
    $sql .= " WHERE";
    $conditions = [];
    if (!empty($category)) {
        $conditions[] = " tbl_pro.cat_id = $category";
    }
    if (!empty($search_query)) {
        $conditions[] = "(tbl_pro.pro_name LIKE '%$search_query%' OR tbl_cat.cat_name LIKE '%$search_query%')";
    }
    $sql .= implode(" AND ", $conditions);
}
$qf = $conn->query($sqlfooterimg);
$qr = $conn->query($sql);
require_once 'include/functions.php';

?>

<!DOCTYPE html>
<html lang="">
<head>
    <!-- Meta Tag -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Title Tag  -->
    <title></title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/favicon.png">
    <!-- Web Font -->
     <!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" />

    <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- StyleSheet -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/magnific-popup.min.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/jquery.fancybox.min.css">
    <link rel="stylesheet" href="css/themify-icons.css">
    <link rel="stylesheet" href="css/niceselect.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/flex-slider.min.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/slicknav.min.css">
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
</head>

<body class="js">
<?php include 'include/headerindexadmin.php';?>

<section class="hero-slider">
        <!-- Single Slider -->
        <div class="single-slider" style=" display: none;">
</div>

<div class="product-area section" style="margin-top: -100px;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="product-info">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="man" role="tabpanel">
                            <div class="tab-single">
                                <div class="row">
                                    <?php
                                   
                                    if ($qr->num_rows > 0) {
                                        while ($rowpro = $qr->fetch_assoc()) {
                                            $productName = $rowpro['pro_name'];
                                            $formattedProductName = formatProductName($productName);
                                            echo '<div class="col-xl-3 col-lg-4 col-md-4 col-12">
                                                <div class="single-product">
                                                    <div class="product-img" style="border: solid 1px rgb(240, 240, 240); border-top-left-radius: 5px; border-top-right-radius: 5px;">
                                                        <a href="product-details.php?pro_id='.$rowpro['pro_id'].'">
                                                            <img class="default-img" style="width: 262px; height: 270px;" src="images/'.$rowpro['pro_img'].'" alt="#">
                                                            <img class="hover-img" style="width: 262px; height: 270px;" src="images/'.$rowpro['pro_img'].'" alt="#">
                                                        </a>
                                                        <div class="button-head">
                                                            <div class="product-action">
                                                                <a data-toggle="modal" data-target="#exampleModal" title="Quick View" href="#">
                                                                
                                                                </a>
                                                                <a title="Selling" href="#">Total Selling: '.$rowpro['pro_selling'].' </a>
                                                             
                                                            </div>
                                                            <div class="product-action-2">
                                                                <a title="Add to cart" style="padding-left: 5px;" href="#">Add to cart<i class="fas fa-shopping-cart"></i></a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="product-content" style="padding-left:5px;background-color:  #f7941d; margin-top:-2px; border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
                                                        <a href="product-details.php?pro_id='.$rowpro['pro_id'].'">'. $formattedProductName .'</a><span style="display: flex;">$'.$rowpro['pro_price'].'</span>
                                                    </div>
                                                </div>
                                            </div>';
                                        }
                                    } else {
                                        echo '<h1 style="text-align: center; margin-left:45%; margin-top:15%; border: 2px solid black;">No Data</h1>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'include/footer.php';?>

<!-- Jquery -->
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.0.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/colors.js"></script>
<script src="js/slicknav.min.js"></script>
<script src="js/owl-carousel.js"></script>
<script src="js/magnific-popup.js"></script>
<script src="js/facnybox.min.js"></script>
<script src="js/waypoints.min.js"></script>
<script src="js/finalcountdown.min.js"></script>
<script src="js/nicesellect.js"></script>
<script src="js/ytplayer.min.js"></script>
<script src="js/flex-slider.js"></script>
<script src="js/scrollup.js"></script>
<script src="js/onepage-nav.min.js"></script>
<script src="js/easing.js"></script>
<script src="js/active.js"></script>

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
</body>
</html>
