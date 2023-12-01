<footer class="footer">
            <div
              class="d-sm-flex justify-content-center justify-content-sm-between"
            >
              <span
                class="text-muted text-center text-sm-left d-block d-sm-inline-block"
                >Copyright © <?php echo date('Y')?>
                RoyalRentals</span
              >
              <span
                class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"
                >Made with
                <i class="far fa-heart text-danger"></i
              ></span>
            </div>
          </footer>
          <script>
            //themes
            var sidebarTheme = localStorage.getItem('sidebarTheme');
            var navtheme = localStorage.getItem('navTheme');
            theme(sidebarTheme, navtheme);

            function theme(sidetheme, navtheme){
              var navbar_classes = "navbar-danger navbar-success navbar-warning navbar-dark navbar-light navbar-primary navbar-info navbar-pink";
              var sidebar_classes = "sidebar-light sidebar-dark";
              var $body = $("body");

              $body.removeClass(sidebar_classes);
              $(".sidebar-bg-options").removeClass("selected");
              $(".navbar").removeClass(navbar_classes);
              
              $(".tiles").removeClass("selected");
              

              if(sidetheme === 'light'){
                $('#sidebar-light-theme').addClass("selected");
                $body.addClass("sidebar-light");
              }
              else if(sidetheme === 'dark'){
                $('#sidebar-dark-theme').addClass("selected");
                $body.addClass("sidebar-dark");
              }

              if(navtheme === 'primary'){
                $(".navbar").addClass("navbar-primary");
                $('.tiles.primary').addClass("selected");
              }
              else if(navtheme === 'success'){
                $(".navbar").addClass("navbar-success");
                $('.tiles.success').addClass("selected");
              }
              else if(navtheme === 'warning'){
                $(".navbar").addClass("navbar-warning");
                $('.tiles.warning').addClass("selected");
              }
              else if(navtheme === 'danger'){
                $(".navbar").addClass("navbar-danger");
                $('.tiles.danger').addClass("selected");
              }
              else if(navtheme === 'light'){
                $(".navbar").addClass("navbar-light");
                $('.tiles.light').addClass("selected");
              }
              else if(navtheme === 'info'){
                $(".navbar").addClass("navbar-info");
                $('.tiles.info').addClass("selected");
              }
              else if(navtheme === 'dark'){
                $(".navbar").addClass("navbar-dark");
                $('.tiles.dark').addClass("selected");
              }
              else if(navtheme === 'default'){
                $(".navbar").addClass("navbar-default");
                $('.tiles.default').addClass("selected");
              }
            }

            //toggling mini menu
            var miniMenu = localStorage.getItem('miniMenu');
            var sidebar_classes2 = "sidebar-hidden sidebar-absolute sidebar-icon-only sidebar-mini sidebar-fixed";
            $('body').removeClass(sidebar_classes2);
              if(miniMenu === 'normal'){
                $('body').removeClass(sidebar_classes2);
              }
              else if(miniMenu === 'sidebar-absolute'){
                $('body').addClass("sidebar-hidden");
                $('body').addClass(miniMenu);
              }
              else{
                $('body').addClass(miniMenu);
              }

              //other side menu settings
              $('#sidebar-layouts a').on('click', function(e){
                e.preventDefault();
                $('body').removeClass(sidebar_classes2);
                var id = $(this).attr('id');
                if(id == 'sidebar-absolute'){
                  $('body').removeClass(sidebar_classes2);
                  $('body').addClass(id);
                  $('body').addClass("sidebar-hidden");
                  localStorage.setItem("miniMenu", id);
                }
                else if(id == 'default'){
                  $('body').removeClass(sidebar_classes2);
                  localStorage.setItem("miniMenu", 'normal');
                }
                else{
                  $('body').removeClass(sidebar_classes2);
                  $('body').addClass(id);
                  localStorage.setItem("miniMenu", id);
                }

              })
          </script>