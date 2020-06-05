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
    $sql = "SELECT (@row_number:=@row_number + 1) AS row_num, ID, UYE_ADI, UYE_SOYADI, UYE_EPOSTA, UYE_SIFRE, UYE_YETKI, 
	UYE_CINSIYET, UYE_DOGUMTARIHI, UYE_SABITTEL, UYE_CEPTEL, UYE_USERNAME FROM UYELER, (SELECT @row_number:=0) AS t ORDER BY ID desc";
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
				"UYE_USERNAME"			=> $company['UYE_USERNAME'],
				"UYE_ADI"				=> $company['UYE_ADI'],
				"UYE_SOYADI"			=> $company['UYE_SOYADI'],
				"UYE_EPOSTA"			=> $company['UYE_EPOSTA'],
				"UYE_SIFRE"				=> $company['UYE_SIFRE'],
				"UYE_CINSIYET"			=> $company['UYE_CINSIYET'],
				"UYE_DOGUMTARIHI"		=> $company['UYE_DOGUMTARIHI'],
				"UYE_SABITTEL"			=> $company['UYE_SABITTEL'],
				"UYE_CEPTEL"			=> $company['UYE_CEPTEL'],
				"UYE_YETKI"			=> $company['UYE_YETKI'],

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
