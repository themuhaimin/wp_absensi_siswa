<?php
include( ROOTDIR . 'require/pdf-helper-functions.php');
$pdf = new PDF_HTML();

if( isset($_POST['generate_posts_pdf'])){
    output_pdf();
}
function output_pdf() {
        global $pdf;
        $title_line_height = 10;
        $content_line_height = 8;
        global $wpdb;
        $kelas=$_POST['kelas'];
        $table_siswa = $wpdb->prefix . "datasiswa";
        $table_absensi = $wpdb->prefix . "absensi";
        $table_kelas = $wpdb->prefix . "kelas";
        // query rekap_absensi
        $rows = $wpdb->get_results("SELECT $table_siswa.nis,$table_siswa.nama_siswa,$table_kelas.kelas,
        	IFNULL((SELECT COUNT($table_absensi.absensi)
                    FROM $table_absensi
                    WHERE $table_absensi.absensi =1
                    AND $table_absensi.nis =  $table_siswa.nis
                    AND $table_absensi.nis IN (SELECT $table_siswa.nis from $table_siswa
                                           WHERE $table_siswa.kelas='$kelas')
                    GROUP BY $table_absensi.nis
                    ORDER BY $table_siswa.nis ASC),0) AS sakit,
                    IFNULL((SELECT COUNT($table_absensi.absensi)
                    FROM $table_absensi
                    WHERE $table_absensi.absensi =2
                    AND $table_absensi.nis =  $table_siswa.nis
                    AND $table_absensi.nis IN (SELECT $table_siswa.nis from $table_siswa
                                           WHERE $table_siswa.kelas='$kelas')
                    GROUP BY $table_absensi.nis
                    ORDER BY $table_siswa.nis ASC),0) AS ijin,
                    IFNULL((SELECT COUNT($table_absensi.absensi)
                    FROM $table_absensi
                    WHERE $table_absensi.absensi =3
                    AND $table_absensi.nis =  $table_siswa.nis
                    AND $table_absensi.nis IN (SELECT $table_siswa.nis from $table_siswa
                                           WHERE $table_siswa.kelas='$kelas')
                    GROUP BY $table_absensi.nis
                    ORDER BY $table_siswa.nis ASC),0) AS alpha,
                    IFNULL((SELECT COUNT($table_absensi.absensi)
                    FROM $table_absensi
                    WHERE $table_absensi.absensi =4
                    AND $table_absensi.nis =  $table_siswa.nis
                    AND $table_absensi.nis IN (SELECT $table_siswa.nis from $table_siswa
                                           WHERE $table_siswa.kelas='$kelas')
                    GROUP BY $table_absensi.nis
                    ORDER BY $table_siswa.nis ASC),0) AS terlambat

            FROM $table_siswa
            INNER JOIN $table_kelas on $table_siswa.kelas=$table_kelas.id_kelas
            WHERE $table_siswa.kelas='$kelas'");
            $header = array(
            		array("label"=>"NIS", "length"=>20, "align"=>"C"),
            		array("label"=>"NAMA", "length"=>115, "align"=>"C"),
            		array("label"=>"S", "length"=>10, "align"=>"C"),
                array("label"=>"I", "length"=>10, "align"=>"C"),
                array("label"=>"A", "length"=>10, "align"=>"C"),
                array("label"=>"T", "length"=>10, "align"=>"C")
            	);
      $pdf->AddPage();
      //set margin
      $pdf->SetMargins(18,25.4,25.4,10);
      #tampilkan judul laporan
      $pdf->SetFont('Arial','B','16');
      $pdf->Cell(0,10, "Daftar Absensi SMP Negeri 1 Kaliwungu", '0', 1, 'C');
      $pdf->Cell(0,10, "Kelas  ".$_POST['kelas'], '0', 1, 'C');
      #buat header tabel
      $pdf->SetFont('Arial','','10');
      $pdf->SetFillColor(103,156,191);
      $pdf->SetTextColor(0);
      $pdf->SetDrawColor(0);
      foreach ($header as $kolom) {
      	$pdf->Cell($kolom['length'], 10, $kolom['label'], 1, '0', $kolom['align'], true);
      }
      $pdf->Ln();
      $pdf->SetFillColor(255);
      foreach ($rows as $row) {
      $pdf->Cell(20, 5, $row->nis, 1, '0', "C", true);
      $pdf->Cell(115, 5, $row->nama_siswa, 1, '0', "L", true);
      $pdf->Cell(10, 5, $row->sakit, 1, '0', "C", true);
      $pdf->Cell(10, 5, $row->ijin, 1, '0', "C", true);
      $pdf->Cell(10, 5, $row->alpha, 1, '0', "C", true);
      $pdf->Cell(10, 5, $row->terlambat, 1, '0', "C", true);
      $pdf->Ln();
         }
      $pdf->Ln();
      $pdf->Cell(120, 5, "", 0, '0', "L", true);
      $pdf->Cell(60, 5, "Kaliwungu, .................2018", 0, '0', "L", true);
      $pdf->Ln();
      $pdf->Cell(120, 5, "", 0, '0', "L", true);
      $pdf->Cell(40, 5, "Wali Kelas", 0, '0', "L", true);
      $pdf->Ln();
      $pdf->Ln();
      $pdf->Ln();
      $pdf->Cell(120, 5, "", 0, '0', "L", true);
      $pdf->Cell(40, 5, "..................", 0, '0', "L", true);

    $pdf->Output('D','Absensi_siswa_'.$_POST['kelas'].'.pdf');
    exit;
}
?>
