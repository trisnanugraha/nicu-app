<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <?php if ($level == 'Sekretaris') { ?>
                        <div class="card-header bg-light">
                            <div class="text-left">
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="add()" title="Add Data"><i class="fas fa-plus"></i> Tambah IBL / Cuti</button>
                            </div>
                        </div>
                    <?php } ?>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tabelibl" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="bg-info text-center">
                                    <th>No.</th>
                                    <th>Nomor Surat</th>
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

<?php echo $modal_tambah_ibl; ?>
<?php echo $modal_validasi_ibl; ?>