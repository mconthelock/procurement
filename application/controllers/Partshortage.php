<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partshortage extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		//$this->load->model('Partshortage_model');

	}

	public function index()
	{
		$data['title'] = 'Part Shortage';
		// 1. เรียกไฟล์ CSS ภายนอก (ใส่ URL เข้าไปใน Array)
		$data['custom_css'] = array(
			base_url('assets/style/partshortage/partshortage.css'),
		);
		$this->views('Partshortage/index', $data);
	}

	public function testphpcallapi()
	{
		echo $_ENV['STATE'] . "<br>";
		if ($_ENV['STATE'] === 'local') {
			$apiUrl = sprintf('%s/shortage/headerprod', $_ENV['APP_PHPTOAPI_LOCAL']);
		} else {
			echo "Environment is not local. Skipping API call.<br>";
			return;
		}
		echo "php call api node -->" . $apiUrl;
		$ch = curl_init($apiUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100); // ป้องกันมันค้างนานเกินไป
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4); // บังคับใช้ IPv4 แก้ปัญหา localhost
		// 🌟 เพิ่มบรรทัดนี้เพื่อบอก cURL ว่าห้ามใช้ Proxy สำหรับ Request นี้เด็ดขาด 🌟
		curl_setopt($ch, CURLOPT_PROXY, '');
		$resp = curl_exec($ch);
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); // ดึง Status Code มาดูด้วย
		if ($resp === false) {
			// กรณีที่ cURL ทำงานผิดพลาด (เช่น ติดต่อเซิร์ฟเวอร์ไม่ได้)
			$error_msg = curl_error($ch);
			printf("cURL error: %s\n", $error_msg);
			// อาจจะเก็บ Log หรือแจ้งเตือน Error ตรงนี้
		} else {
			// ทำงานสำเร็จ แปลงข้อมูล
			echo "<h1>HTTP Status: " . $httpCode . "</h1>";
			echo "<h2>Raw Response (ข้อมูลดิบที่ได้จาก API):</h2>";
			// ใช้ htmlspecialchars ป้องกันกรณีที่ API พ่นกลับมาเป็นหน้าเว็บ HTML (เช่น Error 404/502)
			echo "<div style='border:1px solid red; padding:10px;'>";
			echo "<pre>" . htmlspecialchars($resp) . "</pre>";
			echo "</div>";
			$data['shortageHeaderProdData'] = json_decode($resp, true);

			// เช็กว่า json_decode พังเพราะอะไร
			if ($data['shortageHeaderProdData'] === null) {
				echo "<h2>สาเหตุที่ JSON แปลงไม่ได้:</h2>";
				echo json_last_error_msg();
			}
			// ดึงตัวแปรมาเก็บไว้ให้เรียกง่ายขึ้น
			$apiResult = $data['shortageHeaderProdData'];
			// 1. ตรวจสอบสถานะก่อนทำงานต่อ
			if (isset($apiResult['status']) && $apiResult['status'] === 'success') {
				echo "<h3>ดึงข้อมูลสำเร็จ! จำนวนทั้งหมด: " . $apiResult['total_rows'] . " รายการ</h3>";

				// 2. วนลูปดึงข้อมูลในอาร์เรย์ 'header'
				if (!empty($apiResult['header'])) {
					echo "<ul>";
					foreach ($apiResult['header'] as $row) {
						// เรียกใช้ชื่อคีย์ให้ตรงกับที่ API พ่นออกมา
						$n5 = $row['SCHDMFG_N5'];
						$n4 = $row['SCHDMFG_N4'];
						$n3 = $row['SCHDMFG_N3'];
						$n2 = $row['SCHDMFG_N2'];

						echo "<li>N5: {$n5} | N4: {$n4} | N3: {$n3} | N2: {$n2}</li>";
					}
					echo "</ul>";
				}
			} else {
				echo "API ตอบกลับมาแต่สถานะไม่สำเร็จ หรือไม่มีข้อมูล";
			}
		}
	}
	/*public function create()
	{
		$data['title'] = 'Add Part Shortage';
		$this->load->view('partshortage/create', $data);
	}*/

	/*public function store()
	{
		if ($this->Partshortage_model->insert($_POST))
		{
			$this->session->set_flashdata('message', 'Part shortage added successfully');
			redirect('partshortage');
		}
		else
		{
			$this->session->set_flashdata('error', 'Failed to add part shortage');
			redirect('partshortage/create');
		}
	}*/

	/*public function edit($id)
	{
		$data['title'] = 'Edit Part Shortage';
		$data['shortage'] = $this->Partshortage_model->get($id);
		$this->load->view('partshortage/edit', $data);
	}*/

	/*public function update($id)
	{
		if ($this->Partshortage_model->update($id, $_POST))
		{
			$this->session->set_flashdata('message', 'Part shortage updated successfully');
			redirect('partshortage');
		}
		else
		{
			$this->session->set_flashdata('error', 'Failed to update part shortage');
			redirect('partshortage/edit/' . $id);
		}
	}*/

	/*public function delete($id)
	{
		if ($this->Partshortage_model->delete($id))
		{
			$this->session->set_flashdata('message', 'Part shortage deleted successfully');
		}
		else
		{
			$this->session->set_flashdata('error', 'Failed to delete part shortage');
		}
		redirect('partshortage');
	}*/
}
