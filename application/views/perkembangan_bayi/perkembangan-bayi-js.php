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
          return "<div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-success\" href=\"javascript:void(0)\" title=\"Detail\" onclick=\"detail('" + row[7] + "')\"><i class=\"fas fa-info-circle\"></i> Detail</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-primary\" href=\"javascript:void(0)\" title=\"Edit\" onclick=\"edit('" + row[7] + "')\"><i class=\"fas fa-edit\"></i> Ubah</a></div> <div class=\"d-inline mx-1\"><a class=\"btn btn-xs btn-outline-danger\" href=\"javascript:void(0)\" title=\"Delete\"  onclick=\"del('" + row[7] + "')\"><i class=\"fas fa-trash\"></i> Hapus</a></div>"
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
          url: "<?php echo site_url('perkembangan-bayi/delete'); ?>",
          type: "POST",
          data: "id=" + id,
          cache: false,
          dataType: 'json',
          success: function (respone) {
            if (respone.status == true) {
              Swal.fire({
                icon: 'success',
                title: 'Data Berhasil Dihapus!'
              });
              reload_table();
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
    $('.modal-title').text('Tambah Data Baru'); // Set Title to Bootstrap modal title
  }

  function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); // reset form on modals
    $('.form-group').removeClass('has-error'); // clear error class
    $('.help-block').empty(); // clear error string

    //Ajax Load data from ajax
    $.ajax({
      url: "<?php echo site_url('perkembangan-bayi/edit') ?>/" + id,
      type: "GET",
      dataType: "JSON",
      success: function (data) {
        $('[name="id_perkembangan_bayi"]').val(data.id_perkembangan_bayi);
        $('[name="id_bayi"]').val(data.id_bayi);
        $('[name="berat_badan"]').val(data.berat_badan);
        $('[name="panjang_badan"]').val(data.panjang_badan);
        $('[name="diagnosa_medis"]').val(data.diagnosa_medis);
        $('[name="suhu"]').val(data.suhu);
        $('[name="pernapasan"]').val(data.pernapasan);
        $('[name="heart_rate"]').val(data.heart_rate);
        $('[name="saturasi_oksigen"]').val(data.saturasi_oksigen);
        $('[name="hb"]').val(data.hb);
        $('[name="ht"]').val(data.ht);
        $('[name="leukosit"]').val(data.leukosit);
        $('[name="trombosit"]').val(data.trombosit);
        $('[name="crp"]').val(data.crp);
        $('[name="natrium"]').val(data.natrium);
        $('[name="kalium"]').val(data.kalium);
        $('[name="kalsium"]').val(data.kalsium);
        $('[name="bilirubin_total"]').val(data.bilirubin_total);
        $('[name="albumin"]').val(data.albumin);
        $('[name="gds"]').val(data.gds);
        $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Ubah Data'); // Set title to Bootstrap modal title

      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
      }
    });
  }

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
        if (data.hb == 0 || data.hb == NULL) {
          $('#status_hb').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        } else if (data.hb >= 15.00 && data.hb <= 24.00) {
          $('#status_hb').html('<div class="badge bg-success text-white text-wrap">Normal</div>'); 
        } else {
          $('#status_hb').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="ht"]').text(data.ht + '%');
        if (data.ht == 0 || data.ht == NULL) {
          $('#status_ht').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        } else if (data.ht >= 43.00 && data.ht <= 70.00) {
          $('#status_ht').html('<div class="badge bg-success text-white text-wrap">Normal</div>'); 
        } else {
          $('#status_ht').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="leukosit"]').text(data.leukosit + '/uL');
        if (data.leukosit == 0 || data.leukosit == NULL) {
          $('#status_leukosit').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        } else if (data.leukosit >= 9100 && data.leukosit <= 34000) {
          $('#status_leukosit').html('<div class="badge bg-success text-white text-wrap">Normal</div>'); 
        } else {
          $('#status_leukosit').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="trombosit"]').text(data.trombosit + '/uL');
        if (data.trombosit == 0 || data.trombosit == NULL) {
          $('#status_trombosit').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        } else if (data.trombosit >= 86000 && data.trombosit <= 478000) {
          $('#status_trombosit').html('<div class="badge bg-success text-white text-wrap">Normal</div>'); 
        } else {
          $('#status_trombosit').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="crp"]').text(data.crp + 'mg/L');
        if (data.crp == 0 || data.crp == NULL) {
          $('#status_crp').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        } else if (data.crp <= 5) {
          $('#status_crp').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_crp').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="natrium"]').text(data.natrium + 'mmol/L');
        if (data.natrium == 0 || data.natrium == NULL) {
          $('#status_natrium').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        }else if (data.natrium >= 136 && data.natrium <= 145) {
          $('#status_natrium').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_natrium').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="kalium"]').text(data.kalium + 'mmol/L');
        if (data.kalium == 0 || data.kalium == NULL) {
          $('#status_natrium').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        }else if (data.kalium >= 3.5 && data.kalium <= 5.1) {
          $('#status_kalium').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_kalium').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="kalsium"]').text(data.kalsium + 'mg/dL');
        if (data.kalsium == 0 || data.kalsium == NULL) {
          $('#status_kalsium').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        }else if (data.kalsium >= 7.6 && data.kalsium <= 10.4) {
          $('#status_kalsium').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_kalsium').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="bilirubin_total"]').text(data.bilirubin_total + 'mg/dL');
        if (data.bilirubin_total == 0 || data.bilirubin_total == NULL) {
          $('#status_bilirubin_total').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        }else if (data.bilirubin_total >= 0.14 && data.bilirubin_total <= 14.44) {
          $('#status_bilirubin_total').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_bilirubin_total').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="albumin"]').text(data.albumin + 'g/dL');
        if (data.albumin == 0 || data.albumin == NULL) {
          $('#status_albumin').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        }else if (data.albumin >= 3.3 && data.albumin <= 4.4) {
          $('#status_albumin').html('<div class="badge bg-success text-white text-wrap">Normal</div>');
        } else {
          $('#status_albumin').html('<div class="badge bg-danger text-white text-wrap">Tidak Normal</div>');
        }
        $('[name="gds"]').text(data.gds + 'mg/dL');
        if (data.gds == 0 || data.gds == NULL) {
          $('#status_gds').html('<div class="badge bg-primary text-white text-wrap">Belum Test</div>');
        }else if (data.gds >= 40 && data.gds <= 60) {
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

  function save() {
    $('#btnSave').text('saving...'); //change button text
    $('#btnSave').attr('disabled', true); //set button disable 
    var url;
    if (save_method == 'add') {
      url = "<?php echo site_url('perkembangan-bayi/insert') ?>";
    } else {
      url = "<?php echo site_url('perkembangan-bayi/update') ?>";
    }
    var formdata = new FormData($('#form')[0]);
    $.ajax({
      url: url,
      type: "POST",
      data: formdata,
      dataType: "JSON",
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {

        if (data.status) //if success close modal and reload ajax table
        {
          $('#modal_form').modal('hide');
          reload_table();
          if (save_method == 'add') {
            Toast.fire({
              icon: 'success',
              title: 'Data Berhasil Disimpan!'
            });
          } else if (save_method == 'update') {
            Toast.fire({
              icon: 'success',
              title: 'Data Berhasil Diubah!'
            });
          }
        } else {
          for (var i = 0; i < data.inputerror.length; i++) {
            $('[name="' + data.inputerror[i] + '"]').addClass('is-invalid');
            $('[name="' + data.inputerror[i] + '"]').closest('.kosong').append('<span></span>');
            $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]).addClass('invalid-feedback');
          }
        }
        // $('#id_orangtua').select2();
        $('#btnSave').text('Simpan'); //change button text
        $('#btnSave').attr('disabled', false); //set button enable 


      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert(textStatus);
        // alert('Error adding / update data');
        Toast.fire({
          icon: 'error',
          title: 'Error!!.'
        });
        $('#btnSave').text('Simpan'); //change button text
        $('#btnSave').attr('disabled', false); //set button enable 

      }
    });
  }

  function batal() {
    $('#form')[0].reset();
    reload_table();
  }
</script>