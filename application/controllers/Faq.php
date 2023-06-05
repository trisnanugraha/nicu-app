<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Faq extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_faq');
    }

    public function index()
    {
        $data['judul'] = 'Manajemen FAQ';
        $data['hakakses'] = $this->session->userdata('hak_akses');
        $data['modal_tambah'] = show_my_modal('faq/modal_tambah_faq', $data);
        $js = $this->load->view('faq/faq-js', null, true);
        $this->template->views('faq/home', $data, $js);
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

        $list = $this->Mod_faq->get_datatables();

        $data = array();
        $no = $_POST['start'];

        foreach ($list as $i) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $i->pertanyaan;
            $row[] = $i->respon;
            $row[] = $i->id_faq;
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
            "recordsTotal" => $this->Mod_faq->count_all(),
            "recordsFiltered" => $this->Mod_faq->count_filtered(),
            "data" => $data,
        );


        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_faq->get_faq($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $format = "%Y-%M";
        $post = $this->input->post();
        $this->id_faq = 'FAQ' . '-' . mdate($format) . '-' . uniqid();
        $this->pertanyaan = $post['pertanyaan'];
        $this->respon = $post['respon'];

        $this->Mod_faq->insert($this);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate();

        $post = $this->input->post();

        $id      = $this->input->post('id_faq');
        $this->pertanyaan = $post['pertanyaan'];
        $this->respon = $post['respon'];

        $this->Mod_faq->update($id, $this);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_faq');
        $this->Mod_faq->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('pertanyaan') == '') {
            $data['inputerror'][] = 'pertanyaan';
            $data['error_string'][] = 'Pertanyaan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('respon') == '') {
            $data['inputerror'][] = 'respon';
            $data['error_string'][] = 'Respon Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Faq.php */