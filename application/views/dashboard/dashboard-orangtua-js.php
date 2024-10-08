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

        $('#priode').select2({
            placeholder: "-- Pilih Priode --"
        });
        filter();
        // init();
    })

    $(function () {

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendar.Draggable;

        var calendarEl = document.getElementById('calendar');

        // initialize the external events
        // -----------------------------------------------------------------

        new Draggable(containerEl, {
            itemSelector: '.external-event',
            eventData: function (eventEl) {
                return {
                    title: eventEl.innerText,
                    backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                    borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                    textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
                };
            }
        });

        var calendar = new Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            themeSystem: 'bootstrap',
            //Random default events
            events: [
                {
                    title: 'All Day Event',
                    start: new Date(y, m, 1),
                    backgroundColor: '#f56954', //red
                    borderColor: '#f56954', //red
                    allDay: true
                },
                {
                    title: 'Long Event',
                    start: new Date(y, m, d - 5),
                    end: new Date(y, m, d - 2),
                    backgroundColor: '#f39c12', //yellow
                    borderColor: '#f39c12' //yellow
                },
                {
                    title: 'Meeting',
                    start: new Date(y, m, d, 10, 30),
                    allDay: false,
                    backgroundColor: '#0073b7', //Blue
                    borderColor: '#0073b7' //Blue
                },
                {
                    title: 'Lunch',
                    start: new Date(y, m, d, 12, 0),
                    end: new Date(y, m, d, 14, 0),
                    allDay: false,
                    backgroundColor: '#00c0ef', //Info (aqua)
                    borderColor: '#00c0ef' //Info (aqua)
                },
                {
                    title: 'Birthday Party',
                    start: new Date(y, m, d + 1, 19, 0),
                    end: new Date(y, m, d + 1, 22, 30),
                    allDay: false,
                    backgroundColor: '#00a65a', //Success (green)
                    borderColor: '#00a65a' //Success (green)
                },
                {
                    title: 'Click for Google',
                    start: new Date(y, m, 28),
                    end: new Date(y, m, 29),
                    url: 'https://www.google.com/',
                    backgroundColor: '#3c8dbc', //Primary (light-blue)
                    borderColor: '#3c8dbc' //Primary (light-blue)
                }
            ],
            editable: true,
            droppable: true, // this allows things to be dropped onto the calendar !!!
            drop: function (info) {
                // is the "remove after drop" checkbox checked?
                if (checkbox.checked) {
                    // if so, remove the element from the "Draggable Events" list
                    info.draggedEl.parentNode.removeChild(info.draggedEl);
                }
            }
        });

        calendar.render();
        // $('#calendar').fullCalendar()

        /* ADDING EVENTS */
        var currColor = '#3c8dbc' //Red by default
        // Color chooser button
        $('#color-chooser > li > a').click(function (e) {
            e.preventDefault()
            // Save color
            currColor = $(this).css('color')
            // Add color effect to button
            $('#add-new-event').css({
                'background-color': currColor,
                'border-color': currColor
            })
        })
        $('#add-new-event').click(function (e) {
            e.preventDefault()
            // Get value and make sure it is not null
            var val = $('#new-event').val()
            if (val.length == 0) {
                return
            }

            // Create events
            var event = $('<div />')
            event.css({
                'background-color': currColor,
                'border-color': currColor,
                'color': '#fff'
            }).addClass('external-event')
            event.text(val)
            $('#external-events').prepend(event)

            // Add draggable funtionality
            ini_events(event)

            // Remove event from text input
            $('#new-event').val('')
        })
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
        $('#priode').change(function () {
            filtering = $(this).val();
            // console.log(filtering)
            // init(filtering)

            $.ajax({
                url: "<?php echo site_url('dashboard/fetch_data') ?>",
                type: "POST",
                data: "idPriode=" + filtering,
                dataType: "JSON",
                success: function (data) {
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