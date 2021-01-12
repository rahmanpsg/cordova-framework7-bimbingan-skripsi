<?php
$this->load->view('admin/header');
?>
<div id="isi">
    <div class="page-wrapper">
        <div class="container-fluid">
            <div class="row page-titles">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="text-themecolor m-b-0 m-t-0">Data Pembimbing</h3>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">Master Data</a></li>
                        <li class="breadcrumb-item active">Data Pembimbing</li>
                    </ol>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">Tabel Data Pembimbing</h4>
                            <div class="table-responsive m-t-40">
                                <div class="col text-right">
                                    <button class="btn btn-info" onclick="setModalTambah()">
                                        <div>
                                            <i class="fa fa-plus"></i>
                                            <span>Tambah Data</span>
                                        </div>
                                    </button>
                                </div>

                                <table class="table" id="table" data-toggle="table" data-url="<?php echo $URL_TBL ?>" data-pagination="true" data-search="true" data-unique-id="id">
                                    <thead class="bg-info text-white text-center">
                                        <tr>
                                            <th data-field="no" data-formatter='indexFormatter'>#</th>
                                            <th data-field="nim" class="text-center">Nim</th>
                                            <th data-field="nama">Nama</th>
                                            <th data-field="nama_pembimbing_satu">Pembimbing 1</th>
                                            <th data-field="nama_pembimbing_dua">Pembimbing 2</th>
                                            <th data-field="SK" data-formatter="skFormatter" class="text-center">SK Bimbingan</th>
                                            console.log(val);
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
                                <input type="hidden" id="defaultID">
                                <input type="hidden" id="defaultNIM">
                                <div class="form-group row">
                                    <label for="nim" class="col-sm-3 col-form-label">Mahasiswa</label>
                                    <div class="col-sm-9">
                                        <select name="nim" class="selectpicker show-tick form-control" data-style="btn-outline-light" data-bv-notempty="true" data-bv-notempty-message="Mahasiswa belum dipilih" title=" - Pilih Mahasiswa -" data-live-search="true">
                                            <?php foreach ($dataMhs as $value) : ?>
                                                <option value="<?= $value['nim'] ?>" title="<?= $value['nama'] ?>" data-subtext="<?= $value['nim'] ?>"> <?= $value['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pembimbing_satu" class="col-sm-3 col-form-label">Pembimbing Satu</label>
                                    <div class="col-sm-9">
                                        <select name="pembimbing_satu" class="selectpicker show-tick form-control" data-style="btn-outline-light" data-bv-notempty="true" data-bv-notempty-message="Pembimbing Satu belum dipilih" title=" - Pilih Pembimbing -" data-live-search="true">
                                            <?php foreach ($dataDosen as $value) : ?>
                                                <option value="<?= $value['nbm'] ?>" title="<?= $value['nama'] ?>" data-subtext="<?= $value['nbm'] ?>"> <?= $value['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="pembimbing_dua" class="col-sm-3 col-form-label">Pembimbing Dua</label>
                                    <div class="col-sm-9">
                                        <select name="pembimbing_dua" class="selectpicker show-tick form-control" data-style="btn-outline-light" data-bv-notempty="true" data-bv-notempty-message="Pembimbing Dua belum dipilih" title=" - Pilih Pembimbing -" data-live-search="true">
                                            <?php foreach ($dataDosen as $value) : ?>
                                                <option value="<?= $value['nbm'] ?>" title="<?= $value['nama'] ?>" data-subtext="<?= $value['nbm'] ?>"> <?= $value['nama'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3">Foto Siswa</label>
                                    <div class="col-md-9">
                                        <input type="file" name="sk" accept="image/*" >
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
    formProses = new formProses('<?php echo base_url('admin/manajemenBimbingan') ?>', 'Pembimbing');
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
                    message: 'Data Mahasiswa telah ada',
                    validators: {
                        callback: {
                            callback: function(value, validator, $fields) {
                                if (value == '') {
                                    return true;
                                }
                                let send = [{
                                    'name': 'nim'
                                }, {
                                    'value': value
                                }]

                                if (value !== $('input[id=defaultNIM]').val()) {
                                    formProses.cekData("<?php echo base_url() ?>" + "api/cekData", 'pembimbing', send)
                                        .then((res) => {
                                            if (res) {
                                                myForm
                                                    .bootstrapValidator('updateStatus', 'nim', 'INVALID', 'callback')
                                                    .bootstrapValidator('validateField', 'nim');
                                            }
                                        });
                                }
                                return true;
                            }
                        }
                    }
                },
            }
        })
    })

    myForm.submit((evt) => {
        evt.preventDefault();
    })

    function setModalTambah() {
        myForm.bootstrapValidator('resetForm', true);
        myForm.trigger("reset");

        myModal.modal();
        $('#myModalLabel').html("Form Tambah Data Pembimbing");

        $('.selectpicker').selectpicker('refresh');

        $('#submitBtn').html('<div><i class = "fa fa-save"></i><span> Simpan</span></div>');
    }

    $('#submitBtn').on('click', (e) => {
        myForm.data('bootstrapValidator').validate();        

        let hasErr = myForm.find(".has-error").length;

        if (hasErr == 0) {
            let ButtonText = $('#submitBtn').text();

            if (ButtonText == " Simpan") {
                const formData = new FormData(myForm[0]);
                formData.append('manajemen', 'tambah');

                const res = formProses.upload(formData);
                console.log(res);
                if (res[0] == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Pembimbing berhasil ditambahkan',
                        timer: 1500
                    })
                    myModal.modal('toggle');

                    res[1]['nama'] = $('select[name=nim] option:selected').text();
                    res[1]['nama_pembimbing_satu'] = $('select[name=pembimbing_satu] option:selected').text();
                    res[1]['nama_pembimbing_dua'] = $('select[name=pembimbing_dua] option:selected').text();

                    myTabel.bootstrapTable('append', res[1]);
                }
            } else
            if (ButtonText == " Update") {
                    const nim = $('input[id=defaultNIM]').val();
                    const formData = new FormData(myForm[0]);

                    formData.append('manajemen', 'update');
                    formData.append('where', `nim='${nim}'`);

                    const res = formProses.upload(formData);
                if (res[0] == true) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Data Pembimbing berhasil diubah',
                        timer: 1500
                    })
                    myModal.modal('toggle');

                    res[1]['nama'] = $('select[name=nim] option:selected').text();
                    res[1]['nama_pembimbing_satu'] = $('select[name=pembimbing_satu] option:selected').text();
                    res[1]['nama_pembimbing_dua'] = $('select[name=pembimbing_dua] option:selected').text();

                    const id = $('#defaultID').val();

                    myTabel.bootstrapTable('updateByUniqueId', {
                        id: id,
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

    function skFormatter(val, row){
        const URL = '<?= base_url('sk/') ?>' + `${row.nim}/${val}`;
        return `<a href='${URL}' target='_blank' class='btn btn-primary btn-sm'><i class='fa fa-eye'></i></a>`;
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
            $('#myModalLabel').html("Form Ubah Data Pembimbing");

            $('#defaultID').val(row.id)
            $('#defaultNIM').val(row.nim)
            $('select[name=nim]').val(row.nim)
            $('select[name=pembimbing_satu]').val(row.pembimbing_satu)
            $('select[name=pembimbing_dua]').val(row.pembimbing_dua)

            $('.selectpicker').selectpicker('refresh');

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
                            text: 'Data Pembimbing berhasil dihapus',
                            timer: 1500
                        })
                        myTabel.bootstrapTable('remove', {
                            field: 'id',
                            values: row.id
                        });
                    }
                }
            })
        }
    }
</script>

</body>

</html>