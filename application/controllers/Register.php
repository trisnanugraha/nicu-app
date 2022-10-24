<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_kelas');
        $this->load->model('Mod_sindikat');
        $this->load->model('Mod_jabatan');
        $this->load->model('Mod_angkatan');
        $this->load->model('Mod_user');
        $this->load->model('Mod_userlevel');
        $this->load->model('Mod_aktivasi_user');
        $this->load->model(array('Mod_login'));
    }

    public function index()
    {
        $data['aplikasi'] = $this->Mod_login->Aplikasi()->row();
        $data['user_level'] = $this->Mod_user->userlevelRegister();
        $data['kelas'] = $this->Mod_kelas->get_all_kelas();
        $data['sindikat'] = $this->Mod_sindikat->get_all_sindikat();
        $data['jabatan'] = $this->Mod_jabatan->get_all_jabatan();
        $data['angkatan'] = $this->Mod_angkatan->get_all_angkatan();
        $this->load->view('admin/register', $data);
    }

    function signup()
    {
        $this->_validate();

        $checklevel = $this->Mod_userlevel->getUserlevel($this->input->post('level'));
        if ($checklevel->nama_level != 'Mahasiswa') {
            $save  = array(
                'username' => $this->input->post('username'),
                'nim_nrp' => $this->input->post('username'),
                'full_name' => $this->input->post('fullname'),
                'password'  => get_hash($this->input->post('password')),
                'id_angkatan'  => 5,
                'id_kelas'  => 4,
                'id_sindikat'  => 8,
                'id_jabatan'  => $this->input->post('jabatan'),
                'id_level'  => $this->input->post('level'),
                'is_active' => 'N'
            );
        } else {
            $save  = array(
                'nim_nrp' => $this->input->post('username'),
                'username' => $this->input->post('username'),
                'full_name' => $this->input->post('fullname'),
                'password'  => get_hash($this->input->post('password')),
                'id_angkatan'  => $this->input->post('angkatan'),
                'id_kelas'  => $this->input->post('kelas'),
                'id_sindikat'  => $this->input->post('sindikat'),
                'id_jabatan'  => 8,
                'id_level'  => $this->input->post('level'),
                'is_active' => 'N'
            );
        }

        $id = $this->Mod_user->insert_new_user($save);

        $pending = array(
            'id_user' => $id
        );

        $this->Mod_aktivasi_user->insert($pending);
        $this->fungsi->send_bot($this->input->post('username'), " Berhasil Melakukan Registrasi (Harap Segera Dilakukan Aktivasi Akun)", "REGISTER");
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        $rules = [
            [
                'field' => 'fullname',
                'label' => 'Nama Lengkap',
                'rules' => 'trim|required|alpha|max_length[50]'
            ],
            [
                'field' => 'username',
                'label' => 'NIM / NRP',
                'rules' => 'trim|required|numeric|max_length[20]|is_unique[tbl_user.nim_nrp]'
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required|min_length[5]|max_length[20]'
            ],
            [
                'field' => 'verifypassword',
                'label' => 'Verifikasi Password',
                'rules' => 'trim|required|min_length[5]|max_length[20]|matches[password]'
            ],
            [
                'field' => 'level',
                'label' => 'Hak Akses',
                'rules' => 'trim|required'
            ]
        ];

        $rules_mahasiswa = [
            [
                'field' => 'angkatan',
                'label' => 'Angkatan',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'kelas',
                'label' => 'Kelas',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'sindikat',
                'label' => 'Sindikat',
                'rules' => 'trim|required'
            ]
        ];

        $rules_staff = [
            [
                'field' => 'jabatan',
                'label' => 'Jabatan',
                'rules' => 'trim|required'
            ]
        ];

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_message('required', '{field} Harus Diisi');
        $this->form_validation->set_message('alpha', '{field} Hanya Berupa Huruf');
        $this->form_validation->set_message('numeric', '{field} Hanya Berupa Angka');
        $this->form_validation->set_message('min_length', '{field} Minimal 5 Karakter');
        $this->form_validation->set_message('max_length', '{field} Maksimal 20 Karakter');
        $this->form_validation->set_message('is_unique', '{field} Tidak Tersedia');
        $this->form_validation->set_message('matches', '{field} Harus Sama Dengan Password');
        // $this->form_validation->set_message('valid_email', 'Format {field} Tidak Valid');

        foreach ($rules as $index) {
            if (!$this->form_validation->run($index['field'])) {
                $data['inputerror'][] = $index['field'];
                $data['error_string'][] = form_error($index['field']);
                $data['status'] = FALSE;
            }
        }

        if ($this->input->post('level') != '') {

            $checklevel = $this->Mod_userlevel->getUserlevel($this->input->post('level'));

            if ($checklevel->nama_level == 'Mahasiswa') {
                $this->form_validation->set_rules($rules_mahasiswa);
                foreach ($rules_mahasiswa as $index) {
                    if (!$this->form_validation->run($index['field'])) {
                        $data['inputerror'][] = $index['field'];
                        $data['error_string'][] = form_error($index['field']);
                        $data['status'] = FALSE;
                    }
                }
            } else {
                $this->form_validation->set_rules($rules_staff);
                foreach ($rules_staff as $index) {
                    if (!$this->form_validation->run($index['field'])) {
                        $data['inputerror'][] = $index['field'];
                        $data['error_string'][] = form_error($index['field']);
                        $data['status'] = FALSE;
                    }
                }
            }
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Register.php */
