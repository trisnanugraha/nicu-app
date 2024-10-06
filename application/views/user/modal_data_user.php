<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Form User</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>

            </div>
            <form action="#" id="form" class="form-horizontal" enctype="multipart/form-data">
                <input type="hidden" value="" name="id_user" />
                <div class="card-body">
                    <div class="form-group row ">
                        <label for="username" class="col-sm-4 col-form-label">Username</label>
                        <div class="col-sm-8 kosong">
                            <input type="text" class="form-control" name="username" id="username"
                                placeholder="contoh : johndoe">
                        </div>
                    </div>

                    <?php if ($role == "Orang Tua") { ?>
                        <div class="form-group row ">
                            <label for="nama_ayah" class="col-sm-4 col-form-label">Nama Ayah</label>
                            <div class="col-sm-8 kosong">
                                <input type="text" class="form-control" name="nama_ayah" id="nama_ayah"
                                    placeholder="contoh : John Doe">
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="nama_ibu" class="col-sm-4 col-form-label">Nama Ibu</label>
                            <div class="col-sm-8 kosong">
                                <input type="text" class="form-control" name="nama_ibu" id="nama_ibu"
                                    placeholder="contoh : Jane Doe">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-sm-4 col-form-label">Alamat</label>
                            <div class="col-sm-8 kosong">
                                <textarea class="form-control" name="alamat" id="alamat" rows="5"
                                    style="resize: none;"></textarea>
                            </div>
                        </div>
                        <div class="form-group row ">
                            <label for="no_hp" class="col-sm-4 col-form-label">Nomor HP</label>
                            <div class="col-sm-8 kosong">
                                <input type="text" class="form-control" name="no_hp" id="no_hp"
                                    placeholder="contoh : 08123456789">
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="form-group row ">
                            <label for="full_name" class="col-sm-4 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-8 kosong">
                                <input type="text" class="form-control" name="full_name" id="full_name"
                                    placeholder="contoh : John Doe">
                            </div>
                        </div>
                    <?php } ?>

                    <div class="form-group row ">
                        <label for="password" class="col-sm-4 col-form-label">Password</label>
                        <div class="col-sm-8 kosong">
                            <input type="password" class="form-control " name="password" id="password">
                        </div>
                    </div>
                    <div class="form-group row ">
                        <label for="is_active" class="col-sm-4 col-form-label">Status</label>
                        <div class="col-sm-8 kosong">
                            <select class="form-control" name="is_active" id="is_active">
                                <option value="" selected disabled>Pilih Status</option>
                                <option value="Y">Aktif</option>
                                <option value="N">Non-Aktif</option>
                            </select>
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