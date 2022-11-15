<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('fungsi');
        $this->load->library('user_agent');
        $this->load->helper('myfunction_helper');
        $this->load->model('Mod_user');
        $this->load->model('Mod_aktivasi_user');
        $this->load->model('Mod_userlevel');
        $this->load->model('Mod_dashboard');
        $this->load->model('Mod_log');

        // $this->output->enable_profiler(ENVIRONMENT == 'development');
        // backButtonHandle();
    }

    function index()
    {
        $data['judul'] = 'Dashboard';
        $data['user'] = $this->Mod_user->total_rows();
        $data['pendinguser'] = $this->Mod_aktivasi_user->total_rows();

        $logged_in = $this->session->userdata('logged_in');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect('login');
        } else {
            // $this->template->load('layoutbackend', 'dashboard/view_dashboard', $data);
            $js = $this->load->view('dashboard/dashboard-js', null, true);
            $this->template->views('dashboard/home', $data, $js);
        }

        // echo json_encode($data['dataPenelitian']);
        // echo json_encode($data['dataPKM']);
    }

    public function ajax_list()
    {
        ini_set('memory_limit', '512M');
        set_time_limit(3600);
        $list = $this->Mod_log->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $log) {
            // $cekuser = $this->Mod_kelas->getuser($kelas->id_kelas); 
            $no++;
            $row = array();
            $row[] = $log->log_username;
            $row[] = $log->log_type;
            $row[] = $log->log_desc;
            $row[] = $log->log_ip;
            $row[] = $log->log_os;
            $row[] = $log->log_browser;
            $row[] = tgl_indonesia($log->log_time);
            // $row[] = $cekuser;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Mod_log->count_all(),
            "recordsFiltered" => $this->Mod_log->count_filtered(),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    function getdata()
    {
        $post = $this->input->post();
        $this->id_priode = $post['priode'];
        echo json_encode($this->id_priode = $post['priode']);
    }

    function fetch_data()
    {
        $penelitian = [];
        $pkm = [];

        $id = $_POST['idPriode'];
        // echo json_encode($id);
        if ($id != null) {
            // $penelitian = [];
            $dataPenelitian = $this->Mod_dashboard->get_total_penelitian($id);
            $dataPKM = $this->Mod_dashboard->get_total_pkm($id);
            $dataPriode = $this->Mod_priode->get_priode($id);

            foreach ($dataPenelitian->result() as $row) {
                $penelitian['nama_level'][] = $row->nama_level;
                $penelitian['total'][] = (int) $row->total;
            }

            // $data['dataPenelitian'] = json_encode($penelitian);

            // foreach ($dataPenelitian->result_array() as $row) {
            //     $output[] = array(
            //         'nama_lv'  => $row["nama_level"],
            //         'total' => $row["total"]
            //     );
            // }

            // return $penelitian;
            foreach ($dataPKM->result() as $row) {
                $penelitian['nama_level_pkm'][] = $row->nama_level;
                $penelitian['totalPKM'][] = (int) $row->total;
            }

            $penelitian['priode'][] = $dataPriode->priode;

            echo json_encode($penelitian);
            // foreach ($dataPriode->result_array() as $priode) {
            //     $output[] = array(
            //         'priode' => $priode["priode"]
            //     );
            // }


        }
        // echo json_encode($output);
    }

    function clearLog() {
        $this->Mod_log->clear_log();
        $data['status'] = TRUE;
        echo json_encode($data);
    }
}
/* End of file Dashboard.php */
