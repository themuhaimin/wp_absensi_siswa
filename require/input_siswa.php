<?php
function input_data_siswa() {
  //inisialisasi table
    global $wpdb;
    $table_siswa = $wpdb->prefix . "datasiswa";
    $table_kelas = $wpdb->prefix . "kelas";
    $nis = $_POST["nis"];
    $nama_siswa = $_POST["nama_siswa"];
    $kelas = $_POST["kelas"];
    $alamat = $_POST["alamat"];
    $kota = $_POST["kota"];
    $telepon = $_POST["telepon"];
    //insert
    if (isset($_POST['insert'])) {
        global $wpdb;
        $table_name = $wpdb->prefix . "datasiswa";

        $wpdb->insert(
                $table_name, //table
                array('nis' => $nis,'nama_siswa' => $nama_siswa,'kelas' => $kelas,'alamat' => $alamat,'kota' => $kota,'telepon' => $telepon), //data
                array('%s', '%s') //data format
        );
        $message.="Data Siswa Berhasil Ditambahkan";
        echo '<script>location.href="admin.php?page=data_siswa_list";</script>';


    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/sinetiks-schools/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Tambah Data Siswa</h2>
        <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
        <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
            <p>Three capital letters for the ID</p>
            <table>
              <tr><td>NIS :</td><td><input type='text' name='nis' value='<?= stripslashes($row['nis']) ?>' /></td></tr>
              <tr><td>Nama Siswa:</td><td><input type='text' name='nama_siswa' value='<?= stripslashes($row['nama_siswa']) ?>' /></td></tr>
              <tr><td>Kelas:</td>
              <td><select name="kelas">
                <?php $kelas = $wpdb->get_results("SELECT * from $table_kelas");
                foreach ($kelas as $k) {
                echo '<option value="'.$k->id_kelas.'">'.$k->kelas.'</option>';
              } ?>
              </select>
              </td></tr>
              <tr><td>Alamat:</td><td><textarea name='alamat'><?= stripslashes($row['alamat']) ?> </textarea></td></tr>
              <tr><td>Kota:</td><td><input type='text' name='kota' value='<?= stripslashes($row['kota']) ?>' /></td></tr>
              <tr><td>Telepon:</td><td><input type='text' name='telepon' value='<?= stripslashes($row['telepon']) ?>' /></td></tr>
              <tr><td><input type='submit' name='insert' value='Tambah' class="button button-primary"/><input type='hidden' value='1' name='submitted' /></td>
              <td><a href="admin.php?page=data_siswa_list" class="button button-primary">Batal</a></td></tr>
            </table>
        </form>
    </div>
    <?php
}
?>
