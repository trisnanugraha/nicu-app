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
                    <input type="hidden" value="" name="id_data_imei" />
                    <input type="hidden" value="" name="berkasFile" />
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