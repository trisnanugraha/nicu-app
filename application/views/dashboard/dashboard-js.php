<script type="text/javascript">
    var filtering = 0;
    var table;

    $(document).ready(function () {

        table = $("#tabellog").DataTable({
            "responsive": true,
            "autoWidth": false,
            "language": {
                "sEmptyTable": "Data Log Masih Kosong"
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('dashboard/ajax_list') ?>",
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
            }],
        });
    })

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax 
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    //delete
    function clear_log() {

        Swal.fire({
            title: 'Konfirmasi Hapus Log',
            text: "Apakah Anda Yakin Ingin Menghapus Seluruh Log ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus Semua Log!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?php echo site_url('dashboard/clearLog'); ?>",
                    type: "POST",
                    data: null,
                    dataType: 'json',
                    success: function (respone) {
                        if (respone.status == true) {
                            reload_table();
                            Swal.fire({
                                icon: 'success',
                                title: 'Log Berhasil Dihapus!'
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
</script>