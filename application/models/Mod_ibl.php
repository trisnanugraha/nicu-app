<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mod_ibl extends CI_Model
{

    var $table = 'tbl_ibl';
    var $column_order = array('', 'no_surat');
    var $column_search = array('no_surat');
    var $order = array('id_ibl' => 'desc'); // default order 

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    private function _get_datatables_query($level)
    {
        if ($level == 'Mahasiswa') {
            $this->db->where('status_kakorwa=', 'Disetujui');
            $this->db->from($this->table);
        } else {
            $this->db->from($this->table);
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

    function get_datatables($level)
    {
        $this->_get_datatables_query($level);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($level)
    {
        $this->_get_datatables_query($level);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    function get_all()
    {
        return $this->db->get($this->table)
            ->result();
    }

    function get_all_kelas()
    {
        $this->db->where('nama_kelas !=', '-');
        return $this->db->get($this->table)
            ->result();
    }

    function get_id_angkatan($id)
    {
        $this->db->select('id_angkatan');
        $this->db->where('id_ibl', $id);
        return $this->db->get($this->table)->row();
    }

    function get_ibl($id)
    {
        $this->db->where('id_ibl', $id);
        return $this->db->get($this->table)->row();
    }

    function getuser($id_prodi)
    {
        $this->db->where('id_prodi', $id_prodi);
        $this->db->where('is_active', 'Y');
        $this->db->from('tbl_user');
        return $this->db->count_all_results();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function update($id, $data)
    {
        $this->db->where('id_ibl', $id);
        $this->db->update($this->table, $data);
    }

    function delete($id)
    {
        $this->db->where('id_ibl', $id);
        $this->db->delete($this->table);
    }

    function total_rows()
    {
        $data = $this->db->get($this->table);
        return $data->num_rows();
    }
}

/* End of file Mod_angkatan.php */