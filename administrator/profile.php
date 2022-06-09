<?php

session_start();
if(!isset($_SESSION['loggedin']) || (trim($_SESSION['username']) == '')) {
        header("location: login.php");
        exit();
    }

include_once "../config/Database.php";
include_once "../model/User.php";
$database=new Database;
$connect=$database->connect();

$user=new User($connect);
//get all user
$user=$user->getUser($_SESSION['userid']);


//delete employee

if(isset($_GET['delete']))
{
  $empid=$_GET['delete'];

  

  $employee->deleteemployee($empid);
  
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Finance| Profile</title>

   <!-- Google Font: Source Sans Pro -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="../assets/plugins/toastr/toastr.min.css">
 
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
 
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
<?php 
    if(isset($_SESSION['success']))
    {
      $session_value=$_SESSION['success'];
      unset($_SESSION['success']);
    }
    ?>
    <script>
    var message='<?php echo $session_value;?>';
    </script>
 
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
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="../assets/dist/img/user4-128x128.jpg"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?php echo strtoupper($_SESSION['username'])?></h3>

                <p class="text-muted text-center">Admin</p>

                <ul class="list-group list-group-unbordered mb-3">
                <li class="list-group-item">
                    <b>Username</b> <a class="float-right">@<?php echo $user['name']?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Email</b> <a class="float-right"><?php echo $user['email']?></a>
                  </li>
                  <li class="list-group-item">
                    <b>Phonenumber</b> <a class="float-right"><?php echo $user['phonenumber']?></a>
                  </li>
                  
                </ul>

               
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills" id="myTab">
                 
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Profile Information</a></li>
                  <li class="nav-item"><a class="nav-link" href="#changepassword" data-toggle="tab">Change Password</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  
                  <!-- /.tab-pane -->

                  <div class="active tab-pane" id="settings">
                    <form class="form-horizontal" id="profile" method="post" action="../routes/profileupdate.php">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName" placeholder="Name" name="name" value="<?php echo $user['name']?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                          <input type="email" class="form-control" id="inputEmail" placeholder="Email" name="email" value="<?php echo $user['email']?>">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName2" class="col-sm-2 col-form-label">Ponenumber</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="inputName2" placeholder="Name" name="phonenumber" value="<?php echo $user['phonenumber']?>">
                        </div>
                      </div>
                     
                     
                    
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane" id="changepassword">
                    <form class="form-horizontal" id="changepasswordform" method="post" action="../routes/changepassword.php">
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">Old Password</label>
                        <div class="col-sm-10">
                          <input type="text" <?php if(isset($_SESSION['oldpassworderror'])) 
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
                     ?> id="inputName" placeholder="Name" name="oldpassword">
                      <small class="text-danger mt-5"> <?php if(isset($_SESSION['oldpassworderror']))
                          {
                              echo $_SESSION['oldpassworderror'];
                              unset($_SESSION['oldpassworderror']);
                          }
                        ?>
                        </small>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputName" class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="inputName" placeholder="Name" name="newpassword">
                        </div>
                      </div>
                     
                     
                    
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" class="btn btn-danger" onclick="changepassword()">Change Password</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
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
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>

<!-- jquery-validation -->
<script src="../assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="../assets/plugins/jquery-validation/additional-methods.min.js"></script>
<script src="../assets/plugins/toastr/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script>
$(document).ready(function(){
    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#myTab a[href="' + activeTab + '"]').tab('show');
    }
});
</script>
<script>
$(function () {
  $.validator.setDefaults({
    submitHandler: function (form) {
      this.submit();
    }
  });
  $('#profile').validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      phonenumber: {
        required: true,
       
      },
      name: {
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
      name: {
        required: "Please Enter Name",
      },
      
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.col-sm-10').append(error);
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
<script>
function changepassword() {
  $.validator.setDefaults({
    submitHandler: function (form) {
     this.submit();
    }
  });
  $('#changepasswordform').validate({
    rules: {
      oldpassword: {
        required: true,
        
      },
      newpassword: {
        required: true,
       
      },
     
     
    },
    messages: {
      oldpassword: {
        required: "Please enter a oldpassword",
        
      },
      newpassword: {
        required: "Please Enter newpassword",
      },
     
      
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.col-sm-10').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    }
  });
};
</script>
<script>
if(message !='')
{
  toastr.success(message);
}

</script>
</body>
</html>
