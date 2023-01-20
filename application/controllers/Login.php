<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Mod_login', 'Mod_userlevel'));
    }

    public function index()
    {
        $logged_in = $this->session->userdata('logged_in');
        if ($logged_in == TRUE) {
            if ($this->session->userdata('id_level') == 1) {
                redirect('dashboard');
            } else {
                redirect('data-imei');
            }
        } else {
            $aplikasi['aplikasi'] = $this->Mod_login->Aplikasi()->row();
            $this->load->view('admin/login_data', $aplikasi);
        }
    } //end function index

    function login()
    {

        $this->_validate();
        //cek username database
        $username = anti_injection($this->input->post('username'));
        $status = $this->Mod_login->check_status($username);

        if ($this->Mod_login->check_db($username)->num_rows() == 1) {
            if ($status->is_active != 'N') {
                $db = $this->Mod_login->check_db($username)->row();
                $apl = $this->Mod_login->Aplikasi()->row();

                if (hash_verified(anti_injection($this->input->post('password')), $db->password)) {
                    //cek username dan password yg ada di database
                    $userdata = array(
                        'id_user'  => $db->id_user,
                        'username'    => ucfirst($db->username),
                        'user_name'    => $db->username,
                        'full_name'   => ucfirst($db->full_name),
                        'password'    => $db->password,
                        'id_level'    => $db->id_level,
                        'aplikasi'    => $apl->nama_aplikasi,
                        'title'       => $apl->title,
                        'logo'        => $apl->logo,
                        'nama_owner'     => $apl->nama_owner,
                        'logged_in'    => TRUE,
                        'hak_akses' => ''
                    );

                    $this->session->set_userdata($userdata);

                    $checklevel = $this->_cek_status($userdata['id_level']);

                    if ($checklevel == 'Admin') {
                        helper_log("login", "Berhasil Masuk Ke Sistem", $db->username);
                        $data['url'] = 'dashboard';
                        $userdata['hak_akses'] = 'Admin';
                    } else if ($checklevel == 'Manufaktur') {
                        helper_log("login", "Berhasil Masuk Ke Sistem", $db->username);
                        $data['url'] = 'data-imei';
                        $userdata['hak_akses'] = 'Manufaktur';
                    } else {
                        helper_log("login", "Berhasil Masuk Ke Sistem", $db->username);
                        $data['url'] = 'daftar-imei';
                        // $userdata['hak_akses'] = 'Manufaktur';
                    }
                    // $this->fungsi->send_bot($db->username, "Berhasil Masuk Ke Sistem", "LOGIN");
                    $data['status'] = TRUE;
                    echo json_encode($data);
                } else {
                    $data['pesan'] = "Username atau Password Salah!";
                    $data['error'] = TRUE;
                    // $this->fungsi->send_bot($username, "Gagal Masuk Ke Sistem", "LOGIN");
                    helper_log("login", " Gagal Masuk Ke Sistem", $username);
                    echo json_encode($data);
                }
            } else {
                $data['pesan'] = "Akun Anda belum aktif, silakan hubungi Administrator";
                $data['error'] = TRUE;
                // $this->fungsi->send_bot($username, " Gagal Masuk Ke Sistem (User Belum Diaktivasi)", "LOGIN");
                helper_log("login", $username . " Gagal Masuk Ke Sistem (User Belum Diaktivasi)");
                echo json_encode($data);
            }
        } else {
            $data['pesan'] = "Username atau Password belum terdaftar!";
            $data['error'] = TRUE;
            // $this->fungsi->send_bot($username, " Gagal Masuk Ke Sistem (User Tidak Terdaftar)", "LOGIN");
            helper_log("login", $username . " Gagal Masuk Ke Sistem (User Tidak Terdaftar)");
            echo json_encode($data);
        }
    }

    public function logout()
    {
        // $this->fungsi->send_bot($this->session->userdata['username'], " Berhasil Keluar Dari Sistem", "LOGOUT");
        helper_log("logout", " Berhasil Keluar Dari Sistem", $this->session->userdata['username']);
        $this->session->sess_destroy();
        $this->load->driver('cache');
        $this->cache->clean();
        ob_clean();
        redirect('login');
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('username') == '') {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'Username Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('password') == '') {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function _cek_status($id_level)
    {
        $nama_level = $this->Mod_userlevel->getUserlevel($id_level);
        return $nama_level->nama_level;
    }
}

/* End of file Login.php */
