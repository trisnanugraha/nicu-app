<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <?php if ($hakakses != 'Admin') { ?>
                        <div class="card-header bg-light">
                            <div class="text-left">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="add()" title="Add Data"><i class="fas fa-plus"></i> Tambah Data Baru</button>
                            </div>
                        </div>
                    <?php }; ?>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabel-imei" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-info text-center">
                                    <th>No.</th>
                                    <th>No. IMEI</th>
                                    <th>Tipe Hp</th>
                                    <th>Model Hp</th>
                                    <th>Pendaftar</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Status</th>
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

<?php echo $modal_tambah; ?>