<?php

class PDF extends TFPDF
{
  public $namacustomer = null;
  public $paymentto = null;
  public $address      = null;
  public $tanggal      = null;
  public $shipmentdate = null;
  public $nofaktur     = null;
  public $term         = null;
  public $voyage       = null;
  public $etddate      = null;
  public $etadate      = null;
  public $destbarge    = null;
  public $jenis_inv    = null;
  public $rate_sgd     = null;
  public $gst          = null;
  public $currency     = null;

  function Header()
  {
    $this->SetX(10);
    $this->Cell(190, 25, '', 0, 0);
    $this->Image('assets/zhlkop.PNG', 11, 3, 200, 35);
    $this->Line(10, 35, 250 - 50, 35);
    $this->Ln();
    $this->SetX(10);
    $this->Cell(190, 243, '', 0, 0);
    $this->SetFont('Times', 'B', 20);
    $this->SetX(10);
    $this->Cell(0, 10, 'Tax Invoice', 0, 1, 'C');
    // if ($this->gst == 'GST') {
    //   $this->Cell(0, 10, 'TAX INVOICE', 0, 0, 'C');
    // } else {
    //   $this->Cell(0, 10, 'INVOICE', 0, 1, 'C');
    // }
    $this->Ln();
    $this->SetFont('Times', 'B', 10);
    $this->Cell(20, 5, 'To', 0, 0, 'L', 0);
    $this->Cell(2, 5, ':', 0, 0, 'L', 0);

    $this->SetFont('Times', '', 10);
    $this->Cell(80, 5, $this->namacustomer, 0, 0, 'L', 0);

    $this->SetFont('Times', 'B', 10);
    $this->Cell(28, 5, 'Date', 0, 0, 'R', 0);
    $this->Cell(2, 5, ':', 0, 0, 'L', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(40, 5, $this->tanggal, 0, 1, 'L', 0);

    $this->SetFont('Times', 'B', 10);
    $this->Cell(20, 5, 'Address', 0, 0, 'L', 0);
    $this->Cell(2, 5, ':', 0, 0, 'L', 0);

    $this->SetFont('Times', '', 10);
    $this->MultiCell(45, 5, str_replace("<br />", "", $this->address), 0, 'L');

    $this->SetXY(120, 60);
    $this->SetFont('Times', 'B', 10);
    $this->Cell(20, -15, 'Invoice No.', 0, 0, 'R', 0);
    $this->Cell(2, -15, ':', 0, 0, 'L', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(40, -15, $this->nofaktur, 0, 1, 'L', 0);

    $this->SetXY(120, 70);
    $this->SetFont('Times', 'B', 10);
    $this->Cell(20, -15, 'Invoice Type', 0, 0, 'R', 0);
    $this->Cell(2, -15, ':', 0, 0, 'L', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(3, -15, $this->jenis_inv, 0, 0, 'L', 0);

    $this->SetXY(120, 75);
    $this->SetFont('Times', 'B', 10);
    $this->Cell(20, -15, 'Payment Terms', 0, 0, 'R', 0);
    $this->Cell(2, -15, ':', 0, 0, 'L', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(3, -15, $this->term, 0, 0, 'L', 0);
    // $this->Cell(10, -15, ' days', 0, 1, 'L', 0);


    $this->SetXY(120, 70);
    $this->SetFont('Times', 'B', 10);
    $this->Cell(20, 5, 'Vessel/Voyage No.', 0, 0, 'R', 0);
    $this->Cell(2, 5, ':', 0, 0, 'L', 0);
    $this->SetFont('Times', '', 10);
    $this->MultiCell(60, 5, $this->voyage, 0, 'L');

    $y = $this->GetY();
    $this->SetXY(120, $y);
    $this->SetFont('Times', 'B', 10);
    $this->Cell(20, 5, 'Shipment Date', 0, 0, 'R', 0);
    $this->Cell(2, 5, ':', 0, 0, 'L', 0);
    $this->SetFont('Times', '', 10);
    $this->Cell(40, 5, $this->shipmentdate, 0, 1, 'L', 0);

    $this->ln(15);
    $this->SetFont('Times', 'B', 10);
    $this->Cell(10, 5, 'Items', 'BT', 0, 'C');
    $this->Cell(30, 5, 'Types', 'BT', 0, 'C');
    $this->Cell(20, 5, 'POD', 'BT', 0, 'C');
    $this->Cell(60, 5, 'Description', 'BT', 0, 'C');
    $this->Cell(20, 5, 'Quantity', 'BT', 0, 'R');
    $this->Cell(25, 5, 'Unit Price', 'BT', 0, 'R');
    $this->Cell(27, 5, 'Amount ' . '(' . $this->currency . ')', 'BT', 0, 'R');
    $this->ln(5);
  }


  function NbLines($w, $txt)
  {
    //Computes the number of lines a MultiCell of width w will take
    $cw = &$this->CurrentFont['cw'];
    if ($w == 0) {
      $w = $this->w - $this->rMargin - $this->x;
    }
    $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
    $s = str_replace("\r", '', $txt);
    $nb = strlen($s);
    if ($nb > 0 and $s[$nb - 1] == "\n") {
      $nb--;
    }
    $sep = -1;
    $i = 0;
    $j = 0;
    $l = 0;
    $nl = 1;
    while ($i < $nb) {
      $c = $s[$i];
      if ($c == "\n") {
        $i++;
        $sep = -1;
        $j = $i;
        $l = 0;
        $nl++;
        continue;
      }
      if ($c == ' ') {
        $sep = $i;
      }
      $l += $cw[$c];
      if ($l > $wmax) {
        if ($sep == -1) {
          if ($i == $j) {
            $i++;
          }
        } else {
          $i = $sep + 1;
        }
        $sep = -1;
        $j = $i;
        $l = 0;
        $nl++;
      } else {
        $i++;
      }
    }
    return $nl;
  }

  function Footer()
  {
    if($this->paymentto ==''){

      $sig = $_GET['signature'];
      if ($this->GetY() > 235) {
        $this->AddPage();
      }
      // $this->SetY(-50);
      $this->setFont('Arial', 'B', 8);
      $this->setFillColor(255, 255, 255);
      $this->Cell(90, 5, 'Bank Details :', 0, 0, 'L');
      $this->setFont('Arial', 'B', 10);
      $this->Cell(100, 5, 'ZHENGHE LOGISTICS PTE LTD', 0, 1, 'R');
      $this->setFont('Arial', 'i', 8);
      $this->Cell(10, 5, 'UNITED OVERSEAS BANK LIMITED', 0, 1, 'l');
      $this->Cell(10, 5, 'UOB MAIN BRANCH', 0, 1, 'l');
      $this->Cell(10, 5, 'Swift Code : UOVBSGSG', 0, 1, 'l');
      $this->Cell(10, 5, 'SGD Acct No. 357-309-956-5', 0, 1, 'l');
      $this->Cell(135, 5, 'USD Acct No. 357-907-139-5', 0, 0, 'L');
      $this->Line(145, $this->GetY(), 250 - 50, $this->GetY());
      $this->setFont('Arial', 'B', 11);
      $this->Cell(70, 5, $sig, 0, 1, 'L');
      $this->setFont('Arial', 'I', 7);
      $this->multicell(128, 5, 'All business transactions are in accordance with the Singapore Logistics Association (SLA) Standard Trading Condition, copy is available upon request.', 0, 1, 'L');
    }else{
        $sig = $_GET['signature'];
        if ($this->GetY() > 235) {
          $this->AddPage();
        }
        $this->setFont('Arial', 'B', 8);
        $this->setFillColor(255, 255, 255);
        $this->Cell(90, 5, 'Bank Details :', 0, 0, 'L');
        $this->setFont('Arial', 'B', 10);
        $this->Cell(100, 5, 'ZHENGHE LOGISTICS PTE LTD', 0, 1, 'R'); 
        $this->setFont('Arial', 'i', 8);
        $this->Cell(24, 5, 'Bank Name ', 0, 0, 'l');
        $this->Cell(5, 5, ': ' . $this->_bankName, 0, 1, 'L'); 
        $this->Cell(26, 5, 'Bank Account No. :  ', 0, 0, 'L');
        $this->Cell(5, 5, $this->_bankAccount1 . ' (' . $this->_bankCurrency . ')', 0, 1, 'L'); 
        $this->Cell(26, 5, '', 0, 0, 'L');
        $this->Cell(5, 5, $this->_bankAccount2 . ' (' . $this->_bankCurrency2 . ')', 0, 1, 'L');
        $this->Cell(22, 5, 'Swift Code ', 0, 0, 'l');
        $this->Cell(115, 5, ' : ' . $this->_bankSwift , 0, 0, 'L');
        
        $this->Line(145, $this->GetY(), 250 - 50, $this->GetY());
        $this->setFont('Arial', 'B', 11);
        $this->Cell(70, 5,  $sig, 0, 1, 'L');
        $this->setFont('', 'I', 7);
        $this->multicell(120, 5, 'All business transactions are in accordance with the Singapore Logistics Association (SLA) Standard Trading Condition, copy is available upon request.', 0, 1, 'L');
    }

    if ($this->prepared_by <> ''){
        $this->SetY(270);
        $this->setFont('Arial', 'i', 8);
        $this->Cell(190, 5, 'Prepared By : ' . ucwords(strtolower($this->prepared_by)), 0, 1, 'R');
    }
  }
}

$pdf = new PDF('P', 'mm', 'A4');

if ($get_data_header) {
  foreach ($get_data_header as $r) {
    $rate_sgd     = $r->rate_sgd;
    $namacustomer = $r->namacustomer;
    $address      = $r->address;
    $tanggal      = date("d F Y",  strtotime($r->tanggal));
    $nofaktur     = $r->nofaktur;
    $paymentto    = $r->paymentto;

    $prepared_by = $r->prepared_by;
    if ($r->term == '0') {
      $term_val = 'COD';
    } else {
      $term_val = $r->term . ' days';
    }
    $term = $term_val;

    $voyage       = $r->voyage;
    $currency     = $r->currency;

    if ($r->shipmentdate == '1970-01-01') {
      $shipmentdate = '';
    } else {
      $shipmentdate =  date("d F Y",  strtotime($r->shipmentdate));
    }
    if ($r->etddate == '1970-01-01') {
      $etddate = '';
    } else {
      $etddate = date("d F Y",  strtotime($r->etddate));
    }
    if ($r->etadate == '1970-01-01') {
      $etadate = '';
    } else {
      $etadate = date("d F Y",  strtotime($r->etadate));
    }

    if ($r->jenis_inv == 'bar') {
      $jenis_inv = 'Barge Charges';
    } elseif ($r->jenis_inv == 'fre') {
      $jenis_inv = 'Freight Charges';
    } elseif ($r->jenis_inv == 'trn') {
      $jenis_inv = 'Transport Charges';
    } elseif ($r->jenis_inv == 'imp') {
      $jenis_inv = 'Import Charges';
    } elseif ($r->jenis_inv == 'eim') {
      $jenis_inv = 'Empty Import';
    } elseif ($r->jenis_inv == 'lem') {
      $jenis_inv = 'Local Empty';
    } elseif ($r->jenis_inv == 'bargefreight') {
      $jenis_inv = 'Other';
    }

    if ($r->destbarge == 'idn') {
      $destbarge = 'Indonesia (PSG) To Singapore';
    } elseif ($r->destbarge == 'idn2') {
      $destbarge = 'Indonesia (RSUP) To Singapore';
    } elseif ($r->destbarge == 'sin') {
      $destbarge = 'Singapore To Indonesia (PSG)';
    } elseif ($r->destbarge == 'sin2') {
      $destbarge = 'Singapore To Indonesia (RSUP)';
    } else {
      $destbarge = '';
    }
  }

  $pdf->namacustomer = $namacustomer;
  $pdf->paymentto    = $paymentto;
  $pdf->address      = $address;
  $pdf->tanggal      = $tanggal;
  $pdf->shipmentdate = $shipmentdate;
  $pdf->nofaktur     = $nofaktur;
  $pdf->term         = $term;

  $pdf->voyage       = $voyage;
  $pdf->etddate      = $etddate;
  $pdf->etadate      = $etadate;
  $pdf->destbarge    = $destbarge;
  $pdf->jenis_inv    = $jenis_inv;
  $pdf->rate_sgd     = $rate_sgd;
  $pdf->currency     = $currency;
  $pdf->gst         = $gst_type;
  $pdf->prepared_by = $prepared_by;
}

if ($pdf->currency == 'SGD') {
  if ($total) {
    foreach ($total as $key) {
      $piutang = $key->JUMLAH * $key->rate_sgd;
    }
  } else {
    $piutang = 0;
  }
} else {
  if ($total) {
    foreach ($total as $key) {
      $piutang = $key->JUMLAH * $key->rate;
    }
  } else {
    $piutang = 0;
  }
}
 
$pdf->piutang  = $piutang;
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10); // Left, Top, Right margins
$pdf->setFont('Arial', '', 9);

/* if ($get_data_detail) {
    foreach ($get_data_detail as $l) {
        $no++;
        if ($pdf->GetY() > 235) {
            $pdf->AddPage();
        }
        $y = $pdf->GetY();

        $pdf->SetXY(10, $y);
        $pdf->MultiCell(50, 5, $l->ItemName, 0, 'L');
        $pdf->SetXY(20, $y);
        $pdf->MultiCell(90, 5, $l->description, 0, 'L');
        $pdf->Ln();
        $max = $pdf->NbLines(80, $l->description);
        $y8 = $pdf->GetY();

        $pdf->SetXY(130, $y + $max);
        $pdf->MultiCell(33, 5, $l->unit, 0, 'C');
        $pdf->ln();

        $pdf->SetXY(145, $y + $max);
        $pdf->MultiCell(30, 5, number_format($l->price, 2), 0, 'R');
        $pdf->ln();

        $pdf->SetXY(182, $y + $max);

        if ($pdf->currency == 'SGD') {
            $pdf->MultiCell(20, 5, number_format($l->price * $l->unit * $l->rate_sgd, 2), 0, 'R');
        } else {
            $pdf->MultiCell(20, 5, number_format($l->price * $l->unit * $l->rate, 2), 0, 'R');
        }

        $pdf->ln();
        $totalgst += $l->gst_value;
    }
} else {
    if ($pdf->GetY() > 235) {
        $pdf->AddPage();
    }
    $y = $pdf->GetY();
    $pdf->SetXY(10, $y);
    $pdf->MultiCell(50, 5, $no . ' ' . '', 0, 'L');
    $pdf->SetXY(60, $y);
    $pdf->MultiCell(90, 5, '', 0, 'L');
    $pdf->Ln();
    $max = $pdf->NbLines(80, '');
    $y8 = $pdf->GetY();

    $pdf->SetXY(130, $y + $max);
    $pdf->MultiCell(33, 5, '', 0, 'C');
    $pdf->ln();

    $pdf->SetXY(145, $y + $max);
    $pdf->MultiCell(30, 5, number_format(0, 2), 0, 'R');
    $pdf->ln();

    $pdf->SetXY(182, $y + $max);
    $pdf->MultiCell(20, 5, number_format(0, 2), 0, 'R');
    $pdf->ln();
    $totalgst += "";
} */

foreach($get_currency as $curr){
  $_bankName = $curr->bank_name;
  $_bankSwift = $curr->bank_swift;
  $_bankAccount1 = $curr->bank_account_number;
  $_bankCurrency = $curr->bank_currency_id;
  $_bankAccount2 = $curr->bank_account_number_2;
  $_bankCurrency2 = $curr->bank_currency_id_2;


  $pdf->_bankName = $_bankName;
  $pdf->_bankSwift = $_bankSwift;
  $pdf->_bankAccount1 = $_bankAccount1;
  $pdf->_bankCurrency = $_bankCurrency;
  $pdf->_bankAccount2 = $_bankAccount2;
  $pdf->_bankCurrency2 = $_bankCurrency2;
}

//// kode lama pdf
// $totalgst = 0;
// $no = 0;
// if ($get_data_detail) {
//   $no = 1;
//   foreach ($get_data_detail as $l) {

//     if ($pdf->GetY() > 210) {
//       $pdf->AddPage();
//     }
//     $y = $pdf->GetY();

//     if ($l->head == '1') {
//       if ($l->unit != '0') {
//         $pdf->SetXY(10, $y);
//         $pdf->MultiCell(50, 5,  $no, 0, 'L');
//         $pdf->SetXY(27, $y);
//         $pdf->MultiCell(25, 5, $l->con_type_name, 0, 'L');
//         $pdf->SetXY(52, $y);
//         $pdf->MultiCell(40, 5, $l->pod, 0, 'L');
//         $pdf->SetXY(90, $y);
//         $pdf->MultiCell(53, 5, $l->uom . ' - ' . $l->description, 0, 'L');
//         $pdf->SetXY(143, $y);
//         $pdf->MultiCell(53, 5,  $l->unit, 0, 'L');
//         $pdf->SetXY(160, $y);
//         $pdf->MultiCell(15, 5, number_format($l->price, 2), 0, 'R');
//         $pdf->SetXY(175, $y);
//         if ($pdf->currency == 'SGD') {
//           $pdf->MultiCell(20, 5, number_format($l->price * $l->unit * $l->rate_sgd, 2), 0, 'R');
//         } else {
//           $pdf->MultiCell(20, 5, number_format($l->price * $l->unit * $l->rate, 2), 0, 'R');
//         }
//       } else {
//         $pdf->SetXY(10, $y);
//         $pdf->MultiCell(50, 5,  $no, 0, 'L');
//         $pdf->SetXY(27, $y);
//         $pdf->MultiCell(25, 5, $l->con_type_name, 0, 'L');
//         $pdf->SetXY(52, $y);
//         $pdf->MultiCell(40, 5, $l->pod, 0, 'L');
//         $pdf->SetXY(90, $y);
//         // $pdf->MultiCell(53, 5, '', 0, 'L');
//         // $pdf->SetXY(143, $y);
//         // $pdf->MultiCell(53, 5,  $l->unit, 0, 'L');
//         // $pdf->SetXY(160, $y);
//         // $pdf->MultiCell(15, 5, number_format($l->price, 2), 0, 'R');
//         // $pdf->SetXY(175, $y);
//         // if ($pdf->currency == 'SGD') {
//         //   $pdf->MultiCell(20, 5, number_format($l->price * $l->unit * $l->rate_sgd, 2), 0, 'R');
//         // } else {
//         //   $pdf->MultiCell(20, 5, number_format($l->price * $l->unit * $l->rate, 2), 0, 'R');
//         // }
//       }

//       $no++;
//     } else {
//       $pdf->SetXY(10, $y);
//       $pdf->MultiCell(50, 5, '', 0, 'L');
//       $pdf->SetXY(27, $y);
//       $pdf->MultiCell(25, 5, '', 0, 'L');
//       $pdf->SetXY(52, $y);
//       $pdf->MultiCell(53, 5, '', 0, 'L');
//       $pdf->SetXY(90, $y);
//       $pdf->MultiCell(53, 5, $l->uom . ' - ' . $l->description, 0, 'L');
//       $pdf->SetXY(143, $y);
//       $pdf->MultiCell(53, 5,  $l->unit, 0, 'L');
//       $pdf->SetXY(160, $y);
//       $pdf->MultiCell(15, 5, number_format($l->price, 2), 0, 'R');
//       $pdf->SetXY(175, $y);
//       if ($pdf->currency == 'SGD') {
//         $pdf->MultiCell(20, 5, number_format($l->price * $l->unit * $l->rate_sgd, 2), 0, 'R');
//       } else {
//         $pdf->MultiCell(20, 5, number_format($l->price * $l->unit * $l->rate, 2), 0, 'R');
//       }
//     }

//     $totalgst += $l->gst_value;

//     $pdf->ln();
//   }
// }


//  kode baru test
// $grouped_data = [];

// foreach ($get_data_detail as $row) {
//     if ($row->head == '1') {
//         $grouped_data[$row->con_type_name]['head'] = $row;
//     } else {
//         $grouped_data[$row->con_type_name]['detail'][] = $row;
//     }
// }

// $no = 1;
// $totalgst = 0;

// foreach ($grouped_data as $con_type_name => $group) {
//     $l = $group['head'];

//     if ($pdf->GetY() > 210) $pdf->AddPage();
//     $y = $pdf->GetY();

//     $pdf->SetXY(10, $y);
//     $pdf->MultiCell(50, 5, $no, 0, 'L');
//     $pdf->SetXY(27, $y);
//     $pdf->MultiCell(25, 5, $l->con_type_name, 0, 'L');
//     $pdf->SetXY(52, $y);
//     $pdf->MultiCell(40, 5, $l->pod, 0, 'L');
//     $pdf->SetXY(90, $y);
//     $pdf->MultiCell(53, 5, $l->uom . ' - ' . $l->description, 0, 'L');
//     $pdf->SetXY(143, $y);
//     $pdf->MultiCell(53, 5,  $l->unit, 0, 'L');
//     $pdf->SetXY(160, $y);
//     $pdf->MultiCell(15, 5, number_format($l->price, 2), 0, 'R');
//     $pdf->SetXY(175, $y);
//     $pdf->MultiCell(20, 5, number_format($pdf->currency == 'SGD' ? $l->price * $l->unit * $l->rate_sgd : $l->price * $l->unit * $l->rate, 2), 0, 'R');

//     $totalgst += $l->gst_value;
//     $pdf->ln();

//     if (!empty($group['detail'])) {
//         foreach ($group['detail'] as $d) {
//             if ($pdf->GetY() > 210) $pdf->AddPage();
//             $y = $pdf->GetY();

//             $pdf->SetXY(10, $y);
//             $pdf->MultiCell(50, 5, '', 0, 'L');
//             $pdf->SetXY(27, $y);
//             $pdf->MultiCell(25, 5, '', 0, 'L');
//             $pdf->SetXY(52, $y);
//             $pdf->MultiCell(53, 5, '', 0, 'L');
//             $pdf->SetXY(90, $y);
//             $pdf->MultiCell(53, 5, $d->uom . ' - ' . $d->description, 0, 'L');
//             $pdf->SetXY(143, $y);
//             $pdf->MultiCell(53, 5,  $d->unit, 0, 'L');
//             $pdf->SetXY(160, $y);
//             $pdf->MultiCell(15, 5, number_format($d->price, 2), 0, 'R');
//             $pdf->SetXY(175, $y);
//             $pdf->MultiCell(20, 5, number_format($pdf->currency == 'SGD' ? $d->price * $d->unit * $d->rate_sgd : $d->price * $d->unit * $d->rate, 2), 0, 'R');

//             $totalgst += $d->gst_value;
//             $pdf->ln();
//         }
//     }

//     $no++;
// }


/// kode gebby
$grouped = [];

foreach ($get_data_detail as $row) {

    // 🔥 split berdasarkan "40"
    $parts = explode('40', $row->description);

    // ambil bagian kiri (POD)
    $pod = trim($parts[0]);

    // fallback kalau kosong
    if ($pod == '') {
        $pod = 'UNKNOWN';
    }

    if (!isset($grouped[$pod])) {
        $grouped[$pod] = [];
    }

    $grouped[$pod][] = $row;
}

$totalgst = 0;

$no = 1;
$current_no = 1;

$last_type = '';
$last_item = '';


if ($get_data_detail) {
  $no = 1;
  foreach ($get_data_detail as $l) {

    if ($pdf->GetY() > 210) {
      $pdf->AddPage();
    }
    $y = $pdf->GetY();

    if ($l->head == '1') {
      if ($l->unit != '0') {
        $pdf->SetXY(10, $y);
        $pdf->MultiCell(50, 5,  $no, 0, 'L');
        $pdf->SetXY(27, $y);
        $pdf->MultiCell(25, 5, $l->con_type_name, 0, 'L');
        $pdf->SetXY(52, $y);
        $pdf->MultiCell(40, 5, $l->pod, 0, 'L');
        $pdf->SetXY(90, $y);
        $pdf->MultiCell(53, 5, $l->uom . ' - ' . $l->description, 0, 'L');
        $pdf->SetXY(143, $y);
        $pdf->MultiCell(53, 5,  $l->unit, 0, 'L');
        $pdf->SetXY(160, $y);
        $pdf->MultiCell(15, 5, number_format($l->price, 2), 0, 'R');
        $pdf->SetXY(175, $y);
        if ($pdf->currency == 'SGD') {
          $pdf->MultiCell(20, 5, number_format($l->price * $l->unit * $l->rate_sgd, 2), 0, 'R');
        } else {
          $pdf->MultiCell(20, 5, number_format($l->price * $l->unit * $l->rate, 2), 0, 'R');
        }
        $pdf->SetXY(175, $y + 3);
      } else {
        $pdf->SetXY(10, $y);
        $pdf->MultiCell(50, 5,  $no, 0, 'L');
        $pdf->SetXY(27, $y);
        $pdf->MultiCell(25, 5, $l->con_type_name, 0, 'L');
        $pdf->SetXY(52, $y);
        $pdf->MultiCell(40, 5, $l->pod, 0, 'L');
        $pdf->SetXY(90, $y);
      }

      $no++;
    } else {
      $pdf->SetXY(10, $y);
      $pdf->MultiCell(50, 5, '', 0, 'L');
      $pdf->SetXY(27, $y);
      $pdf->MultiCell(25, 5, '', 0, 'L');
      $pdf->SetXY(52, $y);
      $pdf->MultiCell(53, 5, '', 0, 'L');
      $pdf->SetXY(90, $y);
      $pdf->MultiCell(53, 5, $l->uom . ' - ' . $l->description, 0, 'L');
      $pdf->SetXY(143, $y);
      $pdf->MultiCell(53, 5,  $l->unit, 0, 'L');
      $pdf->SetXY(160, $y);
      $pdf->MultiCell(15, 5, number_format($l->price, 2), 0, 'R');
      $pdf->SetXY(175, $y);
      if ($pdf->currency == 'SGD') {
        $pdf->MultiCell(20, 5, number_format($l->price * $l->unit * $l->rate_sgd, 2), 0, 'R');
      } else {
        $pdf->MultiCell(20, 5, number_format($l->price * $l->unit * $l->rate, 2), 0, 'R');
      }
    }

    $totalgst += $l->gst_value;

    $pdf->ln();
  }
}

//end of kode gebby


if ($r->remarks != NULL || $r->remarks != '') {
  $pdf->MultiCell(20, 10, 'Remarks: ', 0, 'L');
  $pdf->MultiCell(200, 5, $r->remarks, 0, 'L');
}

$pdf->SetY(-80);
$pdf->Line(10, $pdf->GetY(), 250 - 50, $pdf->GetY());

if ($gst_type == 'GST') {


  $pdf->Line(10, $pdf->GetY(), 250 - 50, $pdf->GetY());

  $sumgst = $totalgst * $rate_sgd;
  $sumsgd = $piutang * $rate_sgd;
  $sumall = $sumgst + $sumsgd;

  $pdf->SetFont('Times', '', 8);

  $pdf->SetX(11);
  $pdf->Cell(36, 4, 'GST in ' . '(' . $pdf->currency . ')');
  $pdf->Cell(2, 4, ':');
  $pdf->Cell(36, 4, 'Exchange Rate @ ' . number_format($rate_sgd, 6), 0, 0, 'R');
  $pdf->SetFont('Times', '', 10);
  $pdf->SetX(120);
  $pdf->Cell(36, 4, 'Subtotal Amount ' . $pdf->currency);
  $pdf->Cell(2, 4, ':');
  $pdf->Cell(36, 4, number_format($piutang, 2), 0, 0, 'R');

  $pdf->Ln();
  $pdf->SetFont('Times', '', 8);
  $pdf->SetX(11);
  $pdf->Cell(36, 4, 'Total Before GST in ' . '(' . $pdf->currency . ')');
  $pdf->Cell(2, 4, ':');
  $pdf->Cell(36, 4, number_format($sumsgd, 2), 0, 0, 'R');
  $pdf->SetX(120);
  $pdf->SetFont('Times', '', 10);
  $pdf->Cell(36, 4, 'GST 9%');
  $pdf->Cell(2, 4, ':');
  $pdf->Cell(36, 4, number_format($totalgst, 2), 0, 0, 'R');

  $pdf->Ln();

  $pdf->SetX(11);
  $pdf->SetFont('Times', '', 8);
  $pdf->Cell(36, 4, 'GST Amount in ' . '(' . $pdf->currency . ')');
  $pdf->Cell(2, 4, ':');
  $pdf->Cell(36, 4, number_format($sumgst, 2), 0, 0, 'R');
  $pdf->SetX(120);
  $pdf->SetFont('Times', '', 10);
  $pdf->Cell(36, 4, 'Total Amount ' . '(' . $pdf->currency . ')');
  $pdf->Cell(2, 4, ':');
  $pdf->Cell(36, 4, number_format($piutang + $totalgst, 2), 0, 0, 'R');
  $pdf->Ln();

  $pdf->SetX(11);
  $pdf->SetFont('Times', '', 8);
  $pdf->Cell(36, 4, 'Total Amount to ' . '(' . $pdf->currency . ')');
  $pdf->Cell(2, 4, ':');
  $pdf->Cell(36, 4, number_format($sumall, 2), 0, 0, 'R');
  $pdf->Ln();
} else {
  $pdf->SetFont('Times', '', 10);
  $pdf->SetX(120);
  $pdf->Cell(36, 4, 'Subtotal Amount ' . '(' . $pdf->currency . ')');
  $pdf->Cell(2, 4, ':');
  $pdf->Cell(36, 4, number_format($piutang, 2), 0, 0, 'R');
  $pdf->Ln();
  $pdf->Line(10, $pdf->GetY(), 250 - 50, $pdf->GetY());
}


$pdf->Output();
