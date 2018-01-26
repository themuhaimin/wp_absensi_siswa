<?php

function data_siswa_list() {
  global $wpdb;
  if($_GET['delete']=='hapus') {
    $nis=$_GET['nis'];
      $table_name = $wpdb->prefix . "datasiswa";
      $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE nis = %s", $nis));
      $message.="Data Berhasil dihapus";
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/sinetiks-schools/style-admin.css" rel="stylesheet" />
    <div class="wrap">
        <h2>Daftar Nama Siswa</h2>
          <?php if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
        <div class="tablenav top">
            <div class="alignleft actions">
                <a class="button button-primary"href="<?php echo admin_url('admin.php?page=input_data_siswa'); ?>">Tambah Siswa</a></br>
            </div>
            <br class="clear">
        </div>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "datasiswa";
        $table_kelas = $wpdb->prefix . "kelas";

        $rows = $wpdb->get_results("SELECT *,$table_kelas.kelas from $table_name inner join $table_kelas on $table_name.kelas = $table_kelas.id_kelas");
        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column ss-list-width">NIS</th>
                <th class="manage-column ss-list-width">Nama Siswa</th>
                <th class="manage-column ss-list-width">Kelas</th>
                <th class="manage-column ss-list-width">Alamat</th>
                <th class="manage-column ss-list-width">Kota</th>
                <th class="manage-column ss-list-width">Nomor Telepon</th>
                <th colspan="2" class="manage-column ss-list-width">Aksi</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->nis; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->nama_siswa; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->kelas; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->alamat; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->kota; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->telepon; ?></td>
                    <td><a href="<?php echo admin_url('admin.php?page=edit_data_siswa&nis=' . $row->nis); ?>">Edit</a></td>
                    <td><a href="<?php echo admin_url('admin.php?page=data_siswa_list&delete=hapus&nis=' . $row->nis); ?>">Hapus</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}

?>
