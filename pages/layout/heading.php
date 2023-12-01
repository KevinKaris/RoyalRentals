<?php include "server/connection.php" ?>
<?php
if(isset($_SESSION['username']) && !isset($_SESSION['lock']) && isset($_SESSION['user-group']) && $_SESSION['user-group'] == 2 && (time() - $_SESSION['login-time']) <= 28800){
  $user_id = $_SESSION["user_id"];

  $_SESSION['url'] = $_SERVER['REQUEST_URI'];

  $query = "SELECT * FROM users WHERE id = ?";
  $st = $con -> prepare($query);
  $st -> execute(["$user_id"]);
  $row_detail = $st ->fetch();

  $_SESSION["rental_id"] = $row_detail["rental_id"];
  ?>
  <div class="bar-loader">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
  </div>
  <nav
        class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row default-layout-navbar"
      >
        <div
          class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center"
        >
          <a class="navbar-brand brand-logo" href="dashboard"
            ><img src="images/logo.png" alt="logo"
          /></a>
          <a class="navbar-brand brand-logo-mini" href="dashboard"
            ><img src="images/logo_mini.png" alt="logo"
          /></a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-stretch">
          <button
            class="navbar-toggler navbar-toggler align-self-center"
            type="button"
            data-toggle="minimize"
          >
            <span class="fas fa-bars"></span>
          </button>
          <ul class="navbar-nav">
            <li class="nav-item nav-search d-none d-md-flex">
              <div class="nav-link">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="fas fa-search"></i>
                    </span>
                  </div>
                  <input
                    type="text"
                    class="form-control"
                    placeholder="Search"
                    aria-label="Search"
                  />
                </div>
              </div>
            </li>
          </ul>
          <ul class="navbar-nav navbar-nav-right">
            <!-- <li class="nav-item d-none d-lg-flex">
              <a class="nav-link" href="#">
                <span class="btn btn-primary">+ Create new</span>
              </a>
            </li> -->
            <li class="nav-item dropdown d-none d-lg-flex">
              <div class="nav-link">
                <span
                  class="dropdown-toggle btn btn-outline-dark btn-sm"
                  id="languageDropdown"
                  data-toggle="dropdown"
                  >English</span
                >
              </div>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link count-indicator dropdown-toggle"
                id="notificationDropdown"
                href="#"
                data-toggle="dropdown">
                <i class="fas fa-bell mx-0"></i>
                <span class="count"></span>
              </a>
              <div
                class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                aria-labelledby="notificationDropdown"
              >
                <a class="dropdown-item">
                  <p class="mb-0 font-weight-normal float-left">
                  </p>
                  <!-- <span class="badge badge-pill badge-warning float-right"
                    >View all</span
                  > -->
                </a>
                <div id="notification_content">
                </div>
              </div>
            </li>
            <li class="nav-item nav-profile dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                data-toggle="dropdown"
                id="profileDropdown"
              >
              <?php
              if($row_detail['photo'] !== null){
              ?>
                <img src="<?php echo 'images/profile-photos/'.$row_detail['photo']?>" alt="profile" />
                <?php
              }
              else{
                ?>
                <img src="images/profile-photos/default-profile-pic.jpg" alt="profile" />
                <?php
              }
                ?>
              </a>
              <div
                class="dropdown-menu dropdown-menu-right navbar-dropdown"
                aria-labelledby="profileDropdown"
              >
                <a href="profile" class="dropdown-item">
                  <i class="fa fa-user text-primary"></i>
                  Profile
                </a>
                <a href="lock" class="dropdown-item">
                  <i class="fa fa-lock text-primary"></i>
                  Lock
                </a>
                <div class="dropdown-divider"></div>
                <a href="././server/auth/logout.php" class="dropdown-item logout">
                  <i class="fas fa-power-off text-primary"></i>
                  Logout
                </a>
              </div>
            </li>
            <li class="nav-item nav-settings d-none d-lg-block">
              <a class="nav-link" href="#">
                <i class="fas fa-ellipsis-h"></i>
              </a>
            </li>
          </ul>
          <button
            class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
            type="button"
            data-toggle="offcanvas"
          >
            <span class="fas fa-bars"></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_settings-panel.html -->
        <div class="theme-setting-wrapper">
          <div id="settings-trigger"><i class="fas fa-fill-drip"></i></div>
          <div id="theme-settings" class="settings-panel">
            <i class="settings-close fa fa-times"></i>
            <p class="settings-heading">SIDEBAR SKINS</p>
            <div class="sidebar-bg-options selected" id="sidebar-light-theme">
              <div class="img-ss rounded-circle bg-light border mr-3"></div>
              Light
            </div>
            <div class="sidebar-bg-options" id="sidebar-dark-theme">
              <div class="img-ss rounded-circle bg-dark border mr-3"></div>
              Dark
            </div>
            <p class="settings-heading mt-2">HEADER SKINS</p>
            <div class="color-tiles mx-0 px-4">
              <div class="tiles primary"></div>
              <div class="tiles success"></div>
              <div class="tiles warning"></div>
              <div class="tiles danger"></div>
              <div class="tiles info"></div>
              <div class="tiles dark"></div>
              <div class="tiles default"></div>
            </div>
          </div>
        </div>
        <div id="right-sidebar" class="settings-panel">
          <i class="settings-close fa fa-times"></i>
          <ul class="nav nav-tabs" id="setting-panel" role="tablist">
            <li class="nav-item">
              <a
                class="nav-link active"
                id="todo-tab"
                data-toggle="tab"
                href="#todo-section"
                role="tab"
                aria-controls="todo-section"
                aria-expanded="true"
                >TO DO LIST</a
              >
            </li>
          </ul>
          <div class="tab-content" id="setting-content">
            <div
              class="tab-pane fade show active scroll-wrapper"
              id="todo-section"
              role="tabpanel"
              aria-labelledby="todo-section"
            >
              <div class="add-items d-flex px-3 mb-0">
                <form class="form w-100">
                  <div class="form-group d-flex">
                    <input
                      type="text"
                      class="form-control todo-list-input"
                      placeholder="Add To-do"
                    />
                    <button
                      type="submit"
                      class="add btn btn-primary todo-list-add-btn"
                      id="add-task-todo"
                    >
                      Add
                    </button>
                  </div>
                </form>
              </div>
              <div class="list-wrapper px-3">
                <ul class="d-flex flex-column-reverse todo-list">
                  <?php
                    $user_id = $_SESSION["user_id"];

                    $SELECT = "SELECT * FROM todo WHERE user_id = ?";
                    $statement = $con -> prepare($SELECT);
                    $statement -> execute([$user_id]);
                    $fetch = $statement -> fetchAll();

                    foreach($fetch as $fetch){
                        if($fetch['completed'] == null){
                    ?>
                        <li>
                            <div class="form-check">
                            <label class="form-check-label">
                                <input class="checkbox" type="checkbox" value="<?php echo $fetch['id']?>" /><?php echo $fetch['text']?><i class='input-helper'></i>
                            </label>
                            </div>
                            <i class="remove fa fa-times-circle delete-todo"><input type="hidden" value="<?php echo $fetch['id']?>"></i>
                        </li>
                        <?php
                        }
                        else{
                        ?>
                        <li class="completed">
                            <div class="form-check">
                            <label class="form-check-label">
                                <input class="checkbox" type="checkbox" checked /><?php echo $fetch['text']?><i class='input-helper'></i>
                            </label>
                            </div>
                            <i class="remove fa fa-times-circle delete-todo"><input type="hidden" value="<?php echo $fetch['id']?>"></i>
                        </li>
                    <?php
                        }
                    }
                    ?>
                </ul>
              </div>
            </div>
            <!-- To do section tab ends -->
            <div
              class="tab-pane fade"
              id="chats-section"
              role="tabpanel"
              aria-labelledby="chats-section"
            >
              <div
                class="d-flex align-items-center justify-content-between border-bottom"
              >
                <p
                  class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0"
                >
                  Friends
                </p>
                <small
                  class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 font-weight-normal"
                  >See All</small
                >
              </div>
            </div>
            <!-- chat tab ends -->
          </div>
        </div>
        <!-- partial -->
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <div class="nav-link">
                <div class="profile-image">
                <?php
              if($row_detail['photo'] !== null){
              ?>
                <img src="<?php echo 'images/profile-photos/'.$row_detail['photo']?>" alt="image" />
                <?php
              }
              else{
                ?>
                <img src="images/profile-photos/default-profile-pic.jpg" alt="image" />
                <?php
              }
                ?>
                </div>
                <div class="profile-name">
                  <p class="name">Welcome&nbsp;<?php echo $_SESSION["username"]; ?></p>
                  <?php
                  $st = $con -> prepare("SELECT name FROM rentals WHERE id = ?");
                  $st -> execute([$_SESSION["rental_id"]]);
                  $fetch = $st -> fetch();
                  ?>
                  <p class="designation"><?php echo $fetch['name'] ?></p>
                </div>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="dashboard">
                <i class="fa fa-home menu-icon"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a
                class="nav-link"
                data-toggle="collapse"
                href="#tenants"
                aria-expanded="false"
                aria-controls="page-layouts"
              >
                <i class="fa fa-users menu-icon"></i>
                <span class="menu-title">Tenants</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="tenants">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item d-lg-block">
                    <a class="nav-link" href="all-tenants">All tenants</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="with-balance">Tenants with balances</a>
                  </li>
                  <li class="nav-item d-lg-block">
                    <a class="nav-link" href="without-balance">Tenants without balances</a>
                  </li>
                  <li class="nav-item d-lg-block">
                    <a class="nav-link" href="fined">Fined tenants</a>
                  </li>
                  <li class="nav-item d-lg-block">
                    <a class="nav-link" href="recent">Recent tenants</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="houses">
                <i class="far fa-building menu-icon"></i>
                <span class="menu-title">Houses</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="payment">
                <i class="fas fa-dollar-sign menu-icon"></i>
                <span class="menu-title">Rent Payment</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="expenses">
                <i class="fas fa-file-invoice-dollar menu-icon"></i>
                <span class="menu-title">Expenses</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="email">
                <i class="far fa-envelope menu-icon"></i>
                <span class="menu-title">Email Services</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="javascript:void()"><!--SMS link inactive for now-->
                <i class="far fa-comment menu-icon"></i>
                <span class="menu-title">SMS Services</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="inquiry">
                <i class="fa fa-info-circle menu-icon"></i>
                <span class="menu-title">Inquiry</span>
              </a>
            </li>
            <li class="nav-item d-lg-block">
              <a
                class="nav-link"
                data-toggle="collapse"
                href="#receipt"
                aria-expanded="false"
                aria-controls="page-layouts"
              >
                <i class="fas fa-receipt menu-icon"></i>
                <span class="menu-title">Receipts</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="receipt">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" href="individual-receipt">Individual tenant receipt</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="all-receipts">All tenants receipts</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item d-none d-lg-block">
              <a
                class="nav-link"
                data-toggle="collapse"
                href="#sidebar-layouts"
                aria-expanded="false"
                aria-controls="sidebar-layouts"
              >
                <i class="fas fa-columns menu-icon"></i>
                <span class="menu-title">Sidebar Layouts</span>
                <i class="menu-arrow"></i>
              </a>
              <div class="collapse" id="sidebar-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item">
                    <a class="nav-link" id="sidebar-mini" href="#"
                      >Compact menu</a
                    >
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      href="pages/layout/sidebar-collapsed.html" id="sidebar-icon-only"
                      >Icon menu</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#" id="sidebar-hidden"
                      >Sidebar Hidden</a>
                  </li>
                  <li class="nav-item">
                    <a
                      class="nav-link"
                      href="#" id="sidebar-absolute"
                      >Sidebar Overlay</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#" id="sidebar-fixed"
                      >Sidebar Fixed</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="#" id="default"
                      >Default</a>
                  </li>
                </ul>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="documentation">
                <i class="far fa-file-alt menu-icon"></i>
                <span class="menu-title">Documentation</span>
              </a>
            </li>
          </ul>
        </nav>
<?php
}
elseif(isset($_SESSION['username']) && isset($_SESSION['lock']) && isset($_SESSION['user-group']) && $_SESSION['user-group'] == 2 && (time() - $_SESSION['login-time']) <= 28800){
  echo "<script>window.location.assign('lock')</script>";
}
else{
  echo "<script>window.location.assign('login')</script>";
}
?>

<script src="js/jquery_3.6.0.min.js"></script>
<script>
  $('.profile-image').css('cursor', 'pointer');
  $('.profile-image> img').on('click', function(){
    window.location.assign('profile');
  })

  //displaying loaders
  $(document).ready(function(){
    $('.bar-loader').fadeOut('slow');
  });

  //loading notifications
  $(document).ready(function(){
    $('.count').hide();
    $.ajax({
      type: "get",
      url: "server/notifications.php",
      dataType: 'html',
      success: function (response) {
        if($('#notification_content').html(response)){
          //count the number notifications
          let notification_count = $('#notification_content > .dropdown-item').length;
          if(notification_count > 0){
            $('.dropdown-menu .dropdown-item > p').text('You have '+notification_count+' new notifications');
            $('.count').text(notification_count);
            $('.count').show();
          }
          else{
            $('.dropdown-menu .dropdown-item > p').text('You have no notifications');
            $('.count').text('0');
          }
        }

        $('.dropdown-menu .dropdown-item').on('click', function(){
          var id = $(this).find('input[type=hidden]').val();
          $.ajax({
            type: "post",
            url: "server/notification-viewed.php",
            data: {id: id},
            dataType: "text",
            success: function (response) {
            }
          });
        });
      }
    });
  });
</script>