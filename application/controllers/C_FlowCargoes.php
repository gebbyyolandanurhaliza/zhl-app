
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_FlowCargoes extends MY_Controller {


    function __construct() {
        parent::__construct();

      
        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    function index() {
        // $data['listShipment'] = $this->curlGet('shipments?shipmentType=INTERMODAL_SHIPMENT&_page=1&_limit=10');

        $data['title'] = "Cargoes FLow Tracking";

        $this->template->display('shipping/cargoes_flow/index', $data);


    }

    // ini fungsi untuk genereate Shared Url
    function getGenerateSharedUrl(){
        $param = $this->input->post();
        $containerNumber = $param['containerNumber'];
        // var_dump($containerNumber);
        $getShipment = $this->curlPost("generateSharingUrl", array("containerNumber" => $containerNumber));
        // var_dump($getShipment);

        // $getShipment = $this->curlPost("generateSharingUrl",$containerNumber);
        // var_dump($getShipment);

        if (empty($getShipment)) {
            echo $this->httpResponseCode(404, "Combination of provided org-token and tracking value $containerNumber does not exist");
            return;
        }
    
        echo $this->httpResponseCode(200, "OK", $getShipment);
    }
    // ini tutup fungsi generate shared url

    // public function updateCargoes() {
    //     $param = $this->input->input_stream();

    //     if (isset($param['mblNumber']) && isset($param['shipmentNumber'])) {
    //         $mblNumber = $param['mblNumber'];
    //         $shipmentNumber = $param['shipmentNumber'];
    //         $formData = array(
    //             "formData" => array(
    //                 array(
    //                     "shipmentNumber" => $shipmentNumber,
    //                     "mblNumber" => $mblNumber
    //                 )
    //             )
    //         );
    //         $jsonFormData = json_encode($formData);
    //         var_dump($jsonFormData);

    //         $getShipment = $this->curlPut("updateShipments", $jsonFormData);
    //         // var_dump($getShipment);
    //         // if (empty($getShipment)) {
    //         //     echo $this->httpResponseCode(404, "Not Found");
    //         //     return;
    //         // }
        
    //         echo $this->httpResponseCode(200, "OK", $getShipment);
    //     }
    // }

    public function updateCargoes() {
        $param = $this->input->input_stream();
    
        if (isset($param['shipmentNumber']) && isset($param['bookingNumber']) && isset($param['shipper']) && isset($param['consignee'])) {
            $shipmentNumber = $param['shipmentNumber'];
            // $mblNumber = $param['mblNumber'];
            $bookingNumber = $param['bookingNumber'];
            // $referenceNumber = $param['referenceNumber'];
            $shipper = $param['shipper'];
            $consignee = $param['consignee'];

            // Menyiapkan data untuk disimpan ke database
            $dataToInsert = array(
                'shipmentNumber' => $shipmentNumber,
                'bookingNumber' => $bookingNumber,
                'shipper' => $shipper,
                'consignee' => $consignee,
                'updated_date' => date('Y-m-d H:i:s')
            );

            // Memanggil model untuk menyimpan data
            $this->load->model('M_flowCargoes');
            $insertResult = $this->M_flowCargoes->insert_flowCargoes($dataToInsert);

            $formData = array(
                "formData" => array(
                    array(
                        "shipmentNumber" => $shipmentNumber,
                        "bookingNumber" => $bookingNumber,
                        "shipper" => $shipper,
                        "consignee" => $consignee
                    )
                )
            );
            $getShipment = $this->curlPut("updateShipments", $formData);
    
            if ($getShipment !== null) {
                echo $this->httpResponseCode(200, "OK", $getShipment);
            } else {
                echo $this->httpResponseCode(404, "Not Found");
            }
        } else {
            echo $this->httpResponseCode(400, "Bad Request");
        }
    }

    function getDataByParamAjax(){

        $param = $this->input->get();

        $shipmentType = $param['shipmentType'];
        $shipmentStatus = $param['shipmentStatus'];
        $containerNumber = $param['containerNumber'];
        $limit = $param['limit'];

        // ini untuk get shipment
        // $getShipment = $this->curlGet("shipments?shipmentType=$shipmentType&_page=1&_limit=$limit");
        $getShipment = $this->curlGet("shipments?shipmentType=$shipmentType&status=$shipmentStatus&containerNumber=$containerNumber&_page=1&_limit=$limit");


        if (empty($getShipment)) {
            echo $this->httpResponseCode(404, "Not Found");
            return;
        }
    
        echo $this->httpResponseCode(200, "OK", $getShipment);

    }

    function getCarrierList(){
        $getShipment = $this->curlGet("carrierList");
        if (empty($getShipment)) {
            echo $this->httpResponseCode(404, "Not Found");
            return;
        }
    
        echo $this->httpResponseCode(200, "OK", $getShipment);
        // var_dump($getShipment);
    }

    function getDataByShipId()
    {
        $containerNumber = $this->input->get('id');
        $shipmentType = $this->input->get('shipmentType');
        $shipmentStatus = $this->input->get('shipmentStatus');

        // echo $this->httpResponseCode(200, "OK", "Test");
        // die;
        // ini untuk pengambilan by shipment type saja
        // $getShipment = $this->curlGet("shipments?shipmentType=$shipmentType&_page=1&_limit=1000");
        $getShipment = $this->curlGet("shipments?shipmentType=$shipmentType&containerNumber=$containerNumber&status=$shipmentStatus&_page=1&_limit=1000");
        

      
        $foundShipment = null;

        foreach ($getShipment as $shipment) {
            if ($shipment->containerNumber == $containerNumber) {
                $foundShipment = $shipment;
                break;
            }
        }
        
        echo json_encode($foundShipment);
        die;
        if ($foundShipment !== null) {
            echo $this->httpResponseCode(200, "OK", $foundShipment);
        } else {
            echo $this->httpResponseCode(404, "Not Found");
        }
        


    }

}
