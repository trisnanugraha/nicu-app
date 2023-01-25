<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dataimei extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_manufaktur_imei');
    }

    public function index()
    {
        $data['judul'] = 'Data IMEI';
        $data['manufaktur'] = $this->session->userdata('full_name');
        $data['hakakses'] = $this->session->userdata('hak_akses');
        $data['modal_tambah'] = show_my_modal('data_imei/modal_tambah_imei', $data);
        $js = $this->load->view('data_imei/data-imei-js', null, true);
        $this->template->views('data_imei/home', $data, $js);
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

        $list = $this->Mod_manufaktur_imei->get_datatables($this->session->userdata('id_user'));

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $i) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $i->id_data_imei;
            $row[] = $i->nama_manufaktur;
            $row[] = $i->merk;
            $row[] = $i->no_model;
            $row[] = $i->total;
            $row[] = tgl_indonesia($i->tgl_dibuat);
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
            "recordsTotal" => $this->Mod_manufaktur_imei->count_all($this->session->userdata('id_user')),
            "recordsFiltered" => $this->Mod_manufaktur_imei->count_filtered($this->session->userdata('id_user')),
            "data" => $data,
        );


        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_manufaktur_imei->get_imei($id);
        echo json_encode($data);
    }

    public function insert()
    {

        $this->_validate();

        $format = "%Y-%M";

        $post = $this->input->post();

        $this->id_data_imei = 'M' . '-' . mdate($format) . '-' . uniqid();
        $this->id_manufaktur = $this->session->userdata('id_user');
        $this->merk = $post['merk'];
        $this->no_model = $post['no_model'];
        $this->total = $post['total'];

        if (!empty($_FILES['fileImei']['name'])) {
            $this->file = $this->_upload('manufaktur', 'fileImei');
        } else {
            $this->file = $post['berkasFile'];
        }

        $this->Mod_manufaktur_imei->insert($this);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate();

        $post = $this->input->post();

        $id      = $this->input->post('id_data_imei');
        $this->merk = $post['merk'];
        $this->no_model = $post['no_model'];
        $this->total = $post['total'];
        if (!empty($_FILES['fileImei']['name'])) {
            $this->file = $this->_upload('manufaktur', 'fileImei');
        } else {
            $this->file = $post['berkasFile'];
        }

        $this->Mod_manufaktur_imei->update($id, $this);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_data_imei');
        $this->Mod_manufaktur_imei->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('merk') == '') {
            $data['inputerror'][] = 'merk';
            $data['error_string'][] = 'Merk Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('no_model') == '') {
            $data['inputerror'][] = 'no_model';
            $data['error_string'][] = 'Nomor Model Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('total') == '') {
            $data['inputerror'][] = 'total';
            $data['error_string'][] = 'Total Produk Tidak Boleh Kosong';
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