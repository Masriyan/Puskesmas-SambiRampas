<!DOCTYPE html>
<html lang="en" >
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Administrasi POTA LogIn</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url();?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?php echo base_url();?>assets/vendors/animate.css/animate.min.css" rel="stylesheet">
    <!-- Sweetalert2.css -->
    <link href="<?php echo base_url();?>assets/sweetalert2/sweetalert2.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>assets/build/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login" >
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content" style="padding:0px;">
              <h1 style="font-size:20px;">Puskesmas POTA App's</h1>
              <div class="clearfix"></div>
              <div class="error"></div>
              <form name="fLogin" id="fLogin">
                <div class="form-group">
                  <input type="text" class="form-control" id="username" name="username" placeholder="Username" >
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <button type="button" onclick="cekLogin()" class="btn btn-success btn-block">LOG IN <i class="glyphicon glyphicon-log-in"></i></button>
              </form>
              <div class="clearfix"></div>

              <div class="separator">

                <div class="clearfix"></div>
                <br />

                <div>
                  <!-- <h1><i class="fa fa-paw"></i> <</s>Gentelella Alela!</h1> -->
                  <p>©2017 All Rights Reserved. Puskesmas POTA. Privacy and Terms</p>
                </div>
              </div>
          </section>
        </div>
      </div>
    </div>
    <!-- jQuery -->
    <script src="<?= base_url();?>assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= base_url();?>assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="<?= base_url();?>assets/vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="<?= base_url();?>assets/vendors/nprogress/nprogress.js"></script>
    <!-- validator -->
    <script src="<?= base_url();?>assets/vendors/validator/validator.js"></script>
    <!-- sweetalert -->
    <script src="<?= base_url();?>assets/sweetalert2/sweetalert2.min.js"></script>

    <!-- Custom Theme Scripts -->
    <script src="<?= base_url();?>assets/build/js/custom.min.js"></script>

    <script type="text/javascript">
      $(document).ready(function() {
        swal('Selamat Datang','Di Aplikasi Administrasi Puskesmas POTA','info');
        // resolve();
      });

      function cekLogin() {
        var data = $("#fLogin").serialize();
        if ($("input[name=username]").val() == "" || $("input[name=password]").val() == "") {
          $("input[name=username]").parent().fadeOut().removeClass('has-success');
          $("input[name=password]").parent().fadeOut().removeClass('has-success');
          $("input[name=username]").parent().fadeIn().addClass('has-error');
          $("input[name=password]").parent().fadeIn().addClass('has-error');
          $(".error").fadeOut().fadeIn().html("<div><strong>Error</strong> - Username/Password Tidak boleh kosong.</div>");
          $("input[name=username]").focus();
        }else {
          // console.log("data ada isinya.");
          $.ajax({
            url: '<?= base_url()."login/checkLogin"?>',
            type: 'POST',
            dataType: 'json',
            data: data
          })
          .done(function(res) {
            if (res != "") {
              // console.log("Login Berhasil");
              $.ajax({
                url: '<?= base_url()."login/setSess"?>',
                type: 'POST',
                dataType: 'json',
                data: res
              })
              .done(function(data) {
                // console.log(data);
                if(data.status){
                  document.location='<?= base_url()?>';
                }else {
                  document.location='<?= base_url()."login"?>';
                }
              });
            }else {
              swal({
                title: "Warning !",
                text: "username atau password Salah.",
                type: "warning",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Oke"
              });
              // alert("data gak ada");
            }
          });

        }
      }
    </script>

  </body>
</html>
