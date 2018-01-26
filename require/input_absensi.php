<form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
    <h2>Input Absensi Siswa</h2>
    <table>
      <tr><td>Tanggal hari ini :</td><td><input type="test" class="datepicker" name="tanggal" value="<?php echo date('m/d/Y'); ?>" /></td></tr>
      <tr><td>NIS :</td><td><input type='text' name='nis' value='<?= stripslashes($row['nis']) ?>' /></td></tr>
      <tr><td>Status Absensi :</td><td><input type='radio' name='absensi' value='1' checked="checked"/>Sakit<input type='radio' name='absensi' value='2' />Ijin
        <input type='radio' name='absensi' value='3' />Alpha<input type='radio' name='absensi' value='4' />Terlambat</td></tr>
      <tr><td><input type='submit' name='insert' value='Tambah' class="button button-primary"/><input type='hidden' value='1' name='submitted' /></td>
      <td><a href="admin.php?page=input_absensi" class="button button-primary">Batal</a></td></tr>
    </table>
</form>
