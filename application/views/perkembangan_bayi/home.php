<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card"><?php if ($role != "Orang Tua") { ?>
            <div class="card-header bg-light">
              <div class="text-left">
                <button type="button" class="btn btn-sm btn-outline-primary" onclick="add()" title="Add Data"><i
                    class="fas fa-plus"></i> Tambah Data Baru</button>
              </div>
            </div><?php } ?>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="<?= $table; ?>" class="table table-bordered table-striped table-hover">
              <thead>
                <tr class="bg-info text-center">
                  <th>ID Bayi</th>
                  <th>Nama Lengkap</th>
                  <th>Berat Badan</th>
                  <th>Panjang Badan</th>
                  <th>Diagnosa Media</th>
                  <th>Tanggal Diperiksa</th>
                  <th>Perawat</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>

<?php

echo $modal_perkembangan_bayi;
echo $modal_detail_perkembangan_bayi;