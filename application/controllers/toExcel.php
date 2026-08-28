<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class ToExcel extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
        $this->load->model(array('m_monitor','m_upload_berkas','m_screening'));
    }
    
    public function downloadExcel(){
        $this->load->library("Excel/PHPExcel");
        
        $export = $this->input->post('selDataExport');
        // select data from database
        $bln    = $this->input->post('selBulan');
        $thn    = $this->input->post('selTahun');
        $blnthn = $bln."-".$thn;
        
        if($export == 'all'){
            $title  = 'LAPORAN SEMUA CALON TENAGA KERJA BULAN';
            $by     = 'Registered By';
            $dateBy = 'Registered Date';
            $data   = $this->m_monitor->toExcelSemuaLimitMonth($bln, $thn);
        }elseif($export == 'post'){
            $data   = $this->m_monitor->reportPostedLimitDate($bln, $thn);
            $by     = 'Posted By';
            $dateBy = 'Posted Date';
            $title  = 'LAPORAN TENAGA KERJA YANG DIKIRIM, BULAN';
        }else{
            $data   = NULL;
            $title  = NULL;
            $by     = NULL;
            $dateBy = NULL;
        }
        
        $objPHPExcel    = new PHPExcel();
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(5);
        $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('Z')->setWidth(70);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AB')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AC')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AD')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AE')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AF')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AG')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AH')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AI')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AJ')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AK')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AL')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AM')->setWidth(150);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AN')->setWidth(150);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AO')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AP')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AQ')->setWidth(150);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AR')->setWidth(150);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AS')->setWidth(150);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AT')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AU')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AV')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AW')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AX')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AY')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AZ')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('AA')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(23);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BC')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BD')->setWidth(50);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BE')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('BF')->setWidth(20);
        
        $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode('000');
        $objPHPExcel->getActiveSheet()->getStyle(3)->getFont()->setBold(true);
        
        $objPHPExcel->getActiveSheet()->mergeCells('A1:D1');
        $objPHPExcel->getActiveSheet()->mergeCells('A2:D2');
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A1', $title.' : '.$blnthn)
                
                ->setCellValue('A3', 'No.')
                ->setCellValue('B3', 'RegisID')
                ->setCellValue('C3', 'Nama')
                ->setCellValue('D3', 'Pemborong')
                ->setCellValue('E3', 'Perusahaan')
                ->setCellValue('F3', 'KTP')
                ->setCellValue('G3', 'Jenis Kelamin')
                ->setCellValue('H3', 'Alamat')
                ->setCellValue('I3', 'RT')
                ->setCellValue('J3', 'RW')
                ->setCellValue('K3', 'Handphone')
                ->setCellValue('L3', 'Tempat Lahir')
                ->setCellValue('M3', 'Tanggal Lahir')
                ->setCellValue('N3', 'Tinggal Dengan')
                ->setCellValue('O3', 'Hubungan dg Pelamar')
                ->setCellValue('P3', 'Tinggi Badan')
                ->setCellValue('Q3', 'Berat Badan')
                ->setCellValue('R3', 'Suku')
                ->setCellValue('S3', 'Daerah Asal')
                ->setCellValue('T3', 'Bahasa Daerah')
                ->setCellValue('U3', 'Agama')
                ->setCellValue('V3', 'Status Perkawinan')
                
                ->setCellValue('W3', 'Nama Pasangan')
                ->setCellValue('X3', 'Tanggal Lahir Pasangan')
                ->setCellValue('Y3', 'Pekerjaan Pasangan')
                ->setCellValue('Z3', 'Alamat Pasangan')
                ->setCellValue('AA3', 'Jumlah Anak')
                
                ->setCellValue('AB3', 'Nama Ayah')
                ->setCellValue('AC3', 'Nama Ibu')
                ->setCellValue('AD3', 'Pekerjaan Ortu')
                ->setCellValue('AE3', 'Anak Ke')
                ->setCellValue('AF3', 'Jumlah Saudara')
                ->setCellValue('AG3', 'Pendidikan Terakhir')
                ->setCellValue('AH3', 'Jurusan')
                ->setCellValue('AI3', 'Nama Univ/Sekolah')
                ->setCellValue('AJ3', 'Rata Nilai')
                ->setCellValue('AK3', 'Tahun Masuk')
                ->setCellValue('AL3', 'Tahun Lulus')
                ->setCellValue('AM3', 'Pengalaman Kerja')
                ->setCellValue('AN3', 'Skill/Keahlian')
                ->setCellValue('AO3', 'Pernah Kerja di SAMBU')
                ->setCellValue('AP3', 'Bag/Dept')
                ->setCellValue('AQ3', 'Hobby')
                ->setCellValue('AR3', 'Kegiatan Ekstra')
                ->setCellValue('AS3', 'Kegiatan Organisasi')
                ->setCellValue('AT3', 'Keadaan Fisik')
                ->setCellValue('AU3', 'Idap Penyakit')
                ->setCellValue('AV3', 'Penyakit Apa')
                ->setCellValue('AW3', 'Pernah Terlibat Kriminal')
                ->setCellValue('AX3', 'Perkara Apa')
                ->setCellValue('AY3', 'Bertato')
                ->setCellValue('AZ3', 'Bertindik')
                ->setCellValue('BA3', 'Sedia Rambut Pendek')
                ->setCellValue('BB3', 'Sedia Diberhentikan')
                ->setCellValue('BC3', 'Facebook')
                ->setCellValue('BD3', 'Twitter')
                ->setCellValue('BE3', $by)
                ->setCellValue('BF3', $dateBy);
        
        $ex = $objPHPExcel->setActiveSheetIndex(0);
        $no = 1;
        $counter = 4;
        foreach ($data as $row):
            $ex->setCellValue('A'.$counter, $no++);
            $ex->setCellValue('B'.$counter, $row->HeaderID);
            $ex->setCellValue('C'.$counter, $row->Nama);
            $ex->setCellValue('D'.$counter, $row->Pemborong);
            $ex->setCellValue('E'.$counter, $row->CVNama);
            $ex->setCellValue('F'.$counter, $row->No_Ktp);
            $ex->setCellValue('G'.$counter, $row->Jenis_Kelamin);
            $ex->setCellValue('H'.$counter, $row->Alamat);
            $ex->setCellValue('I'.$counter, $row->RT);
            $ex->setCellValue('J'.$counter, $row->RW);
            $ex->setCellValue('K'.$counter, $row->NoHP);
            $ex->setCellValue('L'.$counter, $row->Tempat_Lahir);
            $ex->setCellValue('M'.$counter, date('d M Y', strtotime($row->Tgl_Lahir)));
            $ex->setCellValue('N'.$counter, $row->TinggalDengan);
            $ex->setCellValue('O'.$counter, $row->HubunganDenganTK);
            $ex->setCellValue('P'.$counter, $row->TinggiBadan);
            $ex->setCellValue('Q'.$counter, $row->BeratBadan);
            $ex->setCellValue('R'.$counter, $row->Suku);
            $ex->setCellValue('S'.$counter, $row->Daerah_Asal);
            $ex->setCellValue('T'.$counter, $row->BahasaDaerah);
            $ex->setCellValue('U'.$counter, $row->Agama);
            $ex->setCellValue('V'.$counter, $row->Status_Personal);
            
            $ex->setCellValue('W'.$counter, $row->NamaSuamiIstri);
            $ex->setCellValue('X'.$counter, date('d M Y', strtotime($row->TglLahirSuamiIstri)));
            $ex->setCellValue('Y'.$counter, $row->PekerjaanSuamiIstri);
            $ex->setCellValue('Z'.$counter, $row->AlamatSuamiIstri);
            $ex->setCellValue('AA'.$counter, $row->JumlahAnak);
            
            $ex->setCellValue('AB'.$counter, $row->NamaBapak);
            $ex->setCellValue('AC'.$counter, $row->NamaIbuKandung);
            $ex->setCellValue('AD'.$counter, $row->ProfesiOrangTua);
            $ex->setCellValue('AE'.$counter, $row->AnakKe);
            $ex->setCellValue('AF'.$counter, $row->JumlahSaudara);
            
            $ex->setCellValue('AG'.$counter, $row->Pendidikan);
            $ex->setCellValue('AH'.$counter, $row->Jurusan);
            $ex->setCellValue('AI'.$counter, $row->Universitas);
            $ex->setCellValue('AJ'.$counter, $row->IPK);
            $ex->setCellValue('AK'.$counter, $row->TahunMasuk);
            $ex->setCellValue('AL'.$counter, $row->TahunLulus);
            
            $ex->setCellValue('AM'.$counter, $row->PengalamanKerja);
            $ex->setCellValue('AN'.$counter, $row->Keahlian);
            $ex->setCellValue('AO'.$counter, $row->PernahKerjaDiSambu);
            $ex->setCellValue('AP'.$counter, $row->KerjadiBagian);
            
            $ex->setCellValue('AQ'.$counter, $row->Hobby);
            $ex->setCellValue('AR'.$counter, $row->KegiatanEkstra);
            $ex->setCellValue('AS'.$counter, $row->KegiatanOrganisasi);
            $ex->setCellValue('AT'.$counter, $row->KeadaanFisik);
            $ex->setCellValue('AU'.$counter, $row->PernahIdapPenyakit);
            $ex->setCellValue('AV'.$counter, $row->PenyakitApa);
            $ex->setCellValue('AW'.$counter, $row->Kriminal);
            $ex->setCellValue('AX'.$counter, $row->PerkaraApa);
            $ex->setCellValue('AY'.$counter, $row->Bertato);
            $ex->setCellValue('AZ'.$counter, $row->Bertindik);
            $ex->setCellValue('BA'.$counter, $row->SediaPotongRambut);
            $ex->setCellValue('BB'.$counter, $row->Sediadiberhentikan);
            
            $ex->setCellValue('BC'.$counter, $row->AccountFacebook);
            $ex->setCellValue('BD'.$counter, $row->AccountTwitter);
            
            if($export == 'all'){
                $ex->setCellValue('BE'.$counter, $row->CreatedBy);
                $ex->setCellValue('BF'.$counter, $row->CreatedDate);
            }elseif($export == 'post'){
                $ex->setCellValue('BE'.$counter, $row->PostedBy);
                $ex->setCellValue('BF'.$counter, $row->PostedDate);
            }else{
                $ex->setCellValue('BE'.$counter, NULL);
                $ex->setCellValue('BF'.$counter, NULL);
            }
            $counter = $counter+1;
        endforeach;
        
        $objPHPExcel->getActiveSheet()->setTitle('LaporanCalonTenaker');
        
        $objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        
        header('Last-Modified:'. gmdate("D, d M Y H:i:s").'GMT');
        header('Chace-Control: no-store, no-cache, must-revalation');
        header('Chace-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Lap_CalonTenaker('.$blnthn.').xlsx"');
        
        $objWriter->save('php://output');
    }
}