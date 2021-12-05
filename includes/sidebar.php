<div class="sidebar">
        <div class="user-profile">
         
          <div class="info-wrapper">
            <p class="user-name">NAME</p>
            <h6 class="display-income"><?php   echo $_SESSION['name'];?></h6>
          </div>
        </div>
        <ul class="navigation-menu">
          <li class="nav-category-divider">MAIN</li>
          <li>
            <a href="dashboard.php">
              <span class="link-title">Dashboard</span>
              <i class="mdi mdi-gauge link-icon"></i>
            </a>
          </li>
         
          <li>
            <a href="users.php">
              <span class="link-title">Users</span>
              <i class=" mdi mdi-bullseye link-icon"></i>
            </a>
          </li>
          <li>
            <a href="task.php">
              <span class="link-title">Tasks</span>
              <i class="mdi mdi-clipboard-outline link-icon"></i>
            </a>
          </li>
         
          <li>
            <a href="logout.php">
              <span class="link-title">Logout</span>
              <i class="mdi mdi-flower-tulip-outline link-icon"></i>
            </a>
          </li>
         
         
        </ul>
        
      </div>