<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {

        table = $("#tabelmhs").DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "sEmptyTable": "Data Mahasiswa Masih Kosong"
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('mahasiswa/ajax_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [0, 1, 2, 3, 4, 5, 6],
                "className": 'text-center'
            }, {
                "searchable": false,
                "orderable": false,
                "targets": 0
            }, {
                "targets": [-1], //last column
                "render": function(data, type, row) {
                    if (row[5] == 'N') {
                        return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" title=\"Activate User\" onclick=\"setStatus(" + row[6] + '\,\'' + row[5] + '\'' + ")\"><i class=\"fas fa-user-check\"></i> Activate User</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-warning\" href=\"javascript:void(0)\" title=\"Reset Password\" onclick=\"reset(" + row[6] + ")\"><i class=\"fas fa-recycle\"></i> Reset Password</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit(" + row[6] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-danger\" href=\"javascript:void(0)\" title=\"Delete\" onclick=\"del(" + row[6] + ")\"><i class=\"fas fa-trash\"></i> Hapus</a></div>";
                    } else {
                        return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-danger\" href=\"javascript:void(0)\" title=\"Disable User\" onclick=\"setStatus(" + row[6] + '\,\'' + row[5] + '\'' + ")\"><i class=\"fas fa-user-alt-slash\"></i> Disable User</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-warning\" href=\"javascript:void(0)\" title=\"Reset Password\" onclick=\"reset(" + row[6] + ")\"><i class=\"fas fa-recycle\"></i> Reset Password</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit(" + row[6] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div>";
                    }
                },
                "orderable": false, //set not orderable
            }, {
                "targets": [-2], //last column
                "render": function(data, type, row) {
                    if (row[5] == "N") {
                        return "<div class=\"badge bg-danger text-white text-wrap\">Non-Aktif</div>"
                    } else {
                        return "<div class=\"badge bg-success text-white text-wrap\">Aktif</div>";
                    }
                }
            }, ],
        });
        
        reset_status()
    });

    function reset_status() {
        $("input").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });
        $("textarea").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });
        $("select").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
            $(this).removeClass('is-invalid');
        });
    }

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    function setStatus(id, status) {

        if (status == 'N') {
            title = 'Aktifkan'
            text = 'Mengaktifkan'
            resultText = 'Diaktifkan'
        } else {
            title = 'Nonaktifkan'
            text = 'Menonaktifkan'
            resultText = 'Dinonaktifkan'
        }

        Swal.fire({
            title: title + ' Akun Mahasiswa',
            text: "Anda Yakin Ingin " + text + " Akun Ini ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, ' + title + ' Sekarang!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?php echo site_url('user/setStatus'); ?>",
                    type: "POST",
                    data: "id=" + id + "&status=" + status,
                    cache: false,
                    dataType: 'json',
                    success: function(respone) {
                        if (respone.status == true) {
                            reload_table();
                            Swal.fire({
                                icon: 'success',
                                title: 'Akun Mahasiswa Berhasil ' + resultText + '!',
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Reset password Error!!.'
                            });
                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        })
    }

    function reset(id) {

        Swal.fire({
            title: 'Anda Yakin Ingin Mengatur Ulang Password ?',
            text: "Default Password : password123",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Atur Ulang Password!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?php echo site_url('user/reset'); ?>",
                    type: "POST",
                    data: "id=" + id,
                    cache: false,
                    dataType: 'json',
                    success: function(respone) {
                        if (respone.status == true) {
                            reload_table();
                            Swal.fire({
                                icon: 'success',
                                title: 'Password Berhasil Diatur Ulang!',
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Reset password Error!!.'
                            });
                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        })
    }

    //delete
    function del(id) {

        Swal.fire({
            title: 'Konfirmasi Hapus Data',
            text: "Apakah Anda Yakin Ingin Menghapus Data Ini ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Data Ini!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?php echo site_url('mahasiswa/delete'); ?>",
                    type: "POST",
                    data: "id_mhs=" + id,
                    cache: false,
                    dataType: 'json',
                    success: function(respone) {
                        if (respone.status == true) {
                            reload_table();
                            Swal.fire({
                                icon: 'success',
                                title: 'Data Mahasiswa Berhasil Dihapus!'
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: 'Delete Error!!.'
                            });
                        }
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        })
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah Mahasiswa'); // Set Title to Bootstrap modal title
    }

    function edit(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('mahasiswa/edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {

                $('[name="id_mhs"]').val(data.id_user);
                $('[name="nama_mhs"]').val(data.full_name);
                $('[name="nim"]').val(data.nim_nrp);
                $('[name="angkatan"]').val(data.id_angkatan);
                $('[name="kelas"]').val(data.id_kelas);
                $('[name="sindikat"]').val(data.id_sindikat);
                $('[name="alamat"]').val(data.alamat);
                $('[name="telepon"]').val(data.no_hp);
                $('[name="email"]').val(data.email);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Mahasiswa'); // Set title to Bootstrap modal title

            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function save() {
        $('#btnSave').text('Menyimpan...'); //change button text
        $('#btnSave').attr('disabled', true); //set button disable 
        var url;

        if (save_method == 'add') {
            url = "<?php echo site_url('mahasiswa/insert') ?>";
        } else {
            url = "<?php echo site_url('mahasiswa/update') ?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: $('#form').serialize(),
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                    if (save_method == 'add') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Mahasiswa Berhasil Disimpan!'
                        });
                    } else if (save_method == 'update') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Data Mahasiswa Berhasil Diubah!'
                        });
                    }
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        if (data.error_string[i] != '') {
                            $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                            $('[name="' + data.inputerror[i] + '"]').closest('.kosong').append('<span></span>');
                            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]).addClass('invalid-feedback');
                        }
                    }
                }
                $('#btnSave').text('Simpan'); //change button text
                $('#btnCancel').text('Batal'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 


            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error adding / update data');
                $('#btnSave').text('Simpan'); //change button text
                $('#btnCancel').text('Batal'); //change button text
                $('#btnSave').attr('disabled', false); //set button enable 

            }
        });
    }

    function tutup() {
        $('#form')[0].reset();
        reload_table();
    }
</script>