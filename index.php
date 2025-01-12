<?php
/**
 * CodeIgniter
 *
 * Sebuah kerangka kerja pengembangan aplikasi open source untuk PHP
 *
 * Konten ini dirilis di bawah Lisensi MIT (MIT)
 *
 * Hak Cipta (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Izin diberikan secara gratis, kepada siapa saja yang memperoleh salinan
 * perangkat lunak ini dan dokumentasi terkait ("Perangkat Lunak"), untuk menangani
 * tanpa batasan, termasuk tanpa batasan hak untuk menggunakan, menyalin, memodifikasi,
 * menggabungkan, menerbitkan, mendistribusikan, melisensikan, dan/atau menjual salinan
 * perangkat lunak ini, serta mengizinkan pihak yang menerima perangkat lunak ini untuk
 * melakukan hal yang sama, dengan syarat berikut:
 *
 * Pemberitahuan hak cipta di atas dan pemberitahuan izin ini harus disertakan
 * dalam semua salinan atau bagian substansial perangkat lunak ini.
 *
 * PERANGKAT LUNAK INI DIBERIKAN "APA ADANYA", TANPA JAMINAN APA PUN, BAIK TERSURAT MAUPUN TERSIRAT,
 * TERMASUK TETAPI TIDAK TERBATAS PADA JAMINAN UNTUK DIPERDAGANGKAN,
 * KESESUAIAN UNTUK TUJUAN TERTENTU DAN NONPELANGGARAN. DALAM KEADAAN APA PUN,
 * PENULIS ATAU PEMEGANG HAK CIPTA TIDAK BERTANGGUNG JAWAB ATAS KLAIM, KERUSAKAN,
 * ATAU TANGGUNG JAWAB LAIN, BAIK DALAM TINDAKAN KONTRAK, PERBUATAN MELAWAN HUKUM,
 * ATAU LAINNYA, YANG TIMBUL DARI, ATAU BERKAITAN DENGAN PERANGKAT LUNAK INI
 * ATAU PENGGUNAAN ATAU TRANSAKSI LAINNYA DALAM PERANGKAT LUNAK INI.
 */

/*
 *---------------------------------------------------------------
 * LINGKUNGAN APLIKASI
 *---------------------------------------------------------------
 *
 * Anda dapat memuat konfigurasi yang berbeda tergantung pada
 * lingkungan saat ini. Menetapkan lingkungan juga memengaruhi
 * hal-hal seperti logging dan pelaporan kesalahan.
 *
 * Ini dapat diatur ke apa saja, tetapi penggunaan standar adalah:
 *
 *     development (pengembangan)
 *     testing (pengujian)
 *     production (produksi)
 */
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');

/*
 *---------------------------------------------------------------
 * PELAPORAN KESALAHAN
 *---------------------------------------------------------------
 *
 * Lingkungan yang berbeda memerlukan tingkat pelaporan kesalahan yang berbeda.
 * Secara default, pengembangan akan menampilkan kesalahan tetapi pengujian
 * dan produksi akan menyembunyikannya.
 */
switch (ENVIRONMENT)
{
    case 'development':
        error_reporting(-1);
        ini_set('display_errors', 1);
        break;

    case 'testing':
    case 'production':
        ini_set('display_errors', 0);
        if (version_compare(PHP_VERSION, '5.3', '>='))
        {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        }
        else
        {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
        }
        break;

    default:
        header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
        echo 'Lingkungan aplikasi tidak diatur dengan benar.';
        exit(1); // EXIT_ERROR
}

/*
 *---------------------------------------------------------------
 * NAMA DIREKTORI SISTEM
 *---------------------------------------------------------------
 *
 * Variabel ini harus berisi nama direktori "system" Anda.
 * Tetapkan path jika tidak berada di direktori yang sama dengan file ini.
 */
$system_path = 'system';

/*
 *---------------------------------------------------------------
 * NAMA DIREKTORI APLIKASI
 *---------------------------------------------------------------
 *
 * Jika Anda ingin front controller ini menggunakan direktori
 * "application" yang berbeda dari yang default, Anda dapat menetapkan
 * namanya di sini. Direktori tersebut juga dapat diubah namanya atau
 * dipindahkan ke mana saja di server Anda.
 */
$application_folder = 'application';

/*
 *---------------------------------------------------------------
 * NAMA DIREKTORI VIEW
 *---------------------------------------------------------------
 *
 * Jika Anda ingin memindahkan direktori view keluar dari direktori aplikasi,
 * tetapkan path-nya di sini.
 */
$view_folder = '';

/*
 * --------------------------------------------------------------------
 * KONTROLER DEFAULT
 * --------------------------------------------------------------------
 *
 * Biasanya Anda akan menetapkan kontroler default di file routes.php.
 * Namun, Anda dapat memaksa pengaturan routing kustom dengan menulis
 * nama kelas/fungsi kontroler tertentu di sini.
 */

/*
 * ---------------------------------------------------------------
 *  Tetapkan path sistem untuk meningkatkan keandalan
 * ---------------------------------------------------------------
 */
if (defined('STDIN'))
{
    chdir(dirname(__FILE__));
}

if (($_temp = realpath($system_path)) !== FALSE)
{
    $system_path = $_temp . DIRECTORY_SEPARATOR;
}
else
{
    $system_path = rtrim($system_path, '/\\') . DIRECTORY_SEPARATOR;
}

// Periksa apakah path sistem benar
if (!is_dir($system_path))
{
    header('HTTP/1.1 503 Service Unavailable.', TRUE, 503);
    echo 'Path folder sistem Anda tidak tampak diatur dengan benar.';
    exit(3); // EXIT_CONFIG
}

/*
 * ---------------------------------------------------------------
 *  Sekarang setelah kita mengetahui path-nya, tetapkan konstanta path utama
 * ---------------------------------------------------------------
 */
define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));
define('BASEPATH', $system_path);
define('FCPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('SYSDIR', basename(BASEPATH));
define('APPPATH', realpath($application_folder) . DIRECTORY_SEPARATOR);
define('VIEWPATH', APPPATH . 'views' . DIRECTORY_SEPARATOR);

/*
 * --------------------------------------------------------------------
 * MEMUAT FILE BOOTSTRAP
 * --------------------------------------------------------------------
 *
 * Dan mari kita mulai...
 */
require_once BASEPATH . 'core/CodeIgniter.php';
