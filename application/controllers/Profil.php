<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_user');
        $this->load->model('Mod_angkatan');
        $this->load->model('Mod_kelas');
        $this->load->model('Mod_sindikat');
        $this->load->model('Mod_log');
    }

    function index()
    {
        $data['judul'] = 'Profil';
        // $data['role'] = $this->session->userdata('role');
        $data['profil'] = $this->Mod_user->get_user($this->session->userdata('id_user'));

        if ($data['profil']->pass_foto == NULL) {
            $data['profil']->pass_foto = 'default.png';
        }

        $tahun_angkatan = $this->Mod_angkatan->get_angkatan($data['profil']->id_angkatan);
        $data['profil']->tahun_angkatan = $tahun_angkatan->nama_angkatan;

        $kelas = $this->Mod_kelas->get_kelas($data['profil']->id_kelas);
        $data['profil']->kelas = $kelas->nama_kelas;

        $sindikat = $this->Mod_sindikat->get_sindikat($data['profil']->id_sindikat);
        $data['profil']->sindikat = $sindikat->nama_sindikat;


        $js = $this->load->view('profil/profil-js', null, true);
        $this->template->views('profil/home', $data, $js);
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id');

        $post = $this->input->post();
        $id = $this->session->userdata['id_user'];
        $format = "%d-%M-%Y--%H-%i";
        if (!empty($_FILES['imagefile']['name'])) {
            $config['upload_path']   = './assets/foto/user';
            $config['allowed_types'] = 'gif|jpg|jpeg|png'; //mencegah upload backdor
            $config['max_size']      = '10240';
            $config['max_width']     = '10240';
            $config['max_height']    = '10240';
            $config['file_name']     = 'pass_foto_' . $id;

            $this->upload->initialize($config);
            if ($this->upload->do_upload('imagefile')) {

                $gambar = $this->upload->data();

                $this->email = $post['email'];
                $this->no_hp = $post['no_hp'];
                $this->alamat = $post['alamat'];
                $this->pass_foto = $gambar['file_name'];

                $temp = $this->Mod_user->get_pass_foto($id)->row_array();

                if ($temp['pass_foto'] != null) {
                    //hapus gambar yg ada diserver
                    unlink('./assets/foto/user/' . $temp['pass_foto']);
                }

                $this->Mod_user->update($id, $this);
                helper_log("edit", "Berhasil Mengubah Data Diri", $this->session->userdata['username']);
                echo json_encode(array("status" => TRUE));
            }
        } else {

            $this->email = $post['email'];
            $this->no_hp = $post['no_hp'];
            $this->alamat = $post['alamat'];

            $this->Mod_user->update($id, $this);
            helper_log("edit", "Berhasil Mengubah Data Diri", $this->session->userdata['username']);
            echo json_encode(array("status" => TRUE));
        }
    }

    public function update_pass()
    {
        $this->_validate_pass();
        $id = $this->input->post('id');
        $db = $this->Mod_user->get_user($this->input->post('id'));

        if ($this->input->post('password_lama') != null) {
            if (hash_verified(anti_injection($this->input->post('password_lama')), $db->password)) {
                $this->password = get_hash($this->input->post('password_baru'));

                $this->Mod_user->update($id, $this);
                helper_log("edit", "Berhasil Mengubah Password", $this->session->userdata['username']);
                echo json_encode(array("status" => TRUE));
            } else {
                $data['inputerror'][] = 'password_lama';
                $data['error_string'][] = 'Password Lama Anda Salah';
                $data['status'] = FALSE;
                helper_log("edit", "Gagal Mengubah Password", $this->session->userdata['username']);
                echo json_encode($data);
                exit();
            }
        }
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('email') == '') {
            $data['inputerror'][] = 'email';
            $data['error_string'][] = 'Email Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('no_hp') == '') {
            $data['inputerror'][] = 'no_hp';
            $data['error_string'][] = 'No. HP Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('alamat') == '') {
            $data['inputerror'][] = 'alamat';
            $data['error_string'][] = 'Alamat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function _validate_pass()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('password_lama') == '') {
            $data['inputerror'][] = 'password_lama';
            $data['error_string'][] = 'Password Lama Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('password_baru') == '') {
            $data['inputerror'][] = 'password_baru';
            $data['error_string'][] = 'Password Baru Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('verify_pass') == '') {
            $data['inputerror'][] = 'verify_pass';
            $data['error_string'][] = 'Verifikasi Password Baru Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('password_baru') != $this->input->post('verify_pass')) {
            $data['inputerror'][] = 'password_baru';
            $data['error_string'][] = 'Password Baru Tidak Cocok Dengan Verifikasi Password Baru';
            $data['status'] = FALSE;
        }

        if ($this->input->post('verify_pass') != $this->input->post('password_baru')) {
            $data['inputerror'][] = 'verify_pass';
            $data['error_string'][] = 'Verifikasi Password Baru Tidak Cocok Dengan Password Baru';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
/* End of file Profil.php */
