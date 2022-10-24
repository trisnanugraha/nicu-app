<!-- Bootstrap modal -->
<div class="modal fade" id="modal_validasi" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <div class="modal-body form">
                <form action="#" id="form_validasi" class="form-horizontal">
                    <input type="hidden" value="" name="id_ibl" id="id_ibl" />
                    <?php
                    if ($level == 'Staff Korwa') { ?>
                        <div class="form-group row ">
                            <label for="status_staff" class="col-sm-3 col-form-label">Validasi Staff Korwa</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="status_staff" id="status_staff">
                                    <option value="Diproses">Diproses</option>
                                    <option value="Butuh Perbaikan">Butuh Perbaikan</option>
                                    <option value="Disetujui">Disetujui</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan_staff" class="col-sm-3 col-form-label">Catatan Staff Korwa</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="catatan_staff" id="catatan_staff" rows="2" style="resize: none;"></textarea>
                            </div>
                        </div>
                    <?php }
                    ?>
                    <?php
                    if ($level == 'Kakorwa') { ?>
                        <div class="form-group row ">
                            <label for="status_kakorwa" class="col-sm-3 col-form-label">Validasi Kakorwa</label>
                            <div class="col-sm-9">
                                <select class="form-control validasi_kakorwa" name="status_kakorwa" id="status_kakorwa">
                                    <option value="Diproses">Diproses</option>
                                    <option value="Butuh Perbaikan">Butuh Perbaikan</option>
                                    <option value="Disetujui">Disetujui</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="catatan_kakorwa" class="col-sm-3 col-form-label">Keterangan Kakorwa</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" name="catatan_kakorwa" id="catatan_kakorwa" rows="2" style="resize: none;"></textarea>
                            </div>
                        </div>
                    <?php }
                    ?>
                </form>
            </div>
            <div class="modal-footer">
                <div class="text-right">
                    <button type="button" id="btnSave" onclick="save()" class="btn btn-primary">Simpan</button>
                    <button class="btn btn-outline-secondary" onclick="tutup()" data-dismiss="modal"> Tutup</button>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- End Bootstrap modal -->