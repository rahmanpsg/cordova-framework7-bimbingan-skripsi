<?php
$this->load->view('admin/header');
?>
<div id="isi">
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="text-themecolor m-b-0 m-t-0">Data Mahasiswa</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master Data</a></li>
                        <li class="breadcrumb-item active">Data Mahasiswa</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Tabel Data Mahasiswa</h4>
                            <div class="table-responsive m-t-40">
                                <div class="col text-right">
                                    <button class="btn btn-info" onclick="setModalTambah()">
                                        <div>
                                            <i class="fa fa-plus"></i>
                                            <span>Tambah Data</span>
                                        </div>
                                    </button>
                                </div>

                                <table class="table" id="table" data-toggle="table" data-url="<?php echo $URL_TBL ?>" data-pagination="true" data-search="true" data-unique-id="nim">
                                    <thead class="bg-info text-white text-center">
                                        <tr>
                                            <th data-field="no" data-formatter='indexFormatter'>#</th>
                                            <th data-field="nim" class="text-center">Nim</th>
                                            <th data-field="nama">Nama</th>
                                            <th data-field="angkatan" class="text-center">Angkatan</th>
                                            <th data-field="judul">Judul</th>
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
                                <input type="hidden" id="defaultNIM">
                                <div class="form-group row">
                                    <label for="nim" class="col-sm-3 col-form-label">NIM</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nim" name="nim" placeholder="NIM" data-bv-notempty="true" data-bv-notempty-message="NIM tidak boleh kosong">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" data-bv-notempty="true" data-bv-notempty-message="Nama tidak boleh kosong">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="angkatan" class="col-sm-3 col-form-label">Angkatan</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" id="angkatan" name="angkatan" placeholder="Angkatan" data-bv-notempty="true" data-bv-notempty-message="Angkatan tidak boleh kosong">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="judul" class="col-sm-3 col-form-label">Judul</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control" id="judul" name="judul" placeholder="Judul" data-bv-notempty="true" data-bv-notempty-message="Judul tidak boleh kosong"></textarea>
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
    formProses = new formProses('<?php echo base_url('admin/manajemen') ?>', 'Mahasiswa');
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
                nim: {
                    message: 'NIM telah digunakan',
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

    $('input[name=nim]').on('focusout', (evt) => {
        const value = evt.target.value;
        var send = [{
            'name': 'nim'
        }, {
            'value': value
        }]

        if (value !== $('input[id=defaultNIM]').val()) {
            formProses.cekData("<?php echo base_url() ?>" + "api/cekData", 'mahasiswa', send)
                .then((res) => {
                    if (res) {
                        myForm
                            .bootstrapValidator('updateStatus', 'nim', 'INVALID', 'callback')
                            .bootstrapValidator('validateField', 'nim');
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
        $('#myModalLabel').html("Form Tambah Mahasiswa");

        $('#submitBtn').html('<div><i class = "fa fa-save"></i><span> Simpan</span></div>');
    }

    $('#submitBtn').on('click', (e) => {
        myForm.data('bootstrapValidator').validate();

        var data = myForm.serializeArray();

        var hasErr = myForm.find(".has-error").length;

        if (hasErr == 0) {
            var ButtonText = $('#submitBtn').text();

            if (ButtonText == " Simpan") {
                const res = formProses.tambah(data);
                if (res[0] == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Mahasiswa berhasil ditambahkan',
                        timer: 1500
                    })
                    myModal.modal('toggle');

                    myTabel.bootstrapTable('append', res[1]);
                }
            } else
            if (ButtonText == " Update") {
                const nim = $('input[id=defaultNIM]').val();
                const res = formProses.update(data, {
                    'nim': nim
                });
                if (res[0] == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Mahasiswa berhasil diubah',
                        timer: 1500
                    })
                    myModal.modal('toggle');

                    myTabel.bootstrapTable('updateByUniqueId', {
                        id: nim,
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
            $('#myModalLabel').html("Form Ubah Mahasiswa");

            $('#defaultNIM').val(row.nim)
            $('#nim').val(row.nim)
            $('#nama').val(row.nama)
            $('#angkatan').val(row.angkatan)
            $('#judul').val(row.judul)
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
                        nim: row.nim
                    });

                    if (res == true) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data Mahasiswa berhasil dihapus',
                            timer: 1500
                        })
                        myTabel.bootstrapTable('remove', {
                            field: 'nim',
                            values: row.nim
                        });
                    }
                }
            })
        }
    }
</script>

</body>

</html>