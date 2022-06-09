<?php

session_start();
if(!isset($_SESSION['loggedin']) || (trim($_SESSION['username']) == '')) {
  header("location: login.php");
  exit();
}

include_once "../config/Database.php";
include_once "../model/Employee.php";
$database=new Database;
$connect=$database->connect();

$employee=new Employee($connect);
//get employee
if(isset($_GET['id']))
{
  $id=$_GET['id'];
  $employee_data=$employee->getEmployee($id);
}
//update employee




?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Finance| Dashboard</title>

   <!-- Google Font: Source Sans Pro -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="../assets/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
  </div> -->
         <!-- /.navbar -->
        <?php include 'parts/navbar.php';?>
        <!-- /.endnavbar -->

 
         <!-- /.sidemenu -->
        
        <?php include 'parts/sidemenu.php';?>
    
         <!-- /.endsidemenu -->

     
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Employee</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employee <?php $val=(isset($id)) ? 'Update' : 'Add'; echo $val; ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"> <small> <?php $val=(isset($id)) ? 'Update' : 'Add'; echo $val; ?> Employee</small></h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?php 
              if(isset($id))
              {
                ?>
              <form id="quickForm" action="../routes/updateemployee.php" method="post">
                <input type="hidden" name="empid" value=<?php echo $id?>/>
                <?php
              }
              else{
                ?>
                <form id="quickForm" action="../routes/addemployee.php" method="post">
                <?php
              }
              
              ?>
              
                <div class="card-body">
                <div class="form-group">
                    <label for="exampleInputName">Employee Name</label>
                    <input type="text" name="name" class="form-control" id="exampleInputName" placeholder="Enter Employee Name" value="<?php if(isset($_SESSION['oldname']))
                          {
                              echo $_SESSION['oldname'];
                              unset($_SESSION['oldname']);
                          }

                         $value = (isset($employee_data['name']) ?  $employee_data['name'] : '');
                         echo $value;
                        ?>">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" name="email"  
                    <?php if(isset($_SESSION['emailerror'])) 
                       {
                       ?>
                          class="form-control is-invalid"
                       <?php
                        }
                        else{
                          ?>
                          class="form-control"
                          <?php
                        }
                     ?>
                    id="exampleInputEmail1" placeholder="Enter email"  value="<?php if(isset($_SESSION['oldemail']))
                          {
                              echo $_SESSION['oldemail'];
                              unset($_SESSION['oldemail']);
                          }
                          $value = (isset($employee_data['email']) ?  $employee_data['email'] : '');
                          echo $value;
                        ?>">
                   
                    <small class="text-danger mt-5"> <?php if(isset($_SESSION['emailerror']))
                          {
                              echo $_SESSION['emailerror'];
                              unset($_SESSION['emailerror']);
                          }
                        ?>
                  </small>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPhone">Email Phonenumber</label>
                    <input type="number" name="phonenumber" class="form-control" id="exampleInputPhone" placeholder="Enter PhoneNumber"
                    value="<?php if(isset($_SESSION['oldphone']))
                          {
                              echo $_SESSION['oldphone'];
                              unset($_SESSION['oldphone']);
                          }
                          $value = (isset($employee_data) ?  $employee_data['phonenumber'] : '');
                         echo $value;
                        ?>"
                        
                        >
                  </div>
                  <div class="form-group">
                    <label for="exampleInputDob">Employee DOB</label>
                    <input type="date" name="dob" class="form-control" id="exampleInputDob" placeholder="Enter Date"  value="<?php if(isset($_SESSION['olddob']))
                          {
                              echo $_SESSION['olddob'];
                              unset($_SESSION['olddob']);
                          }
                          $value = (isset($employee_data) ?  $employee_data['dob'] : '');
                         echo $value;
                        ?>"
                        >
                  </div>
                  <div class="form-group">
                    <label for="exampleInputGander">Employee Gender</label>
                    <select class="form-control" name="gender" id="exampleInputGander">
                      <option value="male" <?php if (isset($employee_data['gender']) == "male") echo "selected"; ?>>Male</option>
                      <option value="female" <?php if (isset($employee_data['gender']) == "female") echo "selected"; ?>>Female</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputaddress">Employee Address</label>
                   <textarea placeholder="Address..." class="form-control" name="address"  
                   value="<?php if(isset($_SESSION['oldaddress']))
                          {
                              echo $_SESSION['oldaddress'];
                              unset($_SESSION['oldaddress']);
                          }
                          $value = (isset($employee_data['address']) ?  $employee_data['address'] : '');
                        
                        ?>"><?php  echo $value;?></textarea>
                  </div>
                 
                
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary float-right"><?php $val=(isset($id)) ? 'Update' : 'Submit'; echo $val; ?></button>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

   <!--end Content Wrapper. Contains page content -->
    <?php include 'parts/footer.php'?>
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="../assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jquery-validation -->
<script src="../assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../assets/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->

<!-- Page specific script -->
<script>
$(function () {
  $.validator.setDefaults({
    submitHandler: function (form) {
      this.submit();
    }
  });
  $('#quickForm').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      phonenumber: {
        required: true,
       
      },
      gender: {
        required: true,
       
      },
     
    },
    messages: {
      email: {
        required: "Please enter a email address",
        email: "Please enter a valid email address"
      },
      phonenumber: {
        required: "Please provide a Phonenumber",
      },
      gender: {
        required: "Please Select Gender",
      },
      
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
});
</script>
</body>
</html>
