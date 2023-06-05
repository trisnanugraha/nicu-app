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
                    <input type="hidden" value="" name="id_faq" />
                    <div class="form-group row">
                        <label for="pertanyaan" class="col-sm-2 col-form-label">Pertanyaan</label>
                        <div class="col-sm-10 kosong">
                            <textarea class="form-control" name="pertanyaan" id="pertanyaan" rows="10" style="resize: none;"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="respon" class="col-sm-2 col-form-label">Respon</label>
                        <div class="col-sm-10 kosong">
                            <textarea class="form-control" name="respon" id="respon" rows="10" style="resize: none;"></textarea>
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