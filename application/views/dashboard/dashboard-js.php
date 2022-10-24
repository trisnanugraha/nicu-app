<script type="text/javascript">
    var filtering = 0;
    var table;

    $(document).ready(function() {

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

        $('#priode').select2({
            placeholder: "-- Pilih Priode --"
        });
        filter();
        // init();
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

    function filter() {
        $('#priode').change(function() {
            filtering = $(this).val();
            // console.log(filtering)
            // init(filtering)

            $.ajax({
                url: "<?php echo site_url('dashboard/fetch_data') ?>",
                type: "POST",
                data: "idPriode=" + filtering,
                dataType: "JSON",
                success: function(data) {
                    // draw(data)
                    var ctx = document.getElementById("chartData").getContext("2d");
                    // var cData = JSON.parse(data);
                    // console.log(cData)

                    // // var color = [];

                    nama_lv = data.nama_level;
                    totalPenelitian = data.total;
                    totalPKM = data.totalPKM;

                    // console.log(nama_lv)

                    if (totalPenelitian != undefined && totalPKM != undefined) {
                        var dataload = {
                            labels: nama_lv,
                            datasets: [{
                                label: 'Penelitian',
                                data: totalPenelitian,
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderColor: 'rgb(255, 99, 132)',
                            }, {
                                label: 'PKM',
                                data: totalPKM,
                                backgroundColor: 'rgba(56, 86, 255, 0.87)',
                                borderColor: 'rgba(56, 86, 255, 0.87)',
                            }],
                        }
                    } else if (totalPenelitian != undefined && totalPKM == undefined) {
                        var dataload = {
                            labels: nama_lv,
                            datasets: [{
                                label: 'Penelitian',
                                data: totalPenelitian,
                                backgroundColor: 'rgb(255, 99, 132)',
                                borderColor: 'rgb(255, 99, 132)',
                            }],
                        }
                    } else if (totalPenelitian == undefined && totalPKM != undefined) {
                        var dataload = {
                            labels: data.nama_level_pkm,
                            datasets: [{
                                label: 'PKM',
                                data: totalPKM,
                                backgroundColor: 'rgba(56, 86, 255, 0.87)',
                                borderColor: 'rgba(56, 86, 255, 0.87)',
                            }],
                        }
                    }

                    var options = {
                        title: {
                            display: true,
                            text: "Data Priode " + data.priode
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }

                    document.getElementById("chart-container").innerHTML = '&nbsp;';
                    document.getElementById("chart-container").innerHTML = '<canvas id="chartData"></canvas>';
                    var ctx = document.getElementById("chartData").getContext("2d");

                    //create bar Chart class object
                    var chart1 = new Chart(ctx, {
                        type: "bar",
                        data: dataload,
                        options: options
                    });
                }
            });
        })
    }

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
                    success: function(respone) {
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