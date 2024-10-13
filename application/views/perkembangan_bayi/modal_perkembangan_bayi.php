<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static">
    <div class="modal-xl modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form Bayi</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" value="" name="id_perkembangan_bayi" />
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="id_bayi">Bayi</label>
                                    <select class="form-control" name="id_bayi" id="id_bayi" style="width: 100%;"
                                        data-live-search="true">
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
                                        placeholder="Tanda Titik Sebagai Koma. contoh : 4.3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="panjang_badan">Panjang Badan (cm)</label>
                                    <input type="text" class="form-control" name="panjang_badan" id="panjang_badan"
                                        placeholder="Tanda Titik Sebagai Koma. contoh : 4.3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="diagnosa_medis">Diagnosa Medis</label>
                                    <textarea class="form-control" name="diagnosa_medis" id="diagnosa_medis" rows="5"
                                        style="resize: none;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="suhu">Suhu Badan (36.5&#8451;-37.5&#8451;)</label>
                                    <input type="text" class="form-control" name="suhu" id="suhu"
                                        placeholder="Tanda Titik Sebagai Koma. contoh : 4.3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="pernapasan">Pernapasan (40-60x/menit)</label>
                                    <input type="text" class="form-control" name="pernapasan" id="pernapasan"
                                        placeholder="Tanda Titik Sebagai Koma. contoh : 4.3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="heart_rate">Heart Rate (130-140x/menit)</label>
                                    <input type="text" class="form-control" name="heart_rate" id="heart_rate"
                                        placeholder="Tanda Titik Sebagai Koma. contoh : 4.3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="saturasi_oksigen">Saturasi Oksigen (>=92%)</label>
                                    <input type="text" class="form-control" name="saturasi_oksigen"
                                        id="saturasi_oksigen" placeholder="Tanda Titik Sebagai Koma. contoh : 4.3">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="h2tl">H2TL</label>
                                    <input type="text" class="form-control" name="h2tl"
                                        id="h2tl" placeholder="Tanda Titik Sebagai Koma. contoh : 4.3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="crp">CRP</label>
                                    <input type="text" class="form-control" name="crp"
                                        id="crp" placeholder="Tanda Titik Sebagai Koma. contoh : 4.3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="natrium">Natrium</label>
                                    <input type="text" class="form-control" name="natrium"
                                        id="natrium" placeholder="Tanda Titik Sebagai Koma. contoh : 4.3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="kalium">Kalium</label>
                                    <input type="text" class="form-control" name="kalium"
                                        id="kalium" placeholder="Tanda Titik Sebagai Koma. contoh : 4.3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="kalsium">Kalsium</label>
                                    <input type="text" class="form-control" name="kalsium"
                                        id="kalsium" placeholder="Tanda Titik Sebagai Koma. contoh : 4.3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="agd">AGD</label>
                                    <input type="text" class="form-control" name="agd"
                                        id="agd" placeholder="Tanda Titik Sebagai Koma. contoh : 4.3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="bilirubin_total">Bilirubin Total</label>
                                    <input type="text" class="form-control" name="bilirubin_total"
                                        id="bilirubin_total" placeholder="Tanda Titik Sebagai Koma. contoh : 4.3">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12 kosong">
                                    <label for="albumin">Albumin</label>
                                    <input type="text" class="form-control" name="albumin"
                                        id="albumin" placeholder="Tanda Titik Sebagai Koma. contoh : 4.3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" class="btn btn-danger" onclick="batal()" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->