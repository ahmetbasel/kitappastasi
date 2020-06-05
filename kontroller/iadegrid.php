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
    
	
	//$sql = "SELECT (@row_number:=@row_number + 1) AS row_num, ID, KITAP_ADI, KITAP_YAZARID, KITAP_RAFID, KITAP_BASIMEVIID, KITAP_KATEGORIID, KITAP_BASIMYILI, KITAP_GIRISTARIHI, KITAP_BARKOD, OLUSTURAN  FROM KITAPLAR, (SELECT @row_number:=0) AS t ORDER BY ID desc";
	$sql = "SELECT 
 k.ID AS ID, k.KITAP_ADI AS KITAP_ADI, yazarlar.YAZAR_ADI AS YAZAR_ADI, raflar.seri AS RAF_SERI, 
	yayinevleri.YAYINEVI_UNVAN AS YAYINEVI_UNVAN, kategoriler.isim AS KATEGORI, k.KITAP_BASIMYILI AS BASIMYILI, 
	k.KITAP_GIRISTARIHI AS GIRISTARIHI, k.KITAP_BARKOD AS BARKOD, k.OLUSTURAN AS OLUSTURAN, k.KITAP_EDINIM AS EDINIM, uyeler.UYE_USERNAME as BAGISCI, k.KITAP_DURUMU as DURUMU, k.KITAP_KIMDE as KITAP_KIMDE FROM KITAPLAR k
LEFT JOIN yazarlar  ON K.kitap_yazarid=yazarlar.id
LEFT JOIN raflar ON K.kitap_rafid= raflar.id
LEFT JOIN uyeler ON K.kitap_bagisci= uyeler.ID
LEFT JOIN yayinevleri ON K.kitap_basimeviid = yayinevleri.ID
LEFT JOIN kategoriler ON K.kitap_kategoriid = kategoriler.id 
WHERE K.kitap_durumu ='BEKLENIYOR'";
	
	
	if ($pdo->query($sql) == false) {
		$result  = 'error';
		$message = 'query error';
		} else {
			$result  = 'success';
			$message = 'query success';
			$st = $pdo->prepare($sql);
			$st->execute();
			$sn=1;
			while ($company = $st->fetch(PDO::FETCH_ASSOC)){
				$mysql_data[] = array(
				"row_num"				=> $sn++,
				"ID"					=> $company['ID'],
				"KITAP_ADI"				=> $company['KITAP_ADI'],
				"KITAP_YAZARID"			=> $company['YAZAR_ADI'],
				"KITAP_RAFID"			=> $company['RAF_SERI'],
				"KITAP_BASIMEVIID"		=> $company['YAYINEVI_UNVAN'],
				"KITAP_KATEGORIID"		=> $company['KATEGORI'],
				"KITAP_BASIMYILI"		=> $company['BASIMYILI'],
				"KITAP_GIRISTARIHI"		=> $company['GIRISTARIHI'],
				"KITAP_BARKOD"			=> $company['BARKOD'],				
				"KITAP_EDINIM"			=> $company['EDINIM'],
				"KITAP_BAGISCI"			=> $company['BAGISCI'],
				"KITAP_DURUMU"			=> $company['DURUMU'],
				"KITAP_KIMDE"			=> $company['KITAP_KIMDE'],
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
