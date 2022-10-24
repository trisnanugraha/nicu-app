<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-3">

        <div class="card card-primary card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle" style="height: 200px; width: auto;" src="<?php site_url(); ?>/assets/foto/user/<?php echo $profil->pass_foto; ?>" alt="User profile picture">
            </div>
            <br>
            <h3 class="profile-username text-center"><?php echo $profil->full_name; ?></h3>
            <p class="text-muted text-center"><?php echo $profil->nim_nrp; ?></p>
          </div>
        </div>
      </div>

      <div class="col-md-9">
        <div class="card">
          <div class="card-header p-2">
            <ul class="nav nav-pills">
              <li class="nav-item"><a class="nav-link active" href="#biodata" data-toggle="tab">Biodata</a></li>
              <li class="nav-item"><a class="nav-link" href="#ubah_data" data-toggle="tab">Ubah Data</a></li>
              <li class="nav-item"><a class="nav-link" href="#ubah_password" data-toggle="tab">Ubah Password</a></li>
            </ul>
          </div>
          <div class="card-body">
            <div class="tab-content">
              <div class="tab-pane active" id="biodata">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                      <td><b>Status Mahasiswa</b></td>
                      <td><?php if ($profil->is_active == 'Y') { ?>
                          <div class="badge bg-success text-white text-wrap">Aktif</div>
                        <?php } else { ?>
                          <div class="badge bg-warning text-white text-wrap">Tidak Aktif</div>
                        <?php } ?>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Nama Lengkap</b></td>
                      <td>
                        <?php echo $profil->full_name; ?>
                      </td>
                    </tr>
                    <tr>
                      <td><b>NIM</b></td>
                      <td><?php echo $profil->nim_nrp; ?></td>
                    </tr>
                    <tr>
                      <td><b>Tahun Angkatan</b></td>
                      <td>
                        <?php echo $profil->tahun_angkatan; ?>
                      </td>
                    </tr>
                    <tr>
                      <td><b>Kelas</b></td>
                      <td><?php echo $profil->kelas; ?></td>
                    </tr>
                    <tr>
                      <td><b>Sindikat</b></td>
                      <td><?php echo $profil->sindikat; ?></td>
                    </tr>
                    <tr>
                      <td><b>Email</b></td>
                      <td><?php echo $profil->email; ?></td>
                    </tr>
                    <tr>
                      <td><b>No. HP</b></td>
                      <td><?php echo $profil->no_hp; ?></td>
                    </tr>
                    <tr>
                      <td><b>Alamat</b></td>
                      <td><?php echo $profil->alamat; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="tab-pane" id="ubah_data">
                <form class="form-horizontal" action="#" id="form_profil">
                  <input type="hidden" value="<?php echo $profil->id_user; ?>" name="id" />
                  <div class="form-group">
                    <label for="email" class="col-form-label">Email<span style="color: red;">*</span></label>
                    <div class="kosong">
                      <input type="email" class="form-control" id="email" name="email" placeholder="Contoh : johndoe@email.com" value="<?php echo $profil->email; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="no_hp" class="col-form-label">No. HP<span style="color: red;">*</span></label>
                    <div class="kosong">
                      <input type="text" class="form-control" id="no_hp" name="no_hp" placeholder="Contoh : 08123456789" value="<?php echo $profil->no_hp; ?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="alamat" class="col-form-label">Alamat<span style="color: red;">*</span></label>
                    <div class="kosong">
                      <textarea class="form-control" id="alamat" name="alamat" placeholder="Contoh : Jl. Merdeka 123"><?php echo $profil->alamat; ?></textarea>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="imagefile" class="col-form-label">Pass Foto<span style="color: red;">*</span></label>
                    <div class="">
                      <img id="v_image" height="150px" style="margin-bottom: 10px;" src="<?php site_url(); ?>/assets/foto/user/<?php echo $profil->pass_foto; ?>">
                      <input type="file" class="form-control btn-file" onchange="loadFile(event)" name="imagefile" id="imagefile" placeholder="Image" value="UPLOAD">
                    </div>
                  </div>
                </form>
                <div>
                  <button type="button" onclick="simpan()" id="btn_simpan" class="btn btn-success">Simpan</button>
                </div>
              </div>
              <div class="tab-pane" id="ubah_password">
                <form class="form-horizontal" action="#" id="form_password">
                  <input type="hidden" value="<?php echo $profil->id_user; ?>" name="id" />
                  <div class="form-group">
                    <label for="password_lama" class="col-form-label">Masukkan Password Lama<span style="color: red;">*</span></label>
                    <div class="kosong">
                      <input type="password" class="form-control" id="password_lama" name="password_lama">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="password_baru" class="col-form-label">Masukkan Password Baru<span style="color: red;">*</span></label>
                    <div class="kosong">
                      <input type="password" class="form-control" id="password_baru" name="password_baru">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="verify_pass" class="col-form-label">Verifikasi Password Baru<span style="color: red;">*</span></label>
                    <div class="kosong">
                      <input type="password" class="form-control" id="verify_pass" name="verify_pass">
                    </div>
                  </div>
                </form>
                <div>
                  <button type="button" onclick="simpan_pass()" id="btn_simpan_pass" class="btn btn-success">Simpan</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>