<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Selamat Datang, <?= $orangtua->username; ?></h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <table width="100%">
                            <tr>
                                <td width="30%">ID Orang Tua</td>
                                <td>:</td>
                                <td><?= $orangtua->id_orangtua; ?></td>
                            </tr>
                            <tr>
                                <td>Nama Ayah</td>
                                <td>:</td>
                                <td><?= $orangtua->nama_ayah; ?></td>
                            </tr>
                            <tr>
                                <td>Nama Ibu</td>
                                <td>:</td>
                                <td><?= $orangtua->nama_ibu; ?></td>
                            </tr>
                            <tr>
                                <td>Nomor HP</td>
                                <td>:</td>
                                <td><?= $orangtua->no_hp; ?></td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td><?= $orangtua->alamat; ?></td>
                            </tr>
                            <tr>
                                <td>Terdaftar Tanggal</td>
                                <td>:</td>
                                <td><?= tgl_indonesia($orangtua->tgl_dibuat); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <h5 class="mb-2 mt-4">Data Bayi</h5>
        <div class="row">
            <?php
            $i = 1;
            foreach ($bayi as $b) { ?>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box shadow-none">
                        <span class="info-box-icon" style="<?= $b->jenis_kelamin == 'L' ? 'background-color: #007bff;' : 'background-color: #ffc0cb;' ?>"><i
                                class="fas fa-baby" style="color: #fff;"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-number">Anak ke-<?= $i; ?></span>
                            <span class="info-box-text">
                                <table width="100%">
                                    <tr>
                                        <td width="30%">ID</td>
                                        <td>:</td>
                                        <td><?= $b->id_bayi; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Ibu</td>
                                        <td>:</td>
                                        <td><?= $b->nama_ibu; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama Lengkap</td>
                                        <td>:</td>
                                        <td><?= $b->nama_bayi; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Lahir</td>
                                        <td>:</td>
                                        <td><?= format_tanggal($b->tgl_lahir); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Jenis Kelamin</td>
                                        <td>:</td>
                                        <td><?= $b->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' ?></td>
                                    </tr>
                                </table>
                            </span>

                        </div>
                    </div>
                </div>
                <?php $i++;
            }
            ?>
        </div>
        <!-- /.row -->
    </div>
</section>