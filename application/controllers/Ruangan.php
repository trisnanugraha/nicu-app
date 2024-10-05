<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ruangan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_ruangan');
    }

    public function index()
    {
        $data['judul'] = 'Data Ruangan';
        $data['hakakses'] = $this->session->userdata('hak_akses');
        $data['modal_tambah'] = show_my_modal('ruangan/modal_tambah_ruangan', $data);
        $js = $this->load->view('ruangan/ruangan-js', null, true);
        $this->template->views('ruangan/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);

        $checklevel = $this->session->userdata('hak_akses');

        $list = $this->Mod_ruangan->get_datatables();

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $i) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $i->nama_ruangan;
            $row[] = $i->no_lantai;
            $row[] = $i->kapasitas;
            $row[] = $i->status;
            $row[] = $i->id_ruangan;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_ruangan->count_all(),
            "recordsFiltered" => $this->Mod_ruangan->count_filtered(),
            "data" => $data,
        );

        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_ruangan->get_ruangan($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $post = $this->input->post();

        $this->id_ruangan = uniqid();
        $this->nama_ruangan = $post['nama_ruangan'];
        $this->no_lantai = $post['no_lantai'];
        $this->status = $post['status'];
        $this->created_by = $this->session->userdata('id_user');
        $this->Mod_ruangan->insert($this);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate();

        $post = $this->input->post();

        $id      = $this->input->post('id_ruangan');
        $this->nama_ruangan = $post['nama_ruangan'];
        $this->no_lantai = $post['no_lantai'];
        $this->kapasitas = $post['kapasitas'];
        $this->status = $post['status'];
        $this->updated_by = $this->session->userdata('id_user');
        $this->updated_at = mdate('%Y-%m-%d %H:%i:%s', now());
        $this->Mod_ruangan->update($id, $this);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_ruangan');
        $this->Mod_ruangan->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('nama_ruangan') == '') {
            $data['inputerror'][] = 'nama_ruangan';
            $data['error_string'][] = 'Nama Ruangan Harus Diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('no_lantai') == '') {
            $data['inputerror'][] = 'no_lantai';
            $data['error_string'][] = 'Nomor Lantai Harus Diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('status') == '') {
            $data['inputerror'][] = 'status';
            $data['error_string'][] = 'Status Harus Dipilih';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Ruangan.php */