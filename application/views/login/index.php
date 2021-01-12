<!DOCTYPE html>
<html lang="en">

<head>
    <title>Sistem Pendeteksi Kemiripan Dokumen</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link href="<?php echo base_url('assets/img/logo/logo.png'); ?>" rel="icon">
    <!--===============================================================================================-->
    <link href="<?php echo base_url('assets/plugins/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css">
    <!--===============================================================================================-->
    <link href="<?php echo base_url('assets/font/font-awesome-4.7.0/css/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
    <!--===============================================================================================-->
    <link href="<?php echo base_url('assets/font/Linearicons-Free-v1.0.0/icon-font.min.css'); ?>" rel="stylesheet" type="text/css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/animate/animate.css'); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/css-hamburgers/hamburgers.min.css'); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/animsition/css/animsition.min.css'); ?>">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/util.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/main.css'); ?>">

    <link rel="stylesheet" href="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.css'); ?>">
    <!--===============================================================================================-->
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100 p-t-50 p-b-90 col-md-5">
                <form id="formLogin" class="login100-form validate-form flex-sb flex-w">
                    <span class="login100-form-title p-b-51">
                        Aplikasi Bimbingan Skripsi Online Teknik Informatika Fakultas Teknik UM-Parepare
                    </span>


                    <div class="wrap-input100 validate-input m-b-16" data-validate="Username tidak boleh kosong">
                        <input class="input100" type="text" name="username" placeholder="Username">
                        <span class="focus-input100"></span>
                    </div>


                    <div class="wrap-input100 validate-input m-b-16" data-validate="Password tidak boleh kosong">
                        <input class="input100" type="password" name="password" placeholder="Password">
                        <span class="focus-input100"></span>
                    </div>

                    <div class="container-login100-form-btn m-t-17">
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!--===============================================================================================-->
    <script src="<?php echo base_url('assets/plugins/jquery/jquery.min.js'); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url('assets/plugins/animsition/js/animsition.min.js'); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/popper.js'); ?>"></script>
    <script src="<?php echo base_url('assets/plugins/bootstrap/js/bootstrap.min (2).js'); ?>"></script>
    <!--===============================================================================================-->
    <script src="<?php echo base_url('assets/js/main.js'); ?>"></script>

    <script src="<?php echo base_url('assets/plugins/sweetalert2/sweetalert2.all.min.js'); ?>"></script>
    <!--===============================================================================================-->
    <script>
        $('#formLogin').submit(function(e) {
            e.preventDefault();

            var data = $('#formLogin').serializeArray();

            var hasErr = $(this).find(".alert-validate").length;

            if (hasErr == 0) {
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>" + "login/cekLogin",
                    dataType: 'JSON',
                    data: {
                        data: data
                    },
                    success: function(res) {
                        if (res) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Anda berhasil login',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout(function() {
                                window.location = "admin/"
                            }, 1200);
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Username atau password salah',
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    }
                });
            }
        })
    </script>

</body>

</html>