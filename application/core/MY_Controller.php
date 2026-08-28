<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	// public $api_url = "http://myrsup.co.id:8228/apimyrsup/";
	// public $api_url = "http://192.168.12.168:5000/apimyrsup/";
	// public $api_url = "http://192.168.12.5:5000/api/";
	public $api_url = "";
	// public $url_rsup = "http://localhost:5001/apimyrsup/";
	// public $url_rsup = "http://apip2.myrsup.co.id:5000/apimypske/";
	// public $url_psg = "http://222.124.139.234:5001/apimypske/";
	// public $url_pske = "http://36.92.171.18:5011/apimypske/";
	public $url_cargoesflow = "https://connect.cargoes.com/flow/api/public_tracking/v1/";

    function __construct()
    {
        parent::__construct();
        // public $secret_key_1 = $this->session->userdata('secret_key_1');
		if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
        
    }

    function get_curl($uri){
        $secret = $this->session->userdata("secret_key_1");
        $url = $this->api_url.$uri;
         

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
            // print "Error: " . curl_error($ch);
            return 0;
		}
		else
		{
			$data = json_decode($result);
			curl_close($ch);
			return json_encode($data);
        }
	}

	 function get_curl_wb($uri, $data_post){
        $secret = $this->session->userdata("secret_key_1");
        // echo $secret;
        $url = $this->api_url.$uri;
        echo $url;
        var_dump($data_post);

		$request_headers = array();
		$request_headers[] = 'Authorization: Bearer ' . $secret;

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($ch);

		if (curl_errno($ch))
		{
            print "Error: " . curl_error($ch);
            echo "sakit";
            return 0;
		}
		else
		{
			$data = json_decode($result);
			curl_close($ch);
			// echo "sehat";
			var_dump($data);

			return json_encode($data);
			
			// var_dump($data);
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
		$secret = $this->session->userdata("secret_key_1");
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
		$secret = $this->session->userdata("secret_key_1");
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

	// Khusus Cargoes API
	function curlGet($endpoint, $apiKey = 'dL6SngaHRXZfvzGA716lioRD7ZsRC9hs', $orgToken = 'YbsLUzbwhjq3IkfkfKaVLdOrrnosEd8F') {

		$url = $this->url_cargoesflow.$endpoint;

		// return $url;

		$headers = array(
			'Accept: application/json',
			'X-DPW-ApiKey: dL6SngaHRXZfvzGA716lioRD7ZsRC9hs',
			'X-DPW-Org-Token: YbsLUzbwhjq3IkfkfKaVLdOrrnosEd8F'
		);


        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_HTTPGET, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        // Cek apakah ada error
        if (curl_errno($ch)) {
            curl_close($ch);
            return json_decode(curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response);
    }

	function curlPost($endpoint, $data, $apiKey = 'dL6SngaHRXZfvzGA716lioRD7ZsRC9hs', $orgToken = 'YbsLUzbwhjq3IkfkfKaVLdOrrnosEd8F') {

		$url = $this->url_cargoesflow.$endpoint;

		// return $url;

		$headers = array(
			'Accept: application/json',
			'X-DPW-ApiKey: dL6SngaHRXZfvzGA716lioRD7ZsRC9hs',
			'X-DPW-Org-Token: YbsLUzbwhjq3IkfkfKaVLdOrrnosEd8F',
			'Content-Type: application/json'
		);

		$jsonData = json_encode($data);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_HTTPGET, true);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    	curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

        $response = curl_exec($ch);

        // Cek apakah ada error
        if (curl_errno($ch)) {
            curl_close($ch);
            return json_decode(curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response);
    }

	function curlPut($endpoint, $data, $apiKey = 'dL6SngaHRXZfvzGA716lioRD7ZsRC9hs', $orgToken = 'YbsLUzbwhjq3IkfkfKaVLdOrrnosEd8F'){
		
		$url = $this->url_cargoesflow.$endpoint;

		$headers = array(
			'Accept: application/json',
			'X-DPW-ApiKey: dL6SngaHRXZfvzGA716lioRD7ZsRC9hs',
			'X-DPW-Org-Token: YbsLUzbwhjq3IkfkfKaVLdOrrnosEd8F',
			'Content-Type: application/json'
		);

		$jsonData = json_encode($data);

        $ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');

		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

        $response = curl_exec($ch);

        // Cek apakah ada error
        if (curl_errno($ch)) {
            curl_close($ch);
            return json_decode(curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response);
	}

}