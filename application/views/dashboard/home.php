<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?php echo $user; ?></h3>

                        <p>Total User</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="<?php echo base_url('user'); ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?php echo $imei; ?></h3>

                        <p>Total Pengajuan IMEI (Provider)</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-address-card"></i>
                    </div>
                    <a href="<?php echo base_url('daftar-imei'); ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo $manufaktur; ?></h3>

                        <p>Total Pengajuan IMEI (Manufaktur)</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-address-card"></i>
                    </div>
                    <a href="<?php echo base_url('manufaktur'); ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3><?php echo $beacukai; ?></h3>

                        <p>Total Pengajuan IMEI (Bea Cukai)</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-address-card"></i>
                    </div>
                    <a href="<?php echo base_url('beacukai'); ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3><?php echo $laporan; ?></h3>

                        <p>Total Laporan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <a href="<?php echo base_url('laporan'); ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <!-- <div class="col-lg-3 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">List Total Mahasiswa / Sindikat</h3>
                                <div class="card-tools">
                                </div>
                            </div>

                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Sindikat</th>
                                            <th style="text-align: center;">Total Mahasiswa</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($totalMahasiswa as $total) {
                                        ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo $total->nama_sindikat; ?></td>
                                                <td style="text-align: center;"><?php echo $total->total; ?></td>
                                            </tr>
                                        <?php }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div> -->
            <div class="col-lg-12 col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Log Activity System</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clear_log()" title="Clear Log"><i class="fas fa-trash"></i> Hapus Log</button>
                                </div>
                            </div>

                            <div class="card-body">
                                <table id="tabellog" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Username</th>
                                            <th style="text-align: center;">Aktivitas</th>
                                            <th style="text-align: center;">Deskripsi</th>
                                            <th style="text-align: center;">IP Address</th>
                                            <th style="text-align: center;">OS</th>
                                            <th style="text-align: center;">Browser</th>
                                            <th style="text-align: center;">Log Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
</section>