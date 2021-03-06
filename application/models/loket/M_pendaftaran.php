<?php
class M_pendaftaran extends CI_Model
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
        $field = "no_ref_pelayanan";
        $tabel = "pelayanan";
        $digit = "3";
        $ymd = date('ymd');
        $q = $this->db->query("SELECT MAX(RIGHT($field,$digit)) AS kd_max FROM $tabel WHERE SUBSTR($field, 1, 6) = $ymd LIMIT 1");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = sprintf('%0' . $digit . 's', $tmp);
            }
        } else {
            $kd = "001";
        }
        date_default_timezone_set('Asia/Jakarta');
        return date('ymd') . '-' . $kd; // SELECT SUBSTR('RI191121-0001', 3, 6); dari digit ke 3 sampai 6 digit seanjutnya
    }

    function get_no_bp($tipe_antrian, $waktu_antrian)
    {
        $field = "kode_antrian_bp";
        $tabel = "antrian_bp";
        $digit = "3";
        if ($waktu_antrian == "Pagi") {
            if ($tipe_antrian == "Dewasa") {
                $kode = "PA";
            } else if ($tipe_antrian == "Anak-Anak") {
                $kode = "PAG";
            }
        } else if ($waktu_antrian == "Sore") {
            if ($tipe_antrian == "Dewasa") {
                $kode = "SA";
            } else if ($tipe_antrian == "Anak-Anak") {
                $kode = "SAG";
            }
        }


        $q = $this->db->query("SELECT MAX(RIGHT($field,$digit)) AS kd_max FROM $tabel WHERE tanggal_antrian=CURRENT_DATE AND waktu_antrian='$waktu_antrian'");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = $kode . sprintf('%0' . $digit . 's',  $tmp);
            }
        } else {
            if ($waktu_antrian == "Pagi") {
                if ($tipe_antrian == "Dewasa") {
                    $kode = "PA001";
                } else if ($tipe_antrian == "Anak-Anak") {
                    $kode = "PAG001";
                }
            } else if ($waktu_antrian == "Sore") {
                if ($tipe_antrian == "Dewasa") {
                    $kode = "SA001";
                } else if ($tipe_antrian == "Anak-Anak") {
                    $kode = "SAG001";
                }
            }
        }
        return $kd;
    }

    function get_no_lab($tipe_antrian)
    {
        $field = "kode_antrian_lab";
        $tabel = "antrian_lab";
        $digit = "3";

        if ($tipe_antrian == "Dewasa") {
            $kode = "A";
        } else if ($tipe_antrian == "Anak-Anak") {
            $kode = "AG";
        }

        $q = $this->db->query("SELECT MAX(RIGHT($field,$digit)) AS kd_max FROM $tabel WHERE tanggal_antrian=CURRENT_DATE");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = $kode . sprintf('%0' . $digit . 's',  $tmp);
            }
        } else {
            if ($tipe_antrian == "Dewasa") {
                $kd = "C001";
            } else if ($tipe_antrian == "Anak-Anak") {
                $kd = "CG001";
            }
        }
        return $kd;
    }

    function get_no_kia($tipe_antrian)
    {
        $field = "kode_antrian_kia";
        $tabel = "antrian_kia";
        $digit = "3";
        if ($tipe_antrian == "Dewasa") {
            $kode = "B";
        } else if ($tipe_antrian == "Anak-Anak") {
            $kode = "BG";
        }


        $q = $this->db->query("SELECT MAX(RIGHT($field,$digit)) AS kd_max FROM $tabel WHERE tanggal_antrian=CURRENT_DATE");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = $kode . sprintf('%0' . $digit . 's',  $tmp);
            }
        } else {
            if ($tipe_antrian == "Dewasa") {
                $kd = "B001";
            } else if ($tipe_antrian == "Anak-Anak") {
                $kd = "BA001";
            }
        }
        return $kd;
    }

    function search_autocomplete($table, $field, $data)
    {
        $this->db->like($field, $data, 'both');
        $this->db->order_by($field, 'ASC');
        $this->db->limit(10);
        return $this->db->get($table)->result();
    }
    // function get_no_transaksi_ambulan()
    // {
    //     $field = "no_pelayanan_a";
    //     $tabel = "pelayanan_ambulan";
    //     $digit = "3";
    //     $kode = "T";
    //     $q = $this->db->query("SELECT MAX(RIGHT($field,$digit)) AS kd_max FROM $tabel");
    //     $kd = "";
    //     if ($q->num_rows() > 0) {
    //         foreach ($q->result() as $k) {
    //             $tmp = ((int) $k->kd_max) + 1;
    //             $kd = $kode . sprintf('%0' . $digit . 's', $tmp);
    //         }
    //     } else {
    //         $kd = "T001";
    //     }
    //     return $kd;
    // }

    function get_no_rm()
    {
        $field = "no_rm";
        $tabel = "master_pasien";
        $digit = "9";
        $kode = "024";

        $q = $this->db->query("SELECT MAX(RIGHT($field,$digit)) AS kd_max FROM $tabel");
        $kd = "";
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $k) {
                $tmp = ((int) $k->kd_max) + 1;
                $kd = $kode . sprintf('%0' . $digit . 's', $tmp);
            }
        } else {
            $kd = "024000000001";
        }
        return $kd;
    }
}
