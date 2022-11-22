<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fungsi
{
	protected $_ci;

	function __construct()
	{
		$this->_ci = &get_instance();
	}

	function template($content, $data = null)
	{
		$data['_content'] = $this->_ci->load->view($content, $data, true);
		$this->_ci->load->view('layoutbackend.php', $data);
	}

	function rupiah($nominal)
	{
		$rp = number_format($nominal, 0, ',', '.');
		return $rp;
	}

	function tanggal_lap($tanggal)
	{
		$bulan = array(
			1 => 'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$p = explode('/', $tanggal);
		return $p[2] . ' ' . $bulan[(int)$p[1]] . ' ' . $p[0];
	}

	function tanggalindo($tanggal)
	{
		$bulan = array(
			1 => 'Januari',
			'Februari',
			'Maret',
			'April',
			'Mei',
			'Juni',
			'Juli',
			'Agustus',
			'September',
			'Oktober',
			'November',
			'Desember'
		);
		$p = explode('-', $tanggal);
		return $p[2] . ' ' . $bulan[(int)$p[1]] . ' ' . $p[0];
	}

	function PdfGenerator($html, $filename, $paper, $orientation)
	{
		$options = new Dompdf\Options();
		$options->setDefaultFont('courier');
		$options->setIsRemoteEnabled(true);

		$dompdf = new Dompdf\Dompdf();
		$dompdf->setOptions($options);
		$dompdf->loadHtml($html);
		$dompdf->setPaper($paper, $orientation);
		$dompdf->render();
		$dompdf->stream($filename, array('Attachment' => 0));
	}

	function getURL()
	{
		$protocol =  "http://";
		if (
			//straight
			isset($_SERVER['HTTPS']) && in_array($_SERVER['HTTPS'], ['on', 1])
			||
			//proxy forwarding
			isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
		) {
			$protocol = 'https://';
		}

		$domainName = $_SERVER['HTTP_HOST'];
		return $protocol . $domainName;
	}

	function send_bot($username, $pesan, $status)
    {
        $TOKEN = "5515327739:AAE8qwYDkK-4er_XnVgDL6IvL2HIXAVnBqI";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = '-658500033';
        file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=<b>STATUS " . $status . "</b>%0A%0AUsername : <b>" . $username . "</b>%0APesan : <b>" . $pesan . "</b>%0AWaktu Log : <b>" . tgl_indonesia(date('Y-m-d H:i:s')) . "</b>&parse_mode=HTML");
    }

	function send_bot_sekretaris($username, $pesan, $status)
    {
        $TOKEN = "5437463795:AAH8FH3vypB_n8p5fdVKVI2y6SrEUJF6WO0";
        $apiURL = "https://api.telegram.org/bot$TOKEN";
        $update = json_decode(file_get_contents("php://input"), TRUE);
        $chatID = '-655524015';
        file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID . "&text=<b>STATUS " . $status . "</b>%0A%0AUsername : <b>" . $username . "</b>%0APesan : <b>" . $pesan . "</b>%0AWaktu Log : <b>" . tgl_indonesia(date('Y-m-d H:i:s')) . "</b>&parse_mode=HTML");
    }
}
