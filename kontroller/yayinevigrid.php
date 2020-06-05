<?php
// Database details
include '../connection/baglanti.php';
function gridBaslikOlustur($baslik){	
	$dizi = $baslik;
	foreach ($dizi as $deger)
	{
		echo "<th>".$deger."</th>";
	}
}
	// Get job (and id)
$job = '';
$id  = '';
	
	
	if (isset($_GET['job'])){
  $job = $_GET['job'];
  if ($job == 'get_companies'){
    if (isset($_GET['id'])){
      $id = $_GET['id'];
      if (!is_numeric($id)){
        $id = '';
      }
    }
  } else {
    $job = '';
  }
}
// Diziyi tanýmla
$mysql_data = array();

// Ýþ Geçerli mi, Kontrol et
if ($job != ''){
    // Ýþi Çalýþtýr
  if ($job == 'get_companies'){
    // Get companies
    $sql = "SELECT (@row_number:=@row_number + 1) AS row_num, ID, YAYINEVI_UNVAN, YAYINEVI_ADRES, YAYINEVI_SEHIR, YAYINEVI_ILCE, YAYINEVI_TELEFON1, YAYINEVI_TELEFON2, YAYINEVI_FAKS, YAYINEVI_TICARETSICILNO, YAYINEVI_VERGIDAIRESI, YAYINEVI_EPOSTA, YAYINEVI_WEBADRESI, YAYINEVI_TEMSILCISI, YAYINEVI_ACIKLAMA, OLUSTURAN  FROM YAYINEVLERI, (SELECT @row_number:=0) AS t ORDER BY ID desc";
	if ($pdo->query($sql) == false) {
		$result  = 'error';
		$message = 'query error';
		} else {
			$result  = 'success';
			$message = 'query success';
			$st = $pdo->prepare($sql);
			$st->execute();
			while ($company = $st->fetch(PDO::FETCH_ASSOC)){
				$mysql_data[] = array(
				"row_num"				=> $company['row_num'],
				"ID"					=> $company['ID'],
				"YAYINEVI_UNVAN"			=> $company['YAYINEVI_UNVAN'],
				"YAYINEVI_ADRES"				=> $company['YAYINEVI_ADRES'],
				"YAYINEVI_SEHIR"			=> $company['YAYINEVI_SEHIR'],
				"YAYINEVI_ILCE"			=> $company['YAYINEVI_ILCE'],
				"YAYINEVI_TELEFON1"			=> $company['YAYINEVI_TELEFON1'],
				"YAYINEVI_TELEFON2"			=> $company['YAYINEVI_TELEFON2'],
				"YAYINEVI_FAKS"		=> $company['YAYINEVI_FAKS'],
				"YAYINEVI_TICARETSICILNO"			=> $company['YAYINEVI_TICARETSICILNO'],
				"YAYINEVI_VERGIDAIRESI"			=> $company['YAYINEVI_VERGIDAIRESI'],
				"YAYINEVI_EPOSTA"					=> $company['YAYINEVI_EPOSTA'],
				"YAYINEVI_WEBADRESI"					=> $company['YAYINEVI_WEBADRESI'],
				"YAYINEVI_TEMSILCISI"					=> $company['YAYINEVI_TEMSILCISI'],
				"YAYINEVI_ACIKLAMA"					=> $company['YAYINEVI_ACIKLAMA'],
				
				);
			}
		}
  } 
  $pdo=null;
}
//////geniþ if üstteki { iþaretiyle bitiyor
// Prepare data
$data = array(
  "result"  => $result,
  "message" => $message,
  "data"    => $mysql_data
);
// Convert PHP array to JSON array
$json_data = json_encode($data);
print $json_data;
////////////

?>
