<?php
session_start();
include 'Connect.php';

// Check if the user is logged in
if (!isset($_SESSION['HELLO'])) {
  header("Location: login.php");
  exit(); // Ensure that no further code is executed
}

// Check if the user has the correct role
if ($_SESSION['USERROLE'] !== 'Admin') {
  header("Location: ll.php"); // Redirect non-admin users to a different page
  exit(); // Ensure that no further code is executed
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">


    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="stylecreate.css">
    <!-- DataTables -->
</head>
<header>
        <nav>
            <div class="logo">MyLogo</div>
            <ul class="nav-links">
                <li><a href="indexadmin.php">Home</a></li>
                <li><a href="create.php">Create</a></li>
        
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>
<?php
if(isset($_REQUEST['delete_id'])){
    $btndelete = $_REQUEST['delete_id'];
    $getImage = $conn->query("SELECT `pro_img` FROM tbl_pro WHERE pro_id=$btndelete");
    $sqlDel = "DELETE FROM tbl_pro WHERE pro_id=$btndelete";

    if($conn->query($sqlDel) === TRUE){
        $imageRow = $getImage->fetch_assoc();
        $imageName = $imageRow['pro_img'];
        if($imageName != 'no-image.png') {
            unlink("images/".$imageName); // Deleting associated image
        }
        echo '
        <div class="alert alert-success alert-dismissible" id="alert-delete">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Success delete!</strong>
        </div>';
    } else {
        echo '
        <div class="alert alert-danger alert-dismissible" id="alert-delete">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong>Error delete!</strong>
        </div>';
    }
}
?>

<body class="hold-transition sidebar-mini">
<div class="card">
    <div class="card-header">
        <h3 class="card-title">DataTable with default features</h3>
    </div>
    <form method="post" enctype="multipart/form-data">
    <!-- /.card-header -->
    <div class="card-body">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pro_Name</th>
                    <th>Cat_Name</th>
                    <th>Pro_QTY</th>
                    <th>Pro_IMG</th>
                    <th>Pro_Price</th>
                    <th>Pro_Selling</th>
                    <th>Pro_Description</th>
                    <th>Pro_Spec</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM `tbl_pro`";
                $sqlcat = "SELECT * FROM `tbl_cat`";
                $qrtype = $conn->query($sqlcat);

                $catNames = [];
                while ($rowcat = $qrtype->fetch_assoc()) {
                    $catNames[$rowcat['cat_id']] = $rowcat['cat_name'];
                }

                $qr = $conn->query($sql);
                if($qr->num_rows > 0) {
                    $i = 1;
                    while($row = $qr->fetch_assoc()) {
                        $catName = isset($catNames[$row['cat_id']]) ? $catNames[$row['cat_id']] : '';
                        echo '
                        <tr>
                            <td>'.$i.'</td>
                            <td>'.$row['pro_name'].'</td>
                            <td>'.$catName.'</td>
                            <td>'.$row['pro_qty'].'</td>
                            <td><img src="images/'.$row['pro_img'].'" alt="no image" height="40px"></td>
                            <td>'.$row['pro_price'].'</td>
                            <td>'.$row['pro_selling'].'</td>
                            <td>'.$row['pro_discription'].'</td>
                                <td>'.$row['pro_spec'].'</td>
                            <td>
                                <a href="update.php?up_id='.$row['pro_id'].'" class="btn btn-sm btn-outline-success">Update</a>
                                <a href="#" data-href="product.php?delete_id='.$row['pro_id'].'" data-bs-toggle="modal" data-bs-target="#confirmDelete" class="btn btn-outline-danger btn-sm custom-delete-btn">Delete</a>
                            </td>
                        </tr>';
                        $i++;
                    }
                } else {
                    echo '
                    <tr>
                        <td colspan="9">No Data</td>
                    </tr>';
                }
                ?>
            </tbody>
            <tfoot>
            </tfoot>
        </table>
              
    </div>
    <!-- /.card-body -->
    </form>
</div>

<!-- /.card -->

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Warning</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                Are you sure you want to delete this data?
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <a class="btn btn-danger btn-ok">Yes</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>

 
  <!-- lINK DIALOG  -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- Google Font: Source Sans Pro -->
  <!-- Ionicons -->

  <!-- Theme style -->


<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
    $(function () {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
    });

    $('#confirmDelete').on('show.bs.modal', function(e) {
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
    });
    $(document).ready(function() {

$(document).ready(function () {
          $('#confirmDelete').on('show.bs.modal', function (e) {
              $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
          });
      });
$("#alert-success").fadeTo(1000, 500).slideUp(300, function(){
  $("#alert-success").slideUp(500);
  window.location=("create.php");
});

});

$(document).ready(function () {
          $('#confirmDelete').on('show.bs.modal', function (e) {
              $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
          });
      });
      $("#alert-delete").fadeTo(2000, 500).slideUp(500, function () {
          $("#alert-delete").slideUp(500);
          window.location = ("product.php");
      });
      $("#alert-insert").fadeTo(2000, 500).slideUp(500, function () {
          $("#alert-delete").slideUp(500);
          window.location = ("general.php");
      });
      $("#alert-update").fadeTo(2000, 500).slideUp(500, function () {
          $("#alert-delete").slideUp(500);
          window.location = ("update.php");
      });

      function displayFileName(input) {
          const fileName = input.files[0].name;
          document.getElementById('fileNameTextBox').value = fileName;
      }
</script>
</body>
</html>
