<?php

use PhpOffice\PhpSpreadsheet\Worksheet\Row;

defined('BASEPATH') or exit('No direct script access allowed');

class Mod_perkembangan_bayi extends CI_Model
{

    var $table = 'tbl_bayi';
    var $column_order = array('a.id_bayi', 'b.nama_bayi', 'a.berat_badan', 'a.panjang_badan', 'a.diagnosa_medis', 'a.tgl_dibuat');
    var $column_search = array('a.id_bayi', 'b.nama_bayi', 'a.berat_badan', 'a.panjang_badan', 'a.diagnosa_medis', 'a.tgl_dibuat');
    var $order = array('a.id_bayi' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($role, $id)
    {
        if ($role != "Orang Tua") {
            $this->db->select('a.*, b.*, c.*, d.*');
            $this->db->join('tbl_bayi b', 'a.id_bayi=b.id_bayi');
            $this->db->join('tbl_tanda_vital c', 'a.id_perkembangan_bayi=c.id_perkembangan_bayi');
            $this->db->join('tbl_hasil_laboratorium d', 'a.id_perkembangan_bayi=d.id_perkembangan_bayi');
            $this->db->from('tbl_data_perkembangan_bayi a');
            $this->db->where('a.deleted !=', 1); // hide from list when deleted
        } else {
            $this->db->select('a.*, b.*, c.*, d.*');
            $this->db->join('tbl_bayi b', 'a.id_bayi=b.id_bayi');
            $this->db->join('tbl_tanda_vital c', 'a.id_perkembangan_bayi=c.id_perkembangan_bayi');
            $this->db->join('tbl_hasil_laboratorium d', 'a.id_perkembangan_bayi=d.id_perkembangan_bayi');
            $this->db->join('tbl_orang_tua e', 'b.id_orangtua=e.id_orangtua');
            $this->db->from('tbl_data_perkembangan_bayi a');
            $this->db->where('a.deleted =', 0); // hide from list when deleted
            $this->db->where('b.id_orangtua =', $id); // hide from list when deleted
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

    function get_datatables($role, $id)
    {
        $this->_get_datatables_query($role, $id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($role, $id)
    {
        $this->_get_datatables_query($role, $id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all($role, $id)
    {
        if ($role != "Orang Tua") {
            $this->db->from('tbl_data_perkembangan_bayi');
            $this->db->where('deleted =', 0);
        } else {
            $this->db->join('tbl_bayi b', 'a.id_bayi=b.id_bayi');
            $this->db->join('tbl_orang_tua c', 'b.id_orangtua=c.id_orangtua');
            $this->db->from('tbl_data_perkembangan_bayi a');
            $this->db->where('a.deleted =', 0);
            $this->db->where('b.id_orangtua =', $id);
        }

        return $this->db->count_all_results();
    }

    function insert_perkembangan_bayi($data)
    {
        $this->db->insert("tbl_data_perkembangan_bayi", $data);
        return $this->db->insert_id();
    }

    function insert_tanda_vital($data)
    {
        $insert = $this->db->insert("tbl_tanda_vital", $data);
        return $insert;
    }

    function insert_hasil_laboratorium($data)
    {
        $insert = $this->db->insert("tbl_hasil_laboratorium", $data);
        return $insert;
    }

    function get_data($id)
    {
        $this->db->select('a.*, b.id_bayi, b.nama_bayi, b.berat_badan AS berat_badan_lahir, b.panjang_badan AS panjang_badan_lahir, c.*, d.*, e.full_name AS nama_perawat');
        $this->db->join('tbl_bayi b', 'a.id_bayi=b.id_bayi');
        $this->db->join('tbl_tanda_vital c', 'a.id_perkembangan_bayi=c.id_perkembangan_bayi');
        $this->db->join('tbl_hasil_laboratorium d', 'a.id_perkembangan_bayi=d.id_perkembangan_bayi');
        $this->db->join('tbl_user e', 'a.dibuat_oleh=e.id_user');
        $this->db->from('tbl_data_perkembangan_bayi a');
        $this->db->where("a.id_perkembangan_bayi", $id);
        return $this->db->get($this->table)->row();
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

    function update_perkembangan_bayi($id, $data)
    {
        $this->db->where('id_perkembangan_bayi', $id);
        $this->db->update("tbl_data_perkembangan_bayi", $data);
    }

    function update_tanda_vital($id, $data)
    {
        $this->db->where('id_perkembangan_bayi', $id);
        $this->db->update("tbl_tanda_vital", $data);
    }

    function update_hasil_laboratorium($id, $data)
    {
        $this->db->where('id_perkembangan_bayi', $id);
        $this->db->update("tbl_hasil_laboratorium", $data);
    }

    function delete($id, $user)
    {
        $this->db->where('id_perkembangan_bayi', $id);
        $this->db->set('deleted', 1);
        $this->db->set('tgl_dihapus', 'NOW()', FALSE);
        $this->db->set('dihapus_oleh', $user);
        $this->db->update('tbl_data_perkembangan_bayi');
    }

    function total_rows()
    {
        $this->db->where('deleted', 0);
        $data = $this->db->get($this->table);

        return $data->num_rows();
    }
}
