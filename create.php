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
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="img/logo.jpg" type="image/x-icon">
  <title>MusicTime</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
 <link rel="stylesheet" href="stylecreate.css">
</head>

<body>
  
<div class="wrapper">
<header>
        <nav>
            <div class="logo">MyLogo</div>
            <ul class="nav-links">
                <li><a href="indexadmin.php">Home</a></li>
                <li><a href="product.php">Product</a></li>
        
            </ul>
            <div class="burger">
                <div class="line1"></div>
                <div class="line2"></div>
                <div class="line3"></div>
            </div>
        </nav>
    </header>

  <div class="content-wrapper">
 

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <br>
      <br>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid" style="width: 90%; justify-content: center; display: flex; margin-top: 2%; ">
    
        
      <form method="post" enctype="multipart/form-data">
      <?php

if (isset($_REQUEST['btnadd'])) {
 $pro_name = $_REQUEST['pro_name'];
 $pro_spec = $_REQUEST['txtspec'];
 $pro_cat = $_REQUEST['cat'];
 $pro_qty = $_REQUEST['pro_qty'];
 $pro_detail =$_REQUEST['txtdetail'];
 $pro_price = $_REQUEST['pro_price'];
 $pro_selling = $_REQUEST['pro_selling'];
 $pro_image = $_FILES['txtimage']['name'];
 $pro_image_tmp = $_FILES['txtimage']['tmp_name'];
 $currentDate = date("d_m_Y_h_i_s");
 $pro_newimage = $currentDate . '_' . rand() . '_' . $pro_image;
 $sqlInsert = "INSERT INTO `tbl_pro`(`pro_name`, `cat_id`, `pro_qty`, `pro_price`, `pro_selling`, `pro_img`,`pro_discription`,`pro_spec`) VALUES   "; 
    if (!empty($pro_image)) {
       
        move_uploaded_file($pro_image_tmp, "images/" .$pro_newimage);

        $sqlInsert .= "('$pro_name','$pro_cat','$pro_qty','$pro_price','$pro_selling','$pro_newimage','$pro_detail','$pro_spec')";
    } else {
        $defaultImage = "no-image.png";
        $sqlInsert .= "('$pro_name','$pro_cat','$pro_qty','$pro_price','$pro_selling','$defaultImage','$pro_detail','$pro_spec')";
    }
    if ($conn->query($sqlInsert) === TRUE) {
        echo '
        <div class ="alert alert-success alert-dismissible" id="alert-success">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Success!</strong>Data has been Inserted 
    </div>
        ';
    } else {
        echo '
        <div class ="alert alert-danger alert-dismissible" id="alert-success">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Error!</strong>Data cannot Insert 
    </div>
    ';
 }

} 
?>
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title"> From create </h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label>Product Tietle</label>
                    <input type="text" class="form-control" placeholder="Enter ..." name="pro_name" required>
                </div>
                <div class="form-group">
                  <label>Category</label>
                  <select class="form-control select2bs4" style="width: 100%;" name= "cat" required>
                  <?php
                $sqlcat = "SELECT * FROM `tbl_cat`";
                $qrcat= $conn->query($sqlcat);
                if($qrcat->num_rows>0){
                    while($rowcat = $qrcat->fetch_assoc()){
                        if($frm['cat_id']==$rowcat['cat_id'])
                            $sel = 'selected';
                        else
                            $sel = '';
                        echo '<option value="'.$rowcat['cat_id'].'" '.$sel.'> '.$rowcat['cat_name'].' </option>';    
                    }
                }
                else{
                    echo '<option value="0"> NO Data </option>';
                }
                ?>
                  </select>
                </div>
         
             
          
                <!-- /.form-group -->
                <div class="form-group">
                    <label>Pro Quantity</label>
                    <input type="number" class="form-control" placeholder="Enter ..." name="pro_qty">
                </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <label>Pro Price</label>
                    <input type="number" class="form-control" placeholder="Enter ..." name="pro_price">
                </div>
                
                <div class="form-group">
                    <label>Pro selling amount</label>
                    <input type="number" class="form-control" placeholder="Enter ..." name="pro_selling">
                </div>
              </div>
    
              <!-- /.col -->
              <div class="col-md-6">
                <img src="images/no-image.png" alt="" style="max-width:100%; height:258px;" id="imgbox">
                <div class="form-group">
                    <label for="exampleInputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" name= "txtimage" id="imgInp"  accept="image/*"   >
                        <label class="custom-file-label">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="" >Upload</span>
                      </div>
                    </div>
                  </div>
                <!-- /.form-group -->
           
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="mb-3">
                <label for="exampleInputFile">Product Description</label>
                    <textarea class="textarea" placeholder="Place some text here"
                            style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="txtdetail"></textarea>
                </div>
              </div> 
              <div class="col-md-6">
                <div class="mb-3">
                <label for="exampleInputFile">Product Specification</label>
                    <textarea class="textarea" placeholder="Place some text here"
                            style="width: 100%; height: 400px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" name="txtspec"></textarea>
                </div>
              </div> 
           
              <button type= "submit" class="btn btn-warning" style= "width:150px; font-weight: bold;" name="btnadd">ADD</button>
             
            
            
            
            </form>
              
          

            </div>
            <!-- /.row -->
            
          </div>
          <!-- /.card-body -->
         
        </div>
        <!-- /.card -->
 
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- date-range-picker -->
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page script -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
  $(function () {
    // Summernote
    $('.textarea').summernote()

    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            imgbox.src = URL.createObjectURL(file)
        }
    }
  })
  
</script>
<script>
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
    $("#alert-danger").fadeTo(1000, 500).slideUp(300, function(){
    $("#alert-danger").slideUp(500);
    window.location=("create.php");

});

$(document).ready(function () {
            $('#confirmDelete').on('show.bs.modal', function (e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });
        });
        $("#alert-delete").fadeTo(2000, 500).slideUp(500, function () {
            $("#alert-delete").slideUp(500);
            window.location = ("create.php");
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
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservationdate').datetimepicker({
        format: 'L'
    });
    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'MM/DD/YYYY hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    $('.my-colorpicker2').on('colorpickerChange', function(event) {
      $('.my-colorpicker2 .fa-square').css('color', event.color.toString());
    });

    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

  })
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
