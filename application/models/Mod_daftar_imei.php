<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_daftar_imei extends CI_Model
{

    var $table = 'tbl_imei';
    var $column_order = array('', 'a.no_imei', 'a.tipe_hp', 'a.model_hp', 'b.full_name', 'a.created_at', 'a.status');
    var $column_search = array('a.no_imei', 'a.tipe_hp', 'a.model_hp', 'b.full_name', 'a.created_at', 'a.status');
    var $order = array('a.created_at' => 'asc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query($id)
    {
        $this->db->select('a.no_imei,
                           a.tipe_hp,
                           a.model_hp,
                           b.full_name as pendaftar,
                           a.created_at,
                           a.status');
        $this->db->join('tbl_user b', 'a.created_by=b.id_user');
        $this->db->from("{$this->table} a");
        if ($id != '1') {
            $this->db->where('a.created_by', $id);
        }

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

    function get_datatables($id)
    {
        $this->_get_datatables_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id)
    {
        $this->_get_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($id)
    {
        $this->db->from($this->table);
        if($id != '1'){
            $this->db->where('created_by', $id);
        }
        return $this->db->count_all_results();
    }

    function get_all()
    {
        return $this->db->get($this->table)
            ->result();
    }

    function get_imei($id)
    {
        $this->db->where('id_data_imei', $id);
        return $this->db->get($this->table)->row();
    }

    function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert;
    }

    function update($id, $data)
    {
        $this->db->where('id_data_imei', $id);
        $this->db->update($this->table, $data);
    }

    function delete($id)
    {
        $this->db->where('id_data_imei', $id);
        $this->db->delete($this->table);
    }
}

/* End of file Mod_manufaktur_imei.php */