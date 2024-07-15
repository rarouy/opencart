<?php
include 'Connect.php';
session_start();
$username = $_SESSION['NAME'];
$userRole = $_SESSION['USERROLE'];
if (!isset($_SESSION['HELLO'])) {
    header("location: login.php");
}
if (isset($_REQUEST['out'])) {
    session_destroy();
    session_commit();
    header("location: login.php");
}

$category = isset($_GET['category']) ? $_GET['category'] : '';
$search_query = isset($_REQUEST['txtsearch']) ? $_REQUEST['txtsearch'] : '';
$pro_id = $_GET['pro_id'];
$sql = "SELECT *  from tbl_pro where pro_id= $pro_id";

//$sqleach = "SELECT* from `tbl_pro` where pro_id = $rowpro['pro_id']";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    // Redirect or handle case where product is not found
    header("Location: indexadmin.php"); // For example, redirect to index.php
    exit;
}


$sqlcat = "SELECT `cat_id` FROM `tbl_pro` WHERE `pro_id` =  ?";
$stmt1 = $conn->prepare($sqlcat);
$stmt1->bind_param("i", $pro_id);
$stmt1->execute();
$result_cat = $stmt1->get_result();

if ($result_cat->num_rows > 0) {
    $row_cat = $result_cat->fetch_assoc();
    $cat_id = $row_cat['cat_id'];

    // Query to get similar products based on category
    $sqlconvert = "SELECT * FROM `tbl_pro` WHERE `cat_id` = ?";
    $stmt2 = $conn->prepare($sqlconvert);
    $stmt2->bind_param("i", $cat_id);
    $stmt2->execute();
    $resultsimilar = $stmt2->get_result();

  
//$qf = $conn->query($sqleach);
function formatProductName($productName) {
  // Convert the entire string to lowercase
  $productName = strtolower($productName);

  // Split the string into words
  $words = explode(' ', $productName);

  // Capitalize the first letter of the first word
  $words[0] = ucfirst($words[0]);

  // Capitalize subsequent words entirely
  for ($i = 1; $i < count($words); $i++) {
      // If the word is already uppercase, keep it as is
      if (strtoupper($words[$i]) === $words[$i]) {
          continue;
      }
      $words[$i] = ucfirst($words[$i]);
  }

  // Join the words back into a string
  return implode(' ', $words);
}

// Assume $row['pro_name'] contains the product name from your database query
$productName = $row['pro_name'];

// Format the product name using the formatProductName function
$formattedProductName = formatProductName($productName);
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
    <title>Eshop - eCommerce HTML5 Template.</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="images/favicon.png">
    <!-- Web Font -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- StyleSheet -->
    <link rel="stylesheet" href="css/bootstrap.css">
    
    
   
    <link rel="stylesheet" href="css/themify-icons.css">
   
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/flex-slider.min.css">
    <link rel="stylesheet" href="css/owl-carousel.css">
    <link rel="stylesheet" href="css/slicknav.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/responsive.css">
    <link rel="stylesheet" href="css/reset.css">
</head>
<style>
    .icon-hover:hover {
      border-color: #3b71ca;
      background-color:  #f7941d;
      color: black;
    }

    .icon-hover:hover i {
      color: black;
    }
    .nav-pills .nav-link.active {
      background-color:  #f7941d;
      color: #212529;
      font-weight: bold;
    }
    .card-comment {
      width: 100%; /* Adjust the width as needed */

      margin: auto; /* Center align the card */
      border: 1px solid #ccc; /* Add a border */
      border-radius: 10px; /* Add border radius */
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
    
}
.specification-content {
    /* Check for rules that might affect visibility */
    color: #000; /* Ensure color is set to a visible color */
    display: block; /* Ensure it's set to block or inline-block if needed */
    visibility: visible; /* Ensure visibility is not set to hidden or collapse */
}

    
  </style>

<body >
<?php include 'include/headerindexadmin.php';?>

<section class="hero-slider">
        <!-- Single Slider -->
        <div class="single-slider" style=" display: none;">
</div>


<section class="py-5">
      <div class="container">
        <div class="row gx-5">
          <aside class="col-lg-6">
            <div class="border rounded-4 mb-3 d-flex justify-content-center">
              <a
                data-fslightbox="mygalley"
                class="rounded-4"
                target="_blank"
                data-type="image"
             
              >
                <img
                  style="max-width: 100%; max-height: 100vh; margin: auto"
                  class="rounded-4 fit"
                  src="images/<?php echo $row['pro_img']; ?>"
                />
              </a>
            </div>

            <!-- thumbs-wrap.// -->
            <!-- gallery-wrap .end// -->
          </aside>
          <main class="col-lg-6">
            <div class="ps-lg-3">
              <h4 class="title text-dark">
                      <?php echo $formattedProductName; ?></php> <br />
         
              </h4>
              <div class="d-flex flex-row my-3">
                <div class="text-warning mb-1 me-2">
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fa fa-star"></i>
                  <i class="fas fa-star-half-alt"></i>
                  <span class="ms-1"> 4.5 </span>
                </div>
                <span class="text-muted"
                  ><i class="fas fa-shopping-basket fa-sm mx-1"></i> <?php echo $row['pro_qty']; ?></php>
                  ITEMS </span
                >
                <span class="text-success ms-2 ml-4">In stock</span>
              </div>

              <div class="mb-3">
                <span class="h5"> <?php echo $row['pro_price']; ?></php>$</span>
                <span class="text-muted"></span>
              </div>

              <p>
                <?php echo $row['pro_discription']; ?>
              </p>
<!-- 
              <div class="row">
                <dt class="col-3 ">Type:</dt>
                <dd class="col-8" >Regular</dd>

                <dt class="col-3">Color</dt>
                <dd class="col-8">Brown</dd>

                <dt class="col-3">Material</dt>
                <dd class="col-8">Cotton, Jeans</dd>

                <dt class="col-3">Brand</dt>
                <dd class="col-8">Reebook</dd>
              </div> -->

              <hr />

              <div class="row mb-4">
                <div class="col-md-4 col-6">
                  <label class="mb-2 d-block">Size</label>
                  <select
                    class="form-select== border border-secondary"
                    style=" padding:10px; height: 35px;"
                  >
                    <option>Small</option>
                    <option>Medium</option>
                    <option>Large</option>
                  </select>
                </div>
                <!-- col.// -->
                <div class="col-md-4 col-6 mb-3">
                  <label class="mb-2 d-block">Quantity</label>
                  <div class="input-group mb-3" style="width: 170px">
                    <button
                      class="btn btn-white border border-secondary px-3"
                      type="button"
                      id="decreaseBtn"
                      data-mdb-ripple-color="dark"
                    >
                      <i class="fas fa-minus"></i>
                    </button>
                    <input
                      type="text"
                      class="form-control text-center border border-secondary"
                      id="quantityInput"
                      placeholder="1"
                      aria-label="Example text with button addon"
                      aria-describedby="button-addon1"
                        value="1"
                    />
                    <button
                      class="btn btn-white border border-secondary px-3"
                      type="button"
                      id="increaseBtn"
                      data-mdb-ripple-color="dark"
                    >
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                </div>
              </div>
              <a href="#" class="btn shadow-0" style="background-color: #f7941d;"> Buy now </a>
              <a href="#" class="btn btn-primary shadow-0">
                <i class="me-1 fa fa-shopping-basket"></i> Add to cart
              </a>
             
            </div>
          </main>
        </div>
      </div>
    </section>
    <!-- content -->

    <section class="bg-light border-top py-4">
      <div class="container">
        <div class="row gx-4">
          <div class="col-lg-8 mb-4">
            <div class="border rounded-2 px-3 py-2 bg-white">
              <!-- Pills navs -->
              <ul
                class="nav nav-pills nav-justified mb-3"
                id="ex1"
                role="tablist"
              >
                <li class="nav-item d-flex" role="presentation">
                  <a
                    class="nav-link d-flex align-items-center justify-content-center w-100 active"
                    id="ex1-tab-1"
                    data-mdb-toggle="pill"
                    href="#ex1-pills-1"
                    role="tab"
                    aria-controls="ex1-pills-1"
                    aria-selected="true"
                  >
                    Specification
                  </a>
                </li>
                <li class="nav-item d-flex" role="presentation">
                  <a
                    class="nav-link d-flex align-items-center justify-content-center w-100"
                    id="ex1-tab-2"
                    data-mdb-toggle="pill"
                    href="#ex1-pills-2"
                    role="tab"
                    aria-controls="ex1-pills-2"
                    aria-selected="false"
                  >
                    Comment
                  </a>
                </li>
              </ul>
                    
              <div class="tab-content">
    <div class="tab-pane fade show active w-100 specification-content" id="ex1-pills-1" role="tabpanel" aria-labelledby="ex1-tab-1">
        <!-- Content for Specification tab -->
        <div class="row">
                    <div class="col-md-11 col-lg-9 col-xl-7">
                      <div class="d-flex flex-start mb-4" style="width: 715px">
                        <div class="card col-12 w-100 card-comment">
                          <div class="card-body p-4">
                            <div>
                              <h5><?php echo $formattedProductName;?></h5>
                              <hr>
                              <p>
                               <?php echo $row['pro_spec'];?>
                              </p>

                             
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--to loop comment -->
                    </div>
                  </div>
    </div>
                <div
                  class="tab-pane fade"
                  id="ex1-pills-2"
                  role="tabpanel"
                  aria-labelledby="ex1-tab-2"
                >
                  <div class="row">
                    <div class="col-md-11 col-lg-9 col-xl-7">
                      <div class="d-flex flex-start mb-4" style="width: 568px">
                        <img
                          class="rounded-circle shadow-1-strong me-3 mr-4"
                          src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(32).webp"
                          alt="avatar"
                          width="65"
                          height="65"
                        />
                        <div class="card col-12 w-100 card-comment">
                          <div class="card-body p-4">
                            <div>
                              <h5>Johny Cash</h5>
                              <p class="small">3 hours ago</p>
                              <p>
                                Cras sit amet nibh libero, in gravida nulla.
                                Nulla vel metus scelerisque ante sollicitudin.
                                Cras purus odio, vestibulum in vulputate at,
                                tempus viverra turpis. Fusce condimentum nunc ac
                                nisi vulputate fringilla. Donec lacinia congue
                                felis in faucibus ras purus odio, vestibulum in
                                vulputate at, tempus viverra turpis.
                              </p>

                              <div
                                class="d-flex justify-content-between align-items-center"
                              >
                                <div class="d-flex align-items-center">
                                  <a href="#!" class="link-muted me-2"
                                    ><i class="fas fa-thumbs-up me-1"></i>132</a
                                  >
                                  <a href="#!" class="link-muted" style="padding-left: 10px;"
                                    ><i class="fas fa-thumbs-down me-1"></i
                                    >15</a
                                  >
                                </div>
                                <a href="#!" class="link-muted"
                                  ><i class="fas fa-reply me-1"></i> Reply</a
                                >
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!--to loop comment -->
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-11 col-lg-9 col-xl-7">
                      <div class="d-flex flex-start" style="width: 568px">
                        <img
                          class="rounded-circle shadow-1-strong me-3  mr-4"
                          src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(31).webp"
                          alt="avatar"
                          width="65"
                          height="65"
                        />
                        <div class="card col-12 w-100 card-comment">
                          <div class="card-body p-4">
                            <div>
                              <h5>Mindy Campbell</h5>
                              <p class="small">5 hours ago</p>
                              <p>
                                Lorem ipsum dolor sit, amet consectetur
                                adipisicing elit. Delectus cumque doloribus
                                dolorum dolor repellat nemo animi at iure autem
                                fuga cupiditate architecto ut quam provident
                                neque, inventore nisi eos quas? Lorem ipsum
                                dolor sit, amet consectetur adipisicing elit.
                                Delectus cumque doloribus dolorum dolor repellat
                                nemo animi at iure autem fuga cupiditate
                                architecto ut quam provident Lorem ipsum dolor
                                sit, amet consectetur adipisicing elit. Delectus
                                cumque doloribus dolorum dolor repellat nemo
                                animi at iure autem fuga cupiditate architecto
                                ut quam provident neque, inventore nisi eos
                                quas? Lorem ipsum dolor sit, amet consectetur
                                adipisicing elit. Delectus cumque doloribus
                                dolorum dolor repellat nemo animi at iure autem
                                fuga cupiditate architecto ut quam provident
                              </p>

                              <div
                                class="d-flex justify-content-between align-items-center"
                              >
                                <div class="d-flex align-items-center">
                                  <a href="#!" class="link-muted me-2"
                                    ><i class="fas fa-thumbs-up me-1"></i>158</a
                                  >
                                  <a href="#!" class="link-muted"style="padding-left: 10px;"
                                    ><i class="fas fa-thumbs-down me-1"></i
                                    >13</a
                                  >
                                </div>
                                <a href="#!" class="link-muted"
                                  ><i class="fas fa-reply me-1"></i> Reply</a
                                >
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!--to loop comment -->

                  <div
                    class="card-footer mt-2 py-3 border-0"
                    style="background-color: white"
                  >
                    <div class="d-flex flex-start w-100">
                      <img
                        class="rounded-circle shadow-1-strong mr-4 me-3"
                        src="https://mdbcdn.b-cdn.net/img/Photos/Avatars/img%20(19).webp"
                        alt="avatar"
                        width="40"
                        height="40"
                      />
                      <div data-mdb-input-init class="form-outline w-100">
                        <textarea
                          class="form-control"
                          id="textAreaExample"
                          rows="4"
                          style="background: #fff"
                        ></textarea>
                        <label class="form-label" for="textAreaExample"
                          >Message</label
                        >
                      </div>
                    </div>
                    <div class="mt-2 pt-1" style="margin-left: 50px">
                      <button
                        type="button"
                        data-mdb-button-init
                        data-mdb-ripple-init
                        class="btn btn-warning btn-sm"
                      >
                        Post comment
                      </button>
                      <button
                        type="button"
                        data-mdb-button-init
                        data-mdb-ripple-init
                        class="btn btn-outline-primary btn-sm"
                      >
                        Cancel
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="px-0 border rounded-2 shadow-0">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Similar items</h5>
                  <?php
                    if ($resultsimilar->num_rows > 0) {
                      while ($row_similar = $resultsimilar->fetch_assoc()) {
                         
                      echo '
                      <div class="d-flex mb-3">

                    <a href="product-details.php?pro_id='.$row_similar['pro_id'].'" class="me-3">
                      <img
                        src="images/'.$row_similar['pro_img'].'"
                        style="width: 130px; height: 100px"
                        class="img-md img-thumbnail"
                      />
                    </a>
                    <div class="info">
                      <a href="product-details.php?pro_id='.$row_similar['pro_id'].'" class="nav-link mb-1">
                       '.$row_similar['pro_name'].' <br />
                      </a>
                      <strong class="text-dark" style="margin-left: 20px"> $ '.$row_similar['pro_price'].'</strong>
                    </div>
                  </div>

                      
                      ';

                      }
                  } else {
                      // No similar products found
                  }
                 } else {
                  // Product not found
                  header("Location: indexadmin.php");
                  exit;
              }
                  
                  ?>
                  
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Footer -->

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

        // JavaScript for increment and decrement buttons
        document.addEventListener("DOMContentLoaded", function () {
            const decreaseButton = document.getElementById("decreaseBtn");
            const increaseButton = document.getElementById("increaseBtn");
            const quantityInput = document.getElementById("quantityInput");

            decreaseButton.addEventListener("click", function () {
              decreaseNumber();
            });

            increaseButton.addEventListener("click", function () {
              increaseNumber();
            });

            function decreaseNumber() {
              let currentValue = parseInt(quantityInput.value);
              if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
              }
            }

            function increaseNumber() {
              let currentValue = parseInt(quantityInput.value);
              quantityInput.value = currentValue + 1;
            }
        });

        // JavaScript for tab navigation
        document.addEventListener("DOMContentLoaded", function () {
            var tabLinks = document.querySelectorAll(".nav-link");

            tabLinks.forEach(function (tabLink) {
                tabLink.addEventListener("click", function (event) {
                    event.preventDefault();

                    tabLinks.forEach(function (link) {
                        link.classList.remove("active");
                        link.setAttribute("aria-selected", "false");
                    });

                    this.classList.add("active");
                    this.setAttribute("aria-selected", "true");

                    var tabPanes = document.querySelectorAll(".tab-pane");
                    tabPanes.forEach(function (pane) {
                        pane.classList.remove("show", "active");
                    });

                    var targetPaneId = this.getAttribute("href");
                    document.querySelector(targetPaneId).classList.add("show", "active");
                });
            });
        });
    </script>
</body>
</html>
