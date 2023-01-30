<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_laporan');
    }

    public function index()
    {
        $data['judul'] = 'Data Laporan';
        $js = $this->load->view('laporan/laporan-js', null, true);
        $this->template->views('laporan/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);

        $checklevel = $this->session->userdata('hak_akses');

        // if ($checklevel == 'Admin') {
        //     $list = $this->Mod_admin_manufaktur_imei->get_datatables();
        // } else {
        //     $list = $this->Mod_manufaktur_imei->get_datatables($this->session->userdata('id_user'));
        // }

        $list = $this->Mod_laporan->get_datatables();

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $i) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $i->id_laporan;
            $row[] = $i->nama_lengkap;
            $row[] = $i->imei;
            $row[] = $i->no_telepon;
            $row[] = $i->email;
            $row[] = $i->deskripsi;
            $row[] = tgl_indonesia($i->created_at);
            // $row[] = $cekuser;
            $data[] = $row;
        }

        // if ($checklevel == 'Admin') {
        //     $output = array(
        //         "draw" => $_POST['draw'],
        //         "recordsTotal" => $this->Mod_manufaktur_imei->count_all(),
        //         "recordsFiltered" => $this->Mod_manufaktur_imei->count_filtered(),
        //         "data" => $data,
        //     );
        // } else {
        //     $output = array(
        //         "draw" => $_POST['draw'],
        //         "recordsTotal" => $this->Mod_manufaktur_imei->count_all($this->session->userdata('id_user')),
        //         "recordsFiltered" => $this->Mod_manufaktur_imei->count_filtered($this->session->userdata('id_user')),
        //         "data" => $data,
        //     );
        // }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_laporan->count_all(),
            "recordsFiltered" => $this->Mod_laporan->count_filtered(),
            "data" => $data,
        );


        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_beacukai->get_imei($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $post = $this->input->post();
        $this->nik = $post['nik'];
        $this->no_imei = $post['no_imei'];
        $this->no_passport = $post['no_passport'];
        $this->no_penerbangan = $post['no_penerbangan'];
        $this->tipe_hp = $post['tipe_hp'];
        $this->model_hp = $post['model_hp'];
        $this->status = 'Aktif Permanen';
        $this->is_vip = 0;
        $this->expired_date = 0;
        $this->created_by = $this->session->userdata('id_user');

        $this->Mod_beacukai->insert($this);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate();

        $post = $this->input->post();

        $id      = $this->input->post('no_imei');
        $this->nik = $post['nik'];
        $this->no_imei = $post['no_imei'];
        $this->no_passport = $post['no_passport'];
        $this->no_penerbangan = $post['no_penerbangan'];
        $this->tipe_hp = $post['tipe_hp'];
        $this->model_hp = $post['model_hp'];
        $this->updated_by = $this->session->userdata('id_user');

        $this->Mod_beacukai->update($id, $this);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('no_imei');
        $this->Mod_beacukai->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('no_imei') == '') {
            $data['inputerror'][] = 'no_imei';
            $data['error_string'][] = 'IMEI Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('nik') == '') {
            $data['inputerror'][] = 'nik';
            $data['error_string'][] = 'NIK Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('no_passport') == '') {
            $data['inputerror'][] = 'no_passport';
            $data['error_string'][] = 'Nomor Passport Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('no_penerbangan') == '') {
            $data['inputerror'][] = 'no_penerbangan';
            $data['error_string'][] = 'Nomor Penerbangan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('tipe_hp') == '') {
            $data['inputerror'][] = 'tipe_hp';
            $data['error_string'][] = 'Tipe HP Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('model_hp') == '') {
            $data['inputerror'][] = 'model_hp';
            $data['error_string'][] = 'Model HP Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function _upload($folder, $target)
    {
        $user = $this->session->userdata['user_name'];
        $format = "%Y-%M-%d--%H-%i";
        $config['upload_path']          = './upload/' . $folder . '/';
        $config['allowed_types']        = 'xls|xlsx';
        $config['overwrite']            = true;
        $config['file_name']            = mdate($format) . "_{$user}";

        $this->upload->initialize($config);

        if ($this->upload->do_upload($target)) {
            return $this->upload->data('file_name');
        }
    }
}

/* End of file Dataimei.php */