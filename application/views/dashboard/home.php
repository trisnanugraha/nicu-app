<section class="content">
    <div class="container-fluid">
        <div class="row">
            <?php if ($role == 'Admin') { ?>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3><?php echo $admin; ?></h3>

                            <p>Total Admin</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-cog"></i>
                        </div>
                        <a href="<?php echo base_url('data-admin'); ?>" class="small-box-footer">Detail <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3><?php echo $perawat; ?></h3>

                            <p>Total Perawat</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-nurse"></i>
                        </div>
                        <a href="<?php echo base_url('data-perawat'); ?>" class="small-box-footer">Detail <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            <?php }
            ?>
            <?php if ($role != 'Orang Tua') { ?>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3><?php echo $orangtua; ?></h3>

                            <p>Total Orang Tua</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                        <a href="<?php echo base_url('data-orang-tua'); ?>" class="small-box-footer">Detail <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
            <?php }
            ?>
            <?php if ($role == 'Admin') { ?>
                <div class="col-lg-12 col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Log Activity System</h3>
                                    <div class="card-tools">
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="clear_log()"
                                            title="Clear Log"><i class="fas fa-trash"></i>
                                            Hapus Log</button>
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
            <?php }
            ?>
        </div>
        <!-- /.row -->
    </div>
</section>