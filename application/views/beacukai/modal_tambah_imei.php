<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body form">
                <form action="#" id="form" class="form-horizontal">
                    <!-- <input type="hidden" value="" name="no_imei" /> -->
                    <div class="form-group row">
                        <label for="register" class="col-sm-3 col-form-label">Register</label>
                        <div class="col-sm-9 kosong">
                            <input type="text" class="form-control" name="register" id="register" readonly value="<?php echo $register; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nik" class="col-sm-3 col-form-label">NIK</label>
                        <div class="col-sm-9 kosong">
                            <input type="text" class="form-control" name="nik" id="nik">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_passport" class="col-sm-3 col-form-label">No. Passport</label>
                        <div class="col-sm-9 kosong">
                            <input type="text" class="form-control" name="no_passport" id="no_passport">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_imei" class="col-sm-3 col-form-label">IMEI</label>
                        <div class="col-sm-9 kosong">
                            <input type="text" class="form-control" name="no_imei" id="no_imei">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_penerbangan" class="col-sm-3 col-form-label">No. Penerbangan</label>
                        <div class="col-sm-9 kosong">
                            <input type="text" class="form-control" name="no_penerbangan" id="no_penerbangan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipe_hp" class="col-sm-3 col-form-label">Tipe HP</label>
                        <div class="col-sm-9 kosong">
                            <input type="text" class="form-control" name="tipe_hp" id="tipe_hp">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="model_hp" class="col-sm-3 col-form-label">Model HP</label>
                        <div class="col-sm-9 kosong">
                            <input type="text" class="form-control" name="model_hp" id="model_hp">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                <button type="button" id="btnCancel" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->