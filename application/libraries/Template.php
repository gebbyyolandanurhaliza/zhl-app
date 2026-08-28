<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Template{
    protected $_CI;
    function __construct(){
        $this->_CI=&get_instance();
    }
	
    function display($template, $data = null){		        
		$data['_style']=$this->_CI->load->view('template/style',$data,true);
		$data['_navigation']=$this->_CI->load->view('template/navigation',$data,true);
		
		$data['_menu']=$this->_CI->load->view('template/menu',$data,true);
		$data['_title']=$this->_CI->load->view('template/title',$data,true);
				
		$data['_content']=$this->_CI->load->view($template,$data,true);
		
		$data['_footer']=$this->_CI->load->view('template/footer',$data,true);
		$data['_script']=$this->_CI->load->view('template/script',$data,true);
        $this->_CI->load->view('/template.php',$data);
    }
	
}

/* End of file template.php */
/* Location: ./system/application/libraries/template.php */