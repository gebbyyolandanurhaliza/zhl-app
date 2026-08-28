
<?php 

$no = 1;

foreach ($total as $r){
    
    $tot1 = ($r->jan1)+($r->feb1)+($r->mar1)+($r->apr1)+($r->mei1)+($r->jun1)+($r->jul1)+($r->ags1)+($r->sep1)+($r->okt1)+($r->nov1)+($r->dec1);
    $tot2 = ($r->jan2)+($r->feb2)+($r->mar2)+($r->apr2)+($r->mei2)+($r->jun2)+($r->jul2)+($r->ags2)+($r->sep2)+($r->okt2)+($r->nov2)+($r->dec2);
    $tot3 = ($r->jan3)+($r->feb3)+($r->mar3)+($r->apr3)+($r->mei3)+($r->jun3)+($r->jul3)+($r->ags3)+($r->sep3)+($r->okt3)+($r->nov3)+($r->dec3);
    $tot4 = ($r->jan4)+($r->feb4)+($r->mar4)+($r->apr4)+($r->mei4)+($r->jun4)+($r->jul4)+($r->ags4)+($r->sep4)+($r->okt4)+($r->nov4)+($r->dec4);
    $tot5 = ($r->jan5)+($r->feb5)+($r->mar5)+($r->apr5)+($r->mei5)+($r->jun5)+($r->jul5)+($r->ags5)+($r->sep5)+($r->okt5)+($r->nov5)+($r->dec5);
    $tot6 = ($r->jan6)+($r->feb6)+($r->mar6)+($r->apr6)+($r->mei6)+($r->jun6)+($r->jul6)+($r->ags6)+($r->sep6)+($r->okt6)+($r->nov6)+($r->dec6);



    echo '<tr style="cursor: pointer;">';

        if($r->urut==='1'){
                echo '<td nowrap>'.$no++.'</td>';
        }else{
                echo '<td nowrap></td>';    
        }


        if($r->urut==='1'){
                echo '<td nowrap>'.$r->shipping_liner.'</td>';
        }else{
                echo '<td nowrap></td>';    
        }


        if($r->urut==='1'){
                echo '<td nowrap align = "center"></td>';
        }else{
                echo '<td nowrap>'.$r->destination.'</td>';
        }


        echo '<td nowrap class="text-right">'.$tot1.'</td>';
        echo '<td nowrap class="text-right">'.$tot3.'</td>';
        echo '<td nowrap class="text-right">'.$tot2.'</td>';
        echo '<td nowrap class="text-right">'.$tot5.'</td>';
        echo '<td nowrap class="text-right">'.$tot4.'</td>';
        echo '<td nowrap class="text-right">'.$tot6.'</td>';
        echo '<td nowrap class="text-right">'.($r->jan1).'</td>';
        echo '<td nowrap class="text-right">'.($r->jan3).'</td>';
        echo '<td nowrap class="text-right">'.($r->jan2).'</td>';
        echo '<td nowrap class="text-right">'.($r->jan5).'</td>';
        echo '<td nowrap class="text-right">'.($r->jan4).'</td>';
        echo '<td nowrap class="text-right">'.($r->jan6).'</td>';
        echo '<td nowrap class="text-right">'.($r->feb1).'</td>';
        echo '<td nowrap class="text-right">'.($r->feb3).'</td>';
        echo '<td nowrap class="text-right">'.($r->feb2).'</td>';
        echo '<td nowrap class="text-right">'.($r->feb5).'</td>';
        echo '<td nowrap class="text-right">'.($r->feb4).'</td>';
        echo '<td nowrap class="text-right">'.($r->feb6).'</td>';
        echo '<td nowrap class="text-right">'.($r->mar1).'</td>';
        echo '<td nowrap class="text-right">'.($r->mar3).'</td>';
        echo '<td nowrap class="text-right">'.($r->mar2).'</td>';
        echo '<td nowrap class="text-right">'.($r->mar5).'</td>';
        echo '<td nowrap class="text-right">'.($r->mar4).'</td>';
        echo '<td nowrap class="text-right">'.($r->mar6).'</td>';
        echo '<td nowrap class="text-right">'.($r->apr1).'</td>';
        echo '<td nowrap class="text-right">'.($r->apr3).'</td>';
        echo '<td nowrap class="text-right">'.($r->apr2).'</td>';
        echo '<td nowrap class="text-right">'.($r->apr5).'</td>';
        echo '<td nowrap class="text-right">'.($r->apr4).'</td>';
        echo '<td nowrap class="text-right">'.($r->apr6).'</td>';
        echo '<td nowrap class="text-right">'.($r->mei1).'</td>';
        echo '<td nowrap class="text-right">'.($r->mei3).'</td>';
        echo '<td nowrap class="text-right">'.($r->mei2).'</td>';
        echo '<td nowrap class="text-right">'.($r->mei5).'</td>';
        echo '<td nowrap class="text-right">'.($r->mei4).'</td>';
        echo '<td nowrap class="text-right">'.($r->mei6).'</td>';
        echo '<td nowrap class="text-right">'.($r->jun1).'</td>';
        echo '<td nowrap class="text-right">'.($r->jun3).'</td>';
        echo '<td nowrap class="text-right">'.($r->jun2).'</td>';
        echo '<td nowrap class="text-right">'.($r->jun5).'</td>';
        echo '<td nowrap class="text-right">'.($r->jun4).'</td>';
        echo '<td nowrap class="text-right">'.($r->jun6).'</td>';
        echo '<td nowrap class="text-right">'.($r->jul1).'</td>';
        echo '<td nowrap class="text-right">'.($r->jul3).'</td>';
        echo '<td nowrap class="text-right">'.($r->jul2).'</td>';
        echo '<td nowrap class="text-right">'.($r->jul5).'</td>';
        echo '<td nowrap class="text-right">'.($r->jul4).'</td>';
        echo '<td nowrap class="text-right">'.($r->jul6).'</td>';
        echo '<td nowrap class="text-right">'.($r->ags1).'</td>';
        echo '<td nowrap class="text-right">'.($r->ags3).'</td>';
        echo '<td nowrap class="text-right">'.($r->ags2).'</td>';
        echo '<td nowrap class="text-right">'.($r->ags5).'</td>';
        echo '<td nowrap class="text-right">'.($r->ags4).'</td>';
        echo '<td nowrap class="text-right">'.($r->ags6).'</td>';
        echo '<td nowrap class="text-right">'.($r->sep1).'</td>';
        echo '<td nowrap class="text-right">'.($r->sep3).'</td>';
        echo '<td nowrap class="text-right">'.($r->sep2).'</td>';
        echo '<td nowrap class="text-right">'.($r->sep5).'</td>';
        echo '<td nowrap class="text-right">'.($r->sep4).'</td>';
        echo '<td nowrap class="text-right">'.($r->sep6).'</td>';
        echo '<td nowrap class="text-right">'.($r->okt1).'</td>';
        echo '<td nowrap class="text-right">'.($r->okt3).'</td>';
        echo '<td nowrap class="text-right">'.($r->okt2).'</td>';
        echo '<td nowrap class="text-right">'.($r->okt5).'</td>';
        echo '<td nowrap class="text-right">'.($r->okt4).'</td>';
        echo '<td nowrap class="text-right">'.($r->okt6).'</td>';
        echo '<td nowrap class="text-right">'.($r->nov1).'</td>';
        echo '<td nowrap class="text-right">'.($r->nov3).'</td>';
        echo '<td nowrap class="text-right">'.($r->nov2).'</td>';
        echo '<td nowrap class="text-right">'.($r->nov5).'</td>';
        echo '<td nowrap class="text-right">'.($r->nov4).'</td>';
        echo '<td nowrap class="text-right">'.($r->nov6).'</td>';
        echo '<td nowrap class="text-right">'.($r->dec1).'</td>';
        echo '<td nowrap class="text-right">'.($r->dec3).'</td>';
        echo '<td nowrap class="text-right">'.($r->dec2).'</td>';
        echo '<td nowrap class="text-right">'.($r->dec5).'</td>';
        echo '<td nowrap class="text-right">'.($r->dec4).'</td>';
        echo '<td nowrap class="text-right">'.($r->dec6).'</td>';
    echo '</tr>';
    
}

?>

