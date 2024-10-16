<?php
date_default_timezone_set('Asia/Jakarta');

function format_tanggal($date)
{
	// Mengubah format dari YYYY-MM-DD menjadi objek DateTime
	$datetime = DateTime::createFromFormat('Y-m-d', $date);

	// Memastikan objek DateTime valid
	if ($datetime) {
		// Mendapatkan tanggal dan bulan dalam teks
		$day = $datetime->format('d');
		$month = $datetime->format('F'); // Bulan dalam teks (January, February, dst)
		$year = $datetime->format('Y');

		// Daftar bulan dalam bahasa Indonesia
		$months_id = [
			'January' => 'Januari',
			'February' => 'Februari',
			'March' => 'Maret',
			'April' => 'April',
			'May' => 'Mei',
			'June' => 'Juni',
			'July' => 'Juli',
			'August' => 'Agustus',
			'September' => 'September',
			'October' => 'Oktober',
			'November' => 'November',
			'December' => 'Desember'
		];

		// Mengubah bulan ke bahasa Indonesia
		$month_id = $months_id[$month] ?? $month;

		// Mengembalikan format yang diinginkan
		return "$day $month_id $year";
	}

	return null; // Jika tanggal tidak valid
}

function tgl_indonesia($date)
{
	/* array hari dan bulan */
	$nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");

	$nama_bulan = array(
		"Januari",
		"Februari",
		"Maret",
		"April",
		"Mei",
		"Juni",
		"Juli",
		"Agustus",
		"September",
		"Oktober",
		"November",
		"Desember"
	);

	/*  Memisahkan format tanggal, bulan, tahun dengan substring */
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tanggal = substr($date, 8, 2);
	$waktu = substr($date, 11, 5);

	//w Urutan hari dalam seminggu
	$hari = date("w", strtotime($date));

	$result = $nama_hari[$hari] . ", " . $tanggal . " " . $nama_bulan[(int) $bulan - 1] . " " . $tahun . " " . $waktu . " WIB";
	//keterangan (int)$bulan-1 karena array dimulai dari index ke 0 maka bulan-1
	return $result;
}

function tgl_indonesia_ibl($date)
{
	/* array hari dan bulan */
	$nama_hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");

	$nama_bulan = array(
		"Januari",
		"Februari",
		"Maret",
		"April",
		"Mei",
		"Juni",
		"Juli",
		"Agustus",
		"September",
		"Oktober",
		"November",
		"Desember"
	);

	/*  Memisahkan format tanggal, bulan, tahun dengan substring */
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tanggal = substr($date, 8, 2);
	$waktu = substr($date, 11, 5);

	//w Urutan hari dalam seminggu
	$hari = date("w", strtotime($date));

	$result = $nama_hari[$hari] . ", " . $tanggal . " " . $nama_bulan[(int) $bulan - 1] . " " . $tahun . ", Pukul " . $waktu . " WIB";
	//keterangan (int)$bulan-1 karena array dimulai dari index ke 0 maka bulan-1
	return $result;
}

function anti_injection($data)
{
	$filter = stripslashes(strip_tags(htmlspecialchars($data, ENT_QUOTES)));
	return $filter;
}

function slug($s)
{
	$c = array(' ');
	$d = array('-', '/', '\\', ',', '.', '#', ':', ';', '\'', '"', '[', ']', '{', '}', ')', '(', '|', '`', '~', '!', '@', '%', '$', '^', '&', '*', '=', '?', '+');

	$s = str_replace($d, '', $s); // Hilangkan karakter yang telah disebutkan di array $d

	$s = strtolower(str_replace($c, '-', $s)); // Ganti spasi dengan tanda - dan ubah hurufnya menjadi kecil semua
	return $s;
}

/** login codeIgniter menggunakan bycrypt **/

if (!function_exists('get_hash')) {
	function get_hash($PlainPassword)
	{
		$option = [
			'cost' => 5, // proses hash sebanyak: 2^5 = 32x
		];
		return password_hash($PlainPassword, PASSWORD_DEFAULT, $option);
	}
}

if (!function_exists('hash_verified')) {
	function hash_verified($PlainPassword, $HashPassword)
	{
		return password_verify($PlainPassword, $HashPassword) ? true : false;
	}
}

/** login codeIgniter menggunakan bycrypt **/

function show_my_modal($content = '', $data = '')
{
	$_ci = &get_instance();
	if ($content != '') {
		$view_content = $_ci->load->view($content, $data, TRUE);
		return $view_content;
	}
}

function helper_log($tipe = "", $str = "", $id = "", $ip = "")
{
	$CI = &get_instance();
	$CI->load->library('user_agent');

	// parameter
	// $param['log_username']  = $CI->session->userdata('username');
	$param['log_type'] = $tipe;
	$param['log_desc'] = $str;
	$param['log_username'] = $id;
	$param['log_ip'] = $CI->input->ip_address();
	$param['log_os'] = $CI->agent->platform();
	$param['log_browser'] = $CI->agent->browser();

	// $CI->load->library('user_agent');

	// $data['browser'] = $CI->agent->browser();

	// $data['browser_version'] = $CI->agent->version();

	// $data['os'] = $CI->agent->platform();

	// $data['ip_address'] = $CI->input->ip_address();

	//load model log
	$CI->load->model('Mod_log');

	//save to database
	$CI->Mod_log->save_log($param);
}
