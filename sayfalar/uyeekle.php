<?php 
header('Content-type: text/html; charset=utf-8');
include '../connection/baglanti.php';
include '../fonksiyonlar/arayuzfonksiyonlar.php';
include "sessionkontrol.php";

//include '../tasarim/mainheader.php';
 error_reporting(0);
 session_start(); 

$output = array( "op" => "", "success"=> true, "error_code" => 0, "message" => "","data" => array() );
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{

  if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("getData") ){
     $id = $_REQUEST["id"];
     $sql = "SELECT * FROM UYELER WHERE ID='".$id."' ORDER BY ID asc";
  
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
else if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("Sil") ){
	 $id = $_REQUEST["ID"];
     $sql = "DELETE FROM UYELER WHERE ID=".$id;
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
	$id 					= $_REQUEST["ID"];
	$UYE_ADI 				= $_REQUEST["UYE_ADI"];
	$UYE_SOYADI 			= $_REQUEST["UYE_SOYADI"];
	$UYE_EPOSTA 			= $_REQUEST["UYE_EPOSTA"];
	$UYE_SIFRE 				= $_REQUEST["UYE_SIFRE"];
	$UYE_CINSIYET 			= $_REQUEST["UYE_CINSIYET"];
	$UYE_DOGUMTARIHI 		= $_REQUEST["UYE_DOGUMTARIHI"];
	$UYE_SABITTEL 			= $_REQUEST["UYE_SABITTEL"];
	$UYE_CEPTEL 			= $_REQUEST["UYE_CEPTEL"];
	$UYE_USERNAME 			= $_REQUEST["UYE_USERNAME"];
	$USER_YETKI 			= $_REQUEST["USER_YETKI"];
	
	//şifre değiştirmek istiyorsak bu alanı kontrol ediyoruz. 
	$checkdeger 			= $_REQUEST["checkdeger"];

	
	 
	 
	 
	$md5li= md5(sha1($UYE_SIFRE)); 
	 
	 if ($id!=null)
		{
			
			if ($checkdeger == '1')
				{
					
					$sql = "UPDATE UYELER set UYE_ADI='$UYE_ADI', UYE_SOYADI='$UYE_SOYADI',UYE_EPOSTA='$UYE_EPOSTA',UYE_CINSIYET='$UYE_CINSIYET', UYE_SIFRE = '$md5li',
			 UYE_DOGUMTARIHI='$UYE_DOGUMTARIHI',UYE_SABITTEL='$UYE_SABITTEL', UYE_YETKI='$USER_YETKI'
			 UYE_CEPTEL='$UYE_CEPTEL',UYE_USERNAME='$UYE_USERNAME' WHERE ID=".$id;
			
				}
			else
				{
					$sql = "UPDATE UYELER set UYE_ADI='$UYE_ADI',UYE_SOYADI='$UYE_SOYADI',UYE_EPOSTA='$UYE_EPOSTA',UYE_CINSIYET='$UYE_CINSIYET',
			 UYE_DOGUMTARIHI='$UYE_DOGUMTARIHI',UYE_SABITTEL='$UYE_SABITTEL',UYE_YETKI='$USER_YETKI',
			 UYE_CEPTEL='$UYE_CEPTEL',UYE_USERNAME='$UYE_USERNAME' WHERE ID=".$id;
				}
			
		}
	else 
	 {	  
		$OLUSTURAN = $_SESSION['username'];
		$sql = "INSERT INTO UYELER (UYE_ADI,UYE_YETKI,UYE_SOYADI,UYE_EPOSTA,UYE_SIFRE,UYE_CINSIYET,UYE_DOGUMTARIHI,UYE_SABITTEL,UYE_CEPTEL,UYE_USERNAME,OLUSTURAN) 
		VALUES 
		('$UYE_ADI', '$USER_YETKI', '$UYE_SOYADI', '$UYE_EPOSTA','$md5li', '$UYE_CINSIYET', '$UYE_DOGUMTARIHI', '$UYE_SABITTEL', '$UYE_CEPTEL', '$UYE_USERNAME', '$OLUSTURAN') ";		
	 } 	 
		 
		 
		 if ($pdo->query($sql) == false) {
      $result  = 'error';
      $message = 'query error';
    } else {
		$basari= " Üye başarı ile eklendii."; 
		$result  = 'success';
		$message = 'query success';

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
  
  <script type="text/javascript">
  
function hideCheckDiv() {
$("#divChck").hide();
};
function showCheckDiv() {
$("#divChck").show();
};
function hideSifre() {
	$("#divSifre").hide();
}
function showSifre() {
	$("#divSifre").show();
}
</script>
  <script>
$(document).ready(function() {
	hideCheckDiv();
	showSifre();
});
  </script>  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Hoşgeldiniz
        <small>Üye İşlemleri</small>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Üye Yönetim Ekranı</h3>

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
									<form id="form1">	
										<div class="box-header">
											<button type="reset" id="btnYeni" name="Yeni" onclick = "hideCheckDiv(),showSifre()" class="btn btn-primary"><span class="fa fa-file-text-o fa-2x"></span> Yeni</button>
											<button type="button" id="btnKaydet" name="Kaydet" onclick="epostaCheck()" class="btn btn-warning"  ><span class="fa fa-save fa-2x"></span> Kaydet</button>
											<button type="button" id="btnSil" name="Sil" onclick = "" class="btn btn-danger"><span class="fa fa-trash-o fa-2x"></span> Sil</button>
										</div>
										<input type="text" name="ID" id="ID" class="form-control hidden"  placeholder="ID"  >
										
										
										
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">ÜYE ADI</span></h4>
													
														<input type="text" class="form-control" name="UYE_USERNAME" id="UYE_USERNAME" required="required" />
												</div>
											</div>
											<div class="col-sm-3">
												<div class="col-sm-6"	>
													<div class="form-group has-success" class="col-sm-6" >
														<h4> <span class="label label-primary" size="6">YETKİ</span></h4>	
														<select id="USER_YETKI" name="USER_YETKI" class="btn btn-warning dropdown">
															<option value="0" selected>SEÇİNİZ</option>
															<option value="KISITLI">KISITLI</option>
															<option value="TAM">TAM</option>
															<option value="KULLANICI">KULLANICI</option>
														</select>
													</div>
												</div>
											</div>		
											<div class="col-sm-3">
												<div class="col-sm-6"	>
													<div class="form-group has-success" class="col-sm-6" id ="divChck">
														<input type="checkbox" id="chckSifre" />
														<h5><span class="label label-primary" size="6">Şifre Güncelle</span></h5>
														<input type="text" class="form-control" name="checkdeger" id="checkdeger" style="display:none;"  />
													</div>
												</div>
											</div>												
												
												
												<div id="divSifre" class="col-sm-6" style="display: none">
													<div class="col-sm-6"	>
														<div class="form-group has-success">
															<h4> <span class="label label-primary">ŞİFRE</span></h4>
															<input type="password" class="form-control" name="UYE_SIFRE" id="UYE_SIFRE"  />
														</div>
													</div>
												<div class="col-sm-6"	>
													<div class="form-group has-success">
															<h4> <span class="label label-primary">ŞİFRE TAKRAR</span></h4>	
															<input type="password" class="form-control" name="UYE_SIFRETEKRAR" id="UYE_SIFRETEKRAR"/>
													</div>
												</div>
													
												
												<script>
													$(function () {
														$("#chckSifre").click(function () {
															if ($(this).is(":checked")) {
																$("#divSifre").show();
																document.getElementById("checkdeger").value = '1';
																
															} else {
																$("#divSifre").hide();
																document.getElementById("checkdeger").value = '0';
																
															}
														});
													});				
																								
																								
												</script>										
												</div>
												
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span for="UYE_ADI" class="label label-primary">ADI</span></h4>	
													
														<input type="text" class="form-control" name="UYE_ADI" id="UYE_ADI"/>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">SOYADI</span></h4>	
														<input type="text" class="form-control" name="UYE_SOYADI" id="UYE_SOYADI"/>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">E-POSTA</span></h4>	
														<input type="text" class="form-control" name="UYE_EPOSTA" id="UYE_EPOSTA" onblur=""/>
												</div>
											</div>
											<script>
												function epostaCheck()
													{
														var mail = document.getElementById("UYE_EPOSTA").value;
														var regex = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+.)+([.])+[a-zA-Z0-9.-]{2,4}$/;
														if (regex.test(mail)==true)
														{
															
														}
														else
														{alert("Hata geçersiz mail adresi girdiniz!");}
													}
											</script>
										</div>		
											<script type="text/javascript">
											
												$( function() {
													$("#UYE_DOGUMTARIHI").datepicker({
														dateFormat: "yy-mm-dd"
													});
												} );
											
											</script>										
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">CİNSİYET</span></h4>		
													<label class="radio-inline"><input type="radio" name="UYE_CINSIYET" id="ERKEK" Value="ERKEK" checked>Erkek</label>
													<label class="radio-inline"><input type="radio" name="UYE_CINSIYET" id = "KADIN" Value="KADIN">Kadın</label>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">DOĞUM TARİHİ</span></h4>
														<input type="text" class="form-control" name="UYE_DOGUMTARIHI" id="UYE_DOGUMTARIHI"/>
												</div>
											</div>
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">SABİT TELEFON</span></h4>		
														<input type="text" class="form-control" name="UYE_SABITTEL" id="UYE_SABITTEL"/>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">CEP TELEFON</span></h4>	
														<input type="text" class="form-control" name="UYE_CEPTEL" id="UYE_CEPTEL"/>
												</div>
											</div>											
										</div>	
										
										
								<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
								<script>
								jQuery(function($){
								$("#UYE_SABITTEL").mask("(999) 999-9999", { autoclear: false });
								$("#UYE_CEPTEL").mask("(999) 999-9999", { autoclear: false });
								
								//$("#FIRMATELEFON2").mask("(999) 999-9999");
								//$("#nic").mask("99999-9999999-9");
								//$("#date").mask("99/99/9999");
								//$("#phone").mask("(999) 999-9999");
								//$("#ext").mask("(999) 999-9999? Ext.99999");
								//$("#mobile").mask("+99 999 999 999");
								//$("#percent").mask("99%");
								//$("#productkey").mask("a*-999-a999");
								//$("#orderno").mask("PO: aaa-999-***");
								//$("#date2").mask("99/99/9999", { autoclear: false });
								//$("#date3").mask("99/99/9999", { autoclear: false, completed:function(){alert("Completed!");} });
								//$("#mobile2").mask("+1 999 999 999");
								});
								</script>
										
										
										
									</form>
								</div>
								
							</div>
							</div>
							<div class="col-xs-12">
									<script type="text/javascript">
									$(document).ready(function(){
										$('#table_UYELER tbody').on('click', 'tr', function () {
											
											var table = $('#table_UYELER').DataTable();
											var datalar= table.row(this).data();
											console.log(datalar);
											var id = datalar['ID'];
											$.ajax({
												url: '?op=getData&id='+id, type:'GET',  
												contentType: false,
												processData:false,
												cache: false,
												dataType: "json",   
											}).done(function(response){ 
												$("#divChck").show();
												$("#divSifre").hide();
											console.log(response);
											
											document.getElementById("ID").value 				= response.data.ID;
											document.getElementById("UYE_ADI").value 			= response.data.UYE_ADI;
											document.getElementById("UYE_SOYADI").value 		= response.data.UYE_SOYADI;
											document.getElementById("UYE_EPOSTA").value 		= response.data.UYE_EPOSTA;
											var cinsiyet = response.data.UYE_CINSIYET;
											if (cinsiyet =="ERKEK")
											{
												document.getElementById("ERKEK").checked = true ;
											}
											else 
											{
												document.getElementById("KADIN").checked = true ;
											}
											document.getElementById("UYE_DOGUMTARIHI").value 	= response.data.UYE_DOGUMTARIHI;
											document.getElementById("UYE_SABITTEL").value 		= response.data.UYE_SABITTEL;
											document.getElementById("UYE_CEPTEL").value			= response.data.UYE_CEPTEL;
											document.getElementById("UYE_USERNAME").value 		= response.data.UYE_USERNAME;
											document.getElementById("USER_YETKI").value			= response.data.UYE_YETKI;

											
											});
										
										});
									});	
								</script>
									<div id="page_container" class="col-lg-12">
									<h3>Kullanıcı Listesi</h3>
									<!--<button type="button" class="button" id="add_company">Add company</button>-->
									<table class="datatable" id="table_UYELER">
										<thead>
											<tr>
												<?php 
													//gridBaslikOlustur(array('S.No','Firma Ünvanı','Temsilcisi','Telefonu'));
													gridBaslikOlustur(array('S.No','KULLANICI ADI','ADI','SOYADI','YETKİ'));
												?>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									<script type="text/javascript">
										//datatable oluşturduktan sonra çağırıyoruz çünkü görmediği bir alana işlem yapamaz
										var tabloadi= "table_UYELER";
										var sayfaadi="../kontroller/uyegrid.php";
										var parameter =  [
											   { "data": "row_num"},
											   { "data": "UYE_USERNAME" },
											   { "data": "UYE_ADI" },
   											   { "data": "UYE_SOYADI" },
											   { "data": "UYE_YETKI" },
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
        <div class="box-footer">
          Footer
        </div>
      </div>
    </section>
  </div>
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.18
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE</a>.</strong> All rights
    reserved.
  </footer>
  <div class="control-sidebar-bg"></div>
</div>
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
							var form = document.getElementById('form');
							//var btnKaydet = document.getElementById('btnKaydet');
							var btnKaydet = document.getElementById('btnKaydet');

							//btnKaydet.addEventListener('click', send);

							function send(e) {
								btnKaydet.click();
							}
							</script>
							<script>
								$(document).ready(function () {
								// $('.sidebar-menu').tree()
								});
								  $("#btnSil").click(function (event) {
									var mesaj = "";
									var tablex = $('#table_UYELER').DataTable();
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
																		$("#divChck").hide();
																		$("#divSifre").show();
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
									var tablex = $('#table_UYELER').DataTable();
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
												hideSifre();
												hideCheckDiv();
												$(form1.reset());
											},
											error: function (e) {
												alert(result.message+' HATA:'+e);
											},
											complete: function(data) {
												tablex.ajax.reload();
											}
										});//ajax
								});   
							</script>
</body>
</html>
