<?php
$this->load->view('admin/header');
?>
<div id="isi">
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="text-themecolor m-b-0 m-t-0">Data Dosen</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master Data</a></li>
                        <li class="breadcrumb-item active">Data Dosen</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Tabel Data Dosen</h4>
                            <div class="table-responsive m-t-40">
                                <div class="col text-right">
                                    <button class="btn btn-info" onclick="setModalTambah()">
                                        <div>
                                            <i class="fa fa-plus"></i>
                                            <span>Tambah Data</span>
                                        </div>
                                    </button>
                                </div>

                                <table class="table" id="table" data-toggle="table" data-url="<?php echo $URL_TBL ?>" data-pagination="true" data-search="true" data-unique-id="nbm">
                                    <thead class="bg-info text-white text-center">
                                        <tr>
                                            <th data-field="no" data-formatter='indexFormatter' class="text-center">#</th>
                                            <th data-field="nbm" class="text-center">NBM</th>
                                            <th data-field="nama">Nama</th>
                                            <th data-field="username">Username</th>
                                            <th data-field="aksi" data-formatter="aksiFormatter" data-events="window.aksiEvents" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Row -->

            <!-- Modal -->
            <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel">Form Tambah Data</h4>
                        </div>
                        <div class="modal-body">
                            <form id="myForm">
                                <input type="hidden" id="defaultNBM">
                                <input type="hidden" id="defaultUsername">
                                <div class="form-group row">
                                    <label for="nbm" class="col-sm-3 col-form-label">NBM</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nbm" name="nbm" placeholder="NBM" data-bv-notempty="true" data-bv-notempty-message="NBM tidak boleh kosong">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" data-bv-notempty="true" data-bv-notempty-message="Nama tidak boleh kosong">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="username" class="col-sm-3 col-form-label">Username</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" data-bv-notempty="true" data-bv-notempty-message="Username tidak boleh kosong">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" data-bv-notempty="true" data-bv-notempty-message="Password tidak boleh kosong">
                                    </div>
                                </div>
                                <div class="col text-right">
                                    <button id="submitBtn" type="submit" class="btn btn-primary">
                                        <div>
                                            <i class="fa fa-save"></i>
                                            <span>Simpan</span>
                                        </div>
                                    </button>
                                    <button class="btn btn-warning" data-dismiss="modal">
                                        <div>
                                            <i class="fa fa-window-close"></i>
                                            <span>Batal</span>
                                        </div>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->

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

<script type="text/javascript">
    formProses = new formProses('<?php echo base_url('admin/manajemen') ?>', 'Dosen');
    myForm = $('#myForm');
    myModal = $('#myModal');
    myTabel = $('#table');

    $(document).ready(function() {
        myForm.bootstrapValidator({
            message: 'This value is not valid',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'fa fa-exclamation-circle',
                validating: 'fa fa-spin fa-refresh'
            },
            excluded: ':disabled',
            fields: {
                nbm: {
                    message: 'NBM telah digunakan',
                    validators: {
                        callback: {
                            callback: function(value, validator, $fields) {
                                if (value == '') {
                                    return true;
                                }
                                return true;
                            }
                        }
                    }
                },
                username: {
                    message: 'Username telah digunakan',
                    validators: {
                        notEmpty: {
                            message: 'Username tidak boleh kosong'
                        },
                        stringLength: {
                            min: 5,
                            max: 30,
                            message: 'Username harus lebih dari 5 karakter'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_]+$/,
                            message: 'Username hanya dapat terdiri dari abjad, angka, dan garis bawah'
                        },
                        callback: {
                            callback: function(value, validator, $fields) {
                                if (value == '') {
                                    return true;
                                }
                                return true;
                            }
                        }
                    }
                },
                password: {
                    message: 'Password tidak sesuai',
                    validators: {
                        stringLength: {
                            min: 3,
                            max: 30,
                            message: 'Password harus lebih dari 3 karakter'
                        }
                    }
                }
            }
        })
    })

    $('input[name=nbm]').on('focusout', (evt) => {
        const value = evt.target.value;
        var send = [{
            'name': 'nbm'
        }, {
            'value': value
        }]

        if (value !== $('input[id=defaultNBM]').val()) {
            formProses.cekData("<?php echo base_url() ?>" + "api/cekData", 'dosen', send)
                .then((res) => {
                    if (res) {
                        myForm
                            .bootstrapValidator('updateStatus', 'nbm', 'INVALID', 'callback')
                            .bootstrapValidator('validateField', 'nbm');
                    }
                });
        }
    })

    $('input[name=username]').on('focusout', (evt) => {
        const value = evt.target.value;
        var send = [{
            'name': 'username'
        }, {
            'value': value
        }]

        if (value !== $('input[id=defaultUsername]').val()) {
            formProses.cekData("<?php echo base_url() ?>" + "api/cekData", 'dosen', send)
                .then((res) => {
                    if (res) {
                        myForm
                            .bootstrapValidator('updateStatus', 'username', 'INVALID', 'callback')
                            .bootstrapValidator('validateField', 'username');
                    }
                });
        }
    })

    myForm.submit((evt) => {
        evt.preventDefault();
    })

    function setModalTambah() {
        myForm.bootstrapValidator('resetForm', true);
        myForm.trigger("reset");

        myModal.modal();
        $('#myModalLabel').html("Form Tambah Dosen");

        $('#submitBtn').html('<div><i class = "fa fa-save"></i><span> Simpan</span></div>');
    }

    $('#submitBtn').on('click', (e) => {
        myForm.data('bootstrapValidator').validate();

        var data = $.grep(myForm.serializeArray(), (val) => {
            return val['name'] != 'id_jurusan'
        })
        var hasErr = myForm.find(".has-error").length;

        if (hasErr == 0) {
            var ButtonText = $('#submitBtn').text();

            if (ButtonText == " Simpan") {
                const res = formProses.tambah(data);
                if (res[0] == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Dosen berhasil ditambahkan',
                        timer: 1500
                    })
                    myModal.modal('toggle');

                    myTabel.bootstrapTable('append', res[1]);
                }
            } else
            if (ButtonText == " Update") {
                const nbm = $('input[id=defaultNBM]').val();
                const res = formProses.update(data, {
                    'nbm': nbm
                });
                if (res[0] == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Dosen berhasil diubah',
                        timer: 1500
                    })
                    myModal.modal('toggle');

                    myTabel.bootstrapTable('updateByUniqueId', {
                        id: nbm,
                        row: res[1]
                    });
                }
            }
        }
    })

    // ===================================== //

    function indexFormatter(val, row, index) {
        return index + 1;
    }

    function aksiFormatter(val) {
        return ["<button data-toggle='tooltip' title='Ubah' class='ubah btn btn-info btn-sm'>",
            "<i class='fa fa-edit'></i>",
            "</button>",
            "<button data-toggle='tooltip' title='Hapus' class='hapus btn btn-danger btn-sm'>",
            "<i class='fa fa-trash'></i>",
            "</button>"
        ].join(' ');
    }

    window.aksiEvents = {
        'click .ubah': function(e, value, row, index) {
            myForm.bootstrapValidator('resetForm', true);
            myForm.trigger("reset");

            myModal.modal();
            $('#myModalLabel').html("Form Ubah Dosen");

            $('#defaultNBM').val(row.nbm)
            $('#defaultUsername').val(row.username)
            $('#nbm').val(row.nbm)
            $('#nama').val(row.nama)
            $('#username').val(row.username)
            $('#password').val(row.password)

            $('#submitBtn').html('<div><i class = "fa fa-edit"></i><span> Update</span></div>');
        },
        'click .hapus': function(e, value, row, index) {
            Swal.fire({
                title: 'Perhatian!',
                text: "Anda yakin untuk menghapus data ini?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#f00a30',
                cancelButtonColor: '#0447b3',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    const res = formProses.hapus({
                        nbm: row.nbm
                    });

                    if (res == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data Dosen berhasil dihapus',
                            timer: 1500
                        })
                        myTabel.bootstrapTable('remove', {
                            field: 'nbm',
                            values: row.nbm
                        });
                    }
                }
            })
        }
    }
</script>

</body>

</html>