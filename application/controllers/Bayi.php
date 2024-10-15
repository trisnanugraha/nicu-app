<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bayi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_user');
        $this->load->model('Mod_userlevel');
        $this->load->model('Mod_bayi');
    }

    public function index($role)
    {
        $this->load->helper('url');

        $data['orangtua'] = $this->Mod_user->get_all_orangtua();

        if ($role == "Admin") {
            $data['judul'] = 'Manajemen Admin';
            $data['table'] = 'tabelAdmin';
            $data['role'] = 'Admin';
            $js = $this->load->view('user/admin-js', null, true);
        } else if ($role == 'Perawat') {
            $data['judul'] = 'Manajemen Bayi';
            $data['table'] = 'tabelBayi';
            $data['role'] = 'Perawat';
            $js = $this->load->view('bayi/bayi-js', null, true);
        } else if ($role == 'Orang Tua') {
            $data['judul'] = 'Manajemen Orang Tua';
            $data['table'] = 'tabelOrangTua';
            $data['role'] = 'Orang Tua';
            $js = $this->load->view('user/orangtua-js', null, true);
        }
        $data['modal_data_bayi'] = show_my_modal('bayi/modal_data_bayi', $data);
        $this->template->views('bayi/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);

        $list = $this->Mod_bayi->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $bayi) {
            $no++;
            $row = array();
            $row[] = $bayi->id_bayi;
            $row[] = $bayi->id_orangtua;
            $row[] = $bayi->nama_bayi;
            $row[] = ($bayi->jenis_kelamin === 'L') ? 'Laki-laki' : 'Perempuan';
            $row[] = format_tanggal($bayi->tgl_lahir);
            $row[] = $bayi->berat_badan . ' KG';
            $row[] = $bayi->panjang_badan . ' CM';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_bayi->count_all(),
            "recordsFiltered" => $this->Mod_bayi->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function insert()
    {
        $this->_validate();

        // Mengambil ID unik (misalnya dari database atau generator)
        $unikId = $this->generateUniqueId(); // Ganti dengan logika untuk menghasilkan Unik ID

        // Mengambil nomor urut terakhir dari database
        $nomorUrut = $this->getNextNumber();

        // Menggabungkan untuk membuat ID
        $idBayi = "B-" . $unikId . "-" . str_pad($nomorUrut, 5, '0', STR_PAD_LEFT);

        $save = array(
            'id_bayi' => $idBayi,
            'id_orangtua' => $this->input->post('id_orangtua'),
            'nama_bayi' => $this->input->post('nama_bayi'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'tgl_lahir' => $this->format_tanggal($this->input->post('tgl_lahir')),
            'berat_badan' => $this->input->post('berat_badan'),
            'panjang_badan' => $this->input->post('panjang_badan'),
            'dibuat_oleh' => $this->session->userdata('id_user')
        );

        $this->Mod_bayi->insert($save);

        echo json_encode(array("status" => TRUE));
    }

    public function edit($id)
    {
        $data = $this->Mod_bayi->get_bayi($id);
        $data->tgl_lahir = $this->format_tanggal_edit($data->tgl_lahir);

        echo json_encode($data);
    }


    public function update()
    {
        $this->_validate();

        $id = $this->input->post('id_bayi');

        $save = array(
            'id_orangtua' => $this->input->post('id_orangtua'),
            'nama_bayi' => $this->input->post('nama_bayi'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'tgl_lahir' => $this->format_tanggal($this->input->post('tgl_lahir')),
            'berat_badan' => $this->input->post('berat_badan'),
            'panjang_badan' => $this->input->post('panjang_badan'),
        );

        $this->Mod_bayi->update($id, $save);

        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $this->Mod_bayi->delete($id);
        $data['status'] = TRUE;
        echo json_encode($data);
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('id_orangtua') == '') {
            $data['inputerror'][] = 'id_orangtua';
            $data['error_string'][] = 'Orang Tua Harus Dipilih';
            $data['status'] = FALSE;
        }

        if ($this->input->post('nama_bayi') == '') {
            $data['inputerror'][] = 'nama_bayi';
            $data['error_string'][] = 'Nama Bayi Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('jenis_kelamin') == '') {
            $data['inputerror'][] = 'jenis_kelamin';
            $data['error_string'][] = 'Jenis Kelamin Harus Dipilih';
            $data['status'] = FALSE;
        }

        if ($this->input->post('tgl_lahir') == '') {
            $data['inputerror'][] = 'tgl_lahir';
            $data['error_string'][] = 'Tanggal Lahir Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('berat_badan') == '') {
            $data['inputerror'][] = 'berat_badan';
            $data['error_string'][] = 'Berat badan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('panjang_badan') == '') {
            $data['inputerror'][] = 'panjang_badan';
            $data['error_string'][] = 'Panjang Badan Tidak Boleh Kosong';
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
        $this->db->select('MAX(SUBSTRING_INDEX(id_bayi, "-", -1)) as last_number');
        $query = $this->db->get('tbl_bayi'); // Ganti dengan nama tabel yang sesuai
        $result = $query->row();

        // Mengambil nomor urut terakhir
        $lastNumber = $result ? intval($result->last_number) : 0;

        return $lastNumber + 1; // Menambah 1 untuk nomor urut berikutnya
    }

    private function format_tanggal($tgl)
    {
        $tgl_lahir = $tgl;
        $date = DateTime::createFromFormat('m/d/Y', $tgl_lahir);
        return $date->format('Y-m-d');
    }

    private function format_tanggal_edit($tgl)
    {
        $tgl_lahir = $tgl;
        $date = DateTime::createFromFormat('Y-m-d', $tgl_lahir);
        return $date->format('m/d/Y');
    }

}
