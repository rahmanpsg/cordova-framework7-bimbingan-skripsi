    <?php
    $this->load->view('admin/header');
    ?>
    <div id="isi">
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-6 col-8 align-self-center">
                        <h3 class="text-themecolor m-b-0 m-t-0">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <!-- Row -->
                <div class="row">
                    <!-- Column -->
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-block">
                                <h1 class="font-light m-b-0"><i class="fa fa-user text-info"></i></h1>
                                <div class="text-right">
                                    <h4 class="card-title">Total Dosen</h4>
                                    <h3 class="font-light m-b-0"><?= $totalDosen ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-block">
                                <h1 class="font-light m-b-0"><i class="fa fa-users text-success"></i></h1>
                                <div class="text-right">
                                    <h4 class="card-title">Total Mahasiswa</h4>
                                    <h3 class="font-light m-b-0"><?= $totalMhs ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-block">
                                <h4 class="card-title text-center">Selamat Datang di Aplikasi Bimbingan Skripsi Online Teknik Informatika Fakultas Teknik Universitas Muhammadiyah Parepare</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Row -->


                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>

    </div>

    <?php
    $this->load->view('admin/footer');
    ?>

    <script>
        $(document).ready(function() {
            $('#formDokumen').bootstrapValidator({
                message: 'This value is not valid',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'fa fa-exclamation-circle',
                    validating: 'glyphicon glyphicon-refresh'
                },
                excluded: ':disabled'
            })
        })
        $('#formDokumen').submit(function() {
            return false;
        });
    </script>

    <script>
        function setModalTambah() {
            $('#formDokumen').bootstrapValidator('resetForm', true);
            $('#formDokumen').trigger("reset");

            $('#modalDokumen').modal();
            $('#myModalLabel').html("Form Tambah Dokumen");

            $('#submitBtn').html('<span class="icon text-white"><i class="fa fa-save"></i></span><span class="text"> Simpan</span>');
        }

        function tambah_mk() {
            $('#formDokumen').submit();
            var data = $('#formDokumen').serializeArray();

            data = jQuery.grep(data, function(value) {
                return value['name'] != 'id';
            });

            var hasErr = $('#formDokumen').find(".has-error").length;

            if (hasErr == 0) {
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>" + "admin/manajemen",
                    dataType: 'JSON',
                    data: {
                        manajemen: 'tambah',
                        form: 'dokumen',
                        data: data
                    },
                    success: function(res) {
                        if (res) {
                            Swal.fire(
                                'Berhasil!',
                                'Dokumen berhasil ditambahkan',
                                'success'
                            )
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        }
                    }
                });
            }
        }

        function update_mk() {
            $('#formDokumen').submit();
            var data = $('#formDokumen').serializeArray();
            var id = $('input[id=id]').val();

            var hasErr = $('#formDokumen').find(".has-error").length;

            if (hasErr == 0) {
                jQuery.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>" + "admin/manajemen",
                    dataType: 'JSON',
                    data: {
                        manajemen: 'update',
                        form: 'dokumen',
                        id: id,
                        data: data
                    },
                    success: function(res) {
                        if (res) {
                            Swal.fire(
                                'Berhasil!',
                                'Dokumen berhasil diubah',
                                'success'
                            )
                            setTimeout(function() {
                                location.reload();
                            }, 500);
                        }
                    }
                });
            }
        }

        $("#submitBtn").click(function() {
            var ButtonText = $.trim($(this).text());
            if (ButtonText == "Simpan") {
                tambah_mk();
            } else
            if (ButtonText == "Update") {
                update_mk();
            }
        })
    </script>

    <script>
        function setTF_IDF(btn) {
            jQuery.ajax({
                type: "POST",
                url: "<?php echo base_url() ?>" + "tf_idf/proses_TF_IDF",
                dataType: 'HTML',
                cache: false,
                beforeSend: function() {
                    $(btn).attr('disabled', true)
                        .html('<span class="icon text-white"><i class="fa fa-spin fa-refresh" role="status"aria-hidden="true"></i></span><span class="text"> Memproses...</span>');
                },
                success: function(res) {
                    Swal.fire(
                        'Berhasil!',
                        'Dokumen berhasil diproses',
                        'success'
                    )

                    $('#isi').html(res);
                }
            })
        }
    </script>

    <script>
        function indexFormatter(val, row, index) {
            return index + 1;
        }

        function aksiFormatter(val) {
            return ["<button data-toggle='tooltip' title='Ubah' class='ubah btn btn-info btn-sm'>",
                "<i class='fa fa-pencil'></i>",
                "</button>",
                "<button data-toggle='tooltip' title='Hapus' class='hapus btn btn-danger btn-sm'>",
                "<i class='fa fa-trash'></i>",
                "</button>"
            ].join(' ');
        }

        window.aksiEvents = {
            'click .ubah': function(e, value, row, index) {
                $('#formDokumen').bootstrapValidator('resetForm', true);
                $('#formDokumen').trigger("reset");

                $('#modalDokumen').modal();
                $('#myModalLabel').html("Form Ubah Dokumen");

                $('input[id=id]').val(row.id);
                $('textarea[name=judul]').val(row.judul);
                $('textarea[name=dokumen]').val(row.dokumen);
                $('textarea[name=penjelasan]').val(row.penjelasan);

                $('#submitBtn').html('<span class="icon text-white"><i class="fa fa-edit"></i></span><span class="text"> Update</span>');
            },
            'click .hapus': function(e, value, row, index) {
                swal.fire({
                    title: "Warning",
                    text: "Anda yakin untuk menghapus Dokumen ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    showCloseButton: false,
                    cancelButtonColor: '#001473',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal'
                }).then(function(res) {
                    if (res.value) {
                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo base_url() ?>" + "admin/manajemen",
                            dataType: "JSON",
                            data: {
                                manajemen: "hapus",
                                form: 'dokumen',
                                id: row.id
                            },
                            success: function(res) {
                                if (res === true) {
                                    Swal.fire(
                                        'Berhasil!',
                                        'Dokumen berhasil dihapus',
                                        'success'
                                    )
                                    setTimeout(function() {
                                        location.reload();
                                    }, 500);
                                }
                            }
                        });
                    }
                });
            }
        }
    </script>
    </body>

    </html>