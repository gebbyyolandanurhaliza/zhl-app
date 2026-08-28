<?php

class M_login extends CI_Model
{

    private $tabel = 'zhl_gen_tbl_user';
    private $period = 'zhl_acc_tbl_mst_periode';
    private $tabel_akses = 'zhl_zht_user';

    function sign_in($userid, $pass)
    {
        $this->db->limit(1);
        $this->db->where('userid', $userid);
        $this->db->where('userpassword', $pass);
        $this->db->order_by('company_id', 'asc');
        return $this->db->get($this->tabel_akses);
    }

    function cek_user($userid)
    {
        $query = $this->db->get_where($this->tabel, array('userid' => $userid, 'notactive' => 0));
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    

    function cek_pass($userid, $pass)
    {
        $query = $this->db->get_where($this->tabel, array('userid' => $userid, 'userpassword' => $pass));
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function save_otp($userid, $otp)
    {
        $this->db->where('userid', $userid);
        $this->db->update($this->tabel, array('otp' => $otp));
        return $this->db->affected_rows();
    }

    function close()
    {
        return $this->db->query("select DATE_ADD(tanggal, INTERVAL 1 DAY) as tanggal FROM acc_tbl_mst_periode ")->row();
    }

    function check_kode_otp($userid, $otp)
    {
        $this->db->select('*');
        $this->db->from($this->tabel);
        $this->db->where('userid', $userid);
        $this->db->where('otp', $otp);
        return $this->db->get()->row();
    }

    function get_user_not_otp($userid)
    {
        $this->db->select('*');
        $this->db->from($this->tabel);
        $this->db->where('userid', $userid);
        return $this->db->get()->row();
    }

    function ambil_tgl()
    {
        return $this->db->get($this->period);
    }

    function get_user($userid)
    {
        $this->db->select('*');
        $this->db->from($this->tabel);
        $this->db->where('userid', $userid);
        return $this->db->get()->row();
    }

    function simpan_log($info)
    {
        $this->db->trans_start();
        $this->db->insert('zhl_gen_tbl_login_history', $info);
        $loginid = $this->db->insert_id();
        $this->db->trans_complete();
        return $loginid;
    }

    function simpan_log_out($login_id)
    {
        $this->db->trans_start();
        $this->db->where('login_id', $login_id);
        $this->db->update('zhl_gen_tbl_login_history', array('date_out' => date('Y-m-d H:i:s')));
        $this->db->trans_complete();
    }

    //
    //    function simpan_log($info) {
    //        $this->db->trans_start();
    //        $this->db->insert('tblUtl_LogOnline', $info);
    //        $signid = $this->db->insert_id();
    //        $this->db->trans_complete();
    //        return $signid;
    //    }
    //
    //    function simpan_log_out($signid) {
    //        $this->db->trans_start();
    //        $this->db->query('Update tblUtl_LogOnline Set SignOut=GetDate() Where SignID=' . $signid);
    //        $this->db->trans_complete();
    //    }
    //


}
