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
        $data['modal_tambah'] = show_my_modal('data_imei/modal_tambah_imei', $data);
        $js = $this->load->view('data_imei/data-imei-js', null, true);
        $this->template->views('data_imei/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_manufaktur_imei->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $i) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $i->nama_manufaktur;
            $row[] = $i->file;
            $row[] = $i->tgl_dibuat;
            $row[] = $i->id_data_imei;
            // $row[] = $cekuser;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_manufaktur_imei->count_all(),
            "recordsFiltered" => $this->Mod_manufaktur_imei->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_sindikat->get_sindikat($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $post = $this->input->post();

        $this->id_manufaktur = $this->session->userdata('id_user');

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
        $id      = $this->input->post('id_sindikat');
        $data  = array(
            'nama_sindikat' => $this->input->post('nama_sindikat'),
        );
        $this->Mod_sindikat->update($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_sindikat');
        $this->Mod_sindikat->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    // private function _validate()
    // {
    //     $data = array();
    //     $data['error_string'] = array();
    //     $data['inputerror'] = array();
    //     $data['status'] = TRUE;

    //     if ($this->input->post('nama_sindikat') == '') {
    //         $data['inputerror'][] = 'nama_sindikat';
    //         $data['error_string'][] = 'Nama Sindikat Tidak Boleh Kosong';
    //         $data['status'] = FALSE;
    //     }

    //     if ($data['status'] === FALSE) {
    //         echo json_encode($data);
    //         exit();
    //     }
    // }

    private function _upload($folder, $target)
    {
        $user = $this->session->userdata['user_name'];
        $format = "%Y-%M-%d--%H-%i";
        $config['upload_path']          = './upload/' . $folder . '/';
        $config['allowed_types']        = 'pdf|doc|docx|xls|xlsx';
        $config['overwrite']            = true;
        $config['file_name']            = mdate($format) . "_{$user}";

        $this->upload->initialize($config);

        if ($this->upload->do_upload($target)) {
            return $this->upload->data('file_name');
        }
    }
}

/* End of file Dataimei.php */