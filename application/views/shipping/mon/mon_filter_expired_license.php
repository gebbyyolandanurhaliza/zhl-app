<?php 
$no=1;
$currentDate = new DateTime(); //2024-08-08
$currentMonthYear = $currentDate->format('n-Y');
$oneMonthLater = (new DateTime())->modify('+1 month')->format('n-Y');

foreach ($license as $licen){

    echo '<tr  onclick="clickdb(this);" style="cursor: pointer;">';
        echo '<td nowrap>'.$no++.'</td>';

        echo '<td nowrap>'.$licen->vehicle_no.'</td>';
        echo '<td nowrap>'.$licen->vehicle_type.'</td>';
        echo '<td nowrap>'.$licen->description.'</td>';
        if (!empty($licen->coe_expiry_date) && $licen->coe_expiry_date !== "1970-01-01") {
            $expiryDate = new DateTime($licen->coe_expiry_date);
            $expiryMonth = (int)$expiryDate->format('n-Y');
            $expiryDateCoe = $expiryDate->format("d F Y");

            if ($expiryMonth <= $oneMonthLater && $expiryMonth >= $currentMonthYear && $expiryDate > $currentDate) {
                echo '<td nowrap style="color: red;">' . $expiryDateCoe . '</td>';
            }elseif($expiryDate <= $currentDate){
                echo '<td nowrap>' . $expiryDateCoe . '<span style="color: red; font-weight: bold;"> (Expired) </span>' . '</td>';
            }else {
                echo '<td nowrap>' . $expiryDateCoe . '</td>';
            }
        } else {
            echo '<td nowrap>Insert date first</td>';
        }

        if (!empty($licen->lifespan_expiry_date) && $licen->lifespan_expiry_date !== "1970-01-01") {
            $lifespanDate = new DateTime($licen->lifespan_expiry_date);
            $lifespanMonth = (int)$lifespanDate->format('n-Y');
            $expiryDatelifespan = $lifespanDate->format("d F Y");

            if ($lifespanMonth <= $oneMonthLater && $lifespanMonth >= $currentMonthYear && $lifespanDate > $currentDate) {
                echo '<td nowrap style="color: red;">' . $expiryDatelifespan . '</td>';
            }elseif($lifespanDate <= $currentDate){
                echo '<td nowrap>' . $expiryDatelifespan . '<span style="color: red; font-weight: bold;"> (Expired) </span>' . '</td>';
            }else {
                echo '<td nowrap>' . $expiryDatelifespan . '</td>';
            }
        }else{
            echo '<td nowrap>Insert date first</td>';
        }

        if (!empty($licen->vehicle_inspection_due_date) && $licen->vehicle_inspection_due_date !== "1970-01-01") {
            // ini untuk tampil tanggal biasa saja
            // echo '<td nowrap>'. date_format(date_create($licen->vehicle_inspection_due_date), "d F Y") .'</td>';

            $inspectionDate = new DateTime($licen->vehicle_inspection_due_date);
            $inspectionMonth = (int)$inspectionDate->format('n-Y');
            $expiryDateinspection = $inspectionDate->format("d F Y");

            if ($inspectionMonth <= $oneMonthLater && $inspectionMonth >= $currentMonthYear && $inspectionDate > $currentDate) {
                echo '<td nowrap style="color: red;">' . $expiryDateinspection . '</td>';
            }elseif($inspectionDate <= $currentDate){
                echo '<td nowrap>' . $expiryDateinspection . '<span style="color: red; font-weight: bold;"> (Expired) </span>' . '</td>';
            }else {
                echo '<td nowrap>' . $expiryDateinspection . '</td>';
            }
        }else{
            echo '<td nowrap>Insert date first</td>';
        }

        if (!empty($licen->road_tax_expiry_date) && $licen->road_tax_expiry_date !== "1970-01-01") {
            $roadtaxDate = new DateTime($licen->road_tax_expiry_date);
            $roadtaxMonth = (int)$roadtaxDate->format('n-Y');
            $expiryDateRoadtax = $roadtaxDate->format("d F Y");

            if ($roadtaxMonth <= $oneMonthLater && $roadtaxMonth >= $currentMonthYear && $roadtaxDate > $currentDate) {
                echo '<td nowrap style="color: red;">' . $expiryDateRoadtax . '</td>';
            }elseif($roadtaxDate <= $currentDate){
                echo '<td nowrap>' . $expiryDateRoadtax . '<span style="color: red; font-weight: bold;"> (Expired) </span>' . '</td>';
            }else {
                echo '<td nowrap>' . $expiryDateRoadtax . '</td>';
            }
        }else{
            echo '<td nowrap>Insert date first</td>';
        }

        if (!empty($licen->vpc_end_date) && $licen->vpc_end_date !== "1970-01-01 00:00:00") {
            $vpcDate = new DateTime($licen->vpc_end_date);
            $vpcMonth = (int)$vpcDate->format('n-Y');
            $expiryDateVpc = $vpcDate->format("d F Y");
        
            if ($vpcMonth <= $oneMonthLater && $vpcMonth >= $currentMonthYear && $vpcDate > $currentDate) {
                echo '<td nowrap style="color: red;">' . $expiryDateVpc . '</td>';
            } elseif ($vpcDate <= $currentDate) {
                echo '<td nowrap>' . $expiryDateVpc . '<span style="color: red; font-weight: bold;"> (Expired) </span>' . '</td>';
            } else {
                echo '<td nowrap>' . $expiryDateVpc . '</td>';
            }
        } else {
            echo '<td nowrap>Insert date first</td>';
        }

        if (!empty($licen->period_insurance_end) && $licen->period_insurance_end !== "1970-01-01") {
            $insuranceDate = new DateTime($licen->period_insurance_end);
            $insuranceMonth = (int)$insuranceDate->format('n-Y');
            $expiryDateInsurance = $insuranceDate->format("d F Y");

            if ($insuranceMonth <= $oneMonthLater && $insuranceMonth >= $currentMonthYear && $insuranceDate > $currentDate) {
                echo '<td nowrap style="color: red;">' . $expiryDateInsurance . '</td>';
            }elseif($insuranceDate <= $currentDate){
                echo '<td nowrap>' . $expiryDateInsurance . '<span style="color: red; font-weight: bold;"> (Expired) </span>' . '</td>';
            }else {
                echo '<td nowrap>' . $expiryDateInsurance . '</td>';
            }
        }else{
            echo '<td nowrap>Insert date first</td>';
        }
        // echo '<pre>' . print_r($insuranceDate) . '</pre>';
    echo '</tr>';
}?>