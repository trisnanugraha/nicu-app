<section class="content">
    <div class="container-fluid">
        <div class="row">
            <?php foreach ($bayi as $b) { ?>
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box <?= $b->jenis_kelamin == 'L' ? 'bg-gradient-primary' : 'bg-gradient-success' ?>">
                        <span class="info-box-icon"><i class="fas fa-baby"></i></span>
                        <div class="info-box-content">
                            <table>
                                <tr>
                                    <td width="40%">ID</td>
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
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- /.row -->
    </div>
</section>