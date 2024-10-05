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
                        <label for="ruangan" class="col-sm-2 col-form-label">Ruangan</label>
                        <div class="col-sm-10 kosong">
                            <select class="form-control" name="ruangan" id="ruangan">
                                <option value="" selected disabled>Pilih Ruangan</option>
                                <?php
                                foreach ($ruangan as $r) { ?>
                                    <option value="<?= $r->id_ruangan; ?>">Lantai <?=$r->no_lantai; ?> - <?=$r->nama_ruangan; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tanggal" class="col-sm-2 col-form-label">Tanggal Acara</label>
                        <div class="input-group col-sm-10 kosong">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-clock"></i></span>
                            </div>
                            <input type="text" class="form-control float-right" id="reservationtime">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tambahan_kursi" class="col-sm-2 col-form-label">Tambahan Kursi</label>
                        <div class="col-sm-10 kosong">
                            <input type="number" class="form-control" name="tambahan_kursi" id="tambahan_kursi">
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