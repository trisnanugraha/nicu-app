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
        $this->load->model('Mod_userlevel');
        $this->load->model('Mod_dashboard');
        $this->load->model('Mod_log');

        // $this->output->enable_profiler(ENVIRONMENT == 'development');
        // backButtonHandle();
    }

    function index()
    {
        $data['judul'] = 'Dashboard';
        $data['admin'] = $this->Mod_user->total_rows(1);
        $data['perawat'] = $this->Mod_user->total_rows(2);
        $data['orangtua'] = $this->Mod_user->total_rows(3);
        
        $logged_in = $this->session->userdata('logged_in');
        $data['role'] = $this->session->userdata('hak_akses');
        if ($logged_in != TRUE || empty($logged_in)) {
            redirect('login');
        } else {
            // $this->template->load('layoutbackend', 'dashboard/view_dashboard', $data);
            $js = $this->load->view('dashboard/dashboard-js', null, true);
            $this->template->views('dashboard/home', $data, $js);
        }

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

    function clearLog() {
        $this->Mod_log->clear_log();
        $data['status'] = TRUE;
        echo json_encode($data);
    }
}
/* End of file Dashboard.php */
