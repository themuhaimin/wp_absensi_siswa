<?php
function edit_data_siswa() {
  global $wpdb;
  $table_name = $wpdb->prefix . "datasiswa";
  $table_kelas = $wpdb->prefix . "kelas";
  $nis = $_GET["nis"];
  $nisnya = $_POST["nis"];
  $nama_siswa = $_POST["nama_siswa"];
  $kelas = $_POST["kelas"];
  $alamat = $_POST["alamat"];
  $kota = $_POST["kota"];
  $telepon = $_POST["telepon"];
//update
  if (isset($_POST['update'])) {
      $update=$wpdb->update(
              $table_name, //table
              array('nis' => $nisnya,'nama_siswa' => $nama_siswa,'kelas' => $kelas,'alamat' => $alamat,'kota' => $kota,'telepon' => $telepon), //data
              array('nis' => $nis), //where
              array('%s'), //data format
              array('%s') //where format
      );
      if($update){
        $message.="Data Siswa Berhasil Diubah";
      } else {
        $message.="Data Siswa Gagal Diubah";
      }
  }
//delete
  else if (isset($_GET['delete'])) {
      $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE nis = %s", $nis));
  } else {//selecting value to update
      $siswa = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name where nis=%s", $nis));
      foreach ($siswa as $s) {
          $nis = $s->nis;
          $nama_siswa = $s->nama_siswa;
          $kelas = $s->kelas;
          $alamat = $s->alamat;
          $kota= $s->kota;
          $telepon = $s->telepon;
      }
  }
  ?>
  <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/sinetiks-schools/style-admin.css" rel="stylesheet" />
  <div class="wrap">
      <h2>Add New School</h2>
      <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
      <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
          <p>Three capital letters for the ID</p>
          <table>
            <tr><td>NIS :</td><td><input type='text' name='nis' value='<?php echo $nis; ?>' /></td></tr>
            <tr><td>Nama Siswa:</td><td><input type='text' name='nama_siswa' value='<?php echo $nama_siswa; ?>' /></td></tr>
            <tr><td>Kelas:</td>
            <td><select name="kelas">
              <?php $kelas = $wpdb->get_results("SELECT * from $table_kelas");
              foreach ($kelas as $k) {
              echo '<option value="'.$k->id_kelas.'">'.$k->kelas.'</option>';
            } ?>
            </select>
            </td></tr>
            <tr><td>Alamat:</td><td><input type='text' name='alamat' value='<?php echo $alamat; ?>' /></td></tr>
            <tr><td>Kota:</td><td><input type='text' name='kota' value='<?php echo $kota; ?>' /></td></tr>
            <tr><td>Telepon:</td><td><input type='text' name='telepon' value='<?php echo $telepon; ?>' /></td></tr>
            <tr><td><input type='submit' name='update' value='Edit' class="button button-primary"/><input type='hidden' value='1' name='submitted' /></td>
            <td><a href="admin.php?page=data_siswa_list" class="button button-primary">Batal</a></td></tr>
          </table>
      </form>
  </div>
  <?php
}
 ?>
