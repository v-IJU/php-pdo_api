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
//get all employess
$employee_data=$employee->readData();

if($employee_data->rowCount())

{
    $employess=[];
    while($row = $employee_data->fetch(PDO::FETCH_OBJ))
    {
        $employess[$row->id]=[
            'id'=>$row->id,
            'name'=>$row->name,
            'username'=>$row->username,
            'email'=>$row->email,
            'phonenumber'=>$row->phonenumber,
            'status'=>$row->status

        ];
    }
    
  }
//delete employee

if(isset($_GET['delete']))
{
  $empid=$_GET['delete'];

  

  $employee->deleteemployee($empid);
  header('location:employeelist.php');
}
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
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="../assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="../assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="../assets/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
 
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="../assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../assets/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="../assets/plugins/toastr/toastr.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="../assets/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="../assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="../assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
 
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
    <?php 
    if(isset($_SESSION['employeeadded']))
    {
      $session_value=$_SESSION['employeeadded'];
      unset($_SESSION['employeeadded']);
    }
    ?>
   
    
    <script>
    var message='<?php echo $session_value;?>';
    </script>
   

    </body>
    </html>
    <section class="content-header">
      <div class="container-fluid">
      
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Employee</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Employee List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sl.no</th>
                    <th>Name</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i=0;
                    if(isset($employess))
                    {
                    foreach($employess as $empid => $data)
                    {
                      $i++;
                      ?>

                    <tr>
                    <td><?php echo $i?></td>
                    <td><?php echo $data['name']?></td>
                    <td><?php echo $data['username']?>
                    </td>
                    <td><?php echo $data['email']?></td>
                    <td> <?php echo $data['phonenumber']?></td>
                    <td>
                    <input type="checkbox" class="toggle-class" <?php if ($data['status'] == 1) echo "checked"; ?> data-toggle="toggle" data-onstyle="success" data-size="sm" data-on="active" data-off="in active" id="<?php echo $data['id']?>" onchange="myFunction(this.id)">
                    </td>
                    <td><div class="btn-group btn-group-sm">
                       
                       <a href="employeeadd.php?id=<?php echo $data['id']?>" class="btn btn-primary" ><i class="fas fa-edit"></i></a>
                     
                     </div>
                     <div class="btn-group btn-group-sm" >
                       
                       <a href="employeelist.php?delete=<?php echo $data['id']?>" class="btn btn-danger" id="delete"><i class="fas fa-trash" ></i></a>
                     
                     </div></td>
                    </tr>


                    <?php
                    }
                  }
                    ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sl.no</th>
                    <th>Name</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
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
<!-- jQuery UI 1.11.4 -->
<script src="../assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 4 -->
<script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../assets/plugins/jszip/jszip.min.js"></script>
<script src="../assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../assets/plugins/toastr/toastr.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>

<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
'use strict';
  $(function(){


    $(document).on('click','#delete',function(e){
      e.preventDefault();
      var link=$(this).attr("href");
      console.log(link);
      Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href=link
    Swal.fire(
      'Deleted!',
      'Your file has been deleted.',
      'success'
    )
  }
})
    });
  });
</script>
<script>
$(function(){
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
});
</script>
<script>
  function myFunction(id){
    var status = $('.toggle-class').prop('checked') == true ? 1 : 0;
       var userid=id;


         $.ajax({
           type: "GET",
            dataType: "json",
            url: '../routes/statuschange.php',
            data: {'status': status, 'userid': userid},
            success: function(data){

              
                if ($.isEmptyObject(data.error)) {
                  console.log(data);
                   toastr.success(data.message);
                }else{

                    Toast1.fire({
                        type: 'error',
                        title: data.error
                    })
                }
            },
            error: function (data) {
                console.log(data.responseText);
                const Toast1 = Swal.mixin({
                      toast: true,
                      position: 'top-end',
                      icon: 'error',
                      showConfirmButton: false,
                      timer: 3000
                    })
                    Toast1.fire({
                        type: 'error',
                        title: data.responseText
                    })
            }

         });

}
  </script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": [ "csv", "excel", "pdf", "print",]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
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
<script>
if(message !='')
{
  toastr.success(message);
}

</script>
</body>
</html>
