<?php
class M_user extends CI_Model
{
    function tampil_data($table)
    {
        return $this->db->get($table);
    }

    function input_data($table, $data)
    {
        $status = $this->db->insert($table, $data);
        return $status;
    }

    function hapus_data($where, $table)
    {
        $this->db->where($where);
        $status = $this->db->delete($table);
        return $status;
    }

    function get_data($table, $where)
    {
        return $this->db->get_where($table, $where);
    }

    function update_data($where, $table, $data)
    {
        $this->db->where($where);
        $status = $this->db->update($table, $data);
        return $status;
    }

    // autogenerate kode / ID
    function get_no()
    {
        $field = "no_user_pegawai";
        $tabel = "user_pegawai";
        $digit = "3";
        $kode = "P";
        $q = $this->db->query("SELECT MAX(RIGHT($field,$digit)) AS kd_max FROM $tabel");
        $kd = "";
        if ($q->num_rows() > 0) {
        foreach ($q->result() as $k) {
        $tmp = ((int) $k->kd_max) + 1;
        $kd = $kode . sprintf('%0' . $digit . 's', $tmp);
        }
        } else {
        $kd = "P001";
        }
        return $kd;
    }
    
}
