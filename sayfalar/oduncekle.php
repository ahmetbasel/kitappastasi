<?php 
 error_reporting(0);
  session_start(); 
header('Content-type: text/html; charset=utf-8');
include '../connection/baglanti.php';
include '../fonksiyonlar/arayuzfonksiyonlar.php';
include "sessionkontrol.php";



$output = array( "op" => "", "success"=> true, "error_code" => 0, "message" => "","data" => array() );
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
	error_reporting(0);
  if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("getData") ){
     $KITAP_ID = $_REQUEST["id"];
     $sql = "SELECT * FROM KITAPLAR WHERE ID='".$KITAP_ID."' ORDER BY ID asc";
    if ($pdo->query($sql) == false) {
      $result  = 'error';
      $message = 'query error';
    } else {
      $result  = 'success';
      $message = 'query success';
    $st = $pdo->prepare($sql);
    $st->execute();
    $mysql_data = $st->fetch(PDO::FETCH_ASSOC);
    }
  $pdo=null;
  //////geni if üstteki { iþaretiyle bitiyor
  // Prepare data
  $data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
  );
  // Convert PHP array to JSON array
  $json_data = json_encode($data);
  //var_dump($mysql_data);
  print $json_data;
  exit;  
  }  
  
  else if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("getUSER_ADI") ){
     $USER_ADI = $_REQUEST["USER_ADI"];
     $sql = "SELECT * FROM UYELER WHERE UYE_USERNAME = '".$USER_ADI."' ORDER BY ID asc";
    if ($pdo->query($sql) == false) {
      $result  = 'error';
      $message = 'query error';
	  $sorgu= $sql;
    } else {
      $result  = 'success';
      $message = 'query success';
    $st = $pdo->prepare($sql);
    $st->execute();
    $mysql_data = $st->fetch(PDO::FETCH_ASSOC);
	$sorgu= $sql;
    }
  $pdo=null;
  //////geni if üstteki { iþaretiyle bitiyor
  // Prepare data
  $data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data,
	"sorgu"	  => $sorgu
  );
  // Convert PHP array to JSON array
  $json_data = json_encode($data);
  //var_dump($mysql_data);
  print $json_data;
  exit;  
  } 
  
  
  
  else if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("Sil") ){
	 $KITAP_ID = $_REQUEST["ID"];
     $sql = "DELETE FROM KITAPLAR WHERE ID=".$KITAP_ID;
	     if ($pdo->query($sql) == false) {
      $result  = 'error';
      $message = 'query error';
    } else {
      $result  = 'success';
      $message = 'query success';
    $st = $pdo->prepare($sql);
    $st->execute();
    }	
  $pdo=null;
  $data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => null
  );
  $json_data = json_encode($data);
  echo $json_data;
}
else if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("Kaydet") ){
	$KITAP_ID 						= $_REQUEST["ID"];
	$KULLANICI_ADI 					= $_REQUEST["USER_ADI"];
	$USER_ID						= $_REQUEST["USER_ID"];
	$KITAP_YAZARID 					= $_REQUEST["KITAP_YAZARID"];
	$KITAP_BASIMEVIID 				= $_REQUEST["KITAP_BASIMEVIID"];
	$KITAP_RAFID	 				= $_REQUEST["KITAP_RAFID"];
	$KITAP_KATEGORIID 				= $_REQUEST["KITAP_KATEGORIID"];
	$KITAP_BASIMYILI 				= $_REQUEST["KITAP_BASIMYILI"];
	$KITAP_GIRISTARIHI 				= $_REQUEST["KITAP_GIRISTARIHI"];
	$KITAP_BARKOD 					= $_REQUEST["KITAP_BARKOD"];	 
	
	$OLUSTURAN = $_SESSION['username'];
	$ISLEMZAMANI = date("Y-m-d h:i:sa") ;
	$KITAP_ODUNC= "ODUNC";
	$KITAP_BEKLENIYOR = "BEKLENIYOR";
	 if ($KITAP_ID!=null){
	
		$sql = "INSERT INTO ISLEMLER (UYE_ID,KITAP_ID,TARIH,OLUSTURAN,DURUMU) VALUES ('$USER_ID','$KITAP_ID','$ISLEMZAMANI','$OLUSTURAN','$KITAP_ODUNC') ";			
		$sqlupdate = "UPDATE KITAPLAR set KITAP_DURUMU='$KITAP_BEKLENIYOR', KITAP_KIMDE='$USER_ID' WHERE ID=".$KITAP_ID;
		}
else
{
	
}	
		 
		 if ($pdo->query($sql) == false ) {
      $result  = 'error';
      $message = 'query error';
    } else {
		if ( $pdo->query($sqlupdate) == false)
		{
			$result  = 'error';
      $message = 'query error';
		}
		else{
      $result  = 'success';
      $message = 'query success';
		}
    }	
	
  $pdo=null;
  $data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => null
  );
  $json_data = json_encode($data);
  echo $json_data;
}
	
exit;
}

include '../tasarim/menu.php';
include '../tasarim/ustalan.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Kitap Pastası (TM) | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->

  
    <style type="text/css">
  /* altta gecici oluşan frame i gizliyor. */
  #upload_frame{
	display:none;
	height:0;
	width:0;
  }
  #msg{
	background-color:#FFE07E;
	border-radius:5px;
	padding:5px;
	display:none;
	width:200px;
	font:italic 13px/18px arial,sans-serif;
  }
  
  </style>
  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

				  

				  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        
        <small>Ödünç Verme</small>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Ödünç Verme Ekranı</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          <!--Start creating your amazing application!-->
		  
					<div class="col-lg-12">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-xs-12">
									<form id="form1" >	
										<div class="box-header">
											<button type="reset" id="btnYeni" name="Yeni" onclick = "" class="btn btn-primary"><span class="fa fa-file-text-o fa-2x"></span> Yeni</button>
											<button type="button" id="btnKaydet" name="Kaydet"  class="btn btn-warning"><span class="fa fa-save fa-2x"></span> Kaydet</button>
											<button type="button" id="btnSil" name="Sil" onclick = "" class="btn btn-danger hidden"><span class="fa fa-trash-o fa-2x"></span> Sil</button>
										</div>
										<input type="text" name="ID" id="ID" class="form-control hidden"  placeholder="ID"  >
										<input type="text" class="form-control hidden" name="USER_ID" id="USER_ID"   />
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-6"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">Kullanıcı Adı</span></h4>		
													<input type="text" class="form-control" name="USER_ADI" id="USER_ADI" />
													<button type="button" id="btnSorgula" name="Sorgula"  class="btn btn-success"><span class="fa fa-search fa-2x"></span> ÜYE SORGULA</button>
													
												</div>
											</div>
											<div class="col-sm-3" id="divkullaniciara"	>
												<div class="col-sm-3" id="divkullanicivar" hidden	>
													<div class="form-group has-success">
													<img src="../kullanicibulundu.png" alt="Kullanıcı Bulundu" height="42" width="42">
														
													</div>
												</div>
												<div class="col-sm-3" id="divkullaniciyok" hidden	>
													<div class="form-group has-success">
													<img src="../kullanicibulunamadi.png" alt="Kullanıcı Bulundu" height="42" width="42">
													</div>
												</div>
											</div>
										</div>
										<!-- kullanıcı ara scripti -->
								<script type="text/javascript">
									$(document).ready(function(){
										  $("#btnSorgula").click(function (event) {
											var USER_ADI = document.getElementById("USER_ADI").value;
											$.ajax({
												url: '?op=getUSER_ADI&USER_ADI='+USER_ADI, type:'GET',  
												contentType: false,
												processData:false,
												cache: false,
												dataType: "json",   
											}).done(function(response){ 
											console.log(response);
											$USER_ID											= response.data.ID;
											$USER_ADI											= response.data.UYE_USERNAME;
											if ($USER_ID!=null)
											{
												$("#divkullanicivar").show();
												$("#divkullaniciyok").hide();
												$("#divkitapbilgileri").show();
												$("#divkitapgrid").show();
												document.getElementById("USER_ID").value 			= $USER_ID;
												document.getElementById("USER_ADI").value 			= $USER_ADI;
											}
											else {
												$("#divkullanicivar").hide();
												$("#divkullaniciyok").show();
												$("#divkitapbilgileri").hide();
												$("#divkitapgrid").hide();
											}
											});
										});
									});	
								</script>
										
										<!-- kullanıcı var yok gizleme -->										
										 <script type="text/javascript">
											function hidedivkullanicivar() {
											$("#hidedivkullanicivar").hide();
											};
											function showdivkullanicivar() {
											$("#showdivkullanicivar").show();
											};
											function hidedivkullaniciyok() {
												$("#hidedivkullaniciyok").hide();
											}
											function showdivkullaniciyok() {
												$("#showdivkullaniciyok").show();
											}
										</script>
										<div class="row" style="margin-top:10px" id="divkitapbilgileri">	
										<div class="row" style="margin-top:10px" >	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">Kitap Adı</span></h4>		
													<input type="text" class="form-control" name="KITAP_ADI" id="KITAP_ADI" readonly />
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">Yazarı</span></h4>
													
													
													
													
													<!--<input type="text" class="form-control" name="YayıneviSEHIR" id="YayıneviSEHIR"/>-->
														<?php
															$smt = $pdo->prepare('SELECT * FROM YAZARLAR order by id');
															$smt->execute();
															$data = $smt->fetchAll();
														?>
														<select name="KITAP_YAZARID" id="KITAP_YAZARID" class="form-control" disabled>
															<option value="0">- Select -</option>
															<?php foreach ($data as $row): ?>
																<option value="<?=$row["id"]?>" ><?=$row["YAZAR_ADI"]?></option>
															<?php endforeach ?>
														</select>
												</div>
											</div>
											<script>
													$(document).ready(function () {
														$("#divkitapbilgileri").hide();
														$("#divkitapgrid").hide();
													});
												</script>
											
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">Yayın Evi</span></h4>
														<?php
															$smt = $pdo->prepare('SELECT * FROM YAYINEVLERI order by ID');
															$smt->execute();
															$data = $smt->fetchAll();
														?>
														<select name="KITAP_BASIMEVIID" id="KITAP_BASIMEVIID" class="form-control" disabled>
															<option value="0">- Select -</option>
															<?php foreach ($data as $row): ?>
																<option value="<?=$row["ID"]?>" ><?=$row["YAYINEVI_UNVAN"]?></option>
															<?php endforeach ?>
														</select>
												</div>
											</div>
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3">
												<div class="form-group has-success">
													<h4> <span class="label label-primary">RAF</span></h4>
														<?php
															$smt = $pdo->prepare('SELECT * FROM RAFLAR order by ID');
															$smt->execute();
															$data = $smt->fetchAll();
														?>
														<select name="KITAP_RAFID" id="KITAP_RAFID" class="form-control" disabled>
															<option value="0">- Select -</option>
															<?php foreach ($data as $row): ?>
																<option value="<?=$row["id"]?>" ><?=$row["seri"]?></option>
															<?php endforeach ?>
														</select>
												</div>
											</div>
											

											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">KATEGORİ</span></h4>
														<?php
															$smt = $pdo->prepare('SELECT * FROM KATEGORILER order by ISIM');
															$smt->execute();
															$data = $smt->fetchAll();
														?>
														<select name="KITAP_KATEGORIID" id="KITAP_KATEGORIID" class="form-control" disabled>
															<option value="0">- Select -</option>
															<?php foreach ($data as $row): ?>
																<option value="<?=$row["id"]?>" ><?=$row["isim"]?></option>
															<?php endforeach ?>
														</select>
												</div>
											</div>
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">BARKODU</span></h4>	
													<input type="text" class="form-control" name="KITAP_BARKOD" id="KITAP_BARKOD" readonly />
												</div>
											</div>
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">BASIM YILI</span></h4>	
														<input type="text" class="form-control" name="KITAP_BASIMYILI" id="KITAP_BASIMYILI" readonly />
												</div>
											</div>											
										</div>
									</div>	
									</form>
								</div>
							</div>								
					</div>					
						<div class="col-xs-12" id="divkitapgrid">
								<script type="text/javascript">
									$(document).ready(function(){
										$('#table_KITAPLAR tbody').on('click', 'tr', function () {
											var table = $('#table_KITAPLAR').DataTable();
											var datalar= table.row(this).data();
											var id = datalar['ID'];
											var bekleniyor = datalar['KITAP_DURUMU'];
											if(bekleniyor=="RAFTA")
											{
											$.ajax({
												url: '?op=getData&id='+id, type:'GET',  
												contentType: false,
												processData:false,
												cache: false,
												dataType: "json",   
											}).done(function(response){ 
											console.log(response);
											$KITAPID											= id;
											$KITAP_ADI											= response.data.kitap_adi;
											$KITAP_YAZARID										= response.data.kitap_yazarid;
											$KITAP_RAFID										= response.data.kitap_rafid;
											$KITAP_BASIMEVIID									= response.data.kitap_basimeviid;
											$KITAP_KATEGORIID									= response.data.kitap_kategoriid;
											$KITAP_BASIMYILI									= response.data.kitap_basimyili;
											$KITAP_BARKOD										= response.data.kitap_barkod;
											document.getElementById("ID").value 				= $KITAPID;
											document.getElementById("KITAP_ADI").value 			= $KITAP_ADI;
											document.getElementById("KITAP_BASIMEVIID").value 	= $KITAP_BASIMEVIID;
											document.getElementById("KITAP_YAZARID").value 		= $KITAP_YAZARID;
											document.getElementById("KITAP_RAFID").value 		= $KITAP_RAFID;
											document.getElementById("KITAP_KATEGORIID").value	= $KITAP_KATEGORIID;
											document.getElementById("KITAP_BASIMYILI").value 	= $KITAP_BASIMYILI;
											document.getElementById("KITAP_BARKOD").value 		= $KITAP_BARKOD;
											});
											}
											else 
											{
												alert("beklenen kitaba işlem yapılamaz");
											}
										});
									});	
								</script>
								<div id="page_container" class="col-lg-12">
									<h3>Yayınevi Listesi</h3>
									<!--<button type="button" class="button" id="add_company">Add company</button>-->
									<table class="datatable" id="table_KITAPLAR">
										<thead>
											<tr>
												<?php 
													//gridBaslikOlustur(array('S.No','Firma Ünvanı','Temsilcisi','Telefonu'));
													gridBaslikOlustur(array('S.No','KITAP ADI','YAZAR','BASIMEVI','RAF','BARKODU','DURUM'));
												?>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									<script type="text/javascript">
										//datatable oluşturduktan sonra çağırıyoruz çünkü görmediği bir alana işlem yapamaz
										var tabloadi= "table_KITAPLAR";
										var sayfaadi="../kontroller/oduncgrid.php";
										var parameter =  [
											   { "data": "row_num"},
											   { "data": "KITAP_ADI" },
											   { "data": "KITAP_YAZARID" },
											   { "data": "KITAP_BASIMEVIID" },
   											   { "data": "KITAP_RAFID" },
											   { "data": "KITAP_BARKOD" },
											   { "data": "KITAP_DURUMU" },
											   
										   ];
										gridbas(tabloadi,sayfaadi,parameter);
									</script>
								</div>
							</div>
						
						<div class="lightbox_bg"></div>
						<div class="lightbox_container">
							<div class="lightbox_close"></div>
							<noscript id="noscript_container">
									<div id="noscript" class="error">
										<p>Bu sayfa için Javascript desteğine ihtiyaç var.</p>
									</div>
							</noscript>
							<div id="loading_container">
								<div id="loading_container2">
									<div id="loading_container3">
										<div id="loading_container4">
											Yükleniyor, lütfen bekleyiniz...
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
        <!-- /.box-body -->
			<div class="box-footer">
			  Footer
			</div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- fatura detay popup -->
<style type="text/css">
.modal-dialog {
  width: 80%;
  height: 80%;
  margin: center;
  padding: 0;
}

.modal-content {
  height: auto;
  min-height: 80%;
  border-radius: 0;
}

</style>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->  


									<script>
									  $(document).ready(function () {
									   // $('.sidebar-menu').tree()
									  });									 
									  $("#btnSil").click(function (event) {
												var mesaj = "";
												var tablex = $('#table_KITAPLAR').DataTable();
												if($("#ID").val()=="" )
												{
													mesaj +=('Silinecek Kaydı Seçiniz');
												}
												if(mesaj.trim()==""){
													var r = confirm("Bu kaydı silmek istediğinize eminmisiniz?");
													if (r == true) {
														event.preventDefault();
														var form = $('#form1')[0];
														var data = new FormData(form);
														data.append("op", "Sil");
															$.ajax({
																type: "POST",
																url: "",
																data: data,
																processData: false,
																contentType: false,
																cache: false,
																beforeSend: function() {
																	$.blockUI;
																	},
																success: function (result) {
																	$.unblockUI;
																	alert('Silindi');
																	$(form1.reset());
																	},
																	error: function (e) {
																//	alert(result.message+' HATA:'+e);
																	},
																	complete: function(data) {
																	tablex.ajax.reload();
																	}	
																});//ajax
														}
														else 
														{
															alert('iptal edildi');
														}
													}	
												});   
 
															  $("#btnKaydet").click(function (event) {
																var mesaj = "";
																var tablex = $('#table_KITAPLAR').DataTable();
																event.preventDefault();
																var form = $('#form1')[0];
																var data = new FormData(form);
																data.append("op", "Kaydet");
																		$.ajax({
																					type: "POST",
																					url: "",
																					data: data,
																					processData: false,
																					contentType: false,
																					cache: false,
																								beforeSend: function() {
																								$.blockUI;
																								   },
																					success: function (result) {
																						
																								 $.unblockUI;
																									alert('Kaydedildi.');
																									$("#divkitapgrid").hide();
																									$(form1.reset());
																									
																									
																					},
																					error: function (e) {
																									
																								//	alert(result.message+' HATA:'+e);
																					},
																					complete: function(data) {
																						tablex.ajax.reload();
																						
																				}
																		});//ajax
																});   

</script>
</body>
</html>
