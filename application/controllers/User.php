<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class User extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_user');
        $this->load->model('Mod_userlevel');
        $this->load->model('Mod_kelas');
        $this->load->model('Mod_sindikat');
        $this->load->model('Mod_angkatan');
        $this->load->model('Mod_jabatan');
        $this->load->model('Mod_import');
    }

    public function index()
    {
        $this->load->helper('url');
        $data['judul'] = 'Manajemen User';
        $data['user'] = $this->Mod_user->getAll();
        $data['user_level'] = $this->Mod_user->userlevel();
        $data['kelas'] = $this->Mod_kelas->get_all_kelas();
        $data['sindikat'] = $this->Mod_sindikat->get_all_sindikat();
        $data['angkatan'] = $this->Mod_angkatan->get_all_angkatan();
        $data['jabatan'] = $this->Mod_jabatan->get_all_jabatan();
        $data['modal_tambah_user'] = show_my_modal('user/modal_tambah_user', $data);
        $js = $this->load->view('user/user-js', null, true);
        $this->template->views('user/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $hak_akses = $this->Mod_userlevel->getId('Mahasiswa');
        $list = $this->Mod_user->get_datatables($hak_akses->id_level);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $user->full_name;
            $row[] = $user->username;
            $row[] = $user->angkatan;
            $row[] = $user->nama_level;
            $row[] = $user->is_active;
            $row[] = $user->id_user;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_user->count_all(),
            "recordsFiltered" => $this->Mod_user->count_filtered($hak_akses->id_level),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function insert()
    {
        // var_dump($this->input->post('username'));
        if ($this->input->post('level') == '') {
            $this->_validateFirst();
        } else {
            $checklevel = $this->Mod_userlevel->getUserlevel($this->input->post('level'));
            $this->_validate($checklevel);
        }

        if ($checklevel->nama_level != 'Mahasiswa') {
            $save  = array(
                'username' => $this->input->post('username'),
                'full_name' => $this->input->post('full_name'),
                'password'  => get_hash($this->input->post('password')),
                'id_angkatan'  => 5,
                'id_kelas'  => 4,
                'id_sindikat'  => 8,
                'id_jabatan'  => $this->input->post('jabatan'),
                'id_level'  => $this->input->post('level'),
                'is_active' => $this->input->post('is_active')
            );
        } else {
            $save  = array(
                'username' => $this->input->post('username'),
                'full_name' => $this->input->post('full_name'),
                'password'  => get_hash($this->input->post('password')),
                'id_angkatan'  => $this->input->post('angkatan'),
                'id_kelas'  => $this->input->post('kelas'),
                'id_sindikat'  => $this->input->post('sindikat'),
                'id_jabatan'  => 8,
                'id_level'  => $this->input->post('level'),
                'is_active' => $this->input->post('is_active')
            );
        }
        $this->Mod_user->insert($save);
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
        $id = $this->input->post('id_user');
        $checklevel = $this->Mod_userlevel->getUserlevel($this->input->post('level'));
        //Jika Password tidak kosong
        if ($this->input->post('password')) {
            if ($checklevel->nama_level != 'Mahasiswa') {
                $save  = array(
                    'username' => $this->input->post('username'),
                    'full_name' => $this->input->post('full_name'),
                    'password'  => get_hash($this->input->post('password')),
                    'id_kelas'  => 4,
                    'id_sindikat'  => 8,
                    'id_jabatan'  => $this->input->post('jabatan'),
                    'id_level'  => $this->input->post('level'),
                    'is_active' => $this->input->post('is_active')
                );
            } else {
                $save  = array(
                    'username' => $this->input->post('username'),
                    'full_name' => $this->input->post('full_name'),
                    'password'  => get_hash($this->input->post('password')),
                    'id_angkatan'  => $this->input->post('angkatan'),
                    'id_kelas'  => $this->input->post('kelas'),
                    'id_sindikat'  => $this->input->post('sindikat'),
                    'id_jabatan'  => 8,
                    'id_level'  => $this->input->post('level'),
                    'is_active' => $this->input->post('is_active')
                );
            }
        } else { //Jika password kosong
            if ($checklevel->nama_level != 'Mahasiswa') {
                $save  = array(
                    'username' => $this->input->post('username'),
                    'full_name' => $this->input->post('full_name'),
                    'id_kelas'  => 4,
                    'id_sindikat'  => 8,
                    'id_jabatan'  => $this->input->post('jabatan'),
                    'id_level'  => $this->input->post('level'),
                    'is_active' => $this->input->post('is_active')
                );
            } else {
                $save  = array(
                    'username' => $this->input->post('username'),
                    'full_name' => $this->input->post('full_name'),
                    'id_angkatan'  => $this->input->post('angkatan'),
                    'id_kelas'  => $this->input->post('kelas'),
                    'id_sindikat'  => $this->input->post('sindikat'),
                    'id_jabatan'  => 8,
                    'id_level'  => $this->input->post('level'),
                    'is_active' => $this->input->post('is_active')
                );
            }
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
            'password'  => get_hash('password123')
        );
        $this->Mod_user->reset_pass($id, $data);
        $data['status'] = TRUE;
        echo json_encode($data);
    }

    public function setStatus()
    {
        $id = $this->input->post('id');

        if($this->input->post('status') == 'N'){
            $status = 'Y';
        } else if($this->input->post('status') == 'Y') {
            $status = 'N';
        }

        $data = array(
            'is_active'  => $status
        );
        $this->Mod_user->update($id, $data);
        $data['status'] = TRUE;
        echo json_encode($data);
    }

    public function download()
    {

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Full name');
        $sheet->setCellValue('D1', 'password');
        $sheet->setCellValue('E1', 'level');
        $sheet->setCellValue('F1', 'Image');
        $sheet->setCellValue('G1', 'Active');

        $user = $this->Mod_user->getAll()->result();
        $no = 1;
        $x = 2;
        foreach ($user as $row) {
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $row->username);
            $sheet->setCellValue('C' . $x, $row->full_name);
            $sheet->setCellValue('D' . $x, $row->password);
            $sheet->setCellValue('E' . $x, $row->nama_level);
            $sheet->setCellValue('F' . $x, $row->image);
            $sheet->setCellValue('F' . $x, $row->is_active);
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'laporan-User';

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


    private function _validate($level)
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

        if ($this->input->post('full_name') == '') {
            $data['inputerror'][] = 'full_name';
            $data['error_string'][] = 'Nama Lengkap Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('password') == '') {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($level != '' && $level->nama_level != 'Mahasiswa') {
            if ($this->input->post('jabatan') == '') {
                $data['inputerror'][] = 'jabatan';
                $data['error_string'][] = 'Jabatan Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }
        }

        if ($level->nama_level == 'Mahasiswa') {
            if ($this->input->post('kelas') == '') {
                $data['inputerror'][] = 'kelas';
                $data['error_string'][] = 'Kelas Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }

            if ($this->input->post('sindikat') == '') {
                $data['inputerror'][] = 'sindikat';
                $data['error_string'][] = 'Sindikat Tidak Boleh Kosong';
                $data['status'] = FALSE;
            }
        }

        if ($this->input->post('is_active') == '') {
            $data['inputerror'][] = 'is_active';
            $data['error_string'][] = 'Status Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('level') == '') {
            $data['inputerror'][] = 'level';
            $data['error_string'][] = 'Hak Akses Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    private function _validateFirst()
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

        if ($this->input->post('full_name') == '') {
            $data['inputerror'][] = 'full_name';
            $data['error_string'][] = 'Nama Lengkap Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('password') == '') {
            $data['inputerror'][] = 'password';
            $data['error_string'][] = 'Password Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('kelas') == '') {
            $data['inputerror'][] = 'kelas';
            $data['error_string'][] = 'Kelas Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('sindikat') == '') {
            $data['inputerror'][] = 'sindikat';
            $data['error_string'][] = 'Sindikat Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('jabatan') == '') {
            $data['inputerror'][] = 'jabatan';
            $data['error_string'][] = 'Jabatan Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('is_active') == '') {
            $data['inputerror'][] = 'is_active';
            $data['error_string'][] = 'Status Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($this->input->post('level') == '') {
            $data['inputerror'][] = 'level';
            $data['error_string'][] = 'Hak Akses Tidak Boleh Kosong';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function import()
    {
        $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        if (isset($_FILES['file']['name']) && in_array($_FILES['file']['type'], $file_mimes)) {

            $arr_file = explode('.', $_FILES['file']['name']);
            $extension = end($arr_file);

            if ($extension == 'csv') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } elseif ($extension == 'xlsx') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            }

            $spreadsheet = $reader->load($_FILES['file']['tmp_name']);

            $sheetData = $spreadsheet->getActiveSheet()->toArray();
            $sheetcount = count($sheetData);
            if ($sheetcount > 1) {
                for ($i = 1; $i < $sheetcount; $i++) {
                    $nama_mhs = $sheetData[$i]['0'];
                    $nim = $sheetData[$i]['1'];

                    $nama_sindikat = $sheetData[$i]['2'];
                    $sindikat = $this->Mod_sindikat->get_sindikat_by_name($nama_sindikat);


                    $alamat = $sheetData[$i]['3'];
                    $telepon = $sheetData[$i]['4'];
                    $nama_angkatan = $sheetData[$i]['5'];
                    $angkatan = $this->Mod_angkatan->get_id_angkatan($nama_angkatan);

                    $kelas = $sheetData[$i]['6'];
                    $nama_kelas = $this->Mod_kelas->get_kelas_by_name($kelas);

                    $nama_jabatan = $sheetData[$i]['7'];
                    $jabatan = $this->Mod_jabatan->get_jabatan_by_name($nama_jabatan);

                    $role = $sheetData[$i]['8'];
                    $hak_akses = $this->Mod_userlevel->getId($role);

                    // echo '<pre>';
                    // echo json_encode($nama_sindikat);

                    $temp_data[] = array(
                        'username' => $nim,
                        'full_name' => $nama_mhs,
                        'password' => get_hash('password123'),
                        'nim_nrp' => $nim,
                        'alamat' => $alamat,
                        'no_hp' => $telepon,
                        'id_angkatan' => $angkatan->id_angkatan,
                        'id_kelas' => $nama_kelas->id_kelas,
                        'id_sindikat' => $sindikat->id_sindikat,
                        'id_jabatan' => $jabatan->id_jabatan,
                        'id_level' => $hak_akses->id_level,
                        'is_active' => 'Y'
                    );
                }

                $insert = $this->Mod_import->insert($temp_data, 'tbl_user');

                if ($insert) {
                    redirect('user');
                }
            }
        }
    }
}