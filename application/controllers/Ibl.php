<?php

use SebastianBergmann\Diff\Diff;

defined('BASEPATH') or exit('No direct script access allowed');

class Ibl extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_ibl');
        $this->load->model('Mod_angkatan');
        $this->load->model('Mod_mahasiswa');
        $this->load->model('Mod_sindikat');
        $this->load->model('Mod_userlevel');
        $this->load->model('Mod_user');
        $this->load->library('ciqrcode');
    }

    public function index()
    {
        $checklevel = $this->_cek_status($this->session->userdata('id_level'));
        $data['level'] = $checklevel;
        $data['judul'] = 'IBL / Cuti';
        $data['angkatan'] = $this->Mod_angkatan->get_all_angkatan();
        $data['modal_tambah_ibl'] = show_my_modal('ibl/modal_tambah_ibl', $data);
        $data['modal_validasi_ibl'] = show_my_modal('ibl/modal_validasi_ibl', $data);

        $js = $this->load->view('ibl/ibl-js', null, true);
        $this->template->views('ibl/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $level = $this->_cek_status($this->session->userdata('id_level'));
        $list = $this->Mod_ibl->get_datatables($level);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ibl) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;

            if ($level == 'Sekretaris') {
                $status = $ibl->status_sekretaris;
                $flag = 0;
            } else if ($level == 'Staff Korwa') {
                $status = $ibl->status_staff;
                $flag = 1;
            } else if ($level == 'Kakorwa') {
                $status = $ibl->status_kakorwa;
                $flag = 1;
            } else if ($level == 'Mahasiswa') {
                $status = $ibl->status_kakorwa;
                $flag = 2;
            }

            if ($status != null) {
                $row = array();
                $row[] = $no;
                $row[] = $ibl->no_surat;
                $row[] = $status;
                $row[] = $ibl->id_ibl;
                $row[] = $flag;
                // $row[] = $cekuser;
                $data[] = $row;
            }
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_ibl->count_all($level),
            "recordsFiltered" => $this->Mod_ibl->count_filtered($level),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_ibl->get_ibl($id);
        $data->tgl_berangkat = date("d-m-Y H:i:s", strtotime($data->tgl_berangkat));
        $data->tgl_kembali = date("d-m-Y H:i:s", strtotime($data->tgl_kembali));
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate();
        $save  = array(
            'no_surat'      => $this->input->post('no_surat'),
            'id_angkatan'   => $this->input->post('id_angkatan'),
            'tgl_berangkat' => $this->input->post('tgl_berangkat'),
            'tgl_kembali'   => $this->input->post('tgl_kembali'),
            'keperluan'     => $this->input->post('keperluan'),
        );

        $this->Mod_ibl->insert($save);

        // $get_id = $this->Mod_ibl->insert($save);

        // $qr = $get_id . '.png'; //buat name dari qr code sesuai dengan nim

        // $params['data'] = 'Surat ini telah disahkan dan divalidasi a/n KETUA SEKOLAH TINGGI ILMU KEPOLISIAN WAKET BIDMINWA u.b. KAKORWA oleh NOVIAR, S.I.K. (KOMISARIS BESAR POLISI NRP 6903039) pada ' . tgl_indonesia(date('Y-m-d H:i:s')) . ' melalui Sistem E-Nota Dinas'; //data yang akan di jadikan QR CODE
        // $params['level'] = 'H'; //H=High
        // $params['size'] = 10;
        // $params['savename'] = FCPATH . './assets/qr-code-ibl/' . $qr; //simpan image QR CODE ke folder assets/images/
        // $this->ciqrcode->generate($params);

        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate();
        $id      = $this->input->post('id_ibl');
        $data  = array(
            'status_staff' => $this->input->post('status_staff'),
        );
        $this->Mod_ibl->update($id, $data);
        echo json_encode(array("status" => TRUE));
    }

    public function send()
    {
        $id = $this->input->post('id_ibl');
        $data_surat = $this->Mod_ibl->get_ibl($id);

        $save = array(
            'status_sekretaris' => 'Diproses',
            'status_staff' => 'Diproses'
        );

        $this->Mod_ibl->update($id, $save);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_ibl');

        if ($id != null) {
            //hapus gambar yg ada diserver
            unlink('assets/qr-code-ibl/' . $id . '.png');
        }

        $this->Mod_ibl->delete($id);
        echo json_encode(array("status" => TRUE));
    }

    public function detail($id)
    {
        $data = $this->Mod_ibl->get_ibl($id);

        $level = $this->_cek_status($this->session->userdata('id_level'));
        $data->level = $level;

        echo json_encode($data);
    }

    public function validate()
    {
        $qr_nota = null;
        $id = $this->input->post('id_ibl');
        $checklevel = $this->_cek_status($this->session->userdata('id_level'));

        if ($checklevel == 'Staff Korwa') {
            $data  = array(
                'status_staff' => $this->input->post('status_staff'),
                'catatan_staff' => $this->input->post('catatan_staff'),
            );

            $this->Mod_ibl->update($id, $data);

            if ($this->input->post('status_staff') == 'Disetujui') {
                $status = array(
                    'status_kakorwa' => 'Diproses'
                );

                $this->Mod_ibl->update($id, $status);
            }
        } else if ($checklevel == 'Kakorwa') {
            $data  = array(
                'status_kakorwa' => $this->input->post('status_kakorwa'),
                'catatan_kakorwa' => $this->input->post('catatan_kakorwa'),
            );

            $this->Mod_ibl->update($id, $data);

            if ($this->input->post('status_kakorwa') == 'Disetujui') {

                $status = array(
                    'status_sekretaris' => 'Disetujui'
                );

                $this->Mod_ibl->update($id, $status);

                $qr_nota = $id . '.png'; //buat name dari qr code sesuai dengan nim

                $params['data'] = 'Surat ini telah disahkan dan divalidasi oleh KOMISARIS BESAR POLISI NRP ' . $this->session->userdata('nim_nrp') . ' a/n ' . $this->session->userdata('full_name')  . ' pada ' . date('d-m-Y H:i:s') . ' Melalui Sistem E-Nota Dinas'; //data yang akan di jadikan QR CODE
                $params['level'] = 'H'; //H=High
                $params['size'] = 10;
                $params['savename'] = FCPATH . './assets/qr-code-ibl/' . $id . ".png"; //simpan image QR CODE ke folder assets/images/
                $this->ciqrcode->generate($params);
            }
        }

        echo json_encode(array("status" => TRUE));
    }

    public function print($id)
    {
        $id_role = $this->Mod_userlevel->getId('Kakorwa');
        $data['kakorwa'] = $this->Mod_user->get_user_by_role($id_role->id_level);
        $angkatan = $this->Mod_ibl->get_id_angkatan($id);
        $data['surat'] = $this->Mod_ibl->get_ibl($id);
        $data['surat']->tgl_dibuat = $this->fungsi->tanggalindo(date('Y-m-d', strtotime($data['surat']->tgl_dibuat)));
        $tgl_berangkat = new DateTime($data['surat']->tgl_berangkat);
        $tgl_kembali = new DateTime($data['surat']->tgl_kembali);
        $total_cuti = date_diff($tgl_berangkat, $tgl_kembali);
        $data['surat']->total_cuti = $total_cuti->days + 1;
        $data['surat']->terbilang = Num_to_text($total_cuti->days + 1);

        $checklevel = $this->_cek_status($this->session->userdata('id_level'));
        if ($checklevel == 'Mahasiswa') {
            $data['mahasiswa'] = $this->Mod_mahasiswa->get_mahasiswa_by_id($this->session->userdata('id_user'));
        } else {
            $data['mahasiswa'] = $this->Mod_mahasiswa->get_all_by_angkatan($angkatan->id_angkatan);
        }


        $this->load->library('pdf');
        $paper = $this->pdf->setPaper('A4', 'potrait');
        $filename = $this->pdf->filename = "Cuti / IBL.pdf";
        $html = $this->load->view('ibl/template-cuti-ibl', $data, TRUE);

        $this->fungsi->PdfGenerator($html, 'Draft - Cuti - IBL.pdf', 'A4', 'potrait');
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('no_surat') == '') {
            $data['inputerror'][] = 'no_surat';
            $data['error_string'][] = 'Nomor Surat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('id_angkatan') == '') {
            $data['inputerror'][] = 'angkatan';
            $data['error_string'][] = 'Angkatan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('tgl_cuti') == '') {
            $data['inputerror'][] = 'tgl_cuti';
            $data['error_string'][] = 'Tanggal Cuti Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('keperluan') == '') {
            $data['inputerror'][] = 'keperluan';
            $data['error_string'][] = 'Keperluan Tidak Boleh Kosong';
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

/* End of file Ibl.php */