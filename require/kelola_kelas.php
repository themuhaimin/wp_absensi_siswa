<?php

function kelola_kelas() {
  global $wpdb;
  $id_kelas=$_POST['id_kelas'];
  $kelas=$_POST['kelas'];
  $table_kelas = $wpdb->prefix . "kelas";
  if($_GET['aksi']=='hapus') {
    $id_kelas=$_GET['id_kelas'];
      $wpdb->query($wpdb->prepare("DELETE FROM $table_kelas WHERE id_kelas = %s", $id_kelas));
      $message.="Data Berhasil dihapus";
    }
    ?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/sinetiks-schools/style-admin.css" rel="stylesheet" />
    <div class="wrap">
    <?php
    if($_GET['aksi']=='input_form') { ?>
      <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
          <p>Three capital letters for the ID</p>
          <table>
            <tr><td>NIS :</td><td><input type='text'name='id_kelas' value='<?php echo $nis; ?>' /></td></tr>
            <tr><td>Nama Siswa:</td><td><input type='text' name='kelas' value='<?php echo $nama_siswa; ?>' /></td></tr>
            <tr><td><input type='submit' name='insert' value='Tambah' class="button button-primary"/><input type='hidden' value='1' name='submitted' /></td>
            <td><a href="admin.php?page=kelola_kelas" class="button button-primary">Batal</a></td></tr>
          </table>
      </form>
      <?php
     }
     //proses insert
     if(isset($_POST['submitted'])) {
       $wpdb->insert(
               $table_kelas, //table
               array('id_kelas' => $id_kelas,'kelas' => $kelas), //data
               array('%s', '%s') //data format
       );
      }
     if(isset($_GET['id_kelas'])) {
       $kelasnya=$_GET['id_kelas'];
       $kelas = $wpdb->get_results($wpdb->prepare("SELECT * from $table_kelas where id_kelas=%s", $kelasnya));
       foreach ($kelas as $s) {
           $v_id_kelas = $s->id_kelas;
           $v_kelas = $s->kelas;
       } ?>

       <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
           <p>Three capital letters for the ID</p>
           <table>
             <tr><td>Id Kelas :</td><td><input type='text' disabled="disable" name='id' value='<?php echo $v_id_kelas; ?>' /></td></tr>
             <tr><td>Nama Kelas:</td><td><input type='text' name='kelas' value='<?php echo $v_kelas; ?>' /></td></tr>
             <input type='hidden' name='id_kelas' value='<?php echo $v_id_kelas; ?>' />
             <tr><td><input type='submit' name='insert' value='Edit' class="button button-primary"/><input type='hidden' value='1' name='proses_edit' /></td>
             <td><a href="admin.php?page=kelola_kelas" class="button button-primary">Batal</a></td></tr>
           </table>
       </form>
       <?php
      }
      //proses edit
      if(isset($_POST['proses_edit'])) {
        $id_kelas=$_POST['id_kelas'];
        $kelas=$_POST['kelas'];
        $update=$wpdb->update(
                $table_kelas, //table
                array('kelas' => $kelas), //data
                array('id_kelas' => $id_kelas), //where
                array('%s'), //data format
                array('%s') //where
        );
        if($update){
          $message.="Data Kelas Berhasil Diubah";
        } else {
          $message.="Data Kelas Gagal Diubah";
        }
       }
     //untuk tampilan edit dengan menghilangkan tombol tambah
    if (isset($message)): ?><div class="updated"><p><?php echo $message; ?></p></div><?php endif; ?>
        <div class="tablenav top">
            <div class="alignleft actions">
              <?php if($_GET['aksi']!='input_form' && !isset($_GET['id_kelas'])){ ?>
                   <a class="button button-primary"href="<?php echo admin_url('admin.php?page=kelola_kelas&aksi=input_form'); ?>">Tambah Siswa</a>
              <?php } ?>
            </br><h2>Daftar Kelas</h2></br>
            </div>
            <br class="clear">
        </div>
        <?php
        $rows = $wpdb->get_results("SELECT * from $table_kelas");
        ?>
        <table class='wp-list-table widefat fixed striped posts'>
            <tr>
                <th class="manage-column ss-list-width">id Kelas</th>
                <th class="manage-column ss-list-width">Nama Kelas</th>
                <th colspan="2" class="manage-column ss-list-width">Aksi</th>
            </tr>
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo $row->id_kelas; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->kelas; ?></td>
                    <td><a href="<?php echo admin_url('admin.php?page=kelola_kelas&id_kelas='. $row->id_kelas); ?>">Edit</a></td>
                    <td><a href="<?php echo admin_url('admin.php?page=kelola_kelas&aksi=hapus&id_kelas=' . $row->id_kelas); ?>">Hapus</a></td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}

?>
