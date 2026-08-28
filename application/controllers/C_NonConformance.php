<?php 
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

defined('BASEPATH') or exit('No direct script access allowed');

class C_NonConformance extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    if (!$this->session->userdata('userid_1')) {
      redirect('login');
    }

    $this->load->model("Nonconformance_model", "Container");
  }

  function index()
  {
    $this->template->display('shipping/mon/non_conformance_verifikasi');
  }

  public function getShipmentByContNumber()
  {
    $param = $this->input->get();
    $containerByParam = $this->Container->getAllShipmentDetailByParam($param);
    $containerDetail = $this->Container->getShipByContid($containerByParam[0]->contid, $containerByParam[0]->container);

    $data = [
      'listContainer' => $containerByParam[0],
      'containerDetail' => $containerDetail
    ];

    echo $this->httpResponseCode(200, $data);
  }


  public function getAllByParam()
  {

    $param = $this->input->get();
    $data = $this->Container->getContainerConformance($param);
    

    // var_dump($param['shipment_date']);
    // $data['listOfFactoryAccess'] = $this->Factory->getFactoryAccess($this->groupId);

    // echo json_encode($param);
    // die;

    echo $this->httpResponseCode(200, "OK", $data);
  }

  // function store()
  // {
  //   // Get POST data
  //   $param = $this->input->post();

  //   // echo json_encode($param);
  //   // die;

  //   // Validate the required parameters before proceeding
  //   if (!isset($param['cont_detailid'], $param['conformance_id'], $param['zhl_remarks'])) {
  //     echo $this->httpResponseCode(400, "Missing required parameters");
  //     return;
  //   }

  //   // Perform the verification process
  //   $verifikasi = $this->Container->verifikasi($param);

  //   // Check the verification result
  //   if ($verifikasi) {
  //     echo $this->httpResponseCode(200, "Verification Successful");
  //   } else {
  //     // Handle the verification failure gracefully
  //     log_message('error', 'Verification failed: ' . json_encode($param));
  //     echo $this->httpResponseCode(500, "Verification Failed");
  //   }
  // }

  function store()
  {
      // Get POST data
      try{
          $param = $this->input->post();
          // var_dump($param);
          // die;
          // Validate the required parameters before proceeding
          if (!isset($param['cont_detailid'], $param['conformance_id'], $param['zhl_remarks'])) {
              echo $this->httpResponseCode(400, "Missing required parameters");
              return;
          }
//           0
// 3
// 4
// 2
// 1
// 0
// 3
  
          // Perform the verification process
          // $verifikasi = $this->Container->verifikasi($param);

          // $conformance_id = isset($param['conformance_id']) ? $param['conformance_id'] : '';
          // $container_number = $this->Container->getContainerNumberInfo($conformance_id);
          // $factory = $container_number[0];
          // if($factory->factory_abbr == "RSUP"){
          //   $isSent = 3;
          // }else{
          //   $isSent = 4;
          // }
          $verifikasi = $this->Container->verifikasi($param);
          $conformance_id = array_filter(array_map('trim', explode(',', $param['conformance_id'])));
          $container_number = $this->Container->getContainerNumberInfo($conformance_id);
          
          $containers = [];
          $factories = [];

          foreach ($container_number as $row) {
            $containers[] = $row->container_number;
            $factories[] = $row->factory_abbr;
          }
          $container_string = implode("\n", $containers);
          $unique_factory = array_unique($factories);
          $factory = $unique_factory[0];
          if ($factory == "RSUP") {
              $isSent = 3;
          } else {
              $isSent = 4;
          }

          $emails = $this->Container->getEmailsByConformanceId($isSent);
  
          // var_dump($container_number);
          // die;
          // Check the verification result
          if ($verifikasi) {
              $mail = new PHPMailer(true);
              try {
                  $mail->isSMTP();
                  $mail->Host = 'smtp.gmail.com';
                  $mail->SMTPAuth = true;
                  $mail->Username = 'notifyremindersambugroup@gmail.com';
                  $mail->Password = 'ifac psdu uhip tlvw';
                  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                  $mail->Port = 587;

                  $mail->setFrom('notifyremindersambugroup@gmail.com', 'Notify Container Issue Sambu Group');
                  $emailReceiver = [];
                  // $mail->addAddress('testingSambu@gmail.com', 'Sistem Pakar');
                  foreach ($emails as $email) {
                    $mail->addAddress($email->emailAddress, $email->username);
                    $emailReceiver[] = $email->emailAddress;
                  }
                  $emailReceiverString = implode(',', $emailReceiver);
                  
                  $mail->isHTML(true);
                  $mail->Subject = 'Reminder On Container Issue';
                  $mailBody = '<html>
                  <head>
                    <style>
                      body {
                        font-family: "Arial", sans-serif;
                        font-size: 12px;
                        line-height: 1.6;
                        color: #333;
                      }

                      h1 {
                        font-size: 14px;
                        font-family: "Arial", sans-serif;
                        color: #333;
                        font-weight: normal;
                      }

                      p {
                        font-size: 12px;
                        font-family: "Arial", sans-serif;
                        color: #333;
                        font-weight: normal;
                      }

                      table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px; 
                      }

                      th, td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: left;
                      }

                      th {
                        background-color: #f2f2f2;
                      }

                      a {
                        color: #007bff;
                        text-decoration: none;
                      }

                      a:hover {
                        text-decoration: underline;
                      }

                      .container_num {
                        color : red;
                      }

                      .verification_qad {
                        background-color: #30419b;
                        padding: 2px 4px;
                        border-radius: 4px;
                        display: inline-block;
                        font-weight: bold;
                        color: #ffffff;
                      }

                      .verification_finish{
                        background-color: #02c58d;
                        padding: 2px 4px;
                        border-radius: 4px;
                        display: inline-block;
                        font-weight: bold;
                        color: #ffffff;
                      }
                    </style>
                  </head>
                  <body>';
                      if($factory == "RSUP"){
                          $mailBody .= '<h1>Dear Team <b>PT Riau Sakti United Plantations</b></h1>';
                      }else{
                          $mailBody .= '<h1>Dear Team <b>PT Pulau Sambu (Guntung)</b></h1>';
                      }
                      $mailBody .= '<p>We would like to inform you that the container numbers below have issues and require immediate attention.</p>
                          <table>
                              <thead>
                                  <tr>
                                      <th>Container Number</th>
                                      <th>Factory</th>
                                      <th>Complete Date</th>
                                      <th>Status</th>
                                      <th>Issues</th>
                                      <th>Remarks By ZHL</th>
                                      <th>Action Now</th>
                                  </tr>
                              </thead>
                              <tbody>';
                              foreach($container_number as $container) {
                                  $originalDate = $container->created_date;
                                  $timestamp = strtotime($originalDate);
                                  $formattedDate = date('d F Y', $timestamp);
                                  $issues = explode(', ', $container->issue);
          
                                  $mailBody .= '<tr>';
                                  $mailBody .= '<td class="container_num"><b>' . htmlspecialchars($container->container_number) . '</b></td>';
                                  if($factory == "RSUP"){
                                      $mailBody .= '<td>PT Riau Sakti United Plantations</td>';
                                  }else{
                                      $mailBody .= '<td>PT Pulau Sambu (Guntung)</td>';
                                  }
                                  $mailBody .= '<td>' . htmlspecialchars($formattedDate) . '</td>';
                                  $mailBody .= '<td>' . htmlspecialchars($container->status) . '</td>';
                                  $mailBody .= '<td><ul>'; 
                                  foreach ($issues as $issue) {
                                      $mailBody .= '<li>' . htmlspecialchars($issue) . '</li>';
                                  }
                                  $mailBody .= '</ul></td>';
                                  $mailBody .= '<td>' . htmlspecialchars($container->zhl_remarks) . '</td>';
                                  if($container->status == "Info Only"){
                                      $mailBody .= '<td><p class="verification_finish">&#x2714; Finish<p></td>';
                                  }else{
                                      $mailBody .= '<td><p class="verification_qad">&#x1F551; Waiting For QAD Verification<p></td>';
                                  }
                                  $mailBody .= '</tr>';
                              }

                      $mailBody .= '</tbody>
                          </table>
  
                          <p>Please follow up promptly in the Container Check System of <b>Krodec Container</b> using the following link: <a href="https://sambu.krodec.com/container">Container Management</a>.</p>
                          <p>Thank you for your attention and cooperation.</p>
  
                          <br><br>
                          
                          <p>Best Regards,</p>
                          <p>Zhenghe Logistic Pte Ltd</p>
                          </body>
                      </html>';

                      $mail->Body = $mailBody;
                      $mail->send();
                      $code = $this->httpResponseCode(200, "Verification Successful and email sent");
                      $decode = json_decode($code, true);
                      echo $code;
                      // echo $this->httpResponseCode(200, "Verification Successful and email sent");
                      $container_num = $container->container_number;
                      $current_date = date('Y-m-d H:i:s');
                      $statusCode = $decode['code'];
                      $message = $decode['message'];
                      $data = [
                          'emailReceiver' => $emailReceiverString, 
                          'containerName' => $container_num, 
                          'dateSent' => $current_date, 
                          'statusCode' => $statusCode, 
                          'message' => $message
                      ];

                      $this->Container->logSendSuccess($data);
              }catch(Exception $e){
                  echo $this->httpResponseCode(200, "Verification Successful but email could not be sent. Mailer Error: {$mail->ErrorInfo}");
              }
          } else {
              // Handle the verification failure gracefully
              log_message('error', 'Verification failed: ' . json_encode($param));
              echo $this->httpResponseCode(500, "Verification Failed");
          }
      }catch (\Throwable $th) {
          echo json_encode($th->getMessage());
      }
  }

  // public function uploadLoi()
  // {
  //   $param = $this->input->post();

  //   $config['upload_path'] = '../container/assets/images/loi_file/';
  //   $config['allowed_types'] = 'gif|jpg|png|jpeg';
  //   $config['encrypt_name'] = TRUE;
  //   // $config['max_size'] = 100; 

  //   $this->load->library('upload', $config);

  //   if (!$this->upload->do_upload('file')) {
  //     echo json_encode([
  //       'code'    => 500,
  //       'message' => strip_tags($this->upload->display_errors())
  //     ]);
  //     exit;
  //   } else {
  //     $data = array('upload_data' => $this->upload->data());

  //     $this->db->where('id', $param['conformance_id']);
  //     $this->db->update('ship_tbl_trn_cont_non_conformance', ['loi_file' => $data['upload_data']['file_name']]);

  //     echo json_encode([
  //       'code'    => 200,
  //       'message' => 'Success Upload LOI',
  //       'file'    => $data['upload_data']['file_name']
  //     ]);
  //     exit;
  //   }
  // }

  public function uploadLoi()
  {
      $param = $this->input->post();

      $config['upload_path'] = '../container/assets/images/loi_file/';
      $config['allowed_types'] = 'gif|jpg|png|jpeg';
      $config['encrypt_name'] = TRUE;

      $this->load->library('upload', $config);

      if (!$this->upload->do_upload('file')) {

          $this->session->set_flashdata('alert', [
              'type' => 'error',
              'message' => strip_tags($this->upload->display_errors())
          ]);

      } else {

          $data = $this->upload->data();
          $ids = explode(',', $param['conformance_ids']);
          foreach ($ids as $id) {
              $this->db->where('id', trim($id));
              $this->db->update('ship_tbl_trn_cont_non_conformance', [
                  'loi_file' => $data['file_name']
              ]);
          }

          $this->session->set_flashdata('alert', [
              'type' => 'success',
              'message' => 'Success Upload LOI'
          ]);
      }

      redirect($_SERVER['HTTP_REFERER']); 
  }
}
