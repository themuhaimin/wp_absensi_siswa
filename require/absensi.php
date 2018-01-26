<?php

function input_absensi() {
  global $wpdb;
  $table_siswa = $wpdb->prefix . "datasiswa";
  $table_kelas = $wpdb->prefix . "kelas";
  $table_absensi = $wpdb->prefix . "absensi";
  //jika ada aksi maka keluarkan form input
  if(isset($_GET['act'])){
    if($_GET['act']=='tambah'){
      require_once(ROOTDIR . 'require/input_absensi.php');
    }
  }
  $nis = $_POST["nis"];
  $tanggal = date('Y-m-d',strtotime($_POST["tanggal"]));
  $absensi =$_POST['absensi'];
  //jika tersubmit maka simpan data
  if (isset($_POST['insert'])) {
  // echo $tanggal;
    //validasi
    $adasiswa = $wpdb->get_results("SELECT * from $table_siswa where nis=$nis");
          $jumlah=0;
          foreach ($adasiswa as $s){
          $jumlah++;
          }
      //jika data nis ada
      if($jumlah>0){
          $siswa = $wpdb->get_results("SELECT * from $table_absensi where nis=$nis and tanggal='$tanggal'");
          $record=0;
          foreach ($siswa as $s){
          $record++;
          }
          if($record>0){
          $message.="Siswa sudah terdata pada tanggal ini silakan cek ulang ";
          } else {
            $wpdb->insert(
                    $table_absensi, //table
                    array('nis' => $nis,'tanggal'=>$tanggal,'absensi'=>$absensi), //data
                    array('%s', '%s') //data format
            );
            $message.="Data Berhasil Ditambahkan";
          }
        } else {
          $message.="tidak ada siswa dengan NIS = ".$nis;
        }
    }
  $rows = $wpdb->get_results("SELECT * from $table_absensi INNER JOIN $table_siswa on $table_siswa.nis=$table_absensi.nis INNER JOIN $table_kelas on $table_siswa.kelas=$table_kelas.id_kelas ORDER BY tanggal DESC");
  ?>
  <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
  <h1>Data Seluruh Absensi Siswa</h1>
  <table  class='wp-list-table widefat fixed striped posts'>
    <tr><td>
      <?php
      if(!isset($_GET['act'])){
            echo '<tr><td colspan="4"><a href="admin.php?page=input_absensi&act=tambah" class="button button-primary">Tambah Absensi</a></td></tr>';
          }
      ?>
          </td></tr>
    <tr>
      <th class="manage-column ss-list-width">Tanggal</th>
      <th class="manage-column ss-list-width">NIS</th>
      <th class="manage-column ss-list-width">Nama Siswa</th>
      <th class="manage-column ss-list-width">Kelas</th>
      <th class="manage-column ss-list-width">Keterangan</th>
  </tr>
  <?php foreach ($rows as $row) { ?>
      <tr>
          <td class="manage-column ss-list-width"><?php echo date('d F Y', strtotime($row->tanggal)); ?></td>
          <td class="manage-column ss-list-width"><?php echo $row->nis; ?></td>
          <td class="manage-column ss-list-width"><?php echo $row->nama_siswa; ?></td>
          <td class="manage-column ss-list-width"><?php echo $row->kelas; ?></td>
          <td class="manage-column ss-list-width"><?php if($row->absensi==1){
             $ket="Sakit";
           } else if($row->absensi==2){
             $ket="Ijin";
           } else if($row->absensi==3){
             $ket="Alpha";
           }
              else {
                $ket="Terlambat";
            }
           echo $ket;  ?></td>
      </tr>
  <?php
      }
      ?>
    </table>
<?php } ?>
