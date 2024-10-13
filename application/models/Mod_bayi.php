<?php

use PhpOffice\PhpSpreadsheet\Worksheet\Row;

defined('BASEPATH') or exit('No direct script access allowed');

class Mod_bayi extends CI_Model
{

    var $table = 'tbl_bayi';
    var $column_order = array('a.id_bayi', 'a.id_orangtua', 'a.nama_bayi', 'a.jenis_kelamin', 'a.tgl_lahir');
    var $column_search = array('a.id_bayi', 'a.id_orangtua', 'a.nama_bayi', 'a.jenis_kelamin', 'a.tgl_lahir');
    var $order = array('a.id_bayi' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query()
    {
        $this->db->select('a.*');
        $this->db->join('tbl_orang_tua b', 'a.id_orangtua=b.id_orangtua');
        $this->db->from('tbl_bayi a');
        $this->db->where('a.deleted !=', 1); // hide from list when deleted

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

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {

        $this->db->from('tbl_bayi');
        $this->db->where('deleted =', 0);
        return $this->db->count_all_results();
    }

    function get_all()
    {
        $this->db->where('deleted =', 0);
        return $this->db->get($this->table)
            ->result();
    }

    function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert;
    }

    function get_bayi($id)
    {
        $this->db->where("id_bayi", $id);
        return $this->db->get($this->table)->row();
    }

    function get_bayi_orangtua($id)
    {
        $this->db->select('b.*,o.*');
        $this->db->join('tbl_orang_tua o', 'b.id_orangtua = o.id_orangtua');
        $this->db->where('b.id_orangtua =', $id);
        $this->db->where('b.deleted =', 0);
        return $this->db->get($this->table . ' b')
            ->result();
    }

    function update($id, $data)
    {
        $this->db->where('id_bayi', $id);
        $this->db->update($this->table, $data);
    }

    function delete($id)
    {
        $this->db->where('id_bayi', $id);
        $this->db->set('deleted', 1);
        $this->db->set('tgl_dihapus', 'NOW()', FALSE);
        $this->db->update('tbl_bayi');
    }

    function total_rows()
    {
        $this->db->where('deleted', 0);
        $data = $this->db->get($this->table);

        return $data->num_rows();
    }
}
