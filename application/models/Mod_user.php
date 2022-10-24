<?php

use PhpOffice\PhpSpreadsheet\Worksheet\Row;

defined('BASEPATH') or exit('No direct script access allowed');

class Mod_user extends CI_Model
{

    var $table = 'tbl_user';
    var $column_order = array('', 'full_name', 'username', 'nama_angkatan', 'nama_level', 'is_active');
    var $column_search = array('full_name', 'username', 'nama_angkatan', 'nama_level', 'is_active');
    var $order = array('id_user' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($id_level)
    {
        $this->db->select('a.*,b.nama_level,c.nama_angkatan as angkatan');
        $this->db->join('tbl_userlevel b', 'a.id_level=b.id_level');
        $this->db->join('tbl_angkatan c', 'a.id_angkatan=c.id_angkatan');
        $this->db->from('tbl_user a');
        $this->db->where('b.id_level !=', $id_level);
        $i = 0;

        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($id_level)
    {
        $this->_get_datatables_query($id_level);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id_level)
    {
        $this->_get_datatables_query($id_level);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {

        $this->db->from('tbl_user');
        return $this->db->count_all_results();
    }

    function view_user($id)
    {
        $this->db->where('id_user', $id);
        return $this->db->get('tbl_user');
    }

    function getAll()
    {
        $this->db->select('a.*,b.nama_level');
        $this->db->join('tbl_userlevel b', 'a.id_level = b.id_level');
        $this->db->order_by('a.id_user desc');
        return $this->db->get('tbl_user a');
    }

    function get_all($level = '')
    {
        $this->db->where('id_level !=', 1);
        if ($level != '') {
            $this->db->where('id_level =', $level);
        }
        return $this->db->get($this->table)
            ->result();
    }

    function get_all_mahasiswa_dosen($id)
    {
        $this->db->where('id_level !=', 1);
        $this->db->where('id_level !=', 8);
        $this->db->where('id_user !=', $id);
        return $this->db->get($this->table)
            ->result();
    }

    function get_all_mahasiswa()
    {
        $this->db->where('id_level =', 6);
        return $this->db->get($this->table)
            ->result();
    }

    function cekUsername($username)
    {
        $this->db->where("username", $username);
        return $this->db->get("tbl_user");
    }

    function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert;
    }

    function insert_new_user($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function get_user($id)
    {
        $this->db->where("id_user", $id);
        return $this->db->get($this->table)->row();
    }

    function get_user_by_role($id)
    {
        $this->db->where('id_level', $id);
        return $this->db->get($this->table)->row();
    }

    function update($id, $data)
    {
        $this->db->where('id_user', $id);
        $this->db->update($this->table, $data);
    }

    function update_status($id)
    {
        $this->db->where('id_user', $id);
        $this->db->set('is_active', 'Y');
        $this->db->update('tbl_user');
    }

    function delete($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete($this->table);
    }

    function userlevel()
    {
        return $this->db->order_by('id_level ASC')
            ->get('tbl_userlevel')
            ->result();
    }

    function userlevelRegister()
    {
        $this->db->where('id_level !=', 1);
        return $this->db->order_by('id_level ASC')
            ->get('tbl_userlevel')
            ->result();
    }

    function prodi()
    {
        return $this->db->order_by('id_prodi ASC')
            ->get('tbl_program_studi')
            ->result();
    }

    function get_pass_foto($id)
    {
        $this->db->select('pass_foto');
        $this->db->from('tbl_user');
        $this->db->where('id_user', $id);
        return $this->db->get();
    }

    function reset_pass($id, $data)
    {
        $this->db->where('id_user', $id);
        $this->db->update('tbl_user', $data);
    }

    function total_rows()
    {
        $data = $this->db->get($this->table);
        return $data->num_rows();
    }
}