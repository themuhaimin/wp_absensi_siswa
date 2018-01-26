<?php
function rekap_absensi(){
global $wpdb;
$table_siswa = $wpdb->prefix . "datasiswa";
$table_absensi = $wpdb->prefix . "absensi";
$table_kelas = $wpdb->prefix . "kelas";?>
<div class="wrap">
  <form method="get" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
      <h1>Laporan Absensi Siswa per Kelas</h1>
      <table>
        <input type='hidden' value='rekap_absensi' name='page' />
        <tr><td>NIS :</td>
        <td><select name="kelas">
          <?php $kelas = $wpdb->get_results("SELECT * from $table_kelas");
          foreach ($kelas as $k) {
          echo '<option value="'.$k->id_kelas.'">'.$k->kelas.'</option>';
        } ?>
        </select>
      </td><td><input type='submit' name='update' value='Lihat Absensi Siswa' class="button button-primary"/></td></tr>
        <tr>
      </table>
  </form>
<?php
  $aksi=$_GET['kelas'];
  if(isset($aksi)){
    global $wpdb;
    $rows = $wpdb->get_results("SELECT $table_siswa.nis,$table_siswa.nama_siswa,$table_kelas.kelas,
    	IFNULL((SELECT COUNT($table_absensi.absensi)
                FROM $table_absensi
                WHERE $table_absensi.absensi =1
                AND $table_absensi.nis =  $table_siswa.nis
                AND $table_absensi.nis IN (SELECT $table_siswa.nis from $table_siswa
                                       WHERE $table_siswa.kelas='$aksi')
                GROUP BY $table_absensi.nis
                ORDER BY $table_siswa.nis ASC),0) AS sakit,
                IFNULL((SELECT COUNT($table_absensi.absensi)
                FROM $table_absensi
                WHERE $table_absensi.absensi =2
                AND $table_absensi.nis =  $table_siswa.nis
                AND $table_absensi.nis IN (SELECT $table_siswa.nis from $table_siswa
                                       WHERE $table_siswa.kelas='$aksi')
                GROUP BY $table_absensi.nis
                ORDER BY $table_siswa.nis ASC),0) AS ijin,
                IFNULL((SELECT COUNT($table_absensi.absensi)
                FROM $table_absensi
                WHERE $table_absensi.absensi =3
                AND $table_absensi.nis =  $table_siswa.nis
                AND $table_absensi.nis IN (SELECT $table_siswa.nis from $table_siswa
                                       WHERE $table_siswa.kelas='$aksi')
                GROUP BY $table_absensi.nis
                ORDER BY $table_siswa.nis ASC),0) AS alpha,
                IFNULL((SELECT COUNT($table_absensi.absensi)
                FROM $table_absensi
                WHERE $table_absensi.absensi =4
                AND $table_absensi.nis =  $table_siswa.nis
                AND $table_absensi.nis IN (SELECT $table_siswa.nis from $table_siswa
                                       WHERE $table_siswa.kelas='$aksi')
                GROUP BY $table_absensi.nis
                ORDER BY $table_siswa.nis ASC),0) AS terlambat

        FROM $table_siswa
        INNER JOIN $table_kelas on $table_siswa.kelas=$table_kelas.id_kelas
        WHERE $table_siswa.kelas='$aksi'");
    ?>
    <table class='wp-list-table widefat fixed striped posts'>
        <tr>
            <th class="manage-column ss-list-width">NIS</th>
            <th class="manage-column ss-list-width">Nama Siswa</th>
            <th class="manage-column ss-list-width">Kelas</th>
            <th class="manage-column ss-list-width">Sakit</th>
            <th class="manage-column ss-list-width">Ijin</th>
            <th class="manage-column ss-list-width">Alpha</th>
            <th class="manage-column ss-list-width">Terlambat</th>

        </tr>
        <?php foreach ($rows as $row) { ?>
            <tr>
                <td class="manage-column ss-list-width"><?php echo $row->nis; ?></td>
                <td width="300" class="manage-column ss-list-width"><?php echo $row->nama_siswa; ?></td>
                <td class="manage-column ss-list-width"><?php echo $row->kelas; ?></td>
                <td class="manage-column ss-list-width"><?php echo $row->sakit; ?></td>
                <td class="manage-column ss-list-width"><?php echo $row->ijin; ?></td>
                <td class="manage-column ss-list-width"><?php echo $row->alpha; ?></td>
                <td class="manage-column ss-list-width"><?php echo $row->terlambat; ?></td>
            </tr>
        <?php } ?>

    </table>
  </br>
    <form method="post" id="as-fdpf-form">
      <input type="hidden" name="kelas" value="<?php echo  $_GET['kelas']; ?>"/>
          <button class="button button-primary" type="submit" name="generate_posts_pdf" value="generate">Cetak laporan PDF</button>
      </form>
  <?php }
 } ?>
