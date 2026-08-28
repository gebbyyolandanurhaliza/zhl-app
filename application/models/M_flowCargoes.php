<?php

class M_flowCargoes extends CI_Model
{
    var $tbl_flowCargoes = 'tblLogUpdate_flowCargoesDtl';

    function insert_flowCargoes($data)
    {
        $this->db->insert($this->tbl_flowCargoes, $data);
        return $this->db->affected_rows();
    }
}