<?php

/**
 * Created by PhpStorm.
 * User: Reza Irhami
 * Date: 1/10/2017
 * Time: 10:13 AM
 */
class M_loadgst extends CI_Model
{

    function __construct() {
        parent::__construct();
    }

    function loadgst(){
        $insert=$this->db->query("INSERT INTO zhl_acc_tbl_trn_gst (
ref_nomor,
jenis_trans,
item,
qty,
gst_type,
gst_value,
price,
currency,
rate,
rate_sgd,
created_by,
created_date)
(SELECT a.NoJurnal,a.jenis_trans,a.Keterangan,1,a.gst_type,a.gst_value,a.Total,a.Currency,a.Rate,a.rate_sgd,a.created_by,a.created_date
FROM zhl_acc_tbl_trn_jurnal AS a
WHERE gst_type <> '' AND 
NoJurnal NOT IN (SELECT ref_nomor FROM zhl_acc_tbl_trn_gst) AND jenis_trans IN ('BI', 'BO', 'CI', 'CO', 'AP', 'AR'))
");

    }
}