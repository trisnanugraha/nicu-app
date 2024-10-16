<script type="text/javascript">
  var save_method; //for save method string
  var table;

  $(document).ready(function () {

    // $('#id_bayi').select2()

    table = $("#tabelPerkembanganBayi").DataTable({
      "responsive": true,
      "autoWidth": false,
      "language": {
        "sEmptyTable": "Data Masih Kosong"
      },
      "processing": true, //Feature control the processing indicator.
      "serverSide": true, //Feature control DataTables' server-side processing mode.
      "order": [], //Initial no order.

      // Load data for the table's content from an Ajax source
      "ajax": {
        "url": "<?php echo site_url('perkembangan-bayi/list') ?>",
        "type": "POST"
      },
      //Set column definition initialisation properties.
      "columnDefs": [{
        "targets": [0, 1, 2, 3, 4, 5, 6, 7],
        "className": 'text-center'
      }, {
        "targets": [-1], //last column
        "render": function (data, type, row) {
          return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" title=\"Detail\" onclick=\"detail('" + row[7] + "')\"><i class=\"fas fa-info-circle\"></i> Detail</a></div>"
        },
        "orderable": false, //set not orderable
      }, {
        "searchable": false,
        "orderable": false,
        "targets": 0
      }],

    });
    $("input").change(function () {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
      $(this).removeClass('is-invalid');
    });
    $("select").change(function () {
      $(this).parent().parent().removeClass('has-error');
      $(this).next().empty();
      $(this).removeClass('is-invalid');
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

  function detail(id) {
    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo site_url('perkembangan-bayi/detail') ?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function (data) {
        $('[name="nama_perawat"]').text(data.nama_perawat);
        $('[name="tanggal_periksa"]').text(data.tgl_dibuat);
        $('[name="id_bayi"]').text(data.id_bayi);
        $('[name="nama_bayi"]').text(data.nama_bayi);
        $('[name="berat_badan_lahir"]').text(data.berat_badan_lahir + ' KG');
        $('[name="panjang_badan_lahir"]').text(data.panjang_badan_lahir + ' CM');
        $('[name="berat_badan"]').text(data.berat_badan + ' KG');
        $('[name="panjang_badan"]').text(data.panjang_badan + ' CM');
        $('[name="diagnosa_medis"]').text(data.diagnosa_medis);
        $('[name="suhu"]').text(data.suhu + ' °C');
        if (data.suhu >= 36.5 && data.suhu <= 37.5) {
          $('#status_suhu').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_suhu').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="pernapasan"]').text(data.pernapasan + 'x/menit');
        if (data.pernapasan >= 40 && data.pernapasan <= 60) {
          $('#status_pernapasan').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_pernapasan').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="heart_rate"]').text(data.heart_rate + 'x/menit');
        if (data.heart_rate >= 130 && data.heart_rate <= 140) {
          $('#status_heart_rate').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_heart_rate').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="saturasi_oksigen"]').text(data.saturasi_oksigen + '%');
        if (data.saturasi_oksigen >= 92) {
          $('#status_saturasi_oksigen').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_saturasi_oksigen').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="h2tl"]').text(data.h2tl);
        $('[name="crp"]').text(data.crp);
        $('[name="natrium"]').text(data.natrium);
        $('[name="kalium"]').text(data.kalium);
        $('[name="kalsium"]').text(data.kalsium);
        $('[name="agd"]').text(data.agd);
        $('[name="bilirubin_total"]').text(data.bilirubin_total);
        $('[name="albumin"]').text(data.albumin);
        $('#modal_form_detail').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Detail Data'); // Set title to Bootstrap modal title

      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

  function batal() {
    $('#form')[0].reset();
    reload_table();
  }
</script>