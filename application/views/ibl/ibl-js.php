<script type="text/javascript">
    var save_method; //for save method string
    var table;
    var tanggal_berangkat;
    var tanggal_kembali;

    $(document).ready(function() {

        table = $("#tabelibl").DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "sEmptyTable": "Data IBL / Cuti Masih Kosong"
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('ibl/ajax_list') ?>",
                "type": "POST"
            },
            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [0, 1, 2, 3],
                "className": 'text-center'
            }, {
                "searchable": false,
                "orderable": false,
                "targets": 0
            }, {
                "targets": [-2],
                "render": function(data, type, row) {
                    if (row[2] == "Diproses") {
                        return "<div class=\"badge bg-info text-white text-wrap\">" + row[2] + "</div>"
                    } else if (row[2] == "Butuh Perbaikan") {
                        return "<div class=\"badge bg-warning text-white text-wrap\">" + row[2] + "</div>"
                    } else if (row[2] == "Disetujui") {
                        return "<div class=\"badge bg-success text-white text-wrap\">" + row[2] + "</div>"
                    } else if (row[2] == "Ditolak") {
                        return "<div class=\"badge bg-danger text-white text-wrap\">" + row[2] + "</div>"
                    } else if (row[2] == "Draft") {
                        return "<div class=\"badge bg-info text-white text-wrap\">" + row[2] + "</div>"
                    }
                }
            }, {
                "targets": [-1], //last column
                "render": function(data, type, row) {
                    if (row[2] == "Diproses" && row[4] == 0 || row[2] == "Disetujui" || row[4] == 2) {
                        return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Preview\" onclick=\"print(" + row[3] + ")\"><i class=\"fas fa-print\"></i> Preview</a></div>";
                    } else if (row[2] == "Diproses" && row[4] == 1) {
                        return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" title=\"Validasi\" onclick=\"validate(" + row[3] + ")\"><i class=\"fas fa-file-signature\"></i> Validasi</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Preview\" onclick=\"print(" + row[3] + ")\"><i class=\"fas fa-print\"></i> Preview</a></div>";
                    } else {
                        return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit(" + row[3] + ")\"><i class=\"fas fa-edit\"></i> Ubah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-danger\" href=\"javascript:void(0)\" title=\"Delete\" onclick=\"del(" + row[3] + ")\"><i class=\"fas fa-trash\"></i> Hapus</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-info\" href=\"javascript:void(0)\" title=\"Preview\" onclick=\"print(" + row[3] + ")\"><i class=\"fas fa-print\"></i> Preview</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" title=\"Kirim Pengajuan\" onclick=\"send(" + row[3] + ")\"><i class=\"fas fa-envelope\"></i> Kirim Pengajuan</a></div>";
                    }
                },
                "orderable": false, //set not orderable
            }, ],
        });
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

        //Date range picker with time picker
        $('#tgl_cuti').daterangepicker({
            timePicker: true,
            showDropdowns: true,
            timePicker24Hour: true,
            locale: {
                format: 'DD-MM-YYYY HH:mm'
            }
        })

        $('#tgl_cuti').on('apply.daterangepicker', function(ev, picker) {
            tanggal_berangkat = picker.startDate.format('YYYY-MM-DD HH:mm:ss')
            tanggal_kembali = picker.endDate.format('YYYY-MM-DD HH:mm:ss')
        });
    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    function print(id) {
        var go_to_url = '<?php echo base_url('ibl/print/'); ?>' + id;
        window.open(go_to_url, '_blank');
    }

    function send(id) {
        Swal.fire({
            title: 'Kirim Pengajuan Surat',
            text: "Apakah Anda Yakin Ingin Mengajukan Surat IBL Ini?",
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Ajukan Sekarang!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?php echo site_url('ibl/send'); ?>",
                    type: "POST",
                    data: "id_ibl=" + id,
                    cache: false,
                    dataType: 'json',
                    success: function(respone) {
                        if (respone.status == true) {
                            reload_table();
                            Swal.fire({
                                icon: 'success',
                                title: 'Pengajuan Surat IBL Berhasil Terkirim!'
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
                    url: "<?php echo site_url('ibl/delete'); ?>",
                    type: "POST",
                    data: "id_ibl=" + id,
                    cache: false,
                    dataType: 'json',
                    success: function(respone) {
                        if (respone.status == true) {
                            reload_table();
                            Swal.fire({
                                icon: 'success',
                                title: 'Cuti / IBL Berhasil Dihapus!'
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

    function validate(id) {
        save_method = 'validate';
        $('#form_validasi')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('ibl/detail') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('[name="id_ibl"]').val(data.id_ibl);
                if (data.level == 'Staff Korwa') {
                    $('[name="status_staff"]').val(data.status_staff);
                    $('[name="catatan_staff"]').val(data.catatan_staff);
                } else if (data.level == 'Kakorwa') {
                    $('[name="status_kakorwa"]').val(data.status_kakorwa);
                    $('[name="catatan_kakorwa"]').val(data.catatan_kakorwa);
                }

                $('#modal_validasi').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Detail Permohonan Surat'); // Set title to Bootstrap modal title
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function add() {
        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Tambah IBL / Cuti'); // Set Title to Bootstrap modal title
    }

    function edit(id) {
        save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
            url: "<?php echo site_url('ibl/edit') ?>/" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                tgl_berangkat = data.tgl_berangkat;
                tgl_kembali = data.tgl_kembali;
                $('[name="id_ibl"]').val(data.id_ibl);
                $('[name="no_surat"]').val(data.no_surat);
                $('#tgl_cuti').data('daterangepicker').setStartDate(data.tgl_berangkat);
                $('#tgl_cuti').data('daterangepicker').setEndDate(data.tgl_kembali);
                $('[name="angkatan"]').val(data.id_angkatan);
                $('[name="keperluan"]').val(data.keperluan);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Ubah Cuti / IBL'); // Set title to Bootstrap modal title

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

        formData = {
            id_ibl: $("#id_ibl").val(),
            no_surat: $("#no_surat").val(),
            id_angkatan: $("#angkatan").val(),
            tgl_cuti: $("#tgl_cuti").val(),
            tgl_berangkat: tanggal_berangkat,
            tgl_kembali: tanggal_kembali,
            keperluan: $("#keperluan").val(),
            status_staff: $("#status_staff").val(),
            catatan_staff: $("#catatan_staff").val(),
            status_kakorwa: $("#status_kakorwa").val(),
            catatan_kakorwa: $("#catatan_kakorwa").val(),
        };

        // console.log(formData)

        if (save_method == 'add') {
            url = "<?php echo site_url('ibl/insert') ?>";
        } else if (save_method == 'update') {
            url = "<?php echo site_url('ibl/update') ?>";
        } else {
            url = "<?php echo site_url('ibl/validate') ?>";
        }

        // ajax adding data to database
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            dataType: "JSON",
            success: function(data) {

                if (data.status) //if success close modal and reload ajax table
                {
                    $('#modal_form').modal('hide');
                    reload_table();
                    if (save_method == 'add') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Cuti / IBL Berhasil Disimpan!'
                        });
                    } else if (save_method == 'update') {
                        Toast.fire({
                            icon: 'success',
                            title: 'Cuti / IBL Berhasil Diubah!'
                        });
                    } else if (save_method == 'validate') {
                        $('#modal_validasi').modal('hide');
                        Toast.fire({
                            icon: 'success',
                            title: 'Cuti / IBL Berhasil Divalidasi!'
                        });
                    }
                } else {
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
                        $('[name="' + data.inputerror[i] + '"]').closest('.kosong').append('<span></span>');
                        $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]).addClass('invalid-feedback');
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
</script>