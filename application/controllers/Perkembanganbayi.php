<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perkembanganbayi extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_user');
        $this->load->model('Mod_userlevel');
        $this->load->model('Mod_bayi');
        $this->load->model('Mod_perkembangan_bayi');
    }

    public function index()
    {

        $role = $this->session->userdata('hak_akses');

        $this->load->helper('url');

        // $data['orangtua'] = $this->Mod_user->get_all_orangtua();
        $data['bayi'] = $this->Mod_bayi->get_all();

        if ($role == "Admin") {
            $data['judul'] = 'Manajemen Perkembangan Bayi';
            $data['table'] = 'tabelAdmin';
            $data['role'] = 'Admin';
            $js = $this->load->view('user/admin-js', null, true);
        } else if ($role == 'Perawat') {
            $data['judul'] = 'Manajemen Perkembangan Bayi';
            $data['table'] = 'tabelPerkembanganBayi';
            $data['role'] = 'Perawat';
            $js = $this->load->view('perkembangan_bayi/perkembangan-bayi-js', null, true);
        } else if ($role == 'Orang Tua') {
            $data['judul'] = 'Data Perkembangan Bayi';
            $data['table'] = 'tabelPerkembanganBayi';
            $data['role'] = 'Orang Tua';
            $js = $this->load->view('perkembangan_bayi/perkembangan-bayi-orangtua-js', null, true);
        }
        $data['modal_perkembangan_bayi'] = show_my_modal('perkembangan_bayi/modal_perkembangan_bayi', $data);
        $data['modal_detail_perkembangan_bayi'] = show_my_modal('perkembangan_bayi/modal_detail_perkembangan_bayi', $data);

        $this->template->views('perkembangan_bayi/home', $data, $js);
    }

    public function ajax_list()
    {
        $role = $this->session->userdata('hak_akses');
        $id = $this->Mod_user->get_user_orangtua($this->session->userdata('id_user'))->id_orangtua;

        $list = $this->Mod_perkembangan_bayi->get_datatables($role, $id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $perkembanganBayi) {
            $no++;
            $row = array();
            $row[] = $perkembanganBayi->id_bayi;
            $row[] = $perkembanganBayi->nama_bayi;
            $row[] = $perkembanganBayi->berat_badan . ' KG';
            $row[] = $perkembanganBayi->panjang_badan . ' CM';
            $row[] = $perkembanganBayi->diagnosa_medis;
            $row[] = tgl_indonesia($perkembanganBayi->tgl_dibuat);
            $row[] = $this->Mod_user->get_user($perkembanganBayi->dibuat_oleh)->full_name;
            $row[] = $perkembanganBayi->id_perkembangan_bayi;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_perkembangan_bayi->count_all($role, $id),
            "recordsFiltered" => $this->Mod_perkembangan_bayi->count_filtered($role, $id),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function insert()
    {
        $this->_validate();

        $save = array(
            'id_bayi' => $this->input->post('id_bayi'),
            'berat_badan' => $this->input->post('berat_badan'),
            'panjang_badan' => $this->input->post('panjang_badan'),
            'diagnosa_medis' => $this->input->post('diagnosa_medis'),
            'dibuat_oleh' => $this->session->userdata('id_user')
        );

        $id = $this->Mod_perkembangan_bayi->insert_perkembangan_bayi($save);

        $save_tanda_vital = array(
            'id_perkembangan_bayi' => $id,
            'suhu' => $this->input->post('suhu'),
            'pernapasan' => $this->input->post('pernapasan'),
            'heart_rate' => $this->input->post('heart_rate'),
            'saturasi_oksigen' => $this->input->post('saturasi_oksigen')
        );

        $this->Mod_perkembangan_bayi->insert_tanda_vital($save_tanda_vital);

        $save_hasil_laboratorium = array(
            'id_perkembangan_bayi' => $id,
            'hb' => $this->input->post('hb'),
            'ht' => $this->input->post('ht'),
            'leukosit' => $this->input->post('leukosit'),
            'trombosit' => $this->input->post('trombosit'),
            'crp' => $this->input->post('crp'),
            'natrium' => $this->input->post('natrium'),
            'kalium' => $this->input->post('kalium'),
            'kalsium' => $this->input->post('kalsium'),
            'bilirubin_total' => $this->input->post('bilirubin_total'),
            'albumin' => $this->input->post('albumin'),
            'gds' => $this->input->post('gds')
        );

        $this->Mod_perkembangan_bayi->insert_hasil_laboratorium($save_hasil_laboratorium);

        echo json_encode(array("status" => TRUE));
    }

    public function edit($id)
    {
        $data = $this->Mod_perkembangan_bayi->get_data($id);
        echo json_encode($data);
    }

    public function detail($id)
    {
        $data = $this->Mod_perkembangan_bayi->get_data($id);
        $data->tgl_dibuat = tgl_indonesia($data->tgl_dibuat);
        $data->tgl_diubah = tgl_indonesia($data->tgl_diubah);
        echo json_encode($data);
    }


    public function update()
    {
        $this->_validate();

        $id = $this->input->post('id_perkembangan_bayi');

        $save = array(
            'id_bayi' => $this->input->post('id_bayi'),
            'berat_badan' => $this->input->post('berat_badan'),
            'panjang_badan' => $this->input->post('panjang_badan'),
            'diagnosa_medis' => $this->input->post('diagnosa_medis'),
            'diubah_oleh' => $this->session->userdata('id_user')
        );

        $this->Mod_perkembangan_bayi->update_perkembangan_bayi($id, $save);

        $save_tanda_vital = array(
            'suhu' => $this->input->post('suhu'),
            'pernapasan' => $this->input->post('pernapasan'),
            'heart_rate' => $this->input->post('heart_rate'),
            'saturasi_oksigen' => $this->input->post('saturasi_oksigen')
        );

        $this->Mod_perkembangan_bayi->update_tanda_vital($id, $save_tanda_vital);

        $save_hasil_laboratorium = array(
            'h2tl' => $this->input->post('h2tl'),
            'crp' => $this->input->post('crp'),
            'natrium' => $this->input->post('natrium'),
            'kalium' => $this->input->post('kalium'),
            'kalsium' => $this->input->post('kalsium'),
            'agd' => $this->input->post('agd'),
            'bilirubin_total' => $this->input->post('bilirubin_total'),
            'albumin' => $this->input->post('albumin'),
            'gds' => $this->input->post('gds')
        );

        $this->Mod_perkembangan_bayi->update_hasil_laboratorium($id, $save_hasil_laboratorium);

        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id');
        $user = $this->session->userdata('id_user');
        $this->Mod_perkembangan_bayi->delete($id, $user);
        $data['status'] = TRUE;
        echo json_encode($data);
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('id_bayi') == '') {
            $data['inputerror'][] = 'id_bayi';
            $data['error_string'][] = 'Bayi Harus Dipilih';
            $data['status'] = FALSE;
        }

        if ($this->input->post('berat_badan') == '') {
            $data['inputerror'][] = 'berat_badan';
            $data['error_string'][] = 'Berat Badan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('panjang_badan') == '') {
            $data['inputerror'][] = 'panjang_badan';
            $data['error_string'][] = 'Panjang Badan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('suhu') == '') {
            $data['inputerror'][] = 'suhu';
            $data['error_string'][] = 'Suhu Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('pernapasan') == '') {
            $data['inputerror'][] = 'pernapasan';
            $data['error_string'][] = 'Pernapasan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('heart_rate') == '') {
            $data['inputerror'][] = 'heart_rate';
            $data['error_string'][] = 'Heart Rate Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('saturasi_oksigen') == '') {
            $data['inputerror'][] = 'saturasi_oksigen';
            $data['error_string'][] = 'Saturasi Oksigen Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('heart_rate') == '') {
            $data['inputerror'][] = 'heart_rate';
            $data['error_string'][] = 'Heart Rate Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('h2tl') == '') {
            $data['inputerror'][] = 'h2tl';
            $data['error_string'][] = 'H2TL Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('crp') == '') {
            $data['inputerror'][] = 'crp';
            $data['error_string'][] = 'CRP Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('natrium') == '') {
            $data['inputerror'][] = 'natrium';
            $data['error_string'][] = 'Natrium Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('kalium') == '') {
            $data['inputerror'][] = 'kalium';
            $data['error_string'][] = 'Kalium Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('kalsium') == '') {
            $data['inputerror'][] = 'kalsium';
            $data['error_string'][] = 'Kalsium Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('agd') == '') {
            $data['inputerror'][] = 'agd';
            $data['error_string'][] = 'AGD Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('bilirubin_total') == '') {
            $data['inputerror'][] = 'bilirubin_total';
            $data['error_string'][] = 'Bilirubin Total Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('albumin') == '') {
            $data['inputerror'][] = 'albumin';
            $data['error_string'][] = 'Albumin Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('gds') == '') {
            $data['inputerror'][] = 'gds';
            $data['error_string'][] = 'GDS Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }


        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function format_tanggal($tgl)
    {
        $tgl_lahir = $tgl;
        $date = DateTime::createFromFormat('m/d/Y', $tgl_lahir);
        return $date->format('Y-m-d');
    }

}
