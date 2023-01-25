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
                        <label for="provider" class="col-sm-2 col-form-label">Provider</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="provider" id="provider" readonly value="<?php echo $provider; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_imei" class="col-sm-2 col-form-label">IMEI</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="no_imei" id="no_imei">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_passport" class="col-sm-2 col-form-label">No. Passport</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="no_passport" id="no_passport">
                        </div>
                    </div>
                    <!-- <div class="form-group row">
                        <label for="created_at" class="col-sm-2 col-form-label">Tanggal Registrasi</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="no_model" id="no_model">
                        </div>
                    </div> -->
                    <div class="form-group row">
                        <label for="expired_date" class="col-sm-2 col-form-label">Masa Aktif</label>
                        <div class="col-sm-10 kosong">
                            <select class="form-control" name="expired_date" id="expired_date">
                                <option value="" selected disabled>Pilih Masa Aktif</option>
                                <option value="1">1 Bulan</option>
                                <option value="3">3 Bulan</option>
                                <option value="6">6 Bulan</option>
                                <option value="12">12 Bulan</option>
                            </select>
                        </div>
                    </div>
                    <!-- <input type="hidden" value="" name="berkasFile" />
                    <div class="form-group row">
                        <label for="fileImei" class="col-sm-2 col-form-label">File</label>
                        <div class="input-group col-sm-10 kosong">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" onchange="loadFile(event)" name="fileImei" id="fileImei">
                                <label class="custom-file-label" id="label-file" for="fileImei">Pilih File</label>
                            </div>
                            <div class="input-group-append">
                                <a class="btn btn-block bg-gradient-info" id="view_file" href="" target="_blank">Preview</a>
                            </div>
                        </div>
                    </div> -->
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