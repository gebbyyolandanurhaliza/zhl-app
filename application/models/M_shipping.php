<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_shipping extends CI_Model
{
  private $container_stock = 'zhl_ship_tbl_trn_cont_stock';
  private $tblContHdr = "ship_tbl_trn_cont_hdr";
  private $tblContLocalDet = "ship_tbl_trn_cont_local_dtl";
  private $tblContAccept = "ship_tbl_trn_cont_acceptance_dtl";
  private $tbltrucking = "zhl_shipping_mon_dksh_trucking";

  private $db3;
  public function __construct()
  {
    parent::__construct();
    $this->db3 = $this->load->database('db3', TRUE);
  }
  //    ---------------------------------------------------------About Shipping Liner---------------------------------------------------------------
  function tampil_shipping_liner()
  {
    $this->db->where('notactive = 0');
    $this->db->order_by('shipping_tipe ', 'asc');
    $this->db->order_by('shipping_name', 'asc');
    $result =  $this->db->get('ship_tbl_mst_shipping_line');
    

    return $result->result();
  }

  function get_stuffing_rpt()
  {
    $this->db->select('stuffing_abbr, stuffing_name');
    $this->db->from('shp_vw_mst_stuffing');
    $sql = $this->db->get();
    if ($sql->num_rows() > 0) {
      $result[''] = "Select";
      foreach ($sql->result_array() as $row) {
        $result[$row['stuffing_abbr']] = ucwords(strtolower($row['stuffing_name']));
      }
      return $result;
    } else {
      echo "";
    }
  }

  function monitor_filter_excel($param_search, $schedule_date1, $schedule_date2)
  {


    $this->db->where('schedule_date >=', dmy_to_ymd($schedule_date1));
    $this->db->where('schedule_date <=', dmy_to_ymd($schedule_date2));

    $this->db->group_start();

    $this->db->like('po_number', $param_search);
    $this->db->or_like('contract_no', $param_search);
    $this->db->or_like('client_ref_no', $param_search);
    $this->db->or_like('factory_abbr', $param_search);
    $this->db->or_like('reff', $param_search);
    $this->db->group_end();
    $this->db->order_by('urut_container', 'asc');

    return $this->db->get('mar_vw_trn_shipping_instruction_find_zhl_shipping')->result();
  }


  function tampil_stuffing_filter($shipdate, $factory, $stuffing)
  {
    $shipmentdate = "%" . $shipdate . "%";

    return $this->db->query("
        SELECT distinct
         c.stuffing_name as type,
        c.stuffing_abbr

        from zhl_ship_vw_trn_cont a
        LEFT JOIN zhl_shp_tblmst_bargecharges b on a.container_id=b.container_id
        LEFT JOIN shp_vw_mst_stuffing c on c.stuffing_abbr= a.stuffing
        LEFT JOIN zhl_tbl_mst_trucking d on d.container_size= a.container_size
        WHERE a.shipmentdate='$shipdate' and a.factory_id=1 and a.tipe=1
        GROUP BY a.stuffing,a.container_size,a.container_abbr

                    ;
        ")->result();
  }


  function tampilfactory($data)
  {
    $query = "(factory_id like '%" . $data . "%' or factory_name like '%" . $data . "%')";
    $result =  $this->db->get('gen_tbl_mst_factory');
    return $result->result();
  }

  function tampil_sc_stuffing_filter($p_shipdate, $factory)
  {
    $shipmentdate = "%" . $p_shipdate . "%" . $factory_id = "%" . $factory . "%";


    return $this->db->query("SELECT
        c.stuffing_name as type,
        SUM(a.c20) AS C20,
		SUM(a.c40) AS C40,
        a.stuffing,
        a.shipmentdate,
        a.container_size,
        a.container_id,
        a.container_abbr,
        a.contid,
        a.factory_id,
        a.factory_abbr,
        a.container_name,
        case
				when (a.container_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,16,17,18,19,20,21,22,23,24,26,27,28,29,30) and a.stuffing='EE') then b.cust_export_empty
				when (a.container_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,16,17,18,19,20,21,22,23,24,26,27,28,29,30) and a.stuffing='EL') then b.cust_export_laden
				when (a.container_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,16,17,18,19,20,21,22,23,24,26,27,28,29,30) and a.stuffing='IT') then b.cust_import_transhipment
				when (a.container_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,16,17,18,19,20,21,22,23,24,26,27,28,29,30) and a.stuffing='LC') then b.cust_local_laden

				END
				as barge_cost,
				case
				when (a.container_size=20) then d.cust_trucking_price
				END
				as trucking_cost_20,
                case
                when (a.container_size=40) then d.cust_trucking_price
                END
                as trucking_cost_40
        from zhl_ship_vw_trn_cont a
        LEFT JOIN zhl_shp_tblmst_bargecharges b on a.container_id=b.container_id
        LEFT JOIN shp_vw_mst_stuffing c on c.stuffing_abbr= a.stuffing
        LEFT JOIN zhl_tbl_mst_trucking d on d.container_size= a.container_size
        WHERE a.shipmentdate='$p_shipdate' and a.factory_id='$factory' and a.tipe=1
        GROUP BY a.stuffing,a.container_size,a.container_abbr;
         ")->result();
  }

  function call_barge_billing($contid)
  {

    $hdr = $this->db->query("SELECT contid, barge,voyage,etd,shipmentdate,eta from ship_tbl_trn_cont_hdr where contid='$contid' ")->row();

    //billing

    $billing = $this->db->query("SELECT po_number, factory_abbr,container_name, stuffing, container_abbr,c20,c40 from zhl_ship_vw_trn_cont where contid= '$hdr->contid' order by stuffing,container_abbr")->result();

    $tetra_billing = [];
    $billing_filter = [];
    $local_biling = [];
    foreach ($billing as $b) {
      if ($b->stuffing == 'ELTP') {
        $tetra_billing[] = $b;
      } elseif ($b->stuffing == 'EL') {
        $local_biling[] = $b;
      } else {
        $billing_filter[] = $b;
      }
    }


    $local = $this->db->query("SELECT po_number, c20,c40,stuffing,container_size,container_abbr from ship_vw_container_local2 WHERE contid= '$hdr->contid' order by stuffing,container_abbr")->result();

    $tetra_local = [];
    $local_filter = [];
    foreach ($local as $c) {
      if ($c->stuffing == 'LLTP') {
        $tetra_local[] = $c;
      } else {
        $local_filter[] = $c;
      }
    }

    $localall = array_merge($local_biling, $local_filter);
    $tetra_all = array_merge($tetra_billing, $tetra_local);

    $hasil = [
      'hdr' => $hdr,
      'billing' => $billing_filter,
      'local' => $localall,
      'tetra' => $tetra_all,
    ];

    return $hasil;
  }



  function tampil_inv_where_detail_arr($p_shipdate, $factory)
  {

    $hdr = $this->db->query("SELECT contid, barge,voyage,etd,shipmentdate,eta from zhl_ship_vw_trn_cont where shipmentdate='$p_shipdate' and factory_id ='$factory' limit 1")->row();

    $hdrinward = $this->db->query("SELECT contid, barge,voyage,etd,shipmentdate,eta from zhl_ship_vw_trn_cont where shipmentdate='$p_shipdate' and factory_id ='$factory' and tipe=2 limit 1")->row();


    //billing
    $billing = $this->db->query("SELECT type,c20,c40,stuffing,shipmentdate,container_size,container_id,container_abbr,contid,factory_id,factory_abbr,container_name,barge_cost,trucking_cost_20,trucking_cost_40,stuffing_name from vw_stuffing_tes where contid= '$hdr->contid' ")->result();




    $tetra_billing = [];
    $billing_filter = [];
    $local_biling = [];

    foreach ($billing as $b) {
      if ($b->stuffing == 'ELTP') {
        $tetra_billing[] = $b;
      } elseif ($b->stuffing == 'EL') {
        $local_biling[] = $b;
      } else {
        $billing_filter[] = $b;
      }
    }
    // $billing_inward
    $billinglocal = $this->db->query("SELECT stuffing_name as type, stuffing, c20,c40,container_size,barge_cost,trucking_cost_20,trucking_cost_40,container_abbr,contid from vw_stuffing_local_inward where contid= '$hdrinward->contid' ")->result();



    //local
    $local = $this->db->query("SELECT stuffing_name, stuffing, c20,c40,container_size,barge_cost,trucking_cost_20,trucking_cost_40,container_abbr,contid from vw_stuffing_local_tes WHERE contid= '$hdr->contid'")->result();

    $tetra_local = [];
    $local_filter = [];
    foreach ($local as $c) {
      if ($c->stuffing == 'LLTP') {
        $tetra_local[] = $c;
      } else {
        $local_filter[] = $c;
      }
    }

    $localall = array_merge($local_biling, $local_filter);
    $tetra_all = array_merge($tetra_billing, $tetra_local);
    $billingall = array_merge($billing_filter, $billinglocal);

    $hasil = [
      'hdr' => $hdr,
      'billing' => $billingall,
      'local' => $localall,
      'tetra' => $tetra_all,


    ];

    return $hasil;
  }


  function tampil_inv_where_detail_arr_montly($p_dari, $p_sampai, $factory)
  {

    $hdr = $this->db->query("SELECT distinct contid,eta from zhl_ship_vw_trn_cont where shipmentdate between '$p_dari' and  '$p_sampai' and factory_id ='$factory' and tipe=1")->result_array();

    $hdrinward = $this->db->query("SELECT distinct contid as contidinward,eta from zhl_ship_vw_trn_cont where shipmentdate between '$p_dari' and  '$p_sampai' and factory_id ='$factory' and tipe=2")->result_array();


    $contid = [];
    foreach ($hdr as $h) {
      $contid[] = $h['contid'];
    }

    $contidinward = [];
    foreach ($hdrinward as $h) {
      $contidinward[] = $h['contidinward'];
    }

    //billing
    $this->db->select("type,sum(c20) as c20,sum(c40) as c40 ,stuffing,container_size,container_id,container_abbr,factory_id,factory_abbr,container_name,barge_cost,trucking_cost_20,trucking_cost_40,stuffing_name");
    $this->db->from('vw_stuffing_tes');
    $this->db->where_in('contid', $contid);
    $this->db->group_by('stuffing,container_id');
    $billingmonthly = $this->db->get()->result();


    $tetra_billing = [];
    $billing_filter = [];
    $local_biling = [];
    foreach ($billingmonthly as $b) {
      if ($b->stuffing == 'ELTP') {
        $tetra_billing[] = $b;
      } elseif ($b->stuffing == 'EL') {
        $local_biling[] = $b;
      } else {
        $billing_filter[] = $b;
      }
    }

    // //local
    $this->db->select("stuffing_name,sum(c20) as c20,sum(c40) as c40 ,container_size,barge_cost,trucking_cost_20,trucking_cost_40,container_abbr,contid,container_id,stuffing");
    $this->db->from('vw_stuffing_local_tes');
    $this->db->where_in('contid', $contid);
    $this->db->group_by('stuffing,container_id');
    $localmonthly = $this->db->get()->result();


    // //localinward
    $this->db->select("stuffing_name as type,sum(c20) as c20,sum(c40) as c40 ,container_size,barge_cost,trucking_cost_20,trucking_cost_40,container_abbr,contid,container_id,stuffing");
    $this->db->from('vw_stuffing_local_inward');
    $this->db->where_in('contid', $contidinward);
    $this->db->group_by('stuffing,container_id');
    $localmonthlyinward = $this->db->get()->result();

    $tetra_local = [];
    $local_filter = [];
    foreach ($localmonthly as $c) {
      if ($c->stuffing == 'LLTP') {
        $tetra_local[] = $c;
      } else {
        $local_filter[] = $c;
      }
    }

    $localall = array_merge($local_biling, $local_filter);
    $tetra_all = array_merge($tetra_billing, $tetra_local);
    $billingall = array_merge($billing_filter, $localmonthlyinward);

    $hasil = [
      'hdr' => $hdr,
      'billingmonthly' => $billingall,
      'localmonthly' => $localall,
      'tetramonthly' => $tetra_all,
    ];

    return $hasil;
  }




  function tampil_sc_stuffingtst($p_shipdate, $factory)
  {
    $shipmentdate = "%" . $p_shipdate . "%" . $factory_id = "%" . $factory . "%";


    return $this->db->query("SELECT
        c.stuffing_name as type,
        ifnull( sum( ifnull( a.c20, 0 )), 0 ) AS C20,
		ifnull( sum( ifnull( a.c40, 0 )), 0 ) AS C40,
        a.stuffing,
        a.shipmentdate,
        a.container_size,
        a.container_id,
        a.container_abbr,
        a.contid,
        a.factory_id,
        a.factory_abbr,
        a.container_name,
        case
				when (a.container_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,16,17,18,19,20,21,22,23,24,26,27,28,29,30) and a.stuffing='EE') then b.cust_export_empty
				when (a.container_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,16,17,18,19,20,21,22,23,24,26,27,28,29,30) and a.stuffing='EL') then b.cust_export_laden
				when (a.container_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,16,17,18,19,20,21,22,23,24,26,27,28,29,30) and a.stuffing='IT') then b.cust_import_transhipment
				when (a.container_id in (1,2,3,4,5,6,7,8,9,10,11,12,13,14,16,17,18,19,20,21,22,23,24,26,27,28,29,30) and a.stuffing='LC') then b.cust_local_laden

				END
				as barge_cost,
				case
				when (a.container_size=20) then d.cust_trucking_price
				END
				as trucking_cost_20,
                case
                when (a.container_size=40) then d.cust_trucking_price
                END
                as trucking_cost_40
        from zhl_ship_vw_trn_cont a
        LEFT JOIN zhl_shp_tblmst_bargecharges b on a.container_id=b.container_id
        LEFT JOIN shp_vw_mst_stuffing c on c.stuffing_abbr= a.stuffing
        LEFT JOIN zhl_tbl_mst_trucking d on d.container_size= a.container_size
        WHERE a.shipmentdate='$p_shipdate' and a.factory_id='$factory' and a.tipe=1
        GROUP BY a.stuffing,a.container_size,a.container_abbr;
         ")->result();
  }
  function tampil_shipping_liner_where($shippingid)
  {
    $this->db->where('shipping_id', $shippingid);
    $result =  $this->db->get('ship_tbl_mst_shipping_line');

    return $result->row();
  }

  function simpan_shipping_liner($data)
  {
    $this->db->insert('ship_tbl_mst_shipping_line', $data);
    return true;
  }

  function update_shipping_liner($shippingid, $data)
  {
    $this->db->where('shipping_id', $shippingid);
    $this->db->update('ship_tbl_mst_shipping_line', $data);
    return true;
  }

  function delete_shipping_liner($shippingid)
  {
    $data = array('notactive' => '1');

    $this->db->where('shipping_id', $shippingid);
    $this->db->update('ship_tbl_mst_shipping_line', $data);
    return true;
  }


  //    ---------------------------------------------------------About Port---------------------------------------------------------------
  function tampil_port()
  {
    $this->db->select('a.*,b.country_name');
    $this->db->from('mar_tblmst_port a');
    $this->db->join('gen_tbl_mst_country b', 'b.country_ids=a.country_ids');
    $this->db->where('a.notactive = 0');
    $result =  $this->db->get();

    return $result->result();
  }

  function tampil_port_where($portid)
  {
    $this->db->select('a.*,b.country_name');
    $this->db->from('mar_tblmst_port a');
    $this->db->join('gen_tbl_mst_country b', 'b.country_ids=a.country_ids');
    $this->db->where('a.port_id', $portid);
    $result =  $this->db->get();

    return $result->row();
  }

  function simpan_port($data)
  {
    $this->db->insert('mar_tblmst_port', $data);
    return true;
  }

  function update_port($portid, $data)
  {
    $this->db->where('port_id', $portid);
    $this->db->update('mar_tblmst_port', $data);
    return true;
  }

  function delete_port($portid)
  {
    $data = array('notactive' => '1');

    $this->db->where('port_id', $portid);
    $this->db->update('mar_tblmst_port', $data);
    return true;
  }

  //    ----------------------------------------------------------------------------------------------------------------------------------
  function tampil_po($fac, $schedule, $po)
  {
    $query = "(po_number like '%" . $po . "%' or shipping_name like '%" . $po . "%' or container_name like '%" . $po . "%')";
    if ($fac != '') {
      $query = $query . " And Factory_id ='" . $fac . "'";
    }

    if ($schedule != '') {
      $query = $query . " And schedule_date ='" . $this->convert($schedule) . "'";
    }
    $this->db->where('proses', '0');
    $this->db->where($query);
    $this->db->group_by('ship_id');
    $this->db->group_by('schedule_date');
    $this->db->group_by('po_number');
    $this->db->group_by('factory_abbr');
    $this->db->group_by('shipping_name');
    $this->db->group_by('container_name');
    $this->db->group_by('port_name');
    $this->db->group_by('destination');
    $this->db->order_by('schedule_date');
    $result = $this->db->get('ship_vw_trn_shipping_instruction');
    return $result->result();
  }

  function tampil_po_outward($data)
  {
    $query = "(po_number like '%" . $data . "%' or shipping_liner like '%" . $data . "%' or voyage like '%" . $data . "%' or eta like '%" . $data . "%' or etd  like '%" . $data . "%' or `from` like '%" . $data . "%' or `to` like '%" . $data . "%')";
    $this->db->where($query);
    $this->db->where('tipe', '1');
    $this->db->where('proses', '0');
    $result = $this->db->get('ship_vw_trn_cont');
    return $result->result();
  }

  function tampil_cont($date, $data)
  {
    $query = "(barge like '%" . $data . "%' or voyage like '%" . $data . "%' or eta like '%" . $data . "%' or etd  like '%" . $data . "%' or `from` like '%" . $data . "%' or `to` like '%" . $data . "%')";

    if ($date != '') {
      $query = $query . " And shipmentdate ='" . $this->convert($date) . "'";
    }

    $this->db->where($query);
    $this->db->order_by('shipmentdate', 'DESC');
    $result = $this->db->get('ship_tbl_trn_cont_hdr');
    return $result->result();
  }

  function tampil_cont_actual_seal()
  {
    $query = " tipe = 2 and shipmentdate > '2022-12-31'";
    $this->db->where($query);
    // $this->db->where('tipe', '2');
    // $this->db->where('shipmentdate',  '2022-12-31');
    $this->db->order_by('shipmentdate', 'DESC');
    $result = $this->db->get('ship_tbl_trn_cont_hdr');
    return $result->result();
  }

  function tampil_cont_berdasarkan_barge($group)
  {
    if ($group == '7') {
      $this->db->where("barge like '%sindo%' and tipe ='2'");
    } elseif ($group == '8') {
      $this->db->where("barge like '%marcopolo%' and tipe ='2'");
    } else {
      $this->db->where("tipe ='2'");
    }
    $this->db->order_by('shipmentdate', 'DESC');
    $result = $this->db->get('ship_tbl_trn_cont_hdr');
    return $result->result();
  }

  function tampil_cont_outward($data)
  {
    $query = "(barge like '%" . $data . "%' or voyage like '%" . $data . "%' or eta like '%" . $data . "%' or etd  like '%" . $data . "%' or `from` like '%" . $data . "%' or `to` like '%" . $data . "%')";
    $this->db->where('tipe', '1');
    $this->db->where('proses', '0');
    $this->db->where($query);
    $result = $this->db->get('ship_vw_trn_cont_proses');
    return $result->result();
  }

  function tampil_cont_hdr($contid)
  {
    $this->db->where('contid', $contid);
    $result = $this->db->get('ship_tbl_trn_cont_hdr');
    return $result->row();
  }

  function tampil_cont_where($contid)
  {
    $this->db->where('contid', $contid);
    $this->db->order_by('urut');
    $result = $this->db->get('ship_vw_trn_cont');
    return $result->result();
  }

  function tampil_cont_where_excel($contid)
  {
    $this->db->where('contid', $contid);
    $this->db->order_by('urut');
    $result = $this->db->get('ship_vw_trn_cont_excel');
    return $result->result();
  }

  function tampil_cont_where_excel_ggfs($contid)
  {
    $this->db->where('contid', $contid);
    $this->db->order_by('urut');
    $result = $this->db->get('ship_vw_trn_cont_excel_ggfs');
    return $result->result();
  }


  function get_container($contid)
  {
    $this->db->select('container,contid,detail_id');
    $this->db->where('contid', $contid);
    $this->db->where('flowcargoes_flag', NULL);
    $this->db->order_by('urut');
    $result = $this->db->get('ship_vw_trn_cont');
    return $result->result();
  }

  function get_containerdetailid($detailid)
  {
    $this->db->select('container,contid,detail_id');
    $this->db->where('detail_id', $detailid);
    $this->db->where('flowcargoes_flag', NULL);
    $this->db->order_by('urut');
    $result = $this->db->get('ship_vw_trn_cont');
    return $result->row();
  }

  function tampil_cont_local_where($contid)
  {
    $this->db->where('contid', $contid);
    // $this->db->order_by('urut');
    $result = $this->db->get('zhl_vw_local_cont_dtl');
    return $result->result();
  }

  function tampil_cont_local_read_factory($param)
  {
    //         `ship_tbl_trn_cont_local_dtl` `a`
    //         LEFT JOIN `zhl_mar_tblmst_customer` `b` ON ((
    //                 `a`.`customer` = `b`.`customer_code`
    //             )))
    //     LEFT JOIN `zhl_ship_tbl_mst_supp_whs_for_cont` `c` ON ((
    //             `c`.`id_supp` = `a`.`supplier`
    //         )))
    // LEFT JOIN `zhl_shp_tblmst_stuffing_local` `d` ON ((
    //     `a`.`stuffing` = `d`.`stuffing_abbr`



    $this->db->select("a.*,container_type, container_number, reff, is_ready_in_zhl, name_supp, customer_name, stuffing_name");
    $this->db->where('a.status', 2);
    $this->db->where('a.is_outward', 0);
    $this->db->where('a.factory_id', $param['factory_id']);
    $this->db->join('ship_tbl_trn_cont_local_dtl b', 'a.det_id = b.id', 'left');
    $this->db->join('zhl_ship_tbl_mst_supp_whs_for_cont c', 'b.supplier = c.id_supp', 'left');
    $this->db->join('zhl_shp_tblmst_stuffing_local d', 'b.stuffing = d.stuffing_abbr', 'left');
    $this->db->join('zhl_mar_tblmst_customer e', 'b.customer = e.customer_code', 'left');

    $result = $this->db->get('ship_tbl_trn_cont_acceptance_dtl a');
    return $result->result();
  }

  function tampil_cont_local_read_zhl()
  {
    $this->db->where('is_ready_in_zhl', 1);
    // $this->db->order_by('urut');
    $result = $this->db->get('zhl_vw_local_cont_dtl');
    return $result->result();
  }
  function tampil_cont_where_outward($contid)
  {
    $this->db->where('contid', $contid);
    $this->db->where('proses', '0');
    $result = $this->db->get('ship_vw_trn_cont');
    return $result->result();
  }

  function tampil_cont_where_actual_seal($contid)
  {
    $this->db->where('contid', $contid);
    $this->db->where('tipe', '2');
    $this->db->order_by('urut ASC');
    $result = $this->db->get('ship_vw_trn_cont');
    return $result->result();
  }

  function simpan_cont_sp($datahdr)
  {
    $this->db->trans_begin();
    $this->db3->trans_begin();

    $id                   = $this->input->post('id');
    $shipid               = $this->input->post('shipid');
    $carrier              = $this->input->post('carrier');
    $destination          = $this->input->post('final');
    $reff                 = $this->input->post('reff');
    $vessel               = $this->input->post('vessel');
    $convessel            = $this->input->post('convessel');
    $depot                = $this->input->post('depot');
    $pod                  = $this->input->post('pod');
    $opcode               = $this->input->post('opcode');
    $etd                  = $this->input->post('etdsin');
    $eta                  = $this->input->post('etasin');
    $container            = $this->input->post('container');
    $seal                 = $this->input->post('seal');
    $weight               = $this->input->post('weight');
    $outward              = $this->input->post('outward');
    $urut                 = $this->input->post('urut');
    $stuffing             = $this->input->post('stuffing');
    $actual_seal          = $this->input->post('actual_seal');
    $stock_id_dtl         = $this->input->post('stock_id_dtl');
    $container_number     = $this->input->post('container');
    $supp                 = $this->input->post('supplier');
    $tipecont             = $this->input->post('tipe');
    $reff_remark          = $this->input->post('reff_remark');
    $depot_remark         = $this->input->post('depot_remark');
    $tare_weight          = remove_thousand_separator($this->input->post('tare_weight'));
    $trucking_date        = $this->input->post('trucking_date');
    $trucking_date_remark = $this->input->post('trucking_date_remark');
    $jml = count($shipid);


    //===============For Local Container New=============
    $id_lc               =  $this->input->post('id_lc');
    $container_number_lc =  $this->input->post('container_number_lc');
    $container_id_lc     =  $this->input->post('container_id_lc');
    $container_name_lc   =  $this->input->post('container_name_lc');
    $loading_port_lc     =  $this->input->post('loading_port_lc');
    $supplier_lc         =  $this->input->post('supplier_lc');
    $customer_lc         =  $this->input->post('customer_lc');
    $proses_lc           =  "0";
    $stuffing_lc         =  $this->input->post('stuffing_lc');
    $reff_lc             =  $this->input->post('reff_lc');
    $urut_lc             =  $this->input->post('urut_lc');
    $is_repair             =  $this->input->post('is_repair');

    $jml_lc              =  count($id_lc);
    //===================================================

    //=================Simpan Header dan Detail Container GGFS===========================
    $id_ggfs                   = $this->input->post('id_ggfs');
    $shipid_ggfs               = $this->input->post('shipid_ggfs');
    $carrier_ggfs              = $this->input->post('carrier_ggfs');
    $destination_ggfs          = $this->input->post('final_ggfs');
    $reff_ggfs                 = $this->input->post('reff_ggfs');
    $vessel_ggfs               = $this->input->post('vessel_ggfs');
    $convessel_ggfs            = $this->input->post('convessel_ggfs');
    $depot_ggfs                = $this->input->post('depot_ggfs');
    $pod_ggfs                  = $this->input->post('pod_ggfs');
    $opcode_ggfs               = $this->input->post('opcode_ggfs');
    $etd_ggfs                  = $this->input->post('etdsin_ggfs');
    $eta_ggfs                  = $this->input->post('etasin_ggfs');
    $container_ggfs            = $this->input->post('container_ggfs');
    $seal_ggfs                 = $this->input->post('seal_ggfs');
    $weight_ggfs               = $this->input->post('weight_ggfs');
    $outward_ggfs              = $this->input->post('outward_ggfs');
    $urut_ggfs                 = $this->input->post('urut_ggfs');
    $stuffing_ggfs             = $this->input->post('stuffing_ggfs');
    $actual_seal_ggfs          = $this->input->post('actual_seal_ggfs');
    $stock_id_dtl_ggfs         = $this->input->post('stock_id_dtl_ggfs');
    $container_number_ggfs     = $this->input->post('container_ggfs');
    $supp_ggfs                 = $this->input->post('supplier_ggfs');
    $reff_remark_ggfs          = $this->input->post('reff_remark_ggfs');
    $depot_remark_ggfs         = $this->input->post('depot_remark_ggfs');
    $tare_weight_ggfs          = remove_thousand_separator($this->input->post('tare_weight_ggfs'));
    $trucking_date_ggfs        = $this->input->post('trucking_date_ggfs');
    $trucking_date_remark_ggfs = $this->input->post('trucking_date_remark_ggfs');

    $jml_ggfs = count($shipid_ggfs);
    
    $query1 = $this->simpan_cont_sp_hdr($datahdr);
    $contid = $query1->contid;
    $flag1 = $query1->flag;

    if ($flag1 == 0) {
      $this->db->trans_rollback();
      $data = array('flag' => $flag1);
      return $data;
    }

    $query2 = $this->simpan_cont_sp_dtl($contid, $id, $shipid, $destination, $reff, $vessel, $convessel, $depot, $pod, $opcode, $etd, $eta, $container, $seal, $weight, $outward, $jml, $carrier, $urut, $stuffing, $actual_seal, $stock_id_dtl, $container_number, $supp, $tipecont, $reff_remark, $depot_remark, $tare_weight, $trucking_date, $trucking_date_remark);
    $flag2 = $query2->flag;

    if ($flag2 == 0) {
      $this->db->trans_rollback();
      $data = array('flag' => $flag2);
      return $data;
    }

    $query3 = $this->simpan_local_cont_sp_dtl($contid, $container_number_lc, $container_id_lc, $container_name_lc, $loading_port_lc, $supplier_lc, $customer_lc, $proses_lc, $stuffing_lc, $jml_lc, $id_lc, $reff_lc, $is_repair);
    $flag3 = $query3->flag;

    if ($flag3 == 0) {
      $this->db->trans_rollback();
      $data = array('flag' => $flag3);
      return $data;
    }

    $query4 = $this->simpan_cont_sp_dtl_ggfs($contid, $id_ggfs, $shipid_ggfs, $destination_ggfs, $reff_ggfs, $vessel_ggfs, $convessel_ggfs, $depot_ggfs, $pod_ggfs, $opcode_ggfs, $etd_ggfs, $eta_ggfs, $container_ggfs, $seal_ggfs, $weight_ggfs, $outward_ggfs, $jml_ggfs, $carrier_ggfs, $urut_ggfs, $stuffing_ggfs, $actual_seal_ggfs, $stock_id_dtl_ggfs, $container_number_ggfs, $supp_ggfs, $tipecont, $reff_remark_ggfs, $depot_remark_ggfs, $tare_weight_ggfs, $trucking_date_ggfs, $trucking_date_remark_ggfs);
    $flag4 = $query4->flag;

    if (empty($flag4) || $flag4 == 0) {
      $this->db->trans_rollback();
      $data = array('flag' => $flag4);
      return $data;
    }
    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE || $this->db3->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $this->db3->trans_rollback();
      $data = array('flag' => $flag2);
      return $data;
    } else {
      $this->db->trans_commit();
      $this->db3->trans_commit();
      $data = array('flag' => $flag2, 'contid' => $contid);
      return $data;
    }
  }

  function simpan_cont_sp_hdr($datahdr)
  {
    $this->db->query("SET @contid = '" . $datahdr['contid'] . "'");
    $this->db->query("SET @flag = 0");
    $this->db->query("call sp_ship_tbl_trn_cont_hdr('" . $datahdr['trans'] . "',@contid,'" . $datahdr['tipe'] . "','" . $datahdr['barge'] . "','" . $datahdr['voyage'] . "','" . $datahdr['etd'] . "',"
      . "'" . $datahdr['etddate'] . "','" . $datahdr['eta'] . "','" . $datahdr['etadate'] . "','" . $datahdr['shipmentdate'] . "','" . $datahdr['from'] . "','" . $datahdr['to'] . "',"
      . "'" . $datahdr['amendmentdate'] . "','" . $datahdr['remarks'] . "','" . $datahdr['createdby'] . "',@flag)");
    $row =  $this->db->query("Select @contid as contid, @flag as flag")->row();

    return $row;
  }

  function simpan_cont_sp_dtl($contid, $id, $shipid, $destination, $reff, $vessel, $convessel, $depot, $pod, $opcode, $etd, $eta, $container, $seal, $weight, $outward, $jml, $carrier, $urut, $stuffing, $actual_seal, $stock_id_dtl, $container_number, $supp, $tipecont, $reff_remark, $depot_remark, $tare_weight, $trucking_date, $trucking_date_remark)
  {
    for ($i = 0; $i < $jml; $i++) {

      //================Kalau pakai Container Number Bisa Save
      if ($container_number[$i] != '') {
        $this->db->query("UPDATE zhl_ship_tbl_trn_cont_stock_dtl set status_note = '1' where container_number ='" . $container_number[$i] . "'");
      }

      //================Kalau pakai Container dengan PO bersangkutan maka akan membuat status PO tersebut akan berubah
      if ($shipid[$i] != '' && $tipecont === '1') {
        $this->db->query("UPDATE mar_tbltrn_shipping_instruction set shp_status = 'OUT' where ship_id ='" . $shipid[$i] . "'");
      } else {
        $this->db->query("UPDATE mar_tbltrn_shipping_instruction set shp_status = 'IN' where ship_id ='" . $shipid[$i] . "'");
      }

      $this->db->query("SET @flag = 0");
      $this->db->query("call sp_ship_tbl_trn_cont_dtl_new1('" . $contid . "','" . $id[$i] . "','" . $shipid[$i] . "','" . $destination[$i] . "','" . $reff[$i] . "','" . $vessel[$i] . "','" . $convessel[$i] . "','" . htmlspecialchars($depot[$i], ENT_QUOTES) . "',"
        . "'" . $pod[$i] . "','" . $opcode[$i] . "','" . $etd[$i] . "','" . $eta[$i] . "','" . $container[$i] . "','" . $seal[$i] . "','" . $weight[$i] . "','" . $outward[$i] . "',@flag,'" . $carrier[$i] . "','" . $urut[$i] . "','" . $stuffing[$i] . "','" . $actual_seal[$i] . "','" . $supp[$i] . "','" . $reff_remark[$i] . "','" . $depot_remark[$i] . "', '" . $tare_weight[$i] . "', '" . $trucking_date[$i] . "', '" . $trucking_date_remark[$i] . "')");
    }

    $row =  $this->db->query("Select @flag as flag")->row();

    return $row;
  }

  function simpan_local_cont_sp_dtl($contid, $container_number_lc, $container_id_lc, $container_name_lc, $loading_port_lc, $supplier_lc, $customer_lc, $proses_lc, $stuffing_lc, $jml_lc, $id_lc, $reff_lc, $is_repair)
  {
    for ($i = 0; $i < $jml_lc; $i++) {

      $this->db->query("SET @flag = 0");
      $this->db->query("call save_local_container_dtl('$is_repair[$i]', '$contid','" . $container_number_lc[$i] . "','" . $container_id_lc[$i] . "','" . $container_name_lc[$i] . "','" . $loading_port_lc[$i] . "','" . $supplier_lc[$i] . "','" . $customer_lc[$i] . "','" . $proses_lc . "','" . $stuffing_lc[$i] . "','" . $id_lc[$i] . "','" . $reff_lc[$i] . "',@flag)
                ");
    }

    $row = $this->db->query("Select @flag as flag")->row();

    return $row;
  }
  function simpan_actual_seal($id, $contid, $actual_seal, $seal, $actual_seal1, $sample, $factory, $container, $orang_terakhir, $tanggal, $jumlah)
  {
    for ($i = 0; $i < $jumlah; $i++) {

      if ($actual_seal[$i] !== '') {
        if ($actual_seal[$i] !== $actual_seal1[$i]) {
          $query1 = "UPDATE ship_tbl_trn_cont_dtl set actual_seal = '" . $actual_seal[$i] . "' WHERE id = '" . $id[$i] . "'";
          $this->db->query($query1);
        }
      }

      if ($sample[$i] !== '') {
        $query1 = "UPDATE ship_tbl_trn_cont_dtl set sample = '" . $sample[$i] . "' WHERE id = '" . $id[$i] . "'";
        $this->db->query($query1);
      }

      // if ($container[$i] !== '') {
      //     $query1 = "UPDATE ship_tbl_trn_cont_dtl set container = '" . $container[$i] . "' WHERE id = '" . $id[$i] . "'";
      //     $this->db->query($query1);
      // }
      $query3 = "INSERT INTO ship_tbl_trn_cont_actual_seal_history (actual_seal,updatedby,dateupdated,contid,id,seal_old,sample,factory,container) VALUES ('" . $actual_seal[$i] . "','" . $orang_terakhir . "','" . $tanggal . "','" . $contid . "','" . $id[$i] . "','" . $seal[$i] . "','" . $sample[$i] . "','" . $factory . "','" . $container[$i] . "')";
      $this->db->query($query3);
    }
  }

  // function simpan_actual_seal($id, $contid, $actual_seal, $seal, $actual_seal1,$sample,$orang_terakhir, $tanggal, $jumlah)
  // {
  //     for ($i = 0; $i < $jumlah; $i++) {

  //         if ($actual_seal[$i] !== '') {
  //             if ($actual_seal[$i] !== $actual_seal1[$i]) {

  //                 $query1 = "UPDATE ship_tbl_trn_cont_dtl set actual_seal = '" . $actual_seal[$i] . "' WHERE id = '" . $id[$i] . "'";
  //                 //    $query2="UPDATE ship_tbl_trn_cont_dtl set seal = '".$actual_seal[$i]."' WHERE id = '".$id[$i]."'";
  //                 $query3 = "INSERT INTO ship_tbl_trn_cont_actual_seal_history (actual_seal,updatedby,dateupdated,contid,id,seal_old) VALUES ('" . $actual_seal[$i] . "','" . $orang_terakhir . "','" . $tanggal . "','" . $contid . "','" . $id[$i] . "','" . $seal[$i] . "')";

  //                 $this->db->query($query1);
  //                 //    $this->db->query($query2);
  //                 $this->db->query($query3);
  //             }
  //         } //============Ini adalah Codingan Lama

  //         // $query1="UPDATE ship_tbl_trn_cont_dtl set actual_seal = '".$actual_seal[$i]."' WHERE id = '".$id[$i]."'";
  //         // $query3="INSERT INTO ship_tbl_trn_cont_actual_seal_history (actual_seal,updatedby,dateupdated,contid,id,seal_old) VALUES ('".$actual_seal[$i]."','".$orang_terakhir."','".$tanggal."','".$contid."','".$id[$i]."','".$seal[$i]."')";

  //         // $this->db->query($query1);
  //         // $this->db->query($query3);

  //     }
  // }

  //=================================Local Container=================

  //=================================================================


  function get_refnum($thn)
  {
    $sql = $this->db->query("SELECT no_reff FROM zhl_ship_tbl_trn_cont_stock_hdr
            WHERE YEAR(arrival_date) = '$thn' AND `no_reff` LIKE '%GV%'
            ORDER BY RIGHT(no_reff,4)  DESC LIMIT 1");
    return $sql->row();
  }


  function select_container($id)
  {
    $this->db->select('*');
    $this->db->where('stock_id_hdr', $id);
    $sql_product = $this->db->get('zhl_ship_tbl_trn_cont_stock_hdr');
    if ($sql_product->num_rows() > 0) {
      foreach ($sql_product->result() as $data) {
        $hasil[] = $data;
      }
      return $hasil;
    }
  }


  function get_container_type()
  {
    return $this->db->get('mar_tblmst_container')->result();
  }

  function get_by_id($id)
  {
    $table = $this->container_stock;
    $this->db->where($this->stock_id, $id);
  }

  function tampil_container_stock($data)
  {
    $query = "(stock_id like '%" . $data . "%')";
    $this->db->where($query);
    $result = $this->db->get('zhl_ship_tbl_trn_cont_stock');
    return $result->result();
  }


  function simpan_container_stock_hdr($data)
  {
    $this->db->insert('zhl_ship_tbl_trn_cont_stock_hdr', $data);
    $primary_key = $this->db->insert_id();
    return $primary_key;
  }

  function simpan_container_local_hdr($data)
  {
    $this->db->insert('ship_tbl_trn_cont_local_hdr', $data);
    $primary_key = $this->db->insert_id();
    return $primary_key;
  }

  function simpan_container_stock_dtl($data)
  {
    $this->db->insert('zhl_ship_tbl_trn_cont_stock_dtl', $data);
    return true;
  }

  function simpan_container_local_dtl($data)
  {
    $this->db->insert('ship_tbl_trn_cont_local_dtl', $data);
    return true;
  }

  function buat_note_container_stock($datastock)
  {
  }

  function get_container_stock_hdr($id)
  {
    $this->db->where('stock_id_hdr', $id);
    return $this->db->get('zhl_ship_tbl_trn_cont_stock_hdr')->result();
  }

  function get_container_stock_dtl($id)
  {
    $this->db->where('stock_id_hdr', $id);
    return $this->db->get('zhl_ship_tbl_trn_cont_stock_dtl')->result();
  }

  function get_container_local_hdr($id)
  {
    $this->db->where('contid', $id);
    return $this->db->get('ship_tbl_trn_cont_local_hdr')->result();
  }

  function get_container_local_dtl($id)
  {
    $this->db->where('contid', $id);
    return $this->db->get('zhl_vw_local_cont_dtl')->result();
  }

  function simpan_cont_stock_sp_dtl($container_number, $container_id, $container_name)
  {
    for ($i = 0; $i < count($container_id); $i++) {
      $this->db->query("call zhl_shp_cont_dtl_stock('" . $container_number[$i] . "','" . $container_id[$i] . "','" . $container_name[$i] . "')");
    }
    return true;
  }


  function update_container_stock_hdr($data_hdr, $stock_id_hdr)
  {
    $this->db->where('stock_id_hdr', $stock_id_hdr);
    $this->db->update('zhl_ship_tbl_trn_cont_stock_hdr', $data_hdr);
    $primary_key = $this->db->insert_id();
    return $primary_key;
  }

  function update_container_local_hdr($data_hdr, $contid)
  {
    $this->db->where('contid', $contid);
    $this->db->update('ship_tbl_trn_cont_local_hdr', $data_hdr);
    $primary_key = $this->db->insert_id();
    return $primary_key;
  }

  function update_container_stock_dtl($data_dtl, $stock_id_dtl)
  {
    $this->db->where('stock_id_dtl', $stock_id_dtl);
    $this->db->update('zhl_ship_tbl_trn_cont_stock_dtl', $data_dtl);
    return true;
  }

  function update_container_local_dtl($data_dtl, $id)
  {
    $this->db->where('id', $id);
    $this->db->update('ship_tbl_trn_cont_local_dtl', $data_dtl);
    return true;
  }

  function delete_container_stock($id)
  {
    $this->db->where('stock_id_dtl', $id);
    $this->db->delete('zhl_ship_tbl_trn_cont_stock_dtl');
    return true;
  }

  function delete_container_local_hdr($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('ship_tbl_trn_cont_local_dtl');
    return true;
  }

  function delete_container_local($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('ship_tbl_trn_cont_local_dtl');
    return true;
  }

  // function delete_container_shipping($data)
  // {
  //     $query = 'call zhl_sp_container_dalete_proses(?, ?)';
  //     $sql = $this->db->query($query, $data);
  //     return true;
  // }

  function delete_container_shipping($id_inward, $id_outward)
  {
    $this->db->query("UPDATE ship_tbl_trn_cont_dtl set contid = '0' WHERE id in ($id_inward)");
    $this->db->query("UPDATE ship_tbl_trn_cont_dtl set proses = '0' WHERE id in ($id_outward)");
    return true;
  }

  function delete_container_shipping_outward($id, $shipid, $contid)
  {
    $this->db->query("UPDATE ship_tbl_trn_cont_dtl set contid = '0' WHERE id = " . $id . "");
    $this->db->query("UPDATE ship_tbl_trn_cont_dtl set ContBackup = '" . $contid . "' WHERE id = " . $id . "");
    $this->db->query("UPDATE mar_tbltrn_shipping_instruction set shp_status = ' ', proses = '0' WHERE ship_id = " . $shipid . "");
  }

  function tampil_container_stock_modal($container_name)
  {
    $query = "(container_name like '%" . $container_name . "%')";
    $this->db->where($query);
    $result = $this->db->get('zhl_mar_tblmst_container');
    return $result->result();
  }

  //-----------------JANGAN GANGGU KODING DIBAWAH-----------------------//
  function tampil_stock_where($contid)
  {
    $this->db->where('stock_id_hdr', $contid);
    $this->db->order_by('stock_id_dtl');
    $result = $this->db->get('zhl_ship_vw_trn_cont_stock');
    return $result->result();
  }
  //-----------------JANGAN GANGGU KODING DIATAS------------------------//


  function delete_cont_sp($contid)
  {
    $this->db->trans_begin();
    $this->db->query("SET @flag = 0");
    $this->db->query("call sp_ship_tbl_trn_cont_del('" . $contid . "',@flag)");
    $query1 =  $this->db->query("Select @flag as flag")->row();

    $flag1 = $query1->flag;

    if ($flag1 == 0) {
      $this->db->trans_rollback();
      $data = array('flag' => $flag1);
      return $data;
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $data = array('flag' => $flag1);
      return $data;
    } else {
      $this->db->trans_commit();
      $data = array('flag' => $flag1);
      return $data;
    }
  }

  function tampil_po_inward($data)
  {
    $query = "(po_number like '%" . $data . "%' or container like '%" . $data . "%' or reff like '%" . $data . "%' or vessel  like '%" . $data . "%' or port_name like '%" . $data . "%' or destination like '%" . $data . "%')";
    $this->db->where($query);
    $this->db->where('tipe', '2');
    $this->db->order_by('shipmentdate');
    $result = $this->db->get('ship_vw_trn_cont');
    return $result->result();
  }

  function tampil_container_loading($data)
  {
    $query = "(carrier like '%" . $data . "%' or voyage like '%" . $data . "%' or to like '%" . $data . "%' or attn like '%" . $data . "%' or from like '%" . $data . "%')";
    $this->db->where($query);
    $this->db->order_by('docdate', 'DESC');
    $result = $this->db->get('ship_tbl_trn_cont_loading_hdr');
    return $result->result();
  }

  function tampil_container_loading_where($id)
  {
    $this->db->where('headerid', $id);
    $result = $this->db->get('ship_vw_trn_cont_loading');
    return $result->result();
  }

  function simpan_cont_l_sp($dataHdr)
  {
    $this->db->trans_begin();
    $cont = $this->input->post('cont');
    $reff = $this->input->post('reff');
    $vessel = $this->input->post('vessel');
    $port = $this->input->post('port');
    $destination = $this->input->post('destination');
    $contid = $this->input->post('contid');
    $jml = count($cont);
    $seal = $this->input->post('seal');
    $opcode = $this->input->post('opcode');

    $query1 = $this->simpan_cont_l_sp_hdr($dataHdr);
    $headerid = $query1->headerid;
    $flag1 = $query1->flag;

    if ($flag1 == 0) {
      $this->db->trans_rollback();
      $data = array('flag' => $flag1);
      return $data;
    }

    $query2 = $this->simpan_cont_l_sp_dtl($headerid, $contid, $cont, $reff, $vessel, $port, $destination, $jml, $seal, $opcode);
    $flag2 = $query2->flag;

    if ($flag2 == 0) {
      $this->db->trans_rollback();
      $data = array('flag' => $flag2);
      return $data;
    }

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $data = array('flag' => $flag1);
      return $data;
    } else {
      $this->db->trans_commit();
      $data = array('headerid' => $headerid, 'flag' => $flag1);
      return $data;
    }
  }

  function simpan_cont_l_sp_hdr($dataHdr)
  {
    $this->db->query("Set @headerid ='" . $dataHdr['id'] . "'");
    $this->db->query("Set @flag = 0");
    $this->db->query("Call sp_ship_tbl_trn_cont_l_hdr ('" . $dataHdr['trans'] . "',@headerid,'" . $dataHdr['docdate'] . "','" . $dataHdr['barge'] . "','" . $dataHdr['voyage'] . "','" . $dataHdr['etasin'] . "','" . $dataHdr['to'] . "','" . $dataHdr['attn'] . "','" . $dataHdr['from'] . "','" . $dataHdr['remarks'] . "','" . $dataHdr['createdby'] . "',@flag)");
    $row = $this->db->query("Select @headerid as headerid, @flag as flag")->row();

    return $row;
  }

  function simpan_cont_l_sp_dtl($headerid, $contid, $cont, $reff, $vessel, $port, $destination, $jml, $seal, $opcode)
  {
    for ($i = 0; $i < $jml; $i++) {
      $this->db->query("Set @flag = 0");
      $this->db->query("Call sp_ship_tbl_trn_cont_l_dtl ('" . $headerid . "','" . $contid[$i] . "','" . $cont[$i] . "','" . $reff[$i] . "','" . $vessel[$i] . "','" . $port[$i] . "','" . $destination[$i] . "','" . $seal[$i] . "','" . $opcode[$i] . "',@flag)");
    }

    $row =  $this->db->query("Select @flag as flag")->row();
    return $row;
  }

  function delete_cont_l_sp($headerid)
  {
    $this->db->trans_begin();
    $this->db->query("Set @flag=0 ");
    $this->db->query("Call sp_ship_tbl_trn_cont_l_del ('" . $headerid . "',@flag)");
    $row = $this->db->query('Select @flag as flag')->row();

    $flag = $row->flag;

    if ($flag == 0) {
      $this->db->trans_rollback();
      $data = array('flag' => $flag);
      return $data;
    }

    $this->db->trans_complete();

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $data = array('flag' => $flag);
      return $data;
    } else {
      $this->db->trans_commit();
      $data = array('flag' => $flag);
      return $data;
    }
  }
  //--------------------------------------------------------------About Driver Job Dibawah-------------------------------------------
  function tampil_driver_job()
  {
    // $query = $this->db->query('select * from zhl_tims_tbl_trn_job_dtl as a join zhl_tims_tbl_trn_job_hdr on a.id_job_hdr = zhl_tims_tbl_trn_job_hdr.id_job_hdr join zhl_tims_mst_vehicle on zhl_tims_mst_vehicle.id_driver = a.id_driver join zhl_tims_mst_driver on a.id_driver = zhl_tims_mst_driver.id_driver');
    // return $query->result();

    $result = $this->db->get('zhl_vw_tims_job_driver');
    return $result->result();
  }

  function tampil_summary_job_filter($currentdate)
  {
    $sql = "curr_date = '" . $currentdate . "'";
    $this->db->where($sql);
    $this->db->order_by('curr_date');

    $result = $this->db->get('zhl_vw_tims_job_driver');
    return $result->result();
  }
  //--------------------------------------------------------------About Driver Job Diatas-------------------------------------------

  function get_factory()
  {
    $sql = $this->db->query("SELECT * FROM gen_tbl_mst_factory");
    if ($sql->num_rows() > 0) {
      $result[''] = 'Select';
      foreach ($sql->result_array() as $value) {
        $result[$value['factory_id']] = ucwords(strtoupper($value['factory_abbr'] . " - " . $value['factory_name']));
      }
      return $result;
    }
  }

  function tampil_factory()
  {
    $result =  $this->db->get('gen_tbl_mst_factory');

    return $result->result();
  }

  function tampil_factory_for_track()
  {
    $this->db->where_in('factory_id', [1, 3, 5, 6]);
    $result =  $this->db->get('gen_tbl_mst_factory');

    return $result->result();
  }


  function tampil_factory_stock_container_inward($stock, $pete)
  {

    $query = "(factory like '%" . $pete . "%')";
    $query2 = "(container_number like '%" . $stock . "%')";

    $this->db->where($query2);
    $this->db->where($query);
    $result = $this->db->get('zhl_ship_vw_trn_cont_stock');

    return $result->result();
  }

  function tampil_factory_stock_container()
  {
    $result = $this->db->get('zhl_ship_vw_trn_cont_stock');

    return $result->result();
  }

  function tampil_factory_stock_container_list()
  {
    //$this->db->where('status_exit',0);
    $result =  $this->db->get('zhl_ship_vw_trn_cont_stock');
    // $result =  $this->db->query('select * FROM zhl_ship_vw_trn_cont_stock ORDER BY free_time_expiry DESC');

    return $result->result();
  }

  function get_customer_name()
  {

    $query = $this->db->query('select loading_port,factory,import_bl_no from zhl_ship_vw_trn_cont_stock group by stock_id_hdr order by stock_id_hdr ASC');
    return $query->result();
  }

  function tampil_factory_stock_container_list_filter($pete)
  {
    //$this->db->where('status_exit',0);
    $query = "(factory like '%" . $pete . "%')";
    $this->db->where($query);
    $result =  $this->db->get('zhl_ship_vw_trn_cont_stock');

    return $result->result();
  }

  function tampil_factory_local_container_list()
  {
    $this->db->order_by('shipmentdate', 'DESC');
    $result =  $this->db->get('ship_vw_tbl_trn_cont_local_hdr');

    return $result->result();
  }

  function tampil_cust()
  {
    $this->db->order_by('customer_company_name');
    $result =  $this->db->get('mar_tblmst_customer');
    return $result->result();
  }

  function convert($date)
  {
    if (trim($date) != '') {
      $explode = explode("-", $date);
      $time = $explode[2] . '/' . $explode[1] . '/' . $explode[0];
    } else {
      $time = '';
    }

    return $time;
  }
  function gettype()
  {
    $this->db->order_by('container_id');
    $result = $this->db->get('mar_tblmst_container');
    return $result->result();
  }

  function getshipinward()
  {
    $this->db->where('tipe', '2');
    $this->db->order_by('contid', 'DESC');
    $result = $this->db->get('ship_tbl_trn_cont_hdr');
    return $result->result();
  }

  function getshipoutward()
  {
    $this->db->where('tipe', '1');
    $this->db->order_by('contid', 'DESC');
    $result = $this->db->get('ship_tbl_trn_cont_hdr');
    return $result->result();
  }

  function getcontainerinward()
  {
    $this->db->order_by('contid');
    $result = $this->db->get('ship_tbl_trn_cont_dtl');
    return $result->result();
  }


  function containerinward_move_gagal($contid, $inward, $outward)
  {
    $this->db->query("UPDATE ship_tbl_trn_cont_dtl set contid = '" . $contid . "' WHERE id in (" . $inward . "," . $outward . ")");
  }

  function containeroutward_move($contid, $inward, $outward)
  {
    $this->db->query("UPDATE ship_tbl_trn_cont_dtl set contid = '" . $contid . "' WHERE id in (" . $inward . "," . $outward . ")");
  }

  function inwardcontainerinward_update2($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('ship_tbl_trn_cont_dtl', $data);
    return $this->db->query("SELECT container FROM ship_tbl_trn_cont_dtl where id = '" . $id . "'")->row();
    //return true;
  }

  function containerinward_update($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('zhl_container_stock_temporary', $data);
    return $this->db->query("SELECT container FROM zhl_container_stock_temporary where stock_id_dtl = '" . $id . "'")->row();
  }

  function container_stock_noted($stock_id_dtl)
  {
    $this->db->query("UPDATE zhl_ship_tbl_trn_cont_stock_dtl set status_note = '1' where stock_id_dtl ='" . $stock_id_dtl . "'");
  }

  function container_inward_changestock($data)
  {
    //$this->db->where('id',$id);

    $query = 'call zhl_sp_container_change(?, ?)';
    $sql = $this->db->query($query, $data);

    return $sql->row();
    //return $this->db->query("SELECT container FROM ship_tbl_trn_cont_dtl where id = '".$id."'")->row();
  }

  function container_inward_changestock2($data)
  {
    //$this->db->where('id',$id);

    $query = 'call zhl_sp_container_change_temporary(?, ?)';
    $sql = $this->db->query($query, $data);

    return $sql->row();
    //return $this->db->query("SELECT container FROM ship_tbl_trn_cont_dtl where id = '".$id."'")->row();
  }

  //============================Epic Comeback
  function tampil_factory_stock_container_comeback()
  {
    //$this->db->where('status_exit',0);
    $result =  $this->db->get('zhl_ship_vw_trn_cont_stock_comeback');
    return $result->result();
  }

  function tampil_supplier()
  {
    $this->db->select("supplier as supplier_name");
    $this->db->group_by("supplier");
    return $this->db->get('zhl_ship_vw_trn_cont_stock_comeback')->result();
  }

  function tampil_year()
  {
    $this->db->select("YEAR(arrival_date) as tahun");
    $this->db->group_by("YEAR(arrival_date)");
    return $this->db->get('zhl_ship_vw_trn_cont_stock_comeback')->result();
  }

  function tampil_cont_stock()
  {
    $this->db->select("container_name");
    $this->db->group_by("container_name");
    return $this->db->get('zhl_ship_vw_trn_cont_stock_comeback')->result();
  }

  function tampil_container_stock_filter($factory,$supplier,$loading_port, $year, $month, $container){        
        $sql="container_number is not null";

        if(trim($factory) !='' ){$sql=$sql." and  factory like '%".$factory."%'";} 
        if(trim($loading_port) !='' ){$sql=$sql." and  loading_port like '%".$loading_port."%'";} 
        if(trim($supplier) !='' ){$sql=$sql." and  supplier like '%".$supplier."%'";} 
        if(trim($year) !='' ){$sql=$sql." and  YEAR(arrival_date) = '".$year."'";} 
        if(trim($month) !='' ){$sql=$sql." and  MONTH(arrival_date) = '".$month."'";} 
        if(trim($container) !='' ){$sql=$sql." and  container_name like '%".$container."%'";} 
        $this->db->where($sql);
        $result=$this->db->get('zhl_ship_vw_trn_cont_stock_comeback');
        return $result->result();
    }

  function container_stock_transfer($id)
  {
    $this->db->query("UPDATE zhl_ship_tbl_trn_cont_stock_dtl set status_note = '3' where stock_id_dtl ='" . $id . "'");
  }

  function container_stock_return_status($id)
  {
    $this->db->query("UPDATE zhl_ship_tbl_trn_cont_stock_dtl set status_note = '2', Remark = 'Return To Singapore' where stock_id_dtl ='" . $id . "'");
  }

  function container_stock_reuse($id)
  {
    $this->db->query("UPDATE zhl_ship_tbl_trn_cont_stock_dtl set status_note = '0' where stock_id_dtl ='" . $id . "'");
  }

  // ujung kali
  function get_shipmentdate($etd)
  {
    return $this->db->query("SELECT shipmentdate FROM ship_tbl_trn_cont_hdr where etd = '" . $etd . "' and shipmentdate > '2021-05-31' order by shipmentdate desc;")->result();
  }

  //  function containerinward_move_19032022($shipmendate, $id, $flag, $et, $shipid){
  //      $query1 = " UPDATE ship_tbl_trn_cont_dtl SET contid =
  //                      ( SELECT contid FROM ship_tbl_trn_cont_hdr where shipmentdate = '$shipmendate' AND ETD = '$et' LIMIT 1)
  //                  where id = '$id' ";

  //      $query2 = "UPDATE ship_tbl_trn_cont_dtl SET contid =
  //                      (SELECT contid FROM ship_tbl_trn_cont_hdr where shipmentdate = '$shipmendate' AND ETA = '$et' LIMIT 1)
  //                  where id = '$flag' ";
  //      $query3 = "UPDATE mar_tbltrn_shipping_instruction set schedule_date = '$shipmendate' where ship_id = '$shipid' ";

  //      $this->db->query($query1);
  //      $this->db->query($query2);
  //      $this->db->query($query3);
  //       // $this->db->query("UPDATE ship_tbl_trn_cont_dtl set contid = '".$contid."' WHERE id in (".$inward.",".$outward.")");
  //  }


  function containerinward_move_multiple($shipdate, $id, $flag, $shipid, $etd, $desc)
  {
    //CALL IMPLODED STRING AS A CONDITIONS USING "IN"
    $table_detail = ($desc == 'ggfs') ? 'ship_tbl_trn_cont_dtl_ggfs' : 'ship_tbl_trn_cont_dtl';
    $pk_column = ($desc == 'ggfs') ? 'id_ggfs' : 'id';

    $query1 = " UPDATE $table_detail SET contid =
                         ( SELECT contid FROM ship_tbl_trn_cont_hdr where shipmentdate = '$shipdate' AND ETD = '$etd' LIMIT 1)
                     where $pk_column IN($id)";
    $query2 = "UPDATE $table_detail SET contid =
                         (SELECT contid FROM ship_tbl_trn_cont_hdr where shipmentdate = '$shipdate' AND ETA = '$etd' LIMIT 1)
                     where $pk_column IN($flag)";

    $query3 = "UPDATE mar_tbltrn_shipping_instruction set schedule_date = '$shipdate' where ship_id IN($shipid)";

    $this->db->query($query1);
    $this->db->query($query2);

    if($desc == 'ggfs'){
      $this->db3->query($query3);
    } else{
      $this->db->query($query3);
    }
  }


  function containerinward_move($shipmendate, $id, $flag, $et, $shipid)
  {
    // LET'S EXPLODE THEM
    $id_explode = explode(" ", $id);
    $flag_explode = explode(" ", $flag);
    $shipid_explode = explode(" ", $shipid);

    // IMPLODE THEM BACK, SEPARATE BY COMMA
    $id_implode = implode(",", $id_explode);
    $flag_implode = implode(",", $flag_explode);
    $shipid_implode = implode(",", $shipid_explode);

    //CALL IMPLODED STRING AS A CONDITIONS USING "IN"
    $query1 = " UPDATE ship_tbl_trn_cont_dtl SET contid =
                         ( SELECT contid FROM ship_tbl_trn_cont_hdr where shipmentdate = '$shipmendate' AND ETD = '$et' LIMIT 1)
                     where id IN($id_implode)";
    $query2 = "UPDATE ship_tbl_trn_cont_dtl SET contid =
                         (SELECT contid FROM ship_tbl_trn_cont_hdr where shipmentdate = '$shipmendate' AND ETA = '$et' LIMIT 1)
                     where id IN($flag_implode)";
    $query3 = "UPDATE mar_tbltrn_shipping_instruction set schedule_date = '$shipmendate' where ship_id IN($shipid_implode)";

    $this->db->query($query1);
    $this->db->query($query2);
    $this->db->query($query3);
  }

  //=================== Tambah Lagi untuk Loading Confirmation ============

  function tampil_po_inward_loading($sl, $ship)
  {
    $query3 = "(shipping_liner like '%" . $sl . "%' and contid = '" . $ship . "')";

    $this->db->where($query3);
    $this->db->order_by('shipmentdate');
    $result = $this->db->get('ship_vw_trn_cont');
    return $result->result();
  }

  function tampil_sl()
  {
    $result = $this->db->query("select distinct shipping_liner from ship_vw_trn_cont order by shipping_liner and shipmentdate > '2018-01-01'");
    return $result->result();
  }

  function tampil_sl_new()
  {
    $result = $this->db->query("select shipping_id,shipping_name from ship_tbl_mst_shipping_line order by shipping_name");
    return $result->result();
  }

  function tampil_shipmentdate()
  {
    $result = $this->db->query("select contid,shipmentdate,etd from ship_tbl_trn_cont_hdr where tipe='2' and shipmentdate > '2018-01-01' order by shipmentdate DESC");
    return $result->result();
  }

  //======================= Kelonggaran Marketing Old==========================

  function enable_update($shipid)
  {
    $this->db->query("UPDATE mar_tbltrn_shipping_instruction set allow_update = '1', proses = '0' WHERE ship_id = " . $shipid . "");
  }

  function enable_update_multiple($shipid)
  {
    $this->db->query("UPDATE mar_tbltrn_shipping_instruction set allow_update = '1', proses = '0' WHERE ship_id IN($shipid)");
  }

  function disable_update($shipid)
  {
    $this->db->query("UPDATE mar_tbltrn_shipping_instruction set allow_update = '0', proses = '1' WHERE ship_id = " . $shipid . "");
  }

  function disable_update_multiple($shipid)
  {
    $this->db->query("UPDATE mar_tbltrn_shipping_instruction set allow_update = '0', proses = '1' WHERE ship_id IN ($shipid)");
  }

  //=======================Tampil Customer Sales Invoice====================
  function tampil_customer()
  {
    $this->db->order_by('group_customer');
    $result =  $this->db->get('zhl_mar_tblmst_customer');
    return $result->result();
  }

  function tampil_customer2()
  {
    $this->db->order_by('customer_code');
    $result =  $this->db->get('zhl_vw_local_cont_dtl');
    return $result->result();
  }
  // =======================================Tracking Container=========================

  function getTrackContainer($param)
  {
    $data = array();
    if (isset($param['shipment_date']) && strlen($param['shipment_date']) > 0 && date('Y', strtotime($param['shipment_date'])) > 1970) {
      $this->db->where("shipmentdate", date("Y-m-d", strtotime($param['shipment_date'])));
    }


    if (!empty($param['tipe'])) {
      if ($param['tipe'] == 2) {
        if (isset($param['eta']) && strlen($param['eta']) > 0) {
          $this->db->where("etd", $param['eta']);
        }
      }
      if ($param['tipe'] == 1) {
        if (isset($param['eta']) && strlen($param['eta']) > 0) {
          $this->db->where("eta", $param['eta']);
        }
      }
    }


    // if (isset($param['factory_id']) && count($param['factory_id']) > 0) {
    //     $this->db->where_in("eta", $param['factory_id']);
    // }
    $this->db->where("tipe", $param['tipe']);

    $this->db->order_by('shipmentdate', 'desc');


    $hdr = $this->db->get($this->tblContHdr)->result();

    foreach ($hdr as $hdr) :
      $this->db->select("a.*, stuffing_name, name_supp, customer_name");
      $this->db->join("zhl_shp_tblmst_stuffing_local b", "b.stuffing_abbr = a.stuffing", "left");
      $this->db->join("zhl_ship_tbl_mst_supp_whs_for_cont c", "c.id_supp = a.supplier", "left");
      $this->db->join("zhl_mar_tblmst_customer d", "d.customer_code = a.customer", "left");
      // if (isset($param['container_number']) && strlen($param['container_number']) > 0) {
      // $this->db->like('container_number', $param['container_number']);
      // }
      $this->db->where(["contid" => $hdr->contid]);
      if ($param['tipe'] == 2) {
        $this->db->where(["is_ready_in_zhl" => 1]);
      }
      $det = $this->db->get($this->tblContLocalDet . " a")->result();
      $detContLocal = [];
      foreach ($det as $val) {
        $contReceived = $this->db->get_where($this->tblContAccept, ['contid' => $hdr->contid, 'det_id' => $val->id])->row();
        if ($contReceived->status == null) {
          $statuStuffing = "";
        } else if ($contReceived->status == 1) {
          $statuStuffing = "Stuffing";
        } else if ($contReceived->status == 2) {
          $statuStuffing = "Un Stuffing";
        }

        if ($contReceived->condition == null || $contReceived->condition == 0) {
          $staturepair = '<i class="fa fa-check" aria-hidden="true"></i>';
        } else{
          $staturepair = '<i class="fa fa-times" aria-hidden="true"></i>';
        }

        $detContLocal[] = [
          "id_received"                => $contReceived->id,
          "id_cont_local"            => $val->id,
          "contid"            => $val->contid,
          "container_type"    => $val->container_type,
          "container_id"    => $val->container_id,
          "container_number"  => $val->container_number,
          "proses"            => $val->proses,
          "bargejurnal"       => $val->bargejurnal,
          "stuffing"          => $val->stuffing,
          "container_id"      => $val->container_id,
          "customer"          => $val->customer,
          "jurnal_trucking"   => $val->jurnal_trucking,
          "is_ready_in_zhl"   => $val->is_ready_in_zhl,
          "is_inward_name"   => $val->is_ready_in_zhl == 1 ? "" : "Alread in the outward list",
          "reff"              => $val->reff,
          "stuffing_name"     => $val->stuffing_name,
          "is_outward"     => $contReceived->is_outward,
          "is_outward_name"     => $contReceived->is_outward == 1 ? "already in the inward list" : "",
          "name_supp"         => $val->name_supp,
          "status_stuffing"   => $contReceived->status,
          "status_stuffing_name" => $statuStuffing,
          "customer_name"     => $val->customer_name,
          "is_received"       => count($contReceived) > 0  ? true : false,
          "status_received"       => count($contReceived) > 0  ? "Received" : "Not Received",
          "receive_date" => $contReceived->created_date,
          "receive_by" => $contReceived->created_by,
          "is_repair" => $staturepair
        ];
      }
      $data[] = [
        "contid"   => $hdr->contid,
        "tipe"     => $hdr->tipe,
        "barge"    => $hdr->barge,
        "voyage"   => $hdr->voyage,
        "etd"      => $hdr->etd,
        "etddate"  => $hdr->etddate,
        "eta"      => $hdr->eta,
        "etadate"  => $hdr->etadate,
        "shipmentdate" => $hdr->shipmentdate,
        "det_local" => $detContLocal
      ];

    endforeach;
    return $data;
  }


  function getLocalContainerByParam($param)
  {
    $this->db->select('tipe, a.contid, a.container_number, shipmentdate, etd, etddate, eta, etadate, `from`, `to`');
    $this->db->from('ship_tbl_trn_cont_local_dtl a');
    $this->db->join('ship_tbl_trn_cont_hdr b', 'a.contid = b.contid');

    if (isset($param['shipmentDate'])) {
      $this->db->where('shipmentdate', date("Y-m-d",  strtotime($param['shipmentDate'])));
    }
    if (isset($param['tipe'])) {
      $this->db->where('tipe', $param['tipe']);
    }

    if (isset($param['containerNumber']) && $param['containerNumber'] != null) {
      $this->db->where('container_number', $param['containerNumber']);
    }

    if (isset($param['limit'])) {
      $this->db->limit($param['limit']);
    }

    $this->db->order_by('shipmentdate', 'desc');

    $query = $this->db->get()->result();
    return $query;
  }

  // =======================================End Tracking Container=========================


  function strore_import($param)
  {
    $this->db->trans_begin();
    $header = [
      'tipe' => $param['tipe'],
      'barge' => $param['vessel'],
      'voyage' => $param['voyage'],
      'etd' => $param['etd'],
      'etddate' => $param['etd_date'],
      'eta' => $param['eta'],
      'etadate' => $param['eta_date'],
      'shipmentdate' => $param['shipment_date'],
      'from' => $param['from'],
      'to' => $param['to'],
      'createdby' => $this->userId,
      'createddate' => currentDate(),
      'customer' => $param['customer'],
      'customer_code' => $this->getCustomerCode($param['customer']),
    ];

    $this->db->insert('zhl_ship_tbl_trn_cont_hdr_import', $header);
    $header_id = $this->db->insert_id();

    foreach ($param['no_urut'] as $key => $item) {
      $detail[] = [
        'contid' => $header_id,
        'urut' => $param['no_urut'][$key],
        'shipping' => $param['ship'][$key],
        'destination' => $param['final_dest'][$key],
        'reff' => $param['booking_ref'][$key],
        'vessel' => $param['voyage_vessel'][$key],
        'depot' => $param['depot'][$key],
        'pod' => $param['pod'][$key],
        'opcode' => $param['op_code'][$key],
        'container_type' => $param['ct'][$key],
        'seal' => $param['seal_number'][$key],
        'container_size_20' => $param['container_type_20'][$key],
        'container_size_40' => $param['container_type_40'][$key],
        'eta_sin' => $param['eta_sin'][$key]
      ];
    }

    $this->db->insert_batch('zhl_ship_tbl_trn_cont_dtl_import', $detail);

    if ($this->db->trans_status() === FALSE) {
      // jika terjadi error, rollback semua perubahan
      $this->db->trans_rollback();
      return false;
    } else {
      // jika semua berhasil, commit semua perubahan
      $this->db->trans_commit();
      return true;
    }
  }

  function validateImport($param)
  {
    $getById = $this->db->get_where('zhl_ship_tbl_trn_cont_hdr_import', [
      'barge' => $param['vessel'],
      'voyage' => $param['voyage'],
      'customer' => $param['customer'],
      'etd' => $param['etd'],
      'eta' => $param['eta'],
      'shipmentdate' => $param['shipment_date'],
    ])->row();

    // if ($getById) return true;

    return $getById;
  }

  function getCustomerCode($name)
  {
    $row = $this->db->get_where('zhl_mar_tblmst_customer', ['customer_text' => $name])->row();

    return $row->customer_code;
  }

  function get_all_cont_location()
  {
    return $this->db->query("select * from(
            SELECT  a.container_number, c.* FROM ship_tbl_trn_cont_local_dtl a
            join zhl_mar_tblmst_container_zhl b on a.container_number = b.container_number
            join ship_tbl_trn_cont_hdr c on a.contid = c.contid
            order by shipmentdate desc , eta desc
            ) as t
            group by container_number
            ORDER BY shipmentdate desc")->result();
  }

  function getTrackContainerZhl($param)
  {
    if (isset($param['shipment_date'])) {
      $this->db->where("shipmentdate", date("Y-m-d", strtotime($param['shipment_date'])));
    }

    if (isset($param['eta']) && strlen($param['eta']) > 0) {
      $this->db->where("eta", $param['eta']);
    }

    if (isset($param['factory_id']) && count($param['factory_id']) > 0) {
      $this->db->where_in("eta", $param['factory_id']);
    }
    $this->db->where("tipe", $param['tipe']);


    $hdr = $this->db->get($this->tblContHdr)->result();

    foreach ($hdr as $hdr) :
      $this->db->select("a.*, stuffing_name, name_supp, customer_name");
      $this->db->join("zhl_shp_tblmst_stuffing_local b", "b.stuffing_abbr = a.stuffing");
      $this->db->join("zhl_ship_tbl_mst_supp_whs_for_cont c", "c.id_supp = a.supplier", "left");
      $this->db->join("zhl_mar_tblmst_customer d", "d.customer_code = a.customer", "left");
      $this->db->where(["contid" => $hdr->contid]);
      $det = $this->db->get($this->tblContLocalDet . " a")->result();
      $detContLocal = [];
      foreach ($det as $val) {
        $contReceived = $this->db->get_where($this->tblContAccept, ['contid' => $hdr->contid, 'det_id' => $val->id])->row();
        if ($contReceived->status == null) {
          $statuStuffing = "";
        } else if ($contReceived->status == 1) {
          $statuStuffing = "Stuffing";
        } else if ($contReceived->status == 2) {
          $statuStuffing = "Un Stuffing";
        }

        $detContLocal[] = [
          "id_received"                => $contReceived->id,
          "id_cont_local"            => $val->id,
          "contid"            => $val->contid,
          "container_type"    => $val->container_type,
          "container_id"    => $val->container_id,
          "container_number"  => $val->container_number,
          "proses"            => $val->proses,
          "bargejurnal"       => $val->bargejurnal,
          "stuffing"          => $val->stuffing,
          "container_id"      => $val->container_id,
          "customer"          => $val->customer,
          "jurnal_trucking"   => $val->jurnal_trucking,
          "reff"              => $val->reff,
          "stuffing_name"     => $val->stuffing_name,
          "is_outward"     => $contReceived->is_outward,
          "is_outward_name"     => $contReceived->is_outward == 1 ? "already in the inward list" : "",
          "name_supp"         => $val->name_supp,
          "status_stuffing"   => $contReceived->status,
          "status_stuffing_name" => $statuStuffing,
          "customer_name"     => $val->customer_name,
          "is_received"       => count($contReceived) > 0  ? true : false,
          "status_received"       => count($contReceived) > 0  ? "Received" : "Not Received",
          "receive_date" => $contReceived->created_date,
          "receive_by" => $contReceived->created_by,
        ];
      }
      $data[] = [
        "contid"   => $hdr->contid,
        "tipe"     => $hdr->tipe,
        "barge"    => $hdr->barge,
        "voyage"   => $hdr->voyage,
        "etd"      => $hdr->etd,
        "etddate"  => $hdr->etddate,
        "eta"      => $hdr->eta,
        "etadate"  => $hdr->etadate,
        "shipmentdate" => $hdr->shipmentdate,
        "det_local" => $detContLocal
      ];

    endforeach;
    return $data;
  }

  function get_all_shipment($tipe)
  {
    $this->db->select('*');
    $this->db->where('tipe', $tipe);
    $this->db->order_by('shipmentdate', 'desc');
    $sql = $this->db->get("ship_tbl_trn_cont_hdr", 10);
    return $sql->result();
  }

  function save_ship_to_inward($param)
  {
    $this->db->trans_begin();
    // insert header container

    $this->db->where('contid', $param['contid']);
    $this->db->where('tipe', $param['tipe']);
    $dataHeader = $this->db->get('ship_tbl_trn_cont_hdr')->row();
    // return $dataHeader;
    // die;

    // // end insert header container

    // // insert container detail

    if (isset($param['det_local_id'])) {
      $dataDetail = [];

      foreach ($param['det_local_id'] as $val) :

        $local = $this->db->get_where("ship_tbl_trn_cont_local_dtl", ['id' => $val])->row();

        $cekCont = $this->db->get_where("ship_tbl_trn_cont_local_dtl", ['contid' => $dataHeader->contid, 'container_number' => $local->container_number])->row();



        if (count($cekCont) == 0) {

          $dataDetail[] =
            [
              "contid" => $dataHeader->contid,
              "container_type" => $local->container_type,
              "container_id" => $local->container_id,
              "container_number" => $local->container_number,
              "reff" => $local->container_number,
              "stuffing" => $local->stuffing,
              "is_ready_in_zhl" => 1,
              "created_by" => $this->session->userdata("userid_1"),
              "created_date" => date("Y-m-d H:i:s"),
            ];
        }
      endforeach;

      $this->db->insert_batch("ship_tbl_trn_cont_local_dtl", $dataDetail);
    }

    // return $dataDetail;
    // die;

    // end insert container detail

    // Update Stock Container
    if (isset($param['det_received_id'])) {

      $dataStcok = [];

      foreach ($param['det_received_id'] as $id) :

        $dataStcok[] =
          [
            "id" => $id,
            "is_outward" => 1,
          ];
      endforeach;

      $this->db->update_batch('ship_tbl_trn_cont_acceptance_dtl', $dataStcok, 'id');
    }
    // End Update Stock Container

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return $dataHeader->contid;
    }
  }

  function save_ship_to_outward($param)
  {
    $this->db->trans_begin();

    $this->db->where('contid', $param['contid']);
    $this->db->where('tipe', $param['tipe']);
    $dataHeader = $this->db->get('ship_tbl_trn_cont_hdr')->row();


    if (isset($param['det_local_id'])) {

      $dataDetail = [];

      foreach ($param['det_local_id'] as $key => $val) :
        $getDetail = $this->db->get_where("ship_tbl_trn_cont_local_dtl", ['id' => $val])->row();
        $dataDetail[] =
          [
            "contid" => $dataHeader->contid,
            "id_inward" => $val,
            "container_type" => $getDetail->container_type,
            "container_id" => $getDetail->container_id,
            "container_number" => $getDetail->container_number,
            "reff" => $getDetail->container_number,
            "stuffing" => $getDetail->stuffing,
            "created_by" => $this->session->userdata("userid_1"),
            "created_date" => date("Y-m-d H:i:s"),
          ];

        $this->db->where("id", $val);
        $this->db->update("ship_tbl_trn_cont_local_dtl", ['is_ready_in_zhl' => 0]);
      endforeach;

      $this->db->insert_batch("ship_tbl_trn_cont_local_dtl", $dataDetail);
    }



    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      return false;
    } else {
      $this->db->trans_commit();
      return $dataHeader->contid;
    }
  }


  // function save_ship_to_outward($param)
  // {
  //     $this->db->trans_begin();
  //     $dataHeader = [
  //         "tipe"          => 1,
  //         "barge"         => $param['vessel'],
  //         "voyage"        => $param['voyage'],
  //         "etd"           => $param['etd'],
  //         "etddate"       => date("Y-m-d", strtotime($param['etd_date'])),
  //         "eta"           => $param['eta'],
  //         "etadate"       => date("Y-m-d", strtotime($param['eta_date'])),
  //         "shipmentdate"  => date("Y-m-d", strtotime($param['shipment_date'])),
  //         "from"          => $param['from'],
  //         "to"            => $param['to'],
  //         "createdby"     => $this->session->userdata("userid_1"),
  //         "createddate"   => date("Y-m-d H:i:s"),
  //     ];

  //     $this->db->insert("ship_tbl_trn_cont_hdr", $dataHeader);

  //     $hdrId = $this->db->insert_id();

  //     if (isset($param['container_id'])) {

  //         $dataDetail = [];

  //         foreach ($param['container_id'] as $key => $val) :
  //             $getDetail = $this->db->get_where("ship_tbl_trn_cont_local_dtl", ['id' => $param['det_id'][$key]])->row();
  //             $dataDetail[] =
  //                 [
  //                     "contid" => $hdrId,
  //                     "id_inward" => $param['det_id'][$key],
  //                     "container_type" => $getDetail->container_type,
  //                     "container_id" => $getDetail->container_id,
  //                     "container_number" => $getDetail->container_number,
  //                     "stuffing" => $getDetail->stuffing,
  //                     "stuffing" => $getDetail->stuffing,
  //                     "created_by" => $this->session->userdata("userid_1"),
  //                     "created_date" => date("Y-m-d H:i:s"),
  //                 ];

  //             $this->db->where("id", $param['det_id'][$key]);
  //             $this->db->update("ship_tbl_trn_cont_local_dtl", ['is_ready_in_zhl' => 0]);
  //         endforeach;

  //         $this->db->insert_batch("ship_tbl_trn_cont_local_dtl", $dataDetail);
  //     }


  //     if ($this->db->trans_status() === FALSE) {
  //         $this->db->trans_rollback();
  //         return false;
  //     } else {
  //         $this->db->trans_commit();
  //         return $hdrId;
  //     }
  // }

  function getContLocalInward($param)
  {
    $this->db->select("a.*, b.customer_name, c.suppliercompany, d.stuffing_abbr");
    $this->db->join("zhl_mar_tblmst_customer b", "a.customer = b.customer_code", "left");
    $this->db->join("zhl_pur_tbl_mst_supplier c", "a.supplier = c.supplierid", "left");
    $this->db->join("zhl_shp_tblmst_stuffing_local d", "a.stuffing = d.stuffing_abbr", "left");
    $this->db->where(['contid' => $param['contid']]);
    return $this->db->get('ship_tbl_trn_cont_local_dtl a')->result();
  }

  function getAllContainerZHL()
  {
    return $this->db->get("zhl_mar_tblmst_container_zhl")->result();
  }

  function save_penerimaan_container($param)
  {
    try {

      $this->db->trans_begin();

      $dataHeader = [
        // 'trans_date' => dateFormat('Y-m-d H:i:s', $param['doc_no']),
        'trans_date' => date('Y-m-d H:i:s'),
        'trans_type' => $param['type'],
        'shipment_date' => $param['shipment_date'],
        'arrival_date' => $param['arrival_date'],
        'vessel' => $param['vessel'],
        'voyage' => $param['voyage'],
        'remarks' => $param['remarksHdr'],
        'created_at' => $this->userId,
        'created_date' => date('Y-m-d H:iLs'),
        'computer' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
        'computer_date' => date('Y-m-d H:iLs')
      ];

      $this->db->insert("zhl_tbl_trn_penerimaan_container_hdr", $dataHeader);
      $hdrId = $this->db->insert_id();

      for ($i = 0; $i < count($param['containerId']); $i++) {
        $is_out = $param['type'] == 'outward' ? 0 : 1;
        $dataDtl[] = [
          'trans_id' => $hdrId,
          'container_number' => $param['containerId'][$i],
          'status_penerimaan' => $param['statusContainer'][$i],
          'remarks' => $param['remarks'][$i],
          'created_at' => $this->userId,
          'created_date' => date('Y-m-d H:iLs'),
          'computer' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
          'computer_date' => date('Y-m-d H:iLs'),
          'is_container_in_singapore' => $is_out
        ];
        if ($param['type'] == 'outward') {
          $this->db->where('container_number', $param['containerId'][$i]);
          $this->db->update('zhl_tbl_trn_penerimaan_container_dtl', ['is_container_in_singapore' => 0]);
        }
      }
      $this->db->insert_batch('zhl_tbl_trn_penerimaan_container_dtl', $dataDtl);

      if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return false;
      } else {
        $this->db->trans_commit();
        return $hdrId;
      }
    } catch (\Throwable $err) {
      echo json_encode($err->getMessage());
    }
  }

  function update_penerimaan_container($param)
  {
    try {

      $this->db->trans_begin();

      $dataHeader = [
        'trans_type' => $param['type'],
        'shipment_date' => $param['shipment_date'],
        'arrival_date' => $param['arrival_date'],
        'vessel' => $param['vessel'],
        'voyage' => $param['voyage'],
        'remarks' => $param['remarksHdr'],
        'updated_at' => $this->userId,
        'updated_date' => date('Y-m-d H:iLs'),
      ];
      $this->db->where('trans_id', $param['trans_id']);
      $this->db->update("zhl_tbl_trn_penerimaan_container_hdr", $dataHeader);

      $this->db->where('trans_id', $param['trans_id']);
      $this->db->delete("zhl_tbl_trn_penerimaan_container_dtl");


      for ($i = 0; $i < count($param['containerId']); $i++) {
        $dataDtl[] = [
          'trans_id' => $param['trans_id'],
          'container_number' => $param['containerId'][$i],
          'status_penerimaan' => $param['statusContainer'][$i],
          'remarks' => $param['remarks'][$i],
          'created_at' => $this->userId,
          'created_date' => date('Y-m-d H:iLs'),
          'computer' => gethostbyaddr($_SERVER['REMOTE_ADDR']),
          'computer_date' => date('Y-m-d H:iLs')
        ];
      }
      $this->db->insert_batch('zhl_tbl_trn_penerimaan_container_dtl', $dataDtl);

      // return $dataDtl;



      if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return false;
      } else {
        $this->db->trans_commit();
        return $param['trans_id'];
      }
    } catch (\Throwable $err) {
      echo json_encode($err->getMessage());
    }
  }

  function tampil_receiptcontainer($data)
  {
    $query = "(vessel like '%" . $data . "%' or voyage like '%" . $data . "%' or etd like '%" . $data . "%' or eta like '%" . $data . "%' or trans_type like '%" . $data . "%')";
    $this->db->where($query);
    $this->db->order_by('trans_date', 'DESC');
    $result = $this->db->get('zhl_tbl_trn_penerimaan_container_hdr');
    return $result->result();
  }

  function get_penerimaan_container_by_id($id)
  {
    $dataHdr = $this->db->get_where("zhl_tbl_trn_penerimaan_container_hdr", ['trans_id' => $id])->row();


    $this->db->select("a.*, b.container_number, b.container_zhl_id, c.status, d.container_name");
    $this->db->join("zhl_mar_tblmst_container_zhl b", "a.container_number = b.container_zhl_id");
    $this->db->join("zhl_tbms_status_container c", "c.id= a.status_penerimaan");
    $this->db->join("zhl_mar_tblmst_container d", "d.container_id = b.container_id");
    $this->db->where("trans_id", $id);
    $detail = $this->db->get("zhl_tbl_trn_penerimaan_container_dtl a")->result();

    $data = [
      'header' => $dataHdr,
      'detail' => $detail
    ];

    return $data;
  }

  function get_penerimaan_container_by_number($containerNumber)
  {
    $this->db->select("a.trans_id as transID, b.trans_date as transDate, b.shipment_date as shipmentDate, b.arrival_date as arrivalDate, voyage, vessel, 'SIN' as location  ,
        c.container_number as containerNumber, status as statusContainer, a.remarks ");
    $this->db->join('zhl_tbl_trn_penerimaan_container_hdr b', 'a.trans_id = b.trans_id');
    $this->db->join('zhl_mar_tblmst_container_zhl c', 'c.container_zhl_id = a.container_number');
    $this->db->join('zhl_tbms_status_container d', 'a.status_penerimaan = d.id');
    $this->db->where('c.container_number', $containerNumber);
    $this->db->where('a.is_container_in_singapore', 1);
    return $this->db->get('zhl_tbl_trn_penerimaan_container_dtl a')->row();
  }

  function get_penerimaan_container_by_container_number($container_number)
  {
  }

  //===================Container Barge Operator=============================
  function simpan_container_barge_operator($id, $contid, $container, $seal, $orang_terakhir, $tanggal, $jumlah)
  {
    for ($i = 0; $i < $jumlah; $i++) {

      $query1 = "UPDATE ship_tbl_trn_cont_dtl set container = '" . $container[$i] . "', seal = '" . $seal[$i] . "' WHERE id = '" . $id[$i] . "'";
      $query3 = "INSERT INTO zhl_ship_tbl_trn_cont_barge_operator (operator,dateupdate,contid,id_cont_dtl) VALUES ('" . $orang_terakhir . "','" . $tanggal . "','" . $contid . "','" . $id[$i] . "')"; // History Operator yang Update System Container Zhenghe

      $this->db->query($query1);
      $this->db->query($query3);
    }
  }

  function update_container_and_seal($id, $data)
  {
    $this->db->where('id', $id);
    $this->db->update('ship_tbl_trn_cont_dtl', $data);
    return true;
  }

  
  function update_container_and_seal_ggfs($id, $data)
  {
    $this->db->where('id_ggfs', $id);
    $this->db->update('ship_tbl_trn_cont_dtl_ggfs', $data);
    return true;
  }

  //=================Master Supplier==========================================
  function get_supplier()
  {
    // $this->db->where('id_supp in (1,2)'Krome@WSX);
    $this->db->order_by('name_supp');
    $result =  $this->db->get('zhl_ship_tbl_mst_supp_whs_for_cont');
    return $result->result();
  }

  //=================Master Depot=============================================
  function get_depot()
  {
    $this->db->order_by('depot_name');
    $result =  $this->db->get('ship_tbl_mst_depot');
    return $result->result();
  }

  //================Monitor Shipping Instruction=============================
  function monitor_filter()
  {
    $param_search   = $this->input->post('param_search');
    $factory_abbr   = $this->input->post('factory_abbr');
    $customer_name  = $this->input->post('customer_name');
    $port_name      = $this->input->post('port_name');
    $sales_marketing_id = $this->input->post('sales_marketing');
    $schedule_date1 = $this->input->post('schedule_date1');
    $schedule_date2 = $this->input->post('schedule_date2');
    $reff          = $this->input->post('reff');

    $this->db->where('schedule_date >=', dmy_to_ymd($schedule_date1));
    $this->db->where('schedule_date <=', dmy_to_ymd($schedule_date2));
    $this->db->like('factory_abbr', $factory_abbr);
    $this->db->like('customer_company_name', $customer_name);
    $this->db->like('final_destination_name', $port_name);
    //$this->db->like('sales_marketing_id', $sales_marketing_id);

    $this->db->group_start();

    $this->db->like('po_number', $param_search);
    $this->db->or_like('contract_no', $param_search);
    //$this->db->or_like('status_name', $param_search);
    $this->db->or_like('client_ref_no', $param_search);
    $this->db->or_like('factory_abbr', $param_search);
    $this->db->or_like('reff', $param_search);

    $this->db->group_end();

    $this->db->order_by('urut_container', 'asc');
    // $this->db->order_by('po_number', 'asc');

    return $this->db->get('mar_vw_trn_shipping_instruction_find_zhl_shipping')->result();
  }

  function sp_prt_hdr($ship_id)
  {
    $sql = $this->db->query("call sp_mar_prt_si($ship_id)");
    $res = $sql->row();
    $sql->next_result();
    $sql->free_result();
    return $res;
  }

  function sp_get_view_document($ship_id, $special_document = 0)
  {
    $sql = $this->db->query("call sp_mar_trn_si_doc($ship_id, $special_document)");
    $res = $sql->result();
    $sql->next_result();
    $sql->free_result();
    return $res;
  }

  function get_agent_for_print($ship_id)
  {
    $this->db->select('agent_name')->from('mar_vw_trn_shipping_instruction_agent');
    $this->db->where('ship_id', $ship_id);
    $this->db->limit(1);
    return $this->db->get();
  }

  function sp_get_detail_po($ship_id)
  {
    $sql = $this->db->query("call sp_mar_trn_si_po($ship_id)");
    $res = $sql->result();
    $sql->next_result();
    $sql->free_result();
    return $res;
  }

  function get_mix_po($ship_id, $po_hdr_id)
  {
    $this->db->where('ship_id', $ship_id);
    $this->db->where_not_in('po_hdr_id', $po_hdr_id);
    return $this->db->get('mar_vw_trn_shipping_instruction_po')->result();
  }

  function sp_get_detail_po_by_po($ship_id, $po_hdr_id)
  {
    $sql = $this->db->query("call sp_mar_trn_si_product_by_po($ship_id, $po_hdr_id)");
    $res = $sql->result();
    $sql->next_result();
    $sql->free_result();
    return $res;
  }

  function get_issued_by($hdr_id)
  {
    $this->db->where('contract_hdr_id', $hdr_id);
    $this->db->limit(1);
    return $this->db->get('mar_vw_trn_sales_contract_issued')->row();
  }

  function get_inward_data_to_si($id)
  {
    $sql = $this->db->query("SELECT * FROM ship_tbl_trn_cont_dtl a LEFT JOIN ship_tbl_trn_cont_hdr b on a.contid=b.contid WHERE shipid = '$id' AND flag > 0 AND b.contid <> 0");
    return $sql->row();
  }

  function get_container_name($containerNumber)
  {
    $this->db->select("container_name");
    $this->db->join("zhl_mar_tblmst_container b", "a.container_id = b.container_id");
    $this->db->where("a.container_number", $containerNumber);
    $sql = $this->db->get("zhl_mar_tblmst_container_zhl a")->row();

    return $sql->container_name;
  }

  function get_list_import_excel($param = null)
  {
    $sql = "SELECT *
                    FROM (
                    SELECT *,
                        @row_num := IF(@prev_customer = customer, @row_num + 1, 1) AS row_num,
                        @prev_customer := customer
                    FROM zhl_ship_tbl_trn_cont_hdr_import,
                        (SELECT @row_num := 0, @prev_customer := '') AS vars
                    WHERE is_active = 0
                    ORDER BY customer, shipmentdate, tipe
                    ) AS subquery
                    WHERE  row_num <= 4 AND (LENGTH(?) = 0 OR shipmentdate = ?) AND (LENGTH(?) = 0 OR customer = ?)
                    AND (
                        (? = 'Barge' AND barge LIKE CONCAT('%', ?, '%'))
                        OR (? = 'Voyage' AND voyage LIKE CONCAT('%', ?, '%'))
                        OR (? = 'Eta' AND Eta LIKE CONCAT('%', ?, '%'))
                        OR (? = 'Etd' AND etd LIKE CONCAT('%', ?, '%'))
                        OR LENGTH(?) <= 2
                    )
                    GROUP BY customer, shipmentdate, tipe, etd
                    ORDER BY shipmentdate, tipe";

    $query = $this->db->query($sql, array(
      $param['shipment_date'], $param['shipment_date'],
      $param['customer'], $param['customer'],
      $param['field'], $param['keyword'],
      $param['field'], $param['keyword'],
      $param['field'], $param['keyword'],
      $param['field'], $param['keyword'],
      $param['field']
    ));

    $sql = $query->result();



    // // $this->db->limit('250');
    // // $this->db->where('jenis_trans', 'PRG');
    // // $this->db->order_by('tanggal', 'DESC');
    // $sql = $this->db->query("SELECT *
    // FROM (
    //   SELECT *,
    //     @row_num := IF(@prev_customer = customer, @row_num + 1, 1) AS row_num,
    //     @prev_customer := customer
    //   FROM zhl_ship_tbl_trn_cont_hdr_import,
    //     (SELECT @row_num := 0, @prev_customer := '') AS vars
    //   WHERE
    //     (LENGTH(:shipment_date) = 0 OR shipmentdate = :shipment_date) AND
    //     (LENGTH(:customer) = 0 OR customer = :customer) AND
    //     (
    //       :field != 'Barge' OR barge LIKE CONCAT('%', :keyword, '%') OR
    //       :field != 'Voyage' OR voyage LIKE CONCAT('%', :keyword, '%') OR
    //       :field != 'Eta' OR Eta LIKE CONCAT('%', :keyword, '%') OR
    //       :field != 'Etd' OR etd LIKE CONCAT('%', :keyword, '%')
    //     )
    //   ORDER BY customer, shipmentdate, tipe
    // ) AS subquery
    // WHERE row_num <= 4
    // GROUP BY customer, shipmentdate, tipe, etd
    // ORDER BY shipmentdate, tipe;
    // ")->result();


    // if (strlen($param['shipment_date']) > 0) {
    //     $this->db->where("shipmentdate", $param['shipment_date']);
    // }

    // if (strlen($param['customer']) > 0) {
    //     $this->db->where("customer", $param['customer']);
    // }
    // if (strlen($param['field']) > 2) {
    //     if ($param['field'] == 'Barge') {
    //         $this->db->LIKE("barge", $param['keyword']);
    //     } else if ($param['field'] == 'Voyage') {
    //         $this->db->LIKE("voyage", $param['keyword']);
    //     } else if ($param['field'] == 'Eta') {
    //         $this->db->LIKE("Eta", $param['keyword']);
    //     } else if ($param['field'] == 'Etd') {
    //         $this->db->LIKE("etd", $param['keyword']);
    //     }
    // }

    // $sql = $this->db->get('zhl_ship_tbl_trn_cont_hdr_import')->result();
    return $sql;
  }

  function deleteImport($contid)
  {

    $this->db->where('contid', $contid);
    $sql = $this->db->update('zhl_ship_tbl_trn_cont_hdr_import', ['is_active' => 1, 'deleted_by' => $this->session->userdata('userid_1'), 'deleted_date' => date("Y-m-d H:i:s")]);

    if ($sql) return true;


    return false;
  }

  function show_import($contid)
  {
    $this->db->join("zhl_ship_tbl_trn_cont_dtl_import b", 'a.contid = b.contid');
    $this->db->where("a.contid", $contid);
    $this->db->where("a.is_active", 0);
    $sql = $this->db->get("zhl_ship_tbl_trn_cont_hdr_import a")->result();

    return $sql;
  }

  function get_customer_import()
  {
    $this->db->select("customer, customer_code");
    $this->db->where("is_active", 0);

    $this->db->group_by("customer");
    return $this->db->get('zhl_ship_tbl_trn_cont_hdr_import')->result();
  }
  function get_shipment_date_import()
  {
    $this->db->select("tipe, etd, etd, shipmentdate");
    $this->db->where("is_active", 0);

    $this->db->group_by("shipmentdate");
    $this->db->order_by("shipmentdate desc");
    return $this->db->get('zhl_ship_tbl_trn_cont_hdr_import')->result();
  }

  function refreshMonImportInOutward($param)
  {
  }


  function mon_noncormance()
  {
    // Ambil data dari tabel 'ship_tbl_trn_cont_non_conformance'
    $this->db->select('*');
    $sql = $this->db->get('ship_tbl_trn_cont_non_conformance')->result();

    // Ambil data dari 'zhl_ship_vw_summary_report' yang memiliki 'container_number'
    // yang ada di tabel 'ship_tbl_trn_cont_non_conformance'
    $this->db->select('*');
    $this->db->from('zhl_ship_vw_summary_report');
    $this->db->join('ship_tbl_trn_cont_non_conformance', 'zhl_ship_vw_summary_report.container = ship_tbl_trn_cont_non_conformance.container_number');
    $contExport = $this->db->get()->result();

    // Buat dictionary dari hasil kueri dengan menggunakan 'container_number' sebagai kunci
    $contExportDictionary = array();
    foreach ($contExport as $cont) {
      $contExportDictionary[$cont->container_number] = $cont;
    }

    $data = [
      'containerNonConformance' => $sql,
      'contExport' => $contExportDictionary
    ];

    return $data;
  }

  function getAllShipmentDate()
  {
    $this->db->select('shipmentdate');
    $this->db->limit(50);
    $this->db->group_by('shipmentdate');
    $this->db->order_by('shipmentdate', 'desc');



    $result = $this->db->get('ship_tbl_trn_cont_hdr')->result();

    return $result;
  }

  public function container_inward_byid($id)
  {
    $this->db->select('*');
    $this->db->from('ship_vw_trn_cont');
    $this->db->where('detail_id', $id);
    return $this->db->get()->row();
  }

  public function setflag_flowcharges($id)
  {
    $this->db->set('flowcargoes_flag', 1);
    $this->db->where('id', $id);
    $this->db->update('ship_tbl_trn_cont_dtl');
  }

  //---------------------------------------------------------ABOUT DKSH TRUCKING-----------------------------------------------------------------------
  public function get_trucking()
  {
    $this->db->select('*');
    $this->db->from('zhl_shipping_mon_dksh_trucking');
    return $this->db->get()->result();
  }
  
  function save_trucking_dksh($data)
  {
      $this->db->insert($this->tbltrucking, $data);
      return $this->db->insert_id();
  }

  function get_id_truck($id)
  {
    $this->db->select('*');
    $this->db->from($this->tbltrucking);
    $this->db->where('id_sn_truck', $id);
    return $this->db->get()->row();
  }

  public function update_trucking_dksh($data, $id)
  {
    $this->db->where('id_sn_truck', $id);
    $this->db->update($this->tbltrucking, $data);
    return $this->db->affected_rows();
  }

  function advance_list_dksh_trucking($po_number) {
    $sql_product = $this->db->query("select * from zhl_shipping_mon_dksh_trucking WHERE po_number like '%$po_number%'");

     if ($sql_product->num_rows() > 0) {
         foreach ($sql_product->result() as $data) {
             $hasil[] = $data;
         }
         return $hasil;
     }
  }

  function delete_trucking($id) {
    $this->db->where('id_sn_truck', $id);
    $this->db->delete('zhl_shipping_mon_dksh_trucking');

  }
  
  // public function tampil_excel_filter_dksh($offset, $length)
  // {
  //     $this->db->limit($length, $offset);
  //     $query = $this->db->get('zhl_shipping_mon_dksh_trucking');

  //     return $query->result();
  // }

  public function tampil_excel_filter_dksh($limit, $offset)
  {
      $this->db->limit($limit, $offset);
      $query = $this->db->get('zhl_shipping_mon_dksh_trucking');

      return $query->result();
  }

  public function tampil_excel_all_dksh(){
    $query = $this->db->get('zhl_shipping_mon_dksh_trucking');
    return $query->result();
  }
  //---------------------------------------------------------TUTUP DKSH TRUCKING-----------------------------------------------------------------------
  
    //----------------------------------------------------------- Container Chart ------------------------------------------------
    function chart_cont_inward($shipmentdate, $factory){
      $sql = $this->db->query("select * FROM vw_stuffing_tes WHERE shipmentdate='$shipmentdate' and tipe='1' and factory_abbr='$factory'");
      $hasil = array();
      if($sql->num_rows() > 0){
        foreach ($sql->result() as $data) {
          $hasil[] = $data;
        }    
      }else{
        $hasil = null;
      }
      return $hasil;
    }

    function chart_cont_outward($shipmentdate, $factory){
      $sql = $this->db->query("select * FROM vw_stuffing_tes WHERE shipmentdate='$shipmentdate' and tipe='2' and factory_abbr='$factory'");
      $hasil = array();
      if($sql->num_rows() > 0){
        foreach ($sql->result() as $data) {
          $hasil[] = $data;
        }    
      }else{
        $hasil = null;
      }
      return $hasil;
    }

    // ini untuk psg outward
    // function chart_cont_psg_inward($shipmentdate){
    //   $sql = $this->db->query("select * FROM vw_stuffing_tes WHERE shipmentdate='$shipmentdate' and tipe='1' and factory_abbr='PSG'");
    //   $hasil = array();
    //   if($sql->num_rows() > 0){
    //     foreach ($sql->result() as $data) {
    //       $hasil[] = $data;
    //     }    
    //   }else{
    //     $hasil = null;
    //   }
    //   return $hasil;
    // }

    // function chart_cont_psg_outward($shipmentdate){
    //   $sql = $this->db->query("select * FROM vw_stuffing_tes WHERE shipmentdate='$shipmentdate' and tipe='2' and factory_abbr='PSG'");
    //   $hasil = array();
    //   if($sql->num_rows() > 0){
    //     foreach ($sql->result() as $data) {
    //       $hasil[] = $data;
    //     }    
    //   }else{
    //     $hasil = null;
    //   }
    //   return $hasil;
    // }
     //---------------------------------------------------- Container Chart Tutup ------------------------------------------------

     function tampil_expired_license()
      {
          $this->db->select('*');
          $this->db->from('zhl_tims_mst_vehicle');
          $result = $this->db->get();
          return $result->row();
      }


  // ================================================================== ggfs =========================================================
  function tampil_po_ggfs($fac, $schedule, $po)
  {
    $query = "(po_number like '%" . $po . "%' or shipping_name like '%" . $po . "%' or container_name like '%" . $po . "%')";
    if ($fac != '') {
      $query = $query . " And Factory_id ='" . $fac . "'";
    }

    if ($schedule != '') {
      $query = $query . " And schedule_date ='" . $this->convert($schedule) . "'";
    }
    $this->db3->where('proses', '0');
    $this->db3->where($query);
    $this->db3->group_by('ship_id');
    $this->db3->group_by('schedule_date');
    $this->db3->group_by('po_number');
    $this->db3->group_by('factory_abbr');
    $this->db3->group_by('shipping_name');
    $this->db3->group_by('container_name');
    $this->db3->group_by('port_name');
    $this->db3->group_by('destination');
    $this->db3->order_by('schedule_date');
    $result = $this->db3->get('ship_vw_trn_shipping_instruction');
    return $result->result();
  }

  function tampil_po_outward_ggfs($data)
  {
    $query = "(po_number like '%" . $data . "%' or shipping_liner like '%" . $data . "%' or voyage like '%" . $data . "%' or eta like '%" . $data . "%' or etd  like '%" . $data . "%' or `from` like '%" . $data . "%' or `to` like '%" . $data . "%')";
    $this->db->where($query);
    $this->db->where('tipe', '1');
    $this->db->where('proses', '0');
    $result = $this->db->get('ship_vw_trn_cont_ggfs');
    return $result->result();
  }

  function tampil_cont_where_ggfs($contid)
  {
    $this->db->where('contid', $contid);
    $this->db->order_by('urut');
    $result = $this->db->get('ship_vw_trn_cont_ggfs');
    return $result->result();
  }

  function get_container_ggfs($contid)
  {
    $this->db->select('container,contid,detail_id');
    $this->db->where('contid', $contid);
    $this->db->where('flowcargoes_flag', NULL);
    $this->db->order_by('urut');
    $result = $this->db->get('ship_vw_trn_cont_ggfs');
    return $result->result();
  }

  function get_containerdetailid_ggfs($detailid)
  {
    $this->db->select('container,contid,detail_id');
    $this->db->where('detail_id', $detailid);
    $this->db->where('flowcargoes_flag', NULL);
    $this->db->order_by('urut');
    $result = $this->db->get('ship_vw_trn_cont_ggfs');
    return $result->row();
  }

  function tampil_cont_local_where_ggfs($contid)
  {
    $this->db->where('contid', $contid);
    $result = $this->db->get('zhl_vw_local_cont_dtl_ggfs');
    return $result->result();
  }

  function tampil_cont_where_outward_ggfs($contid)
  {
    $this->db->where('contid', $contid);
    $this->db->where('proses', '0');
    $result = $this->db->get('ship_vw_trn_cont_ggfs');
    return $result->result();
  }

  function simpan_cont_sp_dtl_ggfs($contid, $id_ggfs, $shipid_ggfs, $destination_ggfs, $reff_ggfs, $vessel_ggfs, $convessel_ggfs, $depot_ggfs, $pod_ggfs, $opcode_ggfs, $etd_ggfs, $eta_ggfs, $container_ggfs, $seal_ggfs, $weight_ggfs, $outward_ggfs, $jml_ggfs, $carrier_ggfs, $urut_ggfs, $stuffing_ggfs, $actual_seal_ggfs, $stock_id_dtl_ggfs, $container_number_ggfs, $supp_ggfs, $tipecont, $reff_remark_ggfs, $depot_remark_ggfs, $tare_weight_ggfs, $trucking_date_ggfs, $trucking_date_remark_ggfs)
  {
    for ($i = 0; $i < $jml_ggfs; $i++) {

      if ($container_number_ggfs[$i] != '') {
        $this->db->query("UPDATE zhl_ship_tbl_trn_cont_stock_dtl set status_note = '1' where container_number ='" . $container_number_ggfs[$i] . "'");
      }

      $this->db->query("SET @flag = 0");
      $this->db->query("call sp_ship_tbl_trn_cont_dtl_new1_ggfs('" . $contid . "','" . $id_ggfs[$i] . "','" . $shipid_ggfs[$i] . "','" . $destination_ggfs[$i] . "','" . $reff_ggfs[$i] . "','" . $vessel_ggfs[$i] . "','" . $convessel_ggfs[$i] . "','" . htmlspecialchars($depot_ggfs[$i], ENT_QUOTES) . "',"
        . "'" . $pod_ggfs[$i] . "','" . $opcode_ggfs[$i] . "','" . $etd_ggfs[$i] . "','" . $eta_ggfs[$i] . "','" . $container_ggfs[$i] . "','" . $seal_ggfs[$i] . "','" . $weight_ggfs[$i] . "','" . $outward_ggfs[$i] . "',@flag,'" . $carrier_ggfs[$i] . "','" . $urut_ggfs[$i] . "','" . $stuffing_ggfs[$i] . "','" . $actual_seal_ggfs[$i] . "','" . $supp_ggfs[$i] . "','" . $reff_remark_ggfs[$i] . "','" . $depot_remark_ggfs[$i] . "', '" . $tare_weight_ggfs[$i] . "', '" . $trucking_date_ggfs[$i] . "', '" . $trucking_date_remark_ggfs  [$i] . "', '" . $tipecont . "')");
    }

    $row =  $this->db->query("Select @flag as flag")->row();

    return $row;
  }
  
  function delete_container_local_hdr_ggfs($id)
  {
    $this->db->where('id_ggfs', $id);
    $this->db->delete('ship_tbl_trn_cont_local_dtl_ggfs');
    return true;
  }

  function delete_container_shipping_ggfs($id_inward, $id_outward)
  {
    $this->db->query("UPDATE ship_tbl_trn_cont_dtl_ggfs set contid = '0' WHERE id_ggfs in ($id_inward)");
    $this->db->query("UPDATE ship_tbl_trn_cont_dtl_ggfs set proses = '0' WHERE id_ggfs in ($id_outward)");
    return true;
  }

  function delete_container_shipping_outward_ggfs($id, $shipid, $contid)
  {
    $this->db->query("UPDATE ship_tbl_trn_cont_dtl_ggfs set contid = '0' WHERE id_ggfs = " . $id . "");
    $this->db->query("UPDATE ship_tbl_trn_cont_dtl_ggfs set ContBackup = '" . $contid . "' WHERE id_ggfs = " . $id . "");
    $this->db3->query("UPDATE mar_tbltrn_shipping_instruction set shp_status = ' ', proses = '0' WHERE ship_id = " . $shipid . "");
  }
   function enable_update_ggfs($shipid)
  {
    $this->db3->query("UPDATE mar_tbltrn_shipping_instruction set allow_update = '1', proses = '0' WHERE ship_id = " . $shipid . "");
  }

  function enable_update_multiple_ggfs($shipid)
  {
    $this->db3->query("UPDATE mar_tbltrn_shipping_instruction set allow_update = '1', proses = '0' WHERE ship_id IN($shipid)");
  }

  function disable_update_ggfs($shipid)
  {
    $this->db3->query("UPDATE mar_tbltrn_shipping_instruction set allow_update = '0', proses = '1' WHERE ship_id = " . $shipid . "");
  }
  function disable_update_multiple_ggfs($shipid)
  {
    $this->db3->query("UPDATE mar_tbltrn_shipping_instruction set allow_update = '0', proses = '1' WHERE ship_id IN ($shipid)");
  }
}
