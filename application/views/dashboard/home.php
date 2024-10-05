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
                    <a href="<?php echo base_url('user'); ?>" class="small-box-footer">Detail <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3><?php echo $ruangan; ?></h3>

                        <p>Jumlah Ruangan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <a href="<?php echo base_url('ruangan'); ?>" class="small-box-footer">Detail <i
                            class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-md-9">
                <div class="card card-primary">
                    <div class="card-body p-0">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>

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
        </div>
        <!-- /.row -->
    </div>
</section>