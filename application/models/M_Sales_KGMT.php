<?php defined('BASEPATH') OR exit('No direct script access allowed');

/* 
 * Author : ITD16 ( FCHAN )
 * Date   : 15/01/2018
 * Time   : 14:26
 */

class M_Sales_KGMT extends CI_Model
{
	// function getCust($dari, $sampai){
	// 	$sql = $this->db->query("SELECT custid, custcompany FROM ship_tbl_trn_inv_hdr where shipdate BETWEEN '".$dari."' AND '".$sampai."' GROUP BY custid;");
	// 	return $sql->result();
	// }

	// function getList($dari, $sampai, $cust, $catid){
	// 	$sql = $this->db->query("SELECT	a.custid, e.product_category_id,	SUM(b.qty*c.uom_volume*ConvertToKG) as TotalKG, SUM(b.qty*c.uom_volume*ConvertToMT) as TotalMT
	// 						FROM
	// 							ship_tbl_trn_inv_hdr a
	// 						INNER JOIN ship_tbl_trn_inv_dtl b ON `b`.`invno` = `a`.`invno` 
	// 						INNER JOIN  mar_tblmst_product c ON c.product_id = b.productid
	// 						INNER JOIN gen_tbl_mst_convertuomvolume d ON c.uom_volume_id = d.ID
	// 						INNER JOIN mar_tblmst_product_category e ON c.product_category_id = e.product_category_id
	// 						where a.custid = '".$cust."' AND e.product_category_id = '".$catid."'  AND a.shipdate BETWEEN '".$dari."' AND '".$sampai."'
	// 						GROUP BY a.custid, e.product_category_id");
	// 	return $sql->row();
	// }

	// function getproduct($dari, $sampai){

	// 	$sql = $this->db->query("SELECT e.product_category_id, e.product_category_name FROM ship_tbl_trn_inv_hdr a
	// 								INNER JOIN ship_tbl_trn_inv_dtl b ON `b`.`invno` = `a`.`invno` 
	// 								INNER JOIN  mar_tblmst_product c ON c.product_id = b.productid
	// 								INNER JOIN mar_tblmst_product_category e ON c.product_category_id = e.product_category_id
	// 								WHERE a.shipdate BETWEEN '".$dari."' AND '".$sampai."'
	// 								GROUP BY e.product_category_id ORDER BY e.product_category_id
	// 							");
	// 	return $sql->result();
	// }
	function ambildata($dari, $sampai){
		return $this->db->query("
				SELECT
					a.custid, a.custcompany,
					SUM(IF(e.product_category_id=1,b.qty*c.net_weight,0)) as TKGUHT,
					SUM(IF(e.product_category_id=1,b.qty*c.net_weight*0.001,0)) as TMTUHT,
					
					SUM(IF(e.product_category_id=2,b.qty*c.net_weight,0)) as TKGDC,
					SUM(IF(e.product_category_id=2,b.qty*c.net_weight*0.001,0)) as TMTDC,
					
					SUM(IF(e.product_category_id=3,b.qty*c.net_weight,0)) as TKGCP,
					SUM(IF(e.product_category_id=3,b.qty*c.net_weight*0.001,0)) as TMTCP,

					SUM(IF(e.product_category_id=4,b.qty*c.net_weight,0)) as TKGPJC,
					SUM(IF(e.product_category_id=4,b.qty*c.net_weight*0.001,0)) as TMTPJC,

					SUM(IF(e.product_category_id=5,b.qty*c.net_weight,0)) as TKGPS,
					SUM(IF(e.product_category_id=5,b.qty*c.net_weight*0.001,0)) as TMTPS,

					SUM(IF(e.product_category_id=9,b.qty*c.net_weight,0)) as TKGCWC,
					SUM(IF(e.product_category_id=9,b.qty*c.net_weight*0.001,0)) as TMTCWC,

					SUM(IF(e.product_category_id=11,b.qty*c.net_weight,0)) as TKGCSC,
					SUM(IF(e.product_category_id=11,b.qty*c.net_weight*0.001,0)) as TMTCSC,

					SUM(IF(e.product_category_id=12,b.qty*c.net_weight,0)) as TKGCCC,
					SUM(IF(e.product_category_id=12,b.qty*c.net_weight*0.001,0)) as TMTCCC,

					SUM(IF(e.product_category_id=13,b.qty*c.net_weight,0)) as TKGCMP,
					SUM(IF(e.product_category_id=13,b.qty*c.net_weight*0.001,0)) as TMTCMP,

					SUM(IF(e.product_category_id=14,b.qty*c.net_weight,0)) as TKGCW,
					SUM(IF(e.product_category_id=14,b.qty*c.net_weight*0.001,0)) as TMTCW,

					SUM(IF(e.product_category_id=15,b.qty*c.net_weight,0)) as TKGCO,
					SUM(IF(e.product_category_id=15,b.qty*c.net_weight*0.001,0)) as TMTCO,

					SUM(IF(e.product_category_id=16,b.qty*c.net_weight,0)) as TKGAC,
					SUM(IF(e.product_category_id=16,b.qty*c.net_weight*0.001,0)) as TMTAC,

					SUM(IF(e.product_category_id=17,b.qty*c.net_weight,0)) as TKGVCO,
					SUM(IF(e.product_category_id=17,b.qty*c.net_weight*0.001,0)) as TMTVCO,

					SUM(IF(e.product_category_id=18,b.qty*c.net_weight,0)) as TKGUHTCM,
					SUM(IF(e.product_category_id=18,b.qty*c.net_weight*0.001,0)) as TMTUHTCM,

					SUM(IF(e.product_category_id=19,b.qty*c.net_weight,0)) as TKGCMD,
					SUM(IF(e.product_category_id=19,b.qty*c.net_weight*0.001,0)) as TMTCMD,

					SUM(IF(e.product_category_id=20,b.qty*c.net_weight,0)) as TKGCS,
					SUM(IF(e.product_category_id=20,b.qty*c.net_weight*0.001,0)) as TMTCS
				FROM
					zhl_ship_tbl_trn_inv_hdr a
				INNER JOIN zhl_ship_tbl_trn_inv_dtl b ON `b`.`invno` = `a`.`invno` 
				INNER JOIN  zhl_mar_tblmst_product c ON c.product_id = b.productid
				INNER JOIN zhl_mar_tblmst_product_category e ON c.product_category_id = e.product_category_id
				WHERE a.docdate BETWEEN '$dari' AND '$sampai'
				GROUP BY a.custid;
			")->result();
	}

}