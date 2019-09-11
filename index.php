<?php
$access_token = 'gdfWCjyBwS+xb/EusK4cvcTATrcIgs1bK6kkU1cx/Bhi3Tta9n08ZPt/tFPS7iWFLIWMxLYckZaGVeXnrpOCxnK/5FkG+Vp6tadAk2DBLE29Ej0VrSgDFuHiOM16Qf2N2TPGvEu3iXHdOt62LUqLAAdB04t89/1O/w1cDnyilFU=';
$host = "ec2-107-22-211-182.compute-1.amazonaws.com";
$user = "mmdkvvqziulstc";
$pass = "e10240d71df70c411f5201bc37491e9091491ff276b8d8b66f8e507ea5b7dc22";
$db = "dcv361109jo6fh";
date_default_timezone_set("Asia/Bangkok");
$date = date("Y-m-d");
function showtime($time)
{
	$date = date("Y-m-d");
	$h = split(":", $time);
	if ($h[1] < 15)
	{
		$h[1] = "00";
		$selectbydate = "select * from weatherstation where \"DATETIME\" BETWEEN '$date $h[0]:0:00' and '$date $h[0]:15:00' order by \"DATETIME\" desc limit 1";
	}
	else
	if ($h[1] >= 15 && $h[1] < 30)
	{
		$h[1] = "15";
		$selectbydate = "select * from weatherstation where \"DATETIME\" BETWEEN '$date $h[0]:15:01' and '$date $h[0]:30:00' order by \"DATETIME\" desc limit 1";
	}
	else
	if ($h[1] >= 30 && $h[1] < 45)
	{
		$h[1] = "30";
		$selectbydate = "select * from weatherstation where \"DATETIME\" BETWEEN '$date $h[0]:30:01' and '$date $h[0]:45:00' order by \"DATETIME\" desc limit 1";
	}
	else
	if ($h[1] >= 45)
	{
		$h[1] = "45";
		$selectbydate = "select * from weatherstation where \"DATETIME\" BETWEEN '$date $h[0]:45:01' and '$date $h[0]:59:59' order by \"DATETIME\" desc limit 1";
	}
	
	return array(
		$h[0] . ":" . $h[1],
		$selectbydate
	);
}
// database
$dbconn = pg_connect("host=" . $GLOBALS['host'] . " port=5432 dbname=" . $GLOBALS['db'] . " user=" . $GLOBALS['user'] . " password=" . $GLOBALS['pass']) or die('Could not connect: ' . pg_last_error());
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
$Light = file_get_contents('https://api.thingspeak.com/channels/331361/fields/3/last.txt');
$water = file_get_contents('https://api.thingspeak.com/channels/331361/fields/4/last.txt');
$HUM = file_get_contents('https://api.thingspeak.com/channels/331361/fields/2/last.txt');
$TEM = file_get_contents('https://api.thingspeak.com/channels/331361/fields/1/last.txt');
$aba = ('https://i.imgur.com//yuRTcoH.jpg');
// convert
$sqlgetlastrecord = "select * from weatherstation order by \"DATETIME\" desc limit 1";
if (!is_null($events['events']))
{
	// Loop through each event
	foreach($events['events'] as $event)
	{
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text')
		{
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			// Build message to reply back
			$messages = ['type' => 'text', 'text' => "ยินดีต้อนรับคุณเข้าสูู่ แอปของเรา."."\n". "กรุณาพิมพ์ [H] เพื่อดูเมนูนะครับ 😊😊😊"."\n". "# ติดต่อAdminได้ที่https://www.facebook.com/AppCALWCH/"
			// "text"
			];
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "H")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้"."\n"."\n"."[1] เว็บไซต์ทางการของการยางแห่งประเทศไทย"."\n"."[2] ข้อมูลข่าวสารเกี่ยวกับยางพารา" . "\n"."[3] ราคาปุ๋ยที่มีวางจำหน่ายในสหกรณ์การเกษตรจังหวัดตรัง" ."\n"."[4] ราคายาง" . "\n" . "[5] ราคาของปุ๋ยยางพาราที่ถูกที่สุดในช่วงอายุต่างๆ" . "\n"  . "[6] วิธีการผสมปุ๋ยใช้เอง"."\n"."[7] ตารางคำนวณสูตรปุ๋ยเคมียางพารา"."\n"."[8] ตารางคำนวณสูตรปุ๋ยอินทรีย์ยางพารา"."\n". "[9] ข้อมูลสภาพอากาศจากกรมอุตุนิยมวิทยา"."\n". "[10] กราฟกำหนดการเชิงเส้นแสดงต้นทุนที่ต่ำที่สุดของการใส่ปุ๋ยอินทรีย์ควบคู่กับปุ๋ยเคมี"."\n". "[11] แผนภูมิแท่งแสดงการเปรียบเทียบราคาของปุ๋ยเคมี ปุ๋ยผสม และปุ๋ยอินทรย์"."\n". "[M] เพื่อแสดงสถานที่ตั้งของหน่วยงานทางการเกษตร"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "4"){
				
				$messages = ['type' => 'text', 'text' => "ราคายางวันนี้ : " . "ข้อมูลจากการยางแห่งประเทศไทย" .  "\n" . "http://www.rubber.co.th/rubber2012/menu5.php"  .  "\n" . "[H] เพื่อดูเมนู"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "1"){
				
				$messages = ['type' => 'text', 'text' => "เว็บไซต์ทางการของการยางแห่งประเทศไทย " .  "\n" . "http://www.raot.co.th/main.php?filename=index." . "\n" . "[H] เพื่อดูเมนู"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "6"){
				
				$messages = ['type' => 'text', 'text' => "วิธีการผสมปุ๋ยใช้เอง : " . "ขอขอบคุณสำหรับข้อมูลจาก NanaGarden" .  "\n" . "https://www.nanagarden.com/topic/3829."  .  "\n" . "[H] เพื่อดูเมนู"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "3"){
				
				$messages = ['type' => 'text', 'text' => "ราคาปุ๋ย" .  "\n" . "https://docs.google.com/document/d/1CJaSBeO7fPn5N9c0lXvK2z7MOp6qqiL-WqSRVJ24dAg/edit."  .  "\n" . "[H] เพื่อดูเมนู"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "2"){
				
				$messages = ['type' => 'text', 'text' => "ดูข้อมูลข่าวสารเกี่ยวกับยางพารา"  .  "\n" . "http://www.raot.co.th/more_news.php?cid=10&filename=index/."  .  "\n" . "[H] เพื่อดูเมนู"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "7"){
				
				$messages = ['type' => 'text', 'text' => "ตารางคำนวณแม่ปุ๋ยเพื่อนำมาผสมใช้เอง" ."\n" . "คำนวณหาแม่ปุ๋ยมาผสมทำปุ๋ยโดยใช้ Microsoft Excel" .  "\n" ."\n" . "ตารางคำนวณแม่ปุ๋ยที่ต้องใช้ผสมสำหรับต้นยางพาราอายุ 1-2 ปี" . "\n" . "https://docs.google.com/spreadsheets/d/1yxyKW8J8k6Hdlef9rYIQ7JTLuCBkWy-OpdX2qwcgAOI/edit?usp=sharing" . "\n" . "ตารางคำนวณหาแม่ปุ๋ยที่ต้องใช้ผสมสำหรับต้นยางพาราอายุ 3-6 ปี" . "\n" . "https://docs.google.com/spreadsheets/d/1Q4aMY6mTPNjBixSWrLwJc2_mB-wQRN9JT9WAVRor_Yg/edit?usp=sharing" . "\n" . "ตารางคำนวณหาแม่ปุ๋ยที่ต้องนำมาผสมสำหรับต้นยางพาราอายุ 7-15 ปี" . "\n"  . "https://docs.google.com/spreadsheets/d/1LaqiA_QfwTmdsTpK0e-1zTmz9b_73B_FZyatD1CxaHA/edit?usp=sharing" . "\n" . "ตารางคำนวณหาแม่ปุ๋ยเพื่อนำมาผสมสำหรับต้นยางพาราอายุ 15 ปี ขึ้นไป" . "\n" . "https://docs.google.com/spreadsheets/d/1Isz8tFcyylk-i807Bz0uJOdBsARkvOutCrP47CAnOeI/edit?usp=sharing" . "\n" . "[H] เพื่อดูเมนู"];
			}
			 
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "5"){
				
				$messages = ['type' => 'text', 'text' => "ราคาปุ๋ยใส่ยางพาราที่ถูกที่สุดในช่วงอายุต่างๆ" ."\n" . "คำนวณหาราคาปุ๋ยที่ถุกที่สุดโดยวิธีเปรียบเทียบอัตราส่วน" .  "\n" . "https://docs.google.com/document/d/1xnbQIHYP_yboKn3CEE819JvgdpLwhJVhgp2aACyc-ww/edit"  .  "\n" . "[H] เพื่อดูเมนู"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "สวัสดี"){
				
				$messages = ['type' => 'text', 'text' => "สวัสดีครับ 😄😄😄" ."\n" . "ยินดีต้อนรับคุณเข้าสู่ CAL. "  .  "\n" . "พิมพ์ [H] เพื่อดูเมนูเลยนะครับ 😄😄😄 "];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "Hi"){
				
  				$messages = ['type' => 'text', 'text' => "Hi 😄😄😄" ."\n" . "Welcome to Cal "  .  "\n" . "Print [H] for menu 😄😄😄"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "รัก"){
				
  				$messages = ['type' => 'text', 'text' => "รักเหมือนกัน 😍😍😍" ."\n" . "Welcome to CAL. "  .  "\n" . "click [H] for menu 😄😄😄"];
			}
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "ฝันดี"){
				
  				$messages = ['type' => 'text', 'text' => "นอนหลับฝันดีนะครับ 😍😍😍" ."\n" . "ขอบคุณที่ใช้บริการ. "  .  "\n" . "พิมพ์ [H] เพื่อดูเมนู 😄😄😄"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "ขอบคุณ"){
				
  				$messages = ['type' => 'text', 'text' => "ขอบคุณที่ใช้บริการนะครับ 😍😍😍" ."\n" . "Thanks for Use . "  .  "\n" . "พิมพ์ [H] เพื่อดูเเมนูนู 😄😄😄"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "บาย"){
				
  				$messages = ['type' => 'text', 'text' => "ขอบคุณที่ใช้บริการนะครับ 😍😍😍" ."\n" . "Thanks for Use CAL. "  .  "\n" . "พิมพ์ [H] เพื่อดูเมนู 😄😄😄"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "Thankyou"){
				
  				$messages = ['type' => 'text', 'text' => "Your'e Welcome 😍😍😍" ."\n" . "Thanks for Use CAL. "  .  "\n" . "Print [H] for menu 😄😄😄"];
			}
			
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "Bye"){
				
  				$messages = ['type' => 'text', 'text' => "Bye Bye 😍😍😍" ."\n" . "Thanks for Use CAL. "  .  "\n" . "Print [H] for menu 😄😄😄"];
			}
	                
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "เป็นไงบ้าง"){
				
  				$messages = ['type' => 'text', 'text' => "ฉันสบายดี ขอบคุณ 😍😍😍" ."\n" . "ขอบคุณที่ใช้บริการ. "  .  "\n" . "พิมพ์ [H] เพื่อดู นะครับ😄😄😄"];
			}
	               
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "แตก1"){
				
  				$messages = ['type' => 'text', 'text' => "สวยพี่สวย!!!!!" ."\n" . "ขอบคุณที่ใช้บริการ. " . "\n" . "พิมพ์ [H] เพื่อดูเมนู นะครับ😄😄😄"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "สวยพี่สวย"){
				
  				$messages = ['type' => 'text', 'text' => "แตก1!!!!!" ."\n" . "ขอบคุณที่ใช้บริการ. " . "\n" . "พิมพ์ [H] เพื่อดูเมนู นะครับ😄😄😄"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "8"){
				
				$messages = ['type' => 'text', 'text' => "ตารางคำนวณวัสดุธรมมชาติเพื่อนำมาผสมปุ๋ยอินทรีย์ใช้เอง" ."\n" . "คำนวณหาแม่ปุ๋ยมาผสมทำปุ๋ยโดยใช้ Microsoft Excel" .  "\n" ."\n" . "ตารางคำนวณวัสดุธรรมชาติที่ต้องใช้ผสมสำหรับต้นยางพาราอายุ 1-2 ปี" . "\n" . "https://docs.google.com/spreadsheets/d/1a3Qgu63WHxpMRAsqVUwoNMLoXYa9eFoZBOmZ5Oi1WKY/edit?usp=sharing" . "\n" . "ตารางคำนวณหาวัสดุธรรมชาติที่ต้องใช้ผสมสำหรับต้นยางพาราอายุ 3-6 ปี" . "\n" . "https://docs.google.com/spreadsheets/d/10-aPIUTM_T58qTz87_jteDqnXX77ThUyNvoZN3ScVlE/edit?usp=sharing" . "\n" . "ตารางคำนวณหาวัสดุธรรมชาติที่ต้องนำมาผสมสำหรับต้นยางพาราอายุ 7-15 ปี" . "\n"  . "https://docs.google.com/spreadsheets/d/1noUErwTSVrSM6Q5SOERBehdDcYAYG4Ax3D4kfB1dobo/edit?usp=sharing" . "\n" . "ตารางคำนวณหาวัสดุธรรมชาติเพื่อนำมาผสมสำหรับต้นยางพาราอายุ 15 ปี ขึ้นไป" . "\n" . "https://docs.google.com/spreadsheets/d/1P4BTIeIR2nBpEtkUv-jK2wU8dalWeGg5gNHUAYRMfmY/edit?usp=sharing" . "\n" . "[H] เพื่อดูเมนู"];
			}
			 
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "9"){
				
  				$messages = ['type' => 'text', 'text' => "https://www.tmd.go.th/daily_forecast.php" ."\n" . "ขอบคุณที่ใช้บริการ. " . "\n" . "พิมพ์ [H] เพื่อดูเมนู นะครับ😄😄😄"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "10")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://www.picz.in.th/images/2018/09/12/fANESe.jpg",
    				'previewImageUrl' => "https://www.picz.in.th/images/2018/09/12/fANESe.jpg"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "11"){
				
  				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้"."\n"."\n"."[12] แผนภูมิแท่งเปรียบเทียบราคาปุ๋ยเคมี ปุ๋ยผสม และปุ๋ยอินทรีย์ อายุ 1-2 ปี"."\n"."[13]แผนภูมิแท่งเปรียบเทียบราคาปุ๋ยเคมี ปุ๋ยผสม และปุ๋ยอินทรีย์ อายุ 3-6 ปี " . "\n"."[14] แผนภูมิแท่งเปรียบเทียบราคาปุ๋ยเคมี ปุ๋ยผสม และปุ๋ยอินทรีย์ อายุ 7-15 ปี" ."\n"."[15]แผนภูมิแท่งเปรียบเทียบราคาปุ๋ยเคมี ปุ๋ยผสม และปุ๋ยอินทรีย์ อายุ 15 ปี ขึ้นไป"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "12")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://sv1.picz.in.th/images/2018/12/21/9w3PG1.png",
    				'previewImageUrl' => "https://sv1.picz.in.th/images/2018/12/21/9w3PG1.png"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "13")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://sv1.picz.in.th/images/2018/12/21/9w3pG8.png",
    				'previewImageUrl' => "https://sv1.picz.in.th/images/2018/12/21/9w3pG8.png"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "14")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://sv1.picz.in.th/images/2018/12/21/9w3LHu.png",
    				'previewImageUrl' => "https://sv1.picz.in.th/images/2018/12/21/9w3LHu.png"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "15")
			{
				$messages = [
				'type' => 'image',
				'originalContentUrl' => "https://sv1.picz.in.th/images/2018/12/21/9w3ygI.png",
    				'previewImageUrl' => "https://sv1.picz.in.th/images/2018/12/21/9w3ygI.png"];
			}
			// Message Event = TextMessage
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "112")
			{
				$messages = [
				'type' => 'video',
				'originalContentUrl' => "https://youtu.be/iByxlVvWrww",
    				'previewImageUrl' => "https://media.giphy.com/media/MuC9gjT2pE1XQDW8PH/giphy.gif"];
			}
			
			
			
			//Begincase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "M")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้"."\n"."\n"."[16] สถานที่ราชการสำหรับเกษตรกรในอำเภอเมืองตรัง"."\n"."[17] สถานที่ราชการสำหรับเกษตรกรในอำเภอย่านตาขาว" . "\n"."[18] สถานที่ราชการสำหรับเกษตรกรในอำเภอปะเหลียน" ."\n"."[19] สถานที่ราชการสำหรับเกษตรกรในกิ่งอำเภอหาดสำราญ" . "\n" . "[20] สถานที่ราชการสำหรับเกษตรกรในอำเภอสิเกา" . "\n"  . "[21] สถานที่ราชการสำหรับเกษตรกรในอำเภอกันตัง"."\n"."[22] สถานที่ราชการสำหรับเกษตรกรในอำเภอห้วยยอด"."\n"."[23] สถานที่ราชการสำหรับเกษตรกรในอำเภอรัษฎา"."\n". "[24] สถานที่ราชการสำหรับเกษตรกรในอำเภอวังวิเศษ"."\n". "[25] สถานที่ราชการสำหรับเกษตรกรในอำเภอนาโยง"."\n". "# ติดต่อAdminได้ที่https://www.facebook.com/AppCALWCH/"];
			}
			
			//อำเภอเมือง
			//Begincase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "16")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้เพื่อหาที่ตั้งของสถานที่"."\n"."\n"."[A1] สหกรณ์การเกษตร(สังข์วิทย์)"."\n"."[A2] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขาตรัง(ข้างสนามกีฬา) " . "\n"."[A3] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขารักษ์จันทร์ " ."\n"."[A4] การยางแห่งประเทศไทยจังหวัดตรัง " . "\n" . "[A5] ตลาดประมูลยางท้องถิ่นจังหวัดตรัง" . "\n"  . "[A6] สหกรณ์กองทุนสวนยางอำเภอเมืองตรัง จำกัด"."\n"."[A7] สหกรณ์กองทุนสวนยางบ้านไร่พรุ จำกัด"."\n"."[A8] สำนักงานเกษตรอำเภอเมืองตรัง"."\n". "[A9] สำนักงานเกษตรจังหวัดตรัง"."\n". "[A10] สำนักงานพัฒนาที่ดินตรัง"."\n". "# ติดต่อAdminได้ที่https://www.facebook.com/AppCALWCH/"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "A1")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สหกรณ์การเกษตร(สังข์วิทย์)',
				'latitude'=> 7.567327,'longitude'=> 99.609301];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "A2")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรจังหวัดตรัง(ข้างสนามกีฬา)',
				'latitude'=> 7.552412,'longitude'=> 99.614273];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "A3")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขารักษ์จันทร์',
				'latitude'=> 7.570532,'longitude'=> 99.615006];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "A4")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'การยางแห่งประเทศไทยจังหวัดตรัง',
				'latitude'=> 7.573122,'longitude'=> 99.616667];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "A5")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ตลาดประมูลยางท้องถิ่นจังหวัดตรัง',
				'latitude'=> 7.573195,'longitude'=> 99.616171];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "A6")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สหกรณ์กองทุนสวนยางอำเภอเมืองตรัง จำกัด',
				'latitude'=> 7.506532,'longitude'=> 99.639957];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "A7")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สหกรณ์กองทุนสวนยางบ้านไร่พรุ จำกัด',
				'latitude'=> 7.567024,'longitude'=> 99.598008];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "A8")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สำนักงานเกษตรอำเภอเมืองตรัง',
				'latitude'=> 7.561105,'longitude'=> 99.606446];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "A9")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สำนักงานเกษตรจังหวัดตรัง',
				'latitude'=> 7.560295,'longitude'=> 99.606944];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "A10")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สำนักงานพัฒนาที่ดินจังหวัดตรัง',
				'latitude'=> 7.515290,'longitude'=> 99.642318];
			}
			
			//อำเภอย่านตาขาว
			//Begincase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "17")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้เพื่อหาที่ตั้งของสถานที่"."\n"."\n"."[B1] สหกรณ์การเกษตรย่านตาขาว"."\n"."[B2] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขาย่านตาขาว " . "\n"."[B3] การยางแห่งประทศไทยย่านตาขาว " ."\n"."[B4] สำนักงานเกษตรอำเภอย่านตาขาว "."\n". "# ติดต่อAdminได้ที่https://www.facebook.com/AppCALWCH/"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "B1")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สหกรณ์การเกษตรย่านตาขาว',
				'latitude'=> 7.378438,'longitude'=> 99.674736];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "B2")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขาย่านตาขาว',
				'latitude'=> 7.382990,'longitude'=> 99.670465];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "B3")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'การยางแห่งประเทศไทยย่านตาขาว',
				'latitude'=> 7.380874,'longitude'=> 99.673080];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "B4")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สำนักงานเกษตรอำเภอย่านตาขาว',
				'latitude'=> 7.385643,'longitude'=> 99.667429];
			}
			
			//อำเภอปะเหลียน
			//Begincase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "18")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้เพื่อหาที่ตั้งของสถานที่"."\n"."\n"."[C1] สหกรณ์การเกษตรปะเหลียน"."\n"."[C2] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขาทุ่งยาว " . "\n"."[C3] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรปะเหลียน(ถนนท่าพญา) " ."\n"."[C4] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขาหาดเลา "."\n"."[C5] ศูนย์วิจัยพัฒนาการเกษตร"."\n". "# ติดต่อAdminได้ที่https://www.facebook.com/AppCALWCH/"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "C1")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สหกรณ์การเกษตรปะเหลียน',
				'latitude'=> 7.317135,'longitude'=> 99.673357];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "C2")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขาทุ่งยาว',
				'latitude'=> 7.215304,'longitude'=> 99.734238];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "C3")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรปะเหลียน(ถนนท่าพญา)',
				'latitude'=> 7.208606,'longitude'=> 99.71596];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "C4")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขาหาดเลา',
				'latitude'=> 7.209142,'longitude'=> 99.725595];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "C5")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ศูนย์วิจัยและพัฒนาการเกษตร',
				'latitude'=> 7.255046,'longitude'=> 99.728389];
			}
			
			//กิ่งอำเภอหาดสำราญ
			//Begincase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "19")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้เพื่อหาที่ตั้งของสถานที่"."\n"."\n"."[D1] สหกรณ์การเกษตรหาดสำราญ"."\n"."[D2] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขาหาดสำราญ"."\n". "# ติดต่อAdminได้ที่https://www.facebook.com/AppCALWCH/"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "D1")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สหกรณ์การเกษตรหาดสำราญ',
				'latitude'=> 7.301512,'longitude'=> 99.582468];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "D2")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขาหาดสำราญ',
				'latitude'=> 7.237284,'longitude'=> 99.580519];
			}
			
			//อำเภอสิเกา
			//Begincase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "20")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้เพื่อหาที่ตั้งของสถานที่"."\n"."\n"."[E1] สหกรณ์การเกษตรอุตสาหกรรมตรัง จำกัด"."\n"."[E2] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขาสิเกา " . "\n"."[E3] สำนักงานเกษตรสิเกา"."\n"."[E4] การยางแห่งประทศไทยสิเกา"."\n". "# ติดต่อAdminได้ที่https://www.facebook.com/AppCALWCH/"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "E1")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สหกรณ์การเกษตรอุตสาหกรรมตรัง จำกัด',
				'latitude'=> 7.660943,'longitude'=> 99.321386];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "E2")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขาสิเกา',
				'latitude'=> 7.575900,'longitude'=> 99.345123];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "E3")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สำนักงานเกษตรสิเกา',
				'latitude'=> 7.575910,'longitude'=> 99.345123];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "E4")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'การยางแห่งประเทศไทยสิเกา',
				'latitude'=> 7.559956,'longitude'=> 99.356703];
			}
			
			//อำเภอกันตัง
			//Begincase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "21")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้เพื่อหาที่ตั้งของสถานที่"."\n"."\n"."[E1] สหกรณ์การเกษตรกันตัง"."\n"."[E2] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขากันตัง " . "\n"."[E3] สำนักงานเกษตรกันตัง"."\n"."[E4] การยางแห่งประทศไทยกันตัง"."\n". "# ติดต่อAdminได้ที่https://www.facebook.com/AppCALWCH/"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "F1")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สหกรณ์การเกษตรกันตัง',
				'latitude'=> 7.409614,'longitude'=> 99.522701];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "F2")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขากันตัง',
				'latitude'=> 7.405768,'longitude'=> 99.514252];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "F3")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สำนักงานเกษตรกันตัง',
				'latitude'=> 7.406287,'longitude'=> 99.517293];
			}
			
			//อำเภอห้วยยอด
			//Begincase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "22")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้เพื่อหาที่ตั้งของสถานที่"."\n"."\n"."[G1] สหกรณ์การเกษตรห้วยยอด"."\n"."[G2] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขาห้วยยอด" . "\n"."[G3] สำนักงานเกษตรห้วยยอด"."\n". "# ติดต่อAdminได้ที่https://www.facebook.com/AppCALWCH/"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "G1")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สหกรณ์การเกษตรห้วยยอด',
				'latitude'=> 7.791373,'longitude'=> 99.632112];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "G2")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรห้วยยอด',
				'latitude'=> 7.787514,'longitude'=> 99.634194];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "G3")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สำนักงานเกษตรห้วยยอด',
				'latitude'=> 7.789247,'longitude'=> 99.634492];
			}
			
			//อำเภอรัษฎา
			//Begincase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "23")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้เพื่อหาที่ตั้งของสถานที่"."\n"."\n"."[H1] สหกรณ์การเกษตรห้วยยอด"."\n"."[H2] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขาห้วยยอด" . "\n". "# ติดต่อAdminได้ที่https://www.facebook.com/AppCALWCH/"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "H1")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สหกรณ์การเกษตรรัษฎา',
				'latitude'=> 7.989861,'longitude'=> 99.624247];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "H2")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรรัษฎา',
				'latitude'=> 7.993617,'longitude'=> 99.639711];
			}
			
			//อำเภอวังวิเศษ
			//Begincase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "24")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้เพื่อหาที่ตั้งของสถานที่"."\n"."\n"."[I1] สหกรณ์การเกษตรวังวิเศษ"."\n"."[I2] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขาวังวิเศษ" . "\n"."[I3] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรเขาวิเศษ"."\n"."[I4] สำนักงานการเกษตรวังวิเศษ"."\n"."# ติดต่อAdminได้ที่https://www.facebook.com/AppCALWCH/"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "I1")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สหกรณ์การเกษตรวังวิเศษ',
				'latitude'=> 7.663932,'longitude'=> 99.466577];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "I2")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรวังวิเศษ',
				'latitude'=> 7.789488,'longitude'=> 99.389498];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "I3")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรเขาวิเศษ',
				'latitude'=> 7.671692,'longitude'=> 99.459045];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "I4")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สำนักงานเกษตรวังวิเศษ',
				'latitude'=> 7.736584,'longitude'=> 99.393910];
			}
			
			//อำเภอนาโยง
			//Begincase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "25")
			{
				$messages = ['type' => 'text', 'text' => "พิมพ์ตัวอักษรตามที่กำหนดให้เพื่อหาที่ตั้งของสถานที่"."\n"."\n"."[J1] สหกรณ์การเกษตรนาโยง"."\n"."[J2] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรสาขานาโยง(ข้างเทศบาล)" . "\n"."[J3] ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรเขาวิเศษ"."\n"."[J4] สำนักงานการเกษตรนาโยง"."\n"."# ติดต่อAdminได้ที่https://www.facebook.com/AppCALWCH/"];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "J1")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สหกรณ์การเกษตรนาโยง',
				'latitude'=> 7.663932,'longitude'=> 99.466577];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "J2")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตรนาโยง(ข้างเทศบาล)',
				'latitude'=> 7.563779,'longitude'=> 99.693733];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "J3")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'ธนาคารเพื่อการเกษตรและสหกรณ์การเกษตร(ข้างเค้กสายใจ)',
				'latitude'=> 7.562332,'longitude'=> 99.703271];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "J4")
			{
				$messages = ['type' => 'location','title'=> "location",'address'=> 'สำนักงานเกษตรนาโยง',
				'latitude'=> 7.562006,'longitude'=> 99.695762];
			}
			
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "111")
			{
				$messages = ['type' => 'text', 'text' => "https://docs.google.com/spreadsheets/d/1HKA610ClbB0WvbL24hVPY5J3llwyoTYj0ShoLDFefsQ/edit?usp=sharing"];
			}
				
			//BeginCase
			if (ereg_replace('[[:space:]]+', '', trim($text)) == "0609"){
				
  				$messages = ['type' => 'text', 'text' => "ปริมาตร"];
			}
			
			
			//EndCase
			if (trim(strtoupper($text)) == "a")
			{
				$messages = ['type' => 'text', 'text' => "a"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "a")
			{
				$messages = [
				'type' => 'text',
				'text' => "https://drive.google.com/open?id=14rP9TkpqLo3UwBcUzOu5zeoWu2tMp9eR"];
			}
			if (trim(strtoupper($text)) == "a")
			{
				$messages = ['type' => 'text', 'text' => "https://drive.google.com/open?id=14rP9TkpqLo3UwBcUzOu5zeoWu2tMp9eR"];
			}
			if ($text == "รูป")
			{
				$messages = ['type' => 'image', 'originalContentUrl' => "https://sv6.postjung.com/picpost/data/184/184340-1-2995.jpg", 'previewImageUrl' => "https://sv6.postjung.com/picpost/data/184/184340-1-2995.jpg"];
			}
			if (ereg_replace('[[:space:]]+', '', strtoupper($text)) == "info")
			{
				$messages = ['type' => 'text', 'text' => "ยางพาราเป็นพืชเศรฐกิจไทย" ."\n"."อ่านเพิ่มเติม: https://th.wikipedia.org/wiki/%E0%B8%A2%E0%B8%B2%E0%B8%87%E0%B8%9E%E0%B8%B2%E0%B8%A3%E0%B8%B2"];
			}
				
			if ( ereg_replace('[[:space:]]+', '', trim($text)) == "O")
			{
				$rs = pg_query($dbconn, $sqlgetlastrecord) or die("Cannot execute query: $query\n");
				$templink = "";
				while ($row = pg_fetch_row($rs))
				{
					$templink = $row[1];
				}
				$messages = ['type' => 'image', 'originalContentUrl' => $templink, 'previewImageUrl' => $templink];
			}
			$textSplited = split(" ", $text);
			if ( ereg_replace('[[:space:]]+', '', trim($textSplited[0])) == "O")
			{
				$dataFromshowtime = showtime($textSplited[1]);
				$rs = pg_query($dbconn, $dataFromshowtime[1]) or die("Cannot execute query: $query\n");
				$templink = ""; 
				$qcount=0;
				while ($row = pg_fetch_row($rs))
				{
					$templink = $row[1];
					$qcount++;
				}
				//$messages = ['type' => 'text', 'text' => "HI $dataFromshowtime[0] \n$dataFromshowtime[1] \n$templink"
				if ($qcount > 0){
				$messages = [
				'type' => 'image',
				'originalContentUrl' => $templink,
					'previewImageUrl' => $templink
				];}
				else {
					$messages = [
						'type' => 'image',
						'originalContentUrl' => "https://imgur.com/aOWIijh.jpg",
							'previewImageUrl' => "https://imgur.com/aOWIijh.jpg" 
		
						];
				}
			}
			if ($text == "O")
			{
				$rs = pg_query($dbconn, $sqlgetlastrecord) or die("Cannot execute query: $query\n");
				$templink = "";
				while ($row = pg_fetch_row($rs))
				{
					$templink = $row[1];
				}
				$messages = ['type' => 'image', 'originalContentUrl' => $templink, 'previewImageUrl' => $templink];
			}
			
			/*if($text == "image"){
			$messages = [
			$img_url = "http://sand.96.lt/images/q.jpg";
			$outputText = new LINE\LINEBot\MessageBuilder\ImageMessageBuilder($img_url, $img_url);
			$response = $bot->replyMessage($event->getReplyToken(), $outputText);
			];
			}*/
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = ['replyToken' => $replyToken, 'messages' => [$messages], ];
			$post = json_encode($data);
			$headers = array(
				'Content-Type: application/json',
				'Authorization: Bearer ' . $access_token
			);
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);
			echo $result . "\r\n";
		}
	}
}
echo "OK";
echo $date;
