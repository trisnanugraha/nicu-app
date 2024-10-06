<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        // $this->load->model('Mod_orangtua');
        $this->load->model('Mod_user');
        $this->load->model('Mod_userlevel');
    }

    public function index($role)
    {
        $this->load->helper('url');
        if ($role == "Admin") {
            $data['judul'] = 'Manajemen Admin';
            $data['table'] = 'tabelAdmin';
            $data['role'] = 'Admin';
            $js = $this->load->view('user/admin-js', null, true);
        } else if ($role == 'Perawat') {
            $data['judul'] = 'Manajemen Perawat';
            $data['table'] = 'tabelPerawat';
            $data['role'] = 'Perawat';
            $js = $this->load->view('user/perawat-js', null, true);
        } else if ($role == 'Orang Tua') {
            $data['judul'] = 'Manajemen Orang Tua';
            $data['table'] = 'tabelOrangTua';
            $data['role'] = 'Orang Tua';
            $js = $this->load->view('user/orangtua-js', null, true);
        }
        $data['modal_data_user'] = show_my_modal('user/modal_data_user', $data);
        $this->template->views('user/home', $data, $js);
    }

    public function ajax_list($role)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);

        $id_role = $this->Mod_userlevel->getId($role)->id_level;

        $list = $this->Mod_user->get_datatables($id_role);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
            $no++;
            $row = array();
            if ($role != 'Orang Tua') {
                $row[] = $no;
                $row[] = $user->full_name;
                $row[] = $user->username;
                $row[] = $user->is_active;
                $row[] = $user->id_user;
            } else {
                $row[] = $user->id_orangtua;
                $row[] = $user->username;
                $row[] = $user->nama_ayah;
                $row[] = $user->nama_ibu;
                $row[] = $user->alamat;
                $row[] = $user->no_hp;
                $row[] = $user->is_active;
                $row[] = $user->id_user;
            }

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_user->count_all($id_role),
            "recordsFiltered" => $this->Mod_user->count_filtered($id_role),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function insert($role)
    {
        $this->_validate("insert", $role);

        // $level = $this->Mod_userlevel->getId("Admin");

        if ($role != 'Orang Tua') {
            $full_name = $this->input->post('full_name');
        } else {
            $full_name = "Orang Tua";
        }

        $save = array(
            'username' => $this->input->post('username'),
            'full_name' => $full_name,
            'password' => get_hash($this->input->post('password')),
            'id_level' => $this->Mod_userlevel->getId($role)->id_level,
            'is_active' => $this->input->post('is_active')
        );

        if ($role != 'Orang Tua') {
            $this->Mod_user->insert($save);
        } else {

            // Mengambil ID unik (misalnya dari database atau generator)
            $unikId = $this->generateUniqueId(); // Ganti dengan logika untuk menghasilkan Unik ID

            // Mengambil nomor urut terakhir dari database
            $nomorUrut = $this->getNextNumber();

            // Menggabungkan untuk membuat ID
            $parentId = "OT-" . $unikId . "-" . str_pad($nomorUrut, 5, '0', STR_PAD_LEFT);

            $get_id = $this->Mod_user->insert_orang_tua($save);

            $save = array(
                'id_orangtua' => $parentId,
                'id_user' => $get_id,
                'nama_ayah' => $this->input->post('nama_ayah'),
                'nama_ibu' => $this->input->post('nama_ibu'),
                'alamat' => $this->input->post('alamat'),
                'no_hp' => $this->input->post('no_hp'),
            );

            $this->Mod_user->insert_tbl_orang_tua($save);
        }

        echo json_encode(array("status" => TRUE));
    }

    public function viewuser()
    {
        $id = $this->input->post('id');
        $table = $this->input->post('table');
        $data['table'] = $table;
        $data['data_field'] = $this->db->field_data($table);
        $data['data_table'] = $this->Mod_user->view_user($id)->result_array();
        $this->load->view('admin/view', $data);
    }

    public function edit($id)
    {
        $data = $this->Mod_user->get_user($id);
        echo json_encode($data);
    }


    public function update()
    {
        $this->_validate("update");

        $id = $this->input->post('id_user');

        //Jika Password tidak kosong
        if ($this->input->post('password')) {
            $save = array(
                'username' => $this->input->post('username'),
                'full_name' => $this->input->post('full_name'),
                'password' => get_hash($this->input->post('password')),
                'is_active' => $this->input->post('is_active')
            );
        } else { //Jika password kosong
            $save = array(
                'username' => $this->input->post('username'),
                'full_name' => $this->input->post('full_name'),
                'is_active' => $this->input->post('is_active')
            );
        }

        $this->Mod_user->update($id, $save);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $this->Mod_user->delete($id);
        $data['status'] = TRUE;
        echo json_encode($data);
    }

    public function reset()
    {
        $id = $this->input->post('id');
        $data = array(
            'password' => get_hash('Secret@2024!')
        );
        $this->Mod_user->reset_pass($id, $data);
        $data['status'] = TRUE;
        echo json_encode($data);
    }

    public function setStatus()
    {
        $id = $this->input->post('id');

        if ($this->input->post('status') == 'N') {
            $status = 'Y';
        } else if ($this->input->post('status') == 'Y') {
            $status = 'N';
        }

        $data = array(
            'is_active' => $status
        );
        $this->Mod_user->update($id, $data);
        $data['status'] = TRUE;
        echo json_encode($data);
    }

    private function _validate($action, $role)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($role == 'Orang Tua') {
            if ($this->input->post('nama_ayah') == '') {
                $data['inputerror'][] = 'nama_ayah';
                $data['error_string'][] = 'Nama Ayah Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }

            if ($this->input->post('nama_ibu') == '') {
                $data['inputerror'][] = 'nama_ibu';
                $data['error_string'][] = 'Nama Ibu Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }

            if ($this->input->post('alamat') == '') {
                $data['inputerror'][] = 'alamat';
                $data['error_string'][] = 'Alamat Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }

            if ($this->input->post('no_hp') == '') {
                $data['inputerror'][] = 'no_hp';
                $data['error_string'][] = 'Nomor HP Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }
        } else {
            if ($this->input->post('full_name') == '') {
                $data['inputerror'][] = 'full_name';
                $data['error_string'][] = 'Nama Lengkap Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }
        }

        if ($this->input->post('username') == '') {
            $data['inputerror'][] = 'username';
            $data['error_string'][] = 'Username Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($action == "insert") {
            $username = $this->input->post('username');
            $user = $this->Mod_user->cekUsername($username);

            if ($user) {
                $data['inputerror'][] = 'username';
                $data['error_string'][] = 'Username Sudah Digunakan';
                $data['status'] = FALSE;
            }

        }

        if ($action == "update" && $this->input->post('username') != '') {
            $username = $this->input->post('username');
            $user = $this->Mod_user->cekUsername($username);

            if ($user && $user->username == $username && $user->id_user != $this->input->post('id_user')) {
                $data['inputerror'][] = 'username';
                $data['error_string'][] = 'Username Sudah Digunakan';
                $data['status'] = FALSE;
            }
        }


        if ($action == "insert") {
            if ($this->input->post('password') == '') {
                $data['inputerror'][] = 'password';
                $data['error_string'][] = 'Password Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }
        }

        if ($this->input->post('is_active') == '') {
            $data['inputerror'][] = 'is_active';
            $data['error_string'][] = 'Status Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }


        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function generateUniqueId()
    {
        // Misalnya, menghasilkan ID unik dengan menggunakan timestamp dan random
        return strtoupper(bin2hex(random_bytes(3))); // Contoh: 'A1B2C3'
    }

    private function getNextNumber()
    {
        // Ganti dengan logika untuk mendapatkan nomor urut terakhir dari database
        // Misalnya, ambil dari tabel dan ambil nomor urut terakhir
        $this->db->select('MAX(SUBSTRING_INDEX(id_orangtua, "-", -1)) as last_number');
        $query = $this->db->get('tbl_orang_tua'); // Ganti dengan nama tabel yang sesuai
        $result = $query->row();

        // Mengambil nomor urut terakhir
        $lastNumber = $result ? intval($result->last_number) : 0;

        return $lastNumber + 1; // Menambah 1 untuk nomor urut berikutnya
    }

}
