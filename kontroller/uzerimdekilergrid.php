<?php
// Database details
include '../connection/baglanti.php';
include "../sayfalar/sessionkontrol.php";
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
	
	
	/*
	$sql = "SELECT 
 k.ID AS ID, k.KITAP_ADI AS KITAP_ADI, yazarlar.YAZAR_ADI AS YAZAR_ADI, raflar.seri AS RAF_SERI, 
	yayinevleri.YAYINEVI_UNVAN AS YAYINEVI_UNVAN, kategoriler.isim AS KATEGORI, k.KITAP_BASIMYILI AS BASIMYILI, 
	k.KITAP_GIRISTARIHI AS GIRISTARIHI, k.KITAP_BARKOD AS BARKOD, k.OLUSTURAN AS OLUSTURAN, k.KITAP_EDINIM AS EDINIM, uyeler.UYE_USERNAME as BAGISCI, k.KITAP_DURUMU as DURUMU FROM KITAPLAR k
LEFT JOIN yazarlar  ON K.kitap_yazarid=yazarlar.id
LEFT JOIN raflar ON K.kitap_rafid= raflar.id
LEFT JOIN uyeler ON K.kitap_bagisci= uyeler.ID
LEFT JOIN yayinevleri ON K.kitap_basimeviid = yayinevleri.ID
LEFT JOIN kategoriler ON K.kitap_kategoriid = kategoriler.id";
	*/
	
	
	$sn=0;
	$KITAP_KIMDE = $_SESSION['username'];
	
    $sql = "SELECT 
 k.ID AS ID, k.KITAP_ADI AS KITAP_ADI, yazarlar.YAZAR_ADI AS YAZAR_ADI, 
	yayinevleri.YAYINEVI_UNVAN AS YAYINEVI_UNVAN, kategoriler.isim AS KATEGORI,
	uyeler.UYE_USERNAME AS KIMDE FROM KITAPLAR k
LEFT JOIN yazarlar  ON K.kitap_yazarid=yazarlar.id
LEFT JOIN uyeler ON K.KITAP_KIMDE = uyeler.ID
LEFT JOIN yayinevleri ON K.kitap_basimeviid = yayinevleri.ID
LEFT JOIN kategoriler ON K.kitap_kategoriid = kategoriler.id
WHERE UYELER.UYE_USERNAME ='1'";
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
				"row_num"				=> $sn++;
				"ID"					=> $company['ID'],
				"KITAP_ADI"				=> $company['KITAP_ADI'],				
				"YAZAR_ADI"				=> $company['YAZAR_ADI'],	
				"YAYINEVI_UNVAN"		=> $company['YAYINEVI_UNVAN'],	
				"KATEGORI"				=> $company['KATEGORI'],		
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
