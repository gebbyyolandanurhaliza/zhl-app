<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Bl_code_ZHT extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('M_Bl_code_ZHT'));

        if (!$this->session->userdata('userid_1')) {
            redirect('login');
        }
    }

    function index() {
        $company_id = $this->session->userdata('company_id');
        $data['jenis_trans'] = $this->M_Bl_code_ZHT->get_jenis_trans();
        $data['jenis_coa'] = $this->M_Bl_code_ZHT->get_coa($company_id);
        $this->template->display('accounting/vcdn/Bl_code_ZHT', $data);
       
    }
public function search()
{
    $dari = $this->input->get('dari');
    $sampai = $this->input->get('sampai');

    // var_dump('GET dari:', $dari);
    // var_dump('GET sampai:', $sampai);

    $data['_tampil_item'] = $this->M_Bl_code_ZHT->hasil($dari, $sampai);

    // var_dump($data['_tampil_item']);
    // exit; 

    $this->template->display('accounting/vcdn/Bl_code_ZHT', $data);
}




// public function print_report()
// {
//     $dari   = $this->input->get('dari');
//     $sampai = $this->input->get('sampai');

//     // pastikan format tanggal jadi Y-m-d
//     $dari_fmt   = date('Y-m-d', strtotime($dari));
//     $sampai_fmt = date('Y-m-d', strtotime($sampai));

//     // ambil data dari model
//     $result = $this->M_Bl_code_ZHT->hasil($dari_fmt, $sampai_fmt);

//     if (empty($result)) {
//         echo "<h3>Tidak ada data pada periode $dari s/d $sampai</h3>";
//         exit;
//     }

//     // buat tampilan HTML untuk print
//     echo "<html>
//     <head>
//         <title>Report ZHT</title>
//         <style>
//             body { font-family: Arial, sans-serif; font-size: 12px; }
//             h2 { text-align: center; }
//             table { border-collapse: collapse; width: 100%; margin-top: 20px; }
//             th, td { border: 1px solid #000; padding: 6px; text-align: left; }
//             th { background: #f2f2f2; }
//         </style>
//     </head>
//     <body>
//         <h2>Report ZHT ($dari s/d $sampai)</h2>
//         <table>
//             <thead>
//                 <tr>
//                     <th>No</th>
//                     <th>Container</th>
//                     <th>Tanggal</th>
//                     <th>No Faktur</th>
//                     <th>No Reff</th>
//                     <th>Debit</th>
//                     <th>Balance</th>
//                 </tr>
//             </thead>
//             <tbody>";

//     $no = 1;
//     foreach ($result as $row) {
//         $container   = isset($row->containerNo) ? $row->containerNo : '-';
//         $tanggal     = isset($row->tanggal) && !empty($row->tanggal) ? $row->tanggal : (isset($row->created_date) ? $row->created_date : '-');
//         $nofaktur    = isset($row->nofaktur) ? $row->nofaktur : '-';
//         $no_reff     = isset($row->no_reff) ? $row->no_reff : '-';
//         $debit       = isset($row->debit) ? number_format($row->debit, 2) : '0.00';
//         $balance     = isset($row->balance) ? number_format($row->balance, 2) : '0.00';

//         echo "<tr>
//                 <td>{$no}</td>
//                 <td>{$container}</td>
//                 <td>{$tanggal}</td>
//                 <td>{$nofaktur}</td>
//                 <td>{$no_reff}</td>
//                 <td>{$debit}</td>
//                 <td>{$balance}</td>
//               </tr>";
//         $no++;
//     }

//     echo "   </tbody>
//         </table>
//         <script>
//             window.print();
//         </script>
//     </body>
//     </html>";

//     exit;
// }

public function print_report() {
    $dari   = $this->input->get('dari');   // format dd-mm-yyyy
    $sampai = $this->input->get('sampai'); // format dd-mm-yyyy

    // convert ke format Y-m-d untuk query
    $start = DateTime::createFromFormat('d-m-Y', $dari)->format('Y-m-d');
    $end   = DateTime::createFromFormat('d-m-Y', $sampai)->format('Y-m-d');

    // ambil data dari model
    $data['_tampil_item'] = $this->M_Bl_code_ZHT->hasil_dua_tanggal($start, $end);

    if (empty($data['_tampil_item'])) {
        echo "<h3>Tidak ada data untuk periode $dari s/d $sampai</h3>";
        exit;
    }

    // kirim ke view PDF
    $data['dari'] = $dari;
    $data['sampai'] = $sampai;
    $this->load->view('accounting/rpt/rpt_bl_code_zht', $data);
}



}

?>