<?php
defined('BASEPATH') or exit('No direct script access allowed');

use phpDocumentor\Reflection\PseudoTypes\False_;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Mahasiswa extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mod_mahasiswa');
        $this->load->model('Mod_angkatan');
        $this->load->model('Mod_sindikat');
        $this->load->model('Mod_import');
        $this->load->model('Mod_user');
        $this->load->model('Mod_userlevel');
        $this->load->model('Mod_kelas');
        $this->load->model('Mod_jabatan');
    }

    public function index()
    {
        $data['judul'] = 'Daftar Mahasiswa';
        $data['angkatan'] = $this->Mod_angkatan->get_all_angkatan();
        $data['sindikat'] = $this->Mod_sindikat->get_all_sindikat();
        $data['kelas'] = $this->Mod_kelas->get_all_kelas();
        $data['modal_tambah_mahasiswa'] = show_my_modal('mahasiswa/modal_tambah_mahasiswa', $data);
        $js = $this->load->view('mahasiswa/mahasiswa-js', null, true);
        $this->template->views('mahasiswa/home', $data, $js);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $hak_akses = $this->Mod_userlevel->getId('Mahasiswa');
        $list = $this->Mod_mahasiswa->get_datatables($hak_akses->id_level);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $mhs) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $mhs->full_name;
            $row[] = $mhs->angkatan;
            $row[] = $mhs->nim_nrp;
            $row[] = $mhs->nama_sindikat;
            $row[] = $mhs->is_active;
            $row[] = $mhs->id_user;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_mahasiswa->count_all(),
            "recordsFiltered" => $this->Mod_mahasiswa->count_filtered($hak_akses->id_level),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function edit($id)
    {
        $data = $this->Mod_mahasiswa->get_user($id);
        echo json_encode($data);
    }

    public function insert()
    {
        $this->_validate('insert');
        $save  = array(
            'full_name'         => $this->input->post('nama_mhs'),
            'nim_nrp'           => $this->input->post('nim'),
            'username'          => $this->input->post('nim'),
            'password'          => get_hash($this->input->post('password')),
            'id_sindikat'       => $this->input->post('sindikat'),
            'id_angkatan'       => $this->input->post('angkatan'),
            'alamat'            => $this->input->post('alamat'),
            'no_hp'             => $this->input->post('telepon'),
            'email'             => $this->input->post('email'),
            'id_kelas'          => $this->input->post('kelas')
        );
        $this->Mod_mahasiswa->insert($save);
        echo json_encode(array("status" => TRUE));
    }

    public function update()
    {
        $this->_validate('update');
        $id      = $this->input->post('id_mhs');
        if ($this->input->post('password')) {
            $save  = array(
                'full_name'         => $this->input->post('nama_mhs'),
                'nim_nrp'           => $this->input->post('nim'),
                'username'          => $this->input->post('nim'),
                'password'          => get_hash($this->input->post('password')),
                'id_sindikat'       => $this->input->post('sindikat'),
                'id_angkatan'       => $this->input->post('angkatan'),
                'alamat'            => $this->input->post('alamat'),
                'no_hp'             => $this->input->post('telepon'),
                'email'             => $this->input->post('email'),
                'id_kelas'          => $this->input->post('kelas')
            );
        } else {
            $save  = array(
                'full_name'         => $this->input->post('nama_mhs'),
                'nim_nrp'           => $this->input->post('nim'),
                'username'          => $this->input->post('nim'),
                'id_sindikat'       => $this->input->post('sindikat'),
                'id_angkatan'       => $this->input->post('angkatan'),
                'alamat'            => $this->input->post('alamat'),
                'no_hp'             => $this->input->post('telepon'),
                'email'             => $this->input->post('email'),
                'id_kelas'          => $this->input->post('kelas')
            );
        }
        $this->Mod_mahasiswa->update($id, $save);
        echo json_encode(array("status" => TRUE));
    }

    public function delete()
    {
        $id = $this->input->post('id_mhs');
        $this->Mod_mahasiswa->delete($id);
        echo json_encode(array("status" => TRUE));
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
                    redirect('daftar-mahasiswa');
                }
            }
        }
    }

    public function download()
    {
        $format = "%d-%M-%Y--%H-%i";
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $styleArray = [
            'font' => [
                'bold'  =>  true,
                'size'  =>  10,
                'name'  =>  'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];
        $styleData = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        $styleDataLeft = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ]
        ];

        $sheet->getColumnDimension('A')->setWidth(10);
        foreach (range('A', 'L') as $col) {
            $sheet->getStyle($col)->getAlignment()->setHorizontal('center');
            if ($col != 'A') {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            $sheet->getDefaultRowDimension($col)->setRowHeight(25);
        }

        $sheet->getStyle('A1:L1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('bfb8b8');
        $sheet->getStyle('A1:L1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1:L1')->applyFromArray($styleArray);
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Username');
        $sheet->setCellValue('C1', 'Nama Lengkap');
        $sheet->setCellValue('D1', 'NIM');
        $sheet->setCellValue('E1', 'Alamat');
        $sheet->setCellValue('F1', 'No. HP');
        $sheet->setCellValue('G1', 'Email');
        $sheet->setCellValue('H1', 'Angkatan');
        $sheet->setCellValue('I1', 'Kelas');
        $sheet->setCellValue('J1', 'Sindikat');
        $sheet->setCellValue('K1', 'Pass Foto');
        $sheet->setCellValue('L1', 'Status Akun');

        $user = $this->Mod_user->get_all_mahasiswa();
        $no = 1;
        $x = 2;
        foreach ($user as $row) {
            $sheet->getStyle("A{$x}:L{$x}")->applyFromArray($styleData);
            $sheet->getStyle("C{$x}")->applyFromArray($styleDataLeft);
            $sheet->getStyle("E{$x}")->applyFromArray($styleDataLeft);
            $sheet->getStyle("G{$x}")->applyFromArray($styleDataLeft);
            $sheet->getStyle("K{$x}")->applyFromArray($styleDataLeft);
            $sheet->setCellValue('A' . $x, $no++);
            $sheet->setCellValue('B' . $x, $row->username);
            $sheet->setCellValue('C' . $x, $row->full_name);
            $sheet->setCellValue('D' . $x, $row->nim_nrp);
            $sheet->setCellValue('E' . $x, $row->alamat);
            $sheet->setCellValue('F' . $x, $row->no_hp);
            $sheet->setCellValue('G' . $x, $row->email);
            $tahun_angkatan = $this->Mod_angkatan->get_angkatan($row->id_angkatan);
            $sheet->setCellValue('H' . $x, $tahun_angkatan->nama_angkatan);
            $kelas = $this->Mod_kelas->get_kelas($row->id_kelas);
            $sheet->setCellValue('I' . $x, $kelas->nama_kelas);
            $sindikat = $this->Mod_sindikat->get_sindikat($row->id_sindikat);
            $sheet->setCellValue('J' . $x, $sindikat->nama_sindikat);
            if ($row->pass_foto != null) {
                $sheet->setCellValue('K' . $x, base_url('assets/foto/user/') . $row->pass_foto);
                $sheet->getCell('K' . $x)->getHyperlink()->setUrl(base_url('assets/foto/user/') . $row->pass_foto);
            }
            if ($row->is_active == 'Y') {
                $sheet->setCellValue('L' . $x, 'Aktif');
            } else if ($row->is_active == 'N') {
                $sheet->setCellValue('L' . $x, 'Non-Aktif');
            }
            $x++;
        }
        $writer = new Xlsx($spreadsheet);
        $filename = 'Data-Mahasiswa-' . mdate($format);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    private function _validate($type)
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($type == 'update') {
            $password_rules = 'trim|min_length[5]|max_length[20]';
            $data_user = $this->Mod_mahasiswa->get_user($this->input->post('id_mhs'));

            if ($data_user->nim_nrp == $this->input->post('nim')) {
                $nim_rules = 'trim|required|numeric';
            } else {
                $nim_rules = 'trim|required|numeric|is_unique[tbl_user.nim_nrp]';
            }
        } else {
            $password_rules = 'trim|required|min_length[5]|max_length[20]';
            $nim_rules = 'trim|required|numeric|is_unique[tbl_user.nim_nrp]';
        }

        $rules = [
            [
                'field' => 'nama_mhs',
                'label' => 'Nama Mahasiswa',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'nim',
                'label' => 'NIM',
                'rules' => $nim_rules
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => $password_rules
            ],
            [
                'field' => 'angkatan',
                'label' => 'Angkatan',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'kelas',
                'label' => 'Kelas',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'sindikat',
                'label' => 'Sindikat',
                'rules' => 'trim|required'
            ],
            [
                'field' => 'telepon',
                'label' => 'No. HP',
                'rules' => 'trim|numeric|max_length[20]'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|valid_email|is_unique[tbl_user.email]'
            ]
        ];

        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules($rules);
        $this->form_validation->set_message('required', '{field} Harus Diisi');
        $this->form_validation->set_message('numeric', '{field} Harus Berupa Angka');
        $this->form_validation->set_message('min_length', '{field} Minimal 5 Karakter');
        $this->form_validation->set_message('max_length', '{field} Maksimal 20 Karakter');
        $this->form_validation->set_message('is_unique', '{field} Sudah Digunakan');
        $this->form_validation->set_message('valid_email', 'Format {field} Tidak Valid');

        foreach ($rules as $index) {
            if (!$this->form_validation->run($index['field'])) {
                $data['inputerror'][] = $index['field'];
                $data['error_string'][] = form_error($index['field']);
                $data['status'] = FALSE;
            }
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}

/* End of file Mahasiswa.php */