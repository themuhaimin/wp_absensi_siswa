<?php
//file header
/*
Plugin Name: Absensi Siswa
Version:1.0
Plugin URI: http://github.com/themuhaimin
Description:Plugin untuk absensi siswa dan sekaligus Data Siswa bagi web sekolah. Ini merupakan plugin versi free. untuk versi berbayar bisa menghubungi WA saya di  085701672924 atau email ke themuhaimin@gmail.com
Author: Muhaimin Muhammad
Author URI: www.digtion.blogspot.co.id
*/
function cek_absen() {
  $form = '<form method="post" action=""/>
      <h2>Input Absensi Siswa</h2>
      <table>
              <tr><td>NIS :</td><td><input type="text" name="nis" /></td></tr>

        <td><a href="admin.php?page=input_absensi" class="button button-primary">Batal</a></td></tr>
      </table>
  </form>';

  return $form;
}
add_shortcode('cek_absen', 'cek_absen');
function data_siswa_instalasi() {

    global $wpdb;

    $table_siswa = $wpdb->prefix . "datasiswa";
    $table_absensi = $wpdb->prefix . "absensi";
    $table_kelas = $wpdb->prefix . "kelas";
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE IF NOT EXISTS $table_absensi(
      `id` int(10) NOT NULL AUTO_INCREMENT,
        `nis` varchar(10) NOT NULL,
        `tanggal` date NOT NULL,
        `absensi` varchar(4) NOT NULL,
        PRIMARY KEY (`id`)
      ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4;";
    $sql2 =  "CREATE TABLE IF NOT EXISTS $table_siswa(
      nis int(9) NOT NULL,
      nama_siswa varchar(200) NOT NULL,
      kelas varchar(50) NOT NULL,
      alamat varchar(200) NOT NULL,
      kota varchar(200) NOT NULL,
      telepon varchar(50) NOT NULL,
        PRIMARY KEY (`nis`)
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $sql3 = "CREATE TABLE IF NOT EXISTS $table_kelas(
      `id_kelas` varchar(11) NOT NULL,
      `kelas` varchar(50) NOT NULL,
      PRIMARY KEY (`id_kelas`)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
//ini data sample
$input_sample = "INSERT INTO $table_absensi (`id`, `nis`, `tanggal`, `absensi`) VALUES
(4, '2356', '2018-01-02', '1'),
(5, '2356', '2018-01-03', '2'),
(6, '2356', '2018-01-04', '1'),
(7, '2356', '2018-01-31', '1'),
(8, '2356', '2018-01-09', '2'),
(9, '1234', '2018-01-09', '3'),
(10, '1235', '2018-01-09', '4'),
(11, '1235', '2018-01-10', '1'),
(12, '9878', '2018-01-10', '2'),
(13, '1234', '2018-01-10', '1');

INSERT INTO $table_siswa (`nis`, `nama_siswa`, `kelas`, `alamat`, `kota`, `telepon`) VALUES
(1234, 'Muhsonal Hamid', '7A', 'Makan ', 'Kendal', '7687'),
(1235, 'Khusnul', '7B', 'Kaliwungu', 'Kendal', '134545r'),
(2356, 'Suharso', '7C', 'Kaliwungu', 'Kendal', '085726753771'),
(9878, 'Kami', '7A', 'Kaki ', 'Kendal', '09090');

INSERT INTO $table_kelas (`id_kelas`, `kelas`) VALUES
('7A', '7A'),
('7B', '7B'),
('7C', '7C'),
('7D', '7D');
";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);
    dbDelta($sql2);
    dbDelta($sql3);
    dbDelta($input_sample);

}
//fungsi untuk uninstall_plugins
function data_siswa_uninstall() {
  global $wpdb;
  $table_siswa = $wpdb->prefix . "datasiswa";
  $table_absensi = $wpdb->prefix . "absensi";
  $table_kelas = $wpdb->prefix . "kelas";
  $charset_collate = $wpdb->get_charset_collate();
  $sql = "DROP TABLE wp_absensi";
  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta($sql);
}
// run the install scripts upon plugin activation
register_activation_hook(__FILE__, 'data_siswa_instalasi');
register_deactivation_hook(__FILE__, 'data_siswa_uninstall');
add_action('admin_menu','menu_admin_show');
function menu_admin_show() {

	//this is the main item for the menu
	add_menu_page('Data Siswa', //page title
	'Input Absen Siswa', //menu title
	'manage_options', //capabilities
	'input_absensi', //menu slug
	'input_absensi' //function
	);
  add_submenu_page('input_absensi', //parent slug
  'Kelola Kelas', //page title
  'Kelola Kelas', //menu title
  'manage_options', //capability
  'kelola_kelas', //menu slug
  'kelola_kelas'); //function
  add_submenu_page('input_absensi', //parent slug
  'Data Siswa', //page title
  'Data Siswa', //menu title
  'manage_options', //capability
  'data_siswa_list', //menu slug
  'data_siswa_list'); //function
  add_submenu_page('input_absensi', //parent slug
  'Rekap Absensi', //page title
  'Rekap Absensi', //menu title
  'manage_options', //capability
  'rekap_absensi', //menu slug
  'rekap_absensi'); //function
  add_submenu_page(null, //parent slug
  'Edit Siswa Baru', //page title
  'Edit Siswa', //menu title
  'manage_options', //capability
  'edit_data_siswa', //menu slug
  'edit_data_siswa'); //function
  add_submenu_page(null, //parent slug
  'Tambah Siswa Baru', //page title
  'Tambah Siswa', //menu title
  'manage_options', //capability
  'input_data_siswa', //menu slug
  'input_data_siswa'); //function
}
define('ROOTDIR', plugin_dir_path(__FILE__));
wp_enqueue_script('jquery', plugins_url('css/jquery-1.12.4.js',__FILE__));
wp_enqueue_style('jquery-ui', plugins_url('css/jquery-ui.css',__FILE__));
wp_enqueue_script('jquery-ui', plugins_url('js/jquery-ui.js',__FILE__), array('jquery-ui-datepicker'),time(), true);
wp_enqueue_script('kalender', plugins_url('js/kalender.js',__FILE__));
wp_enqueue_style('jquery-ui-datepicker');
require_once(ROOTDIR . 'require/data_siswa_list.php');
require_once(ROOTDIR . 'require/input_siswa.php');
require_once(ROOTDIR . 'require/edit_data_siswa.php');
require_once(ROOTDIR . 'require/absensi.php');
require_once(ROOTDIR . 'require/rekap_absensi.php');
require_once(ROOTDIR . 'require/kelola_kelas.php');
require_once(ROOTDIR . 'require/create_pdf.php');

?>
