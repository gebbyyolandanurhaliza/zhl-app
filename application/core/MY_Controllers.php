<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controllers extends CI_Controller {
	public $api_url = "http://myrsup.co.id:8228/apimyrsup/";
	// public $api_url = "http://192.168.12.5:5000/api/";
    

    public function __construct() {
        parent::__construct();
        // public $secret_key = $this->session->userdata('secret_key');
        
    }

    function get_curl($uri){
        $secret = $this->session->userdata("secret_key");
        $url = $this->api_url.$uri;
        // echo "<br>";
        // echo $secret;

		$request_headers = array();
		$request_headers[] = 'Authorization: Bearer ' . $secret;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);

		if (curl_errno($ch))
		{
            print "Error: " . curl_error($ch);
            return 0;
		}
		else
		{
			$data = json_decode($result);
			curl_close($ch);
			return json_encode($data);
        }
	}
	
	function post_curl($uri, $data_post){
		$url = $this->api_url.$uri;
		
		$content = 'Content-Length: ' . strlen($data_post);
		$request_headers = array('Content-Type: application/json', $content);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		
		if (curl_errno($ch)){
			print "Error: " . curl_error($ch);
			curl_close($ch);
            return 0;
		}
		else{
			$data =  json_decode($result);
			curl_close($ch);
			return json_encode($data);
        }
	}

	function post_curl_with_jwt($uri, $data_post){
		$secret = $this->session->userdata("secret_key");
		$key = 'Authorization: Bearer ' . $secret;
		$url = $this->api_url.$uri;
		
		$content = 'Content-Length: ' . strlen($data_post);
		$request_headers = array('Content-Type: application/json', $content, $key);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);     
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);
		
		if (curl_errno($ch))		{
			print "Error: " . curl_error($ch);
			curl_close($ch);
            return 0;
		}else{
			$data =  json_decode($result);
			curl_close($ch);
			return json_encode($data);
        }
	}

	function put_curl($uri, $data_post){
		$secret = $this->session->userdata("secret_key");
		$key = 'Authorization: Bearer ' . $secret;
		$url = $this->api_url.$uri;
		
		$content = 'Content-Length: ' . strlen($data_post);
		$request_headers = array('Content-Type: application/json', $content, $key);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response  = curl_exec($ch);
		
		if (curl_errno($ch))		{
			print "Error: " . curl_error($ch);
			curl_close($ch);
            return 0;
		}else{
			$data =  json_decode($response);
			curl_close($ch);
			return json_encode($data);
        }
	}

}