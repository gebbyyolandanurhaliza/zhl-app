<?php
class M_status_container extends CI_Model
{
	private $tb_status_container		= 'zhl_tbms_status_container';

	function __construct()
    {
        parent::__construct();
    }

	function get_all()
	{
		return $this->db->get($this->tb_status_container)->result();
	}

	

}
