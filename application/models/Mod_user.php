<?php

use PhpOffice\PhpSpreadsheet\Worksheet\Row;

defined('BASEPATH') or exit('No direct script access allowed');

class Mod_user extends CI_Model
{

    var $table = 'tbl_user';
    var $column_order = array('', 'a.full_name', 'a.username', 'b.nama_level', 'a.is_active');
    var $column_order_orang_tua = array('a.username', 'b.nama_level', 'a.is_active', 'c.id_orangtua', 'c.nama_ayah', 'c.nama_ibu', 'c.alamat', 'c.no_hp');
    var $column_search = array('a.full_name', 'a.username', 'b.nama_level', 'a.is_active');
    var $column_search_orang_tua = array('a.username', 'b.nama_level', 'a.is_active', 'c.id_orangtua', 'c.nama_ayah', 'c.nama_ibu', 'c.alamat', 'c.no_hp');
    var $order = array('a.id_user' => 'desc'); // default order

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    private function _get_datatables_query($id_level)
    {
        if ($id_level != 3) {
            $this->db->select('a.*,b.nama_level');
        } else {
            $this->db->select('a.*,b.nama_level, c.*');
            $this->db->join('tbl_orang_tua c', 'c.id_user=a.id_user');
        }

        $this->db->join('tbl_userlevel b', 'a.id_level=b.id_level');
        $this->db->from('tbl_user a');
        $this->db->where('deleted !=', 1); // hide users from list when deleted
        $this->db->where('a.id_level =', $id_level); // get only administrator level
        $i = 0;

        if ($id_level != 3) {
            $search = $this->column_search;
            $order = $this->column_order;
        } else {
            $search = $this->column_search_orang_tua;
            $order = $this->column_order_orang_tua;
        }

        foreach ($search as $item) // loop column
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

                if (count($search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
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

    public function count_all($id_level)
    {

        $this->db->from('tbl_user');
        $this->db->where('id_level =', $id_level);
        $this->db->where('deleted =', 0);
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
        $this->db->where('deleted !=', 1);
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
        return $this->db->get("tbl_user")->row();
    }

    function insert($data)
    {
        $insert = $this->db->insert($this->table, $data);
        return $insert;
    }

    function insert_orang_tua($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    function insert_tbl_orang_tua($data)
    {
        $insert = $this->db->insert("tbl_orang_tua", $data);
        return $insert;
    }

    function get_user($id)
    {
        $this->db->where("id_user", $id);
        return $this->db->get($this->table)->row();
    }

    function get_user_orangtua($id)
{
    // Menggunakan query builder untuk join
    $this->db->select('u.*, o.*'); // Memilih semua kolom dari tbl_user (u) dan tbl_orangtua (o)
    $this->db->from($this->table . ' u'); // Alias untuk tbl_user
    $this->db->join('tbl_orang_tua o', 'u.id_user = o.id_user', 'left'); // Melakukan join dengan tbl_orangtua
    $this->db->where('u.id_user', $id); // Menentukan kondisi where

    return $this->db->get()->row(); // Mengambil hasil sebagai objek
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

    function update_orangtua($id, $data)
    {
        $this->db->where('id_user', $id);
        $this->db->update("tbl_orang_tua", $data);
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
        $this->db->set('deleted', 1);
        $this->db->set('tgl_dihapus', 'NOW()', FALSE);
        $this->db->update('tbl_user');
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

    function total_rows($id_level)
    {
        $this->db->where('id_level', $id_level);
        $data = $this->db->get($this->table);

        return $data->num_rows();
    }
}
