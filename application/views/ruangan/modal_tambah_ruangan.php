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
                <input type="hidden" value="" name="id_ruangan" />
                    <div class="form-group row">
                        <label for="nama_ruangan" class="col-sm-2 col-form-label">Nama Ruangan</label>
                        <div class="col-sm-10 kosong">
                            <input type="text" class="form-control" name="nama_ruangan" id="nama_ruangan">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_lantai" class="col-sm-2 col-form-label">Nomor Lantai</label>
                        <div class="col-sm-10 kosong">
                            <input type="number" class="form-control" name="no_lantai" id="no_lantai">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="kapasitas" class="col-sm-2 col-form-label">Kapasitas</label>
                        <div class="col-sm-10 kosong">
                            <input type="number" class="form-control" name="kapasitas" id="kapasitas">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10 kosong">
                            <select class="form-control" name="status" id="status">
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
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