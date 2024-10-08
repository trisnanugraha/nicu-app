<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form Bayi</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" value="" name="id_bayi" />
                <div class="card-body">
                    <div class="form-group row ">
                        <label for="id_orangtua" class="col-sm-4 col-form-label">Orang Tua</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="id_orangtua" id="id_orangtua"
                                style="width: 100%;" data-live-search="true">
                                <option value="" selected disabled>Pilih Orang Tua</option>
                                <?php
                                foreach ($orangtua as $ot) { ?>
                                    <option value="<?= $ot->id_orangtua; ?>">
                                        <?= $ot->id_orangtua . ' - ' . $ot->nama_ibu; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="nama_bayi" class="col-sm-4 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-8 kosong">
                            <input type="text" class="form-control" name="nama_bayi" id="nama_bayi"
                                placeholder="contoh : johndoe">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="jenis_kelamin" class="col-sm-4 col-form-label">Jenis Kelamin</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="jenis_kelamin" id="jenis_kelamin">
                                <option value="" selected disabled>Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tgl_lahir" class="col-sm-4 col-form-label">Tanggal Lahir</label>
                        <div class="col-sm-8 kosong">
                            <input type="text" class="form-control" id="tgl_lahir" name="tgl_lahir"
                                data-toggle="datetimepicker" data-target="#tgl_lahir" />
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