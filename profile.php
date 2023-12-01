<?php session_start() ?>
<!DOCTYPE html>
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>RoyalRentals</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/all.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css"  />
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/logo_mini.png" />
</head>

  <body>
    <style>
        .enlarge{
            z-index: 6 !important;
            width: 300px !important;
            height: 300px !important;
            border-radius: 2px !important;
            transform: translate(-65%, -35%) !important;
        }
        .profile-image{
            position: relative;
            cursor: pointer;
            z-index: 5;
            transition: .3s ease-in-out;
        }
        .profile-image2{
            z-index: 0;
            position: absolute;
            transform: translate(-100%);
            transition: .2s ease-in-out !important;
        }
        .clearfix input{
          border: none;
          width: 100%;
        }
        .image-upload input{
          visibility: hidden;
        }
        .image-uploader{
          position: absolute;
          top: 60px;
          transform: translateX(-60%);
          width: 35px;
          height: 35px;
          font-size: 18px;
          background: #fff;
          z-index: 5;
          box-shadow: 0 0 7px #d7d7d7c1;
        }
        .image-uploader:hover{
          box-shadow: 0 0 7px #d7d7d7c1;
        }
        .toggle {
            position : relative ;
            display : inline-block;
            width : 36px;
            height : 17px;
            background-color: #aab2bd;
            border-radius: 30px;
        }
               
        /* After slide changes */
        .toggle:after {
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            border-radius: 50%;
            background-color: #fff;
            top: 1px; 
            left: 1px;
            transition:  all 0.5s;
        }
               
        /* Checkbox checked effect */
        #change-password:checked + .toggle::after {
            left : 20px; 
        }
               
        /* Checkbox checked toggle label bg color */
        #change-password:checked + .toggle {
            background-color: #392c70;
        }
               
        /* Checkbox vanished */
        #change-password { 
            display : none;
        }
        #image {
            display: block;
            max-width: 100%;
        }
        .preview {
            overflow: hidden;
            width: 160px; 
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }
        .custom{
          width: 700px;
          height: 500px;
        }
        #password-error{
          display: none;
        }
        @media (max-width: 991px){
            .card-body input{
                width: 50%;
            }
            .clearfix input{
              width: 100%;
            }
            .custom{
              width: 750px;
              margin-left: -120px !important;
            }
        }
        @media (max-width: 575.98px){
            .card-body input{
                width: 100%;
            }
            .clearfix input{
              width: 100%;
            }
            .custom{
              width: 95%;
              height: 550px;
              margin-left: 10px !important;
            }
        }
    </style>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <?php include 'pages/layout/heading.php' ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">Profile</h3>
              <!-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="tel:">Tables</a></li>
                  <li class="breadcrumb-item active" aria-current="page">
                    Data table
                  </li>
                </ol>
              </nav> -->
            </div>
            <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                  <?php
                        $user = "SELECT * FROM users WHERE id = ? AND rental_id = ?";
                        $prepare = $con -> prepare($user);
                        $prepare -> execute([$_SESSION["user_id"], $_SESSION["rental_id"]]);
                        $fetch = $prepare -> fetch();

                        //fetching rental details
                        $rental = "SELECT * FROM rentals WHERE id = ?";
                        $prepare2 = $con -> prepare($rental);
                        $prepare2 -> execute([$_SESSION["rental_id"]]);
                        $fetch2 = $prepare2 -> fetch();
                        ?>
                    <div class="col-lg-4">
                      <div class="text-center pb-4">
                        <?php
                        if($fetch['photo'] != null){
                        ?>
                        <img src="<?php echo 'images/profile-photos/'.$fetch['photo']?>" alt="profile" class="img-lg rounded-circle mb-3 profile-image"/>
                        <img src="<?php echo 'images/profile-photos/'.$fetch['photo']?>" alt="profile" class="img-lg rounded-circle mb-3 profile-image2"/>
                        <?php
                        }
                        else{
                        ?>
                        <img src="images/profile-photos/default-profile-pic.jpg" alt="profile" class="img-lg rounded-circle mb-3 profile-image"/>
                        <img src="images/profile-photos/default-profile-pic.jpg" alt="profile" class="img-lg rounded-circle mb-3 profile-image2"/>
                        <?php }?>
                        <button class="rounded-circle border-0 image-uploader text-primary" id="upload-profile"><i class="fa fa-camera"></i></button>
                        <form class="image-upload" enctype="multipart/form-data">
                          <input type="file" name="image" accept=".jpg, .jpeg, .png, .webp" id="file">
                        </form>
                        <p><strong>Rental:&nbsp;</strong><?php echo $fetch2['name']?></p>
                        <p class="mt-3"><button class="btn btn-light btn-sm" id="remove-photo" value="<?php echo $fetch['id']?>">Remove Photo</button></p>
                      </div>
                    </div>
                    <div class="col-lg-8 pl-lg-5">
                      <div class="d-flex justify-content-between">
                        <div>
                          <h3><?php echo $fetch['f_name'].' '.$fetch['l_name']?></h3>
                        </div>
                      </div>
                      <div class="mt-4 py-2 border-bottom"></div>
                      <div class="profile-feed">
                        <div class="py-4">
                        <p class="clearfix">
                          <span class="float-left">
                            First Name
                          </span>
                          <span class="float-right text-muted">
                            <input type="text" class="text-muted" id="f-name" value="<?php echo $fetch['f_name']?>">
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Last Name
                          </span>
                          <span class="float-right text-muted">
                            <input type="text" class="text-muted" id="l-name" value="<?php echo $fetch['l_name']?>">
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Username
                          </span>
                          <span class="float-right text-muted">
                            <input type="text" class="text-muted" id="username" value="<?php echo $fetch['username']?>">
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Phone
                          </span>
                          <span class="float-right text-muted">
                            <input type="phone" class="text-muted" id="phone" value="<?php echo '0'.$fetch['phone']?>">
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Email
                          </span>
                          <span class="float-right text-muted">
                            <input type="email" class="text-muted" id="email" value="<?php echo $fetch['email']?>">
                          </span>
                        </p>
                        <p class="clearfix">
                          <span class="float-left">
                            Change Password
                          </span>
                          <span class="float-left mx-3">
                            <input type="checkbox" name="" id="change-password" class="form-control">
                            <label for="change-password" class="toggle"></label>
                          </span>
                          <span class="float-right text-muted mx-0">
                            <input type="password" class="text-muted" id="password" placeholder="Password">
                          </span>
                          <span id="password-error" class="text-danger"></span>
                        </p>
                        <button class="btn btn-primary mt-4 py-2" id="save" style="float: right;">Save</button>
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </div>
          <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content custom">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Crop image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">  
                                    <!--  default image where we will set the src via jquery-->
                                    <img id="image">
                                </div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="close-modal" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="crop">Crop</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <?php include 'pages/layout/footer.php' ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <script src="js/jquery_3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <!-- container-scroller -->
    <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="js/off-canvas.js"></script>
  <script src="js/hoverable-collapse.js"></script>
  <script src="js/misc.js"></script>
  <script src="js/settings.js"></script>
  <script src="js/todolist.js"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="js/dashboard.js"></script>
  <script src="js/alerts.js"></script>
  <!-- End custom js for this page-->
  </body>
  <script>
        $(document).ready(function(){
          //require atleast 8 digits in password input
          var password = $('#password').val();
          $('#password').on('input', function(){
            if(password.length < 8){
              $('#password-error').text('Atleast 8 characters required!');
              $('#password-error').show();
            }
            else{
              $('#password-error').text('');
              $('#password-error').hide();
            }
          })


          $(document).on('click', function(event){
            if($(event.target).is('.profile-image')){
                $('.profile-image2').addClass('enlarge');
            }
            else{
              $('.profile-image2').removeClass('enlarge');
            }
          })

          //uploading a profile image
          $('.image-uploader').on('click', function(){
            $('.image-upload input').click();
            $('.image-upload input').on('change', function(){
              //TODO - upload image
            })
          })
        })

        //disabling and enabling password input by default
        $('#password').prop('disabled', true);

        $('#change-password').on('change',function(){
          if($(this).is(':checked')){
              $('#password').prop('disabled', false);
            }
            else{
              $('#password').prop('disabled',true);
            }
        })

        //saving profile

        //d
        $('#save').on('click', function(){
          if($('#change-password').is(':checked')){
            //saving profile
            if($('#password').val() != ''){
                if(password.length > 7){
                  $.ajax({
                    type: "POST",
                    url: "server/save-profile.php",
                    data: {f_name: $('#f-name').val(), l_name: $('#l-name').val(), username: $('#username').val(), phone: $('#phone').val(), email: $('#email').val(), password: $('#password').val()},
                    success: function (response) {
                      if(response == '1'){
                        return showSwal('success-message');
                      }
                      else{
                        return showSwal('server-message-without-cancel');
                      }
                    },
                    error: function(){
                      return showSwal('server-message-without-cancel');
                    }
                  });
                }
                else{
                  $('#password-error').text('Atleast 8 characters required!');
                  $('#password-error').show();
                }
            }
            else{
              alert('Password cannot be empty!');
            }
          }
          else{
            if($('#f-name').val() != '' && $('#l-name').val() != '' && $('#username').val() != '' && $('#phone').val() != '' && $('#email').val() != ''){
              $.ajax({
                type: "POST",
                url: "server/save-profile.php",
                data: {f_name: $('#f-name').val(), l_name: $('#l-name').val(), username: $('#username').val(), phone: $('#phone').val(), email: $('#email').val()},
                success: function (response) {
                  if(response == '1'){
                    return showSwal('success-message');
                  }
                  else{
                    return showSwal('server-message-without-cancel');
                  }
                },
                error: function(){
                  return showSwal('server-message-without-cancel');
                }
              });
            }
            else{
              alert('Fill all fields!');
            }
          }
        })

        //uploading profile image
        // $('#file').on('change', function(){
        //   var formData = new FormData();
        //   var fileInput = $('#file')[0];
          
        //   // Check if a file is selected
        //   if (fileInput.files.length > 0) {
        //       formData.append('image', fileInput.files[0]);
        //       $.ajax({
        //           url: "server/save-profile.php",
        //           type: 'POST',
        //           data: formData,
        //           contentType: false,
        //           processData: false,
        //           success: function(response) {
        //             if(response !== ''){
        //               if($('.profile-image, .profile-image2').attr('src', 'images/profile-photos/'+response)){
        //                 return showSwal('success-message');
        //               }
        //             }
        //             else{
        //               return showSwal('server-message-without-cancel');
        //             }
        //           },
        //           error: function(){
        //             return showSwal('server-message-without-cancel');
        //           }
        //       });
        //   } else {
        //       alert('Please select an image file.');
        //   }
        // })

        $('#remove-photo').on('click', function(){
          var user_id = $(this).val();
          $.ajax({
            type: "post",
            url: "server/remove-photo.php",
            data: {user_id: user_id},
            dataType: "text",
            success: function (response) {
              if(response == '1'){
                $('.profile-image, .profile-image2').attr('src', 'images/profile-photos/default-profile-pic.jpg');
              }
            }
          });
        })




    var bs_modal = $('#modal');
    var image = $('#image')[0];
    var cropper,reader,file;
   

    $("body").on("change", "#file", function(e) {
        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            bs_modal.modal('show');
        };


        if (files && files.length > 0) {
            file = files[0];
            originalFileName = file.name;

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    bs_modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 180,
            height: 180,
        });

        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                var base64data = reader.result;
                $.ajax({
                  url: "server/save-profile.php",
                  type: 'POST',
                  data: {image: base64data, filename: originalFileName},
                  dataType: 'text',
                  success: function(response) {
                    if(response !== ''){
                      if($('.profile-image, .profile-image2').attr('src', 'images/profile-photos/'+response)){
                        if(bs_modal.modal('hide')){
                          return showSwal('success-message');
                        }
                      }
                    }
                    else{
                      return showSwal('server-message-without-cancel');
                    }
                  },
                  error: function(){
                    return showSwal('server-message-without-cancel');
                  }
              });
            };
        });
    });
    </script>
</html>
