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
        $('[name="tanggal_diubah"]').text(data.tgl_diubah);
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
        if (data.heart_rate >= 130 && data.heart_rate <= 160) {
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
        $('[name="hb"]').text(data.hb + 'g/dl');
        if (data.hb == 0 || data.hb === null || data.hb === '') {
          $('#status_hb').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        } else if (data.hb >= 15.00 && data.hb <= 24.00) {
          $('#status_hb').html('<div class="badge bg-success text-white text-wrap">Normal</div>'); 
        } else {
          $('#status_hb').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="ht"]').text(data.ht + '%');
        if (data.ht == 0 || data.ht === null || data.ht === '') {
          $('#status_ht').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        } else if (data.ht >= 43.00 && data.ht <= 70.00) {
          $('#status_ht').html('<div class="badge bg-success text-white text-wrap">Normal</div>'); 
        } else {
          $('#status_ht').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="leukosit"]').text(data.leukosit + '/uL');
        if (data.leukosit == 0 || data.leukosit === null || data.leukosit === '') {
          $('#status_leukosit').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        } else if (data.leukosit >= 9100 && data.leukosit <= 34000) {
          $('#status_leukosit').html('<div class="badge bg-success text-white text-wrap">Normal</div>'); 
        } else {
          $('#status_leukosit').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="trombosit"]').text(data.trombosit + '/uL');
        if (data.trombosit == 0 || data.trombosit === null || data.trombosit === '') {
          $('#status_trombosit').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        } else if (data.trombosit >= 86000 && data.trombosit <= 478000) {
          $('#status_trombosit').html('<div class="badge bg-success text-white text-wrap">Normal</div>'); 
        } else {
          $('#status_trombosit').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="crp"]').text(data.crp + 'mg/L');
        if (data.crp == 0 || data.crp === null || data.crp === '') {
          $('#status_crp').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        } else if (data.crp <= 5) {
          $('#status_crp').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_crp').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="natrium"]').text(data.natrium + 'mmol/L');
        if (data.natrium == 0 || data.natrium === null || data.natrium === '') {
          $('#status_natrium').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        }else if (data.natrium >= 136 && data.natrium <= 145) {
          $('#status_natrium').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_natrium').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="kalium"]').text(data.kalium + 'mmol/L');
        if (data.kalium == 0 || data.kalium === null || data.kalium === '') {
          $('#status_natrium').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        }else if (data.kalium >= 3.5 && data.kalium <= 5.1) {
          $('#status_kalium').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_kalium').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="kalsium"]').text(data.kalsium + 'mg/dL');
        if (data.kalsium == 0 || data.kalsium === null || data.kalsium === '') {
          $('#status_kalsium').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        }else if (data.kalsium >= 7.6 && data.kalsium <= 10.4) {
          $('#status_kalsium').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_kalsium').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="bilirubin_total"]').text(data.bilirubin_total + 'mg/dL');
        if (data.bilirubin_total == 0 || data.bilirubin_total === null || data.bilirubin_total === '') {
          $('#status_bilirubin_total').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        }else if (data.bilirubin_total >= 0.14 && data.bilirubin_total <= 14.44) {
          $('#status_bilirubin_total').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_bilirubin_total').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="albumin"]').text(data.albumin + 'g/dL');
        if (data.albumin == 0 || data.albumin === null || data.albumin === '') {
          $('#status_albumin').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        }else if (data.albumin >= 3.3 && data.albumin <= 4.4) {
          $('#status_albumin').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_albumin').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="gds"]').text(data.gds + 'mg/dL');
        if (data.gds == 0 || data.gds === null || data.gds === '') {
          $('#status_gds').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        }else if (data.gds >= 50) {
          $('#status_gds').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_gds').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
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