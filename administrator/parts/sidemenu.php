<?php
$url= $_SERVER['REQUEST_URI'];
$lastname = substr($url, strrpos($url, '/') + 1);
$arr = explode('.',$lastname);



?> 
 
 <!-- Sidebar Menu -->
 <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              
        <li class="nav-item
            <?php if($arr[0]=="dashboard")
                {
                  ?>
                  menu-open
                  <?php
                }
            ?>
          ">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
               Dashboard
                
              </p>
            </a>
           
          </li>
          <li class="nav-item
          <?php if($arr[0]=="employeeadd" || $arr[0]=="employeelist")
                {
                  ?>
                  menu-open
                  <?php
                }
            ?>
          ">
          
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user-alt"></i>
              <p>
                Employee
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="employeelist.php" class="nav-link  
                  <?php if($arr[0]=="employeelist")
                  {
                    ?>
                    active
                    <?php
                  }
                ?>
                 ">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Employee</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="employeeadd.php" class="nav-link 
                <?php if($arr[0]=="employeeadd")
                  {
                    ?>
                    active
                    <?php
                  }
                ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Employee</p>
                </a>
              </li>
            </ul>
          </li>
         <li class="nav-header">MULTI LEVEL EXAMPLE</li>
        
        
        </ul>
      </nav>
      <!-- /.sidebar-menu -->