<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_zht_gen_master extends CI_Model
{

    private $tblmst_country = 'zhl_gen_tbl_mst_country';
    private $country_id = 'country_id';
	
	private $tblmst_currency = 'zhl_gen_tbl_mst_currency';
	private $currency_id = 'currency_id';
	
	private $tblmst_status = 'zhl_gen_tbl_mst_status';
	private $status_id = 'status_id';
	
	private $tblmst_factory = 'zhl_gen_tbl_mst_factory';
	private $factory_id	= 'factory_id';
	
	private $tblmst_uom = 'zhl_gen_tbl_mst_item_uom';

	private $tblmst_group_cust = 'zht_mar_tblmst_customer_group';
	
	private $tblmst_ship_line = 'zhl_ship_tbl_mst_shipping_line';
	

//------ akses database acak -----
  	private $table_vendor		= 'zhl_pur_tbl_mst_supplier';
  	private $table_group_vendor = 'zhl_gen_tbl_mst_vendor_group';
  	//private $id 				= 'id';


	private $mark_table			= 'zhl_mar_tblmst_marketing';
	private $mark_view			= 'zhl_mar_vw_mst_marketing';
    private $mark_id			= 'marketing_id';

	private $sales_view			= 'zhl_mar_vw_mst_sales_marketing';
	private $sales_id			= 'userid';

	private $cust_table			= 'zht_mar_tblmst_customer';
	private $cust_view			= 'zht_mar_vw_mst_customer';
    private $cust_id			= 'customer_id';

	private $cust_doc_table		= 'zht_mar_tblmst_customer_document';
	private $cust_product_table	= 'zht_mar_tblmst_customer_product_purchase';

	private $cust_payterm_table = 'zht_mar_tblmst_customer_payterm';
	private $cust_payterm_view	= 'zht_mar_vw_mst_customer_payterm';

    private $cust_bank_table    = 'zht_mar_tblmst_customer_bank';
    private $cust_bank_view     = 'zht_mar_vw_mst_customer_bank';

	private $agent_table		= 'zhl_mar_tblmst_agent';
	private $agent_view			= 'zhl_mar_vw_mst_agent';

	private $brand_table		= 'zhl_mar_tblmst_brand';
	private $brand_id			= 'brand_id';

	private $document_table		= 'zhl_mar_tblmst_document';
	private $document_id		= 'document_id';

	private $bank_table			= 'zhl_mar_tblmst_bank';
	private $bank_view			= 'zhl_mar_vw_mst_bank';

	private $uom_volume_table	= 'zhl_mar_tblmst_uom_volume';

	private $uom_quantity_table = 'zhl_mar_tblmst_uom_quantity';

	private $uom_price_table	= 'zhl_mar_tblmst_uom_price';

	private $pack_size_table	= 'zhl_mar_tblmst_packing_size';
	private $packing_size_id	= 'packing_size_id';

	private $packing_type_table = 'zhl_mar_tblmst_packing_type';
	private $packing_type_id	= 'packing_type_id';

	private $container_table	= 'zhl_mar_tblmst_container';
	private $container_id		= 'container_id';

	private $port_table			= 'zhl_mar_tblmst_port';
	private $port_view			= 'zhl_mar_vw_mst_port';
	private $port_id			= 'port_id';

	private $tradingterm_table	= 'zhl_mar_tblmst_trading_term';
	private $tradingterm_id		= 'trading_term_id';

	private $paymentterm_table	= 'zhl_mar_tblmst_payment_term';
	private $paymentterm_id		= 'payment_term_id';

	private $shelf_table		= 'zhl_mar_tblmst_product_shelf_life';
	private $shelf_id			= 'product_shelf_life_id';

	private $maincate_table		= 'zhl_mar_tblmst_main_category';
	private $maincate_id		= 'main_category_id';

	private $sup_table			= 'zhl_pur_tbl_mst_supplier';
//------ akses database acak -----

    private $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all($nama_master)
    {
		switch ($nama_master) {
			case 'country':
				$this->db->where('not_active', 0);
				$this->db->order_by('country_name', 'ASC');
				$result = $this->db->get($this->tblmst_country);
				break;
			
			case 'currency':
				$this->db->where('not_active', 0);
				$this->db->order_by('currency_name', 'ASC');
				$result = $this->db->get($this->tblmst_currency);
				break;
			
			case 'status':
				$this->db->order_by('status_id', 'ASC');
				$result = $this->db->get($this->tblmst_status);
				break;
			
			case 'factory':
				$this->db->order_by('factory_abbr', 'ASC');
				$result = $this->db->get($this->tblmst_factory);
				break;
			
			case 'uom':
				$this->db->order_by('uomname', 'ASC');
				$result = $this->db->get($this->tblmst_uom);
				break;
			
			case 'customer';
			    $this->db->order_by('customer_id','ASC');
			    $result = $this->db->get($this->cust_table);
			    break;

			case 'group_customer':
				$this->db->order_by('customer_group_id', 'ASC');
				$result = $this->db->get($this->tblmst_group_cust);
				break;

			case 'vendor';
			    $this->db->order_by('supplierid','ASC');
			    $result = $this->db->get($this->table_vendor);
			    break;

			case 'group_vendor';
			    $this->db->order_by('id','ASC');
			    $result = $this->db->get($this->table_group_vendor);
			    break;

			case 'shipping_line':
				$this->db->where('notactive', 0);
				$result = $this->db->get($this->tblmst_ship_line);
				break;
			
			case 'item':
				$this->db->select('itemid,itemname');
				$this->db->where('notactive', 0);
				$result = $this->db->get('gen_tbl_mst_item');
				break;

			default:
				break;
		}
		        
        return $result->result();
    }
	
	function get_all_with_param($nama_master, $param)
	{
		switch ($nama_master) {
			case 'status':
				$this->db->where($param);
				$this->db->order_by('status_id', 'ASC');
				$result = $this->db->get($this->tblmst_status);
				break;

			default:
				break;
		}
		return $result->result();
	}

    // get data by id
    function get_by_id($nama_master, $id)
    {
		switch ($nama_master) {
			case 'country':
				$table = $this->tblmst_country;
				$this->db->where($this->country_id, $id);
				break;
			
			case 'currency':
				$table = $this->tblmst_currency;
				$this->db->where($this->currency_id, $id);
				break;
			
			case 'status':
				$table = $this->tblmst_status;
				$this->db->where($this->status_id, $id);
				break;
			
			case 'factory':
				$table = $this->tblmst_factory;
				$this->db->where($this->factory_id, $id);
				break;
	      
	        case 'customer':
	            $table = $this->cust_table;
	            $this->db->where($this->customer_id,$id);
	            break;


			case 'group_customer':
				$table = $this->tblmst_group_cust;
				$this->db->where('customer_group_id', $id);
				break;
			
			case 'vendor';
				$table = $this->table_vendor;
				$this->db->where($this->supplierid,$id);
				break;

			case 'group_vendor';
				$table = $this->table_group_vendor;
				$this->db->where($this->id,$id);
				break;


			case 'shipping_line':
				$table = $this->tblmst_ship_line;
				$this->db->where('shipping_id', $id);
				break;

			default:
				break;
		}
		
        return $this->db->get($table)->row();
    }
    
    // get total rows
    function country_total_rows($q = NULL) {
		$this->db->where('not_active', 0);
        $this->db->like('country_id', $q);
		$this->db->or_like('country_name', $q);
		$this->db->or_like('country_ids', $q);
		$this->db->or_like('country_idn', $q);
		$this->db->from($this->tblmst_country);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function country_get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->country_id, $this->order);
        $this->db->like('country_id', $q);
		$this->db->or_like('country_name', $q);
		$this->db->or_like('country_ids', $q);
		$this->db->or_like('country_idn', $q);
		$this->db->or_like('created_by', $q);
		$this->db->or_like('created_date', $q);
		$this->db->or_like('updated_by', $q);
		$this->db->or_like('updated_date', $q);
		$this->db->limit($limit, $start);
        return $this->db->get($this->tblmst_country)->result();
    }

    // insert data
    function insert($nama_master, $data)
    {
        switch ($nama_master) {
			case 'country':
				$table = $this->tblmst_country;
				break;
			
			case 'currency':
				$table = $this->tblmst_currency;
				break;
			
			case 'customer';
				$table = $this->cust_table;
				break;

			case 'group_customer';
				$table = $this->tblmst_group_cust;
				break;

			case 'vendor';
				$table = $this->table_vendor;
				break;

			case 'group_vendor';
			 	$table = $this->table_group_vendor;
			 	break;

			case 'status':
				$table = $this->tblmst_status;
				break;
			
			case 'factory':
				$table = $this->tblmst_factory;
				break;
			
			default:
				break;
		}
		$this->db->insert($table, $data);
    }

    // update data
    function update($nama_master, $id, $data)
    {
		switch ($nama_master) {
			case 'country':
				$table = $this->tblmst_country;
				$this->db->where($this->country_id, $id);
				break;
			
			case 'currency':
				$table = $this->tblmst_currency;
				$this->db->where($this->currency_id, $id);
				break;
			
			case 'status':
				$table = $this->tblmst_status;
				$this->db->where($this->status_id, $id);
				break;
			
			case 'factory':
				$table = $this->tblmst_factory;
				$this->db->where($this->factory_id, $id);
				break;

			case 'customer';
				$table = $this->cust_table;
				$this->db->where($this->customer_id, $id);
			
			case 'group_customer':
				$table = $this->tblmst_group_cust;
				$this->db->where('customer_group_id', $id);
				break;

			case 'vendor';
				$table = $this->table_vendor;
				$this->db->where($this->supplierid, $id);
				break;

			case 'group_vendor';
				$table = $this->table_group_vendor;
				$this->db->where($this->id, $id);
				break;

			default:
				break;
		}
        
        $this->db->update($table, $data);
    }

    // delete data
    function delete($nama_master, $id)
    {
		switch ($nama_master) {
			case 'country':
				$table = $this->tblmst_country;
				$this->db->where($this->country_id, $id);	
				$this->db->update($table, array('not_active' => 1));
				break;
			
			case 'currency':
				$table = $this->tblmst_currency;
				$this->db->where($this->currency_id, $id);	
				$this->db->delete($table);
				break;

			case 'customer':
				$table = $this->cust_table;
				$this->db->where($this->customer_id, $id);	
				$this->db->update($table, array('not_active' => 1));
				break;
			
			case 'group_customer':
				$table = $this->tblmst_group_cust;
				$this->db->where('customer_group_id', $id);	
				$this->db->delete($table);
				break;

//vendor dan group vendor belum ditambahkan....................
			
			case 'status':
				$table = $this->tblmst_status;
				$this->db->where($this->status_id, $id);	
				$this->db->delete($table);
				break;
			
			case 'factory':
				$table = $this->tblmst_factory;
				$this->db->where($this->factory_id, $id);	
				$this->db->delete($table);
				break;
			
		//	case 'group_customer':
		//		$this->db->where('customer_group_id', $id);
		//		$this->db->delete($this->tblmst_group_cust);
		//		break;

			default:
				break;
		}
	
    }

//--------------vendor dan group vendor----------------
    function cek($table,$where){
        $this->db->where($where);
        
        $sql=  $this->db->get($table);
        if($sql->num_rows() > 0){$result=1;}
        else{$result=0;}
        return $result;     
    }


    function simpan_vendor($data){
        $this->db->insert('pur_tbl_mst_supplier',$data);
        return true;
    }
    
    function update_vendor($vendorid,$data,$user){
        $this->db->where('supplierid',$vendorid);
        $this->db->where('createdby',$user);
        $sql = $this->db->get('pur_tbl_mst_supplier');
        
        if ($sql->num_rows() > 0) {
            $this->db->where('supplierid',$vendorid);
            $this->db->where('createdby',$user);
            $this->db->update('pur_tbl_mst_supplier',$data);
            return true;
        } else {
            return false;
        }
        
    }
    
    function delete_vendor($vendorid,$user){
        $this->db->where('supplierid',$vendorid);
        $this->db->where('createdby',$user);
        $sql = $this->db->get('pur_tbl_mst_supplier');
        
        if ($sql->num_rows() > 0) {
            $this->db->where('supplierid',$vendorid);
            $this->db->update('pur_tbl_mst_supplier',array('notactive'=>'1'));
            return true;
        } else {
            return false;
        }
    }
    
    function tampil_supp_group(){
        $this->db->select('a.*,b.AccountName');
        $this->db->from('gen_tbl_mst_vendor_group a');
        $this->db->join('acc_master_coa b','b.NoCOA=a.nocoa','left outer');
        $this->db->where('a.notactive = 0');
        $result=  $this->db->get();
        return $result->result();
    }
    
    function simpan_vendor_group($data){
        $this->db->insert('gen_tbl_mst_vendor_group',$data);
        return true;
    }
    
    function update_vendor_group($id,$data){
        $this->db->where('id',$id);
        $this->db->update('gen_tbl_mst_vendor_group',$data);
        return true;
    }
    
    function delete_vendor_group($id){
        $this->db->where('id',$id);
        $this->db->update('gen_tbl_mst_vendor_group',array('notactive'=>'1'));
        return true;
    } 

}