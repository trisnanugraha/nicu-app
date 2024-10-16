<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form_detail" role="dialog" data-backdrop="static">
    <div class="modal-xl modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form Bayi</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="container-fluid mt-3">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Nama Perawat</th>
                                            <th>Tanggal Pemeriksaan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td name="nama_perawat" id="nama_perawat"></td>
                                            <td name="tanggal_periksa" id="tanggal_periksa"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Data Perkembangan Bayi</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th>Deskripsi</th>
                                            <th style="width: 50%">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td>ID Bayi</td>
                                            <td name="id_bayi" id="id_bayi"></td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>Nama Bayi</td>
                                            <td name="nama_bayi" id="nama_bayi"></td>
                                        </tr>
                                        <tr>
                                            <td>3.</td>
                                            <td>Berat Badan Lahir</td>
                                            <td name="berat_badan_lahir" id="berat_badan_lahir"></td>
                                        </tr>
                                        <tr>
                                            <td>4.</td>
                                            <td>Panjang Badan Lahir</td>
                                            <td name="panjang_badan_lahir" id="panjang_badan_lahir"></td>
                                        </tr>
                                        <tr>
                                            <td>5.</td>
                                            <td>Berat Badan Saat Ini</td>
                                            <td name="berat_badan" id="berat_badan"></td>
                                        </tr>
                                        <tr>
                                            <td>6.</td>
                                            <td>Panjang Badan Saat Ini</td>
                                            <td name="panjang_badan" id="panjang_badan"></td>
                                        </tr>
                                        <tr>
                                            <td>7.</td>
                                            <td>Diagnosa Medis</td>
                                            <td name="diagnosa_medis" id="diagnosa_medis"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="4">Data Tanda - Tanda Vital</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th>Deskripsi</th>
                                            <th style="width: 60%">Keterangan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td>Suhu Badan</td>
                                            <td name="suhu" id="suhu"></td>
                                            <td id="status_suhu"></td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>Pernapasan</td>
                                            <td name="pernapasan" id="pernapasan"></td>
                                            <td id="status_pernapasan"></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Heart Rate</td>
                                            <td name="heart_rate" id="heart_rate"></td>
                                            <td id="status_heart_rate"></td>
                                        </tr>
                                        <tr>
                                            <td>4.</td>
                                            <td>Saturasi Oksigen</td>
                                            <td name="saturasi_oksigen" id="saturasi_oksigen"></td>
                                            <td id="status_saturasi_oksigen"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="3">Data Hasil Laboratorium</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th>Deskripsi</th>
                                            <th style="width: 60%">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td>H2TL</td>
                                            <td name="h2tl" id="h2tl"></td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>CRP</td>
                                            <td name="crp" id="crp"></td>
                                        </tr>
                                        <tr>
                                            <td>3.</td>
                                            <td>Natrium</td>
                                            <td name="natrium" id="natrium"></td>
                                        </tr>
                                        <tr>
                                            <td>4.</td>
                                            <td>Kalium</td>
                                            <td name="kalium" id="kalium"></td>
                                        </tr>
                                        <tr>
                                            <td>5.</td>
                                            <td>Kalsium</td>
                                            <td name="kalsium" id="kalsium"></td>
                                        </tr>
                                        <tr>
                                            <td>6.</td>
                                            <td>AGD</td>
                                            <td name="agd" id="agd"></td>
                                        </tr>
                                        <tr>
                                            <td>7.</td>
                                            <td>Bilirubin Total</td>
                                            <td name="bilirubin_total" id="bilirubin_total"></td>
                                        </tr>
                                        <tr>
                                            <td>8.</td>
                                            <td>Bilirubin Total</td>
                                            <td name="bilirubin_total" id="bilirubin_total"></td>
                                        </tr>
                                        <tr>
                                            <td>9.</td>
                                            <td>Albumin</td>
                                            <td name="albumin" id="albumin"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" value="" name="id_perkembangan_bayi" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="id_bayi">Bayi</label>
                                    <select class="form-control" disabled name="id_bayi" id="id_bayi"
                                        style="width: 100%;" data-live-search="true">
                                        <option value="" selected disabled>Pilih Bayi</option>
                                        <?php
                                        foreach ($bayi as $b) { ?>
                                            <option value="<?= $b->id_bayi; ?>">
                                                <?= $b->id_bayi . ' - ' . $b->nama_bayi; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="berat_badan">Berat Badan (kg)</label>
                                    <input type="text" class="form-control" name="berat_badan" id="berat_badan"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="panjang_badan">Panjang Badan (cm)</label>
                                    <input type="text" class="form-control" name="panjang_badan" id="panjang_badan"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="diagnosa_medis">Diagnosa Medis</label>
                                    <textarea class="form-control" name="diagnosa_medis" id="diagnosa_medis" rows="5"
                                        style="resize: none;" disabled></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="suhu">Suhu Badan (36.5&#8451;-37.5&#8451;)</label>
                                    <input type="text" class="form-control" name="suhu" id="suhu" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="pernapasan">Pernapasan (40-60x/menit)</label>
                                    <input type="text" class="form-control" name="pernapasan" id="pernapasan" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="heart_rate">Heart Rate (130-140x/menit)</label>
                                    <input type="text" class="form-control" name="heart_rate" id="heart_rate" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="saturasi_oksigen">Saturasi Oksigen (>=92%)</label>
                                    <input type="text" class="form-control" name="saturasi_oksigen" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="h2tl">H2TL</label>
                                    <input type="text" class="form-control" name="h2tl" id="h2tl" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="crp">CRP</label>
                                    <input type="text" class="form-control" name="crp" id="crp" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="natrium">Natrium</label>
                                    <input type="text" class="form-control" name="natrium" id="natrium" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="kalium">Kalium</label>
                                    <input type="text" class="form-control" name="kalium" id="kalium" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="kalsium">Kalsium</label>
                                    <input type="text" class="form-control" name="kalsium" id="kalsium" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="agd">AGD</label>
                                    <input type="text" class="form-control" name="agd" id="agd" disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="bilirubin_total">Bilirubin Total</label>
                                    <input type="text" class="form-control" name="bilirubin_total" id="bilirubin_total"
                                        disabled>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="albumin">Albumin</label>
                                    <input type="text" class="form-control" name="albumin" id="albumin" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form> -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->