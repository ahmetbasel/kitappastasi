<?php 
header('Content-type: text/html; charset=utf-8');
include '../connection/baglanti.php';
include '../fonksiyonlar/arayuzfonksiyonlar.php';
include "sessionkontrol.php";
 error_reporting(0);
 session_start(); 
$output = array( "op" => "", "success"=> true, "error_code" => 0, "message" => "","data" => array() );
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{

  if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("getData") ){
     $id = $_REQUEST["id"];
     $sql = "SELECT * FROM YAZARLAR WHERE ID='".$id."' ORDER BY ID asc";
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
  $data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
  );
  $json_data = json_encode($data);
  print $json_data;
  exit;  
  }
else if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("Sil") ){
	 $id = $_REQUEST["ID"];
     $sql = "DELETE FROM YAZARLAR WHERE ID=".$id;
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
	$YAZAR_ADI 				= $_REQUEST["YAZAR_ADI"];
	
	if ($id!=null)
		{
			$sql = "UPDATE YAZARLAR set YAZAR_ADI='$YAZAR_ADI' WHERE ID= ".$id;	
		}
	else 
	 {	
		$OLUSTURAN = $_SESSION['username'];
		$sql = "INSERT INTO YAZARLAR (YAZAR_ADI, OLUSTURAN) VALUES  ('$YAZAR_ADI', '$OLUSTURAN') ";	
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
        <small>Yazar İşlemleri</small>
      </h1>
    </section>
    <section class="content">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Yazar Yönetim Ekranı</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
					<div class="col-lg-12">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-xs-12">
									<form id="form1">	
										<div class="box-header">
											<button type="reset" id="btnYeni" name="Yeni" onclick = "" class="btn btn-primary"><span class="fa fa-file-text-o fa-2x"></span> Yeni</button>
											<button type="button" id="btnKaydet" name="Kaydet" onclick="" class="btn btn-warning"  ><span class="fa fa-save fa-2x"></span> Kaydet</button>
											<button type="button" id="btnSil" name="Sil" onclick = "" class="btn btn-danger"><span class="fa fa-trash-o fa-2x"></span> Sil</button>
										</div>
										<input type="text" class="form-control hidden" name="ID" id="ID">										
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">YAZAR ADI</span></h4>
													
														<input type="text" class="form-control" name="YAZAR_ADI" id="YAZAR_ADI" required="required" />
												</div>
											</div>
										</div>				
								</div>
									</form>
								</div>
							</div>
							</div>
							<div class="col-xs-12">
									<script type="text/javascript">
									$(document).ready(function(){
										$('#table_YAZARLAR tbody').on('click', 'tr', function () {
											
											var table = $('#table_YAZARLAR').DataTable();
											var datalar= table.row(this).data();
											var id = datalar['ID'];
											$.ajax({
												url: '?op=getData&id='+id, type:'GET',  
												contentType: false,
												processData:false,
												cache: false,
												dataType: "json",   
											}).done(function(response){ 
											console.log(response);
											document.getElementById("ID").value 				= id;
											document.getElementById("YAZAR_ADI").value 			= response.data.YAZAR_ADI;
											});
										});
									});	
								</script>
									<div id="page_container" class="col-lg-12">
									<h3>Yazar Listesi</h3>
									<!--<button type="button" class="button" id="add_company">Add company</button>-->
									<table class="datatable" id="table_YAZARLAR">
										<thead>
											<tr>
												<?php 
													//gridBaslikOlustur(array('S.No','Firma Ünvanı','Temsilcisi','Telefonu'));
													gridBaslikOlustur(array('S.No','YAZAR_ADI'));
												?>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									<script type="text/javascript">
										//datatable oluşturduktan sonra çağırıyoruz çünkü görmediği bir alana işlem yapamaz
										var tabloadi= "table_YAZARLAR";
										var sayfaadi="../kontroller/yazargrid.php";
										var parameter =  [
											   { "data": "row_num"},
											   { "data": "YAZAR_ADI" },
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
							var btnKaydet = document.getElementById('btnKaydet');
							function send(e) {
								btnKaydet.click();
							}
							</script>
							<script>
								$(document).ready(function () {
								});
								  $("#btnSil").click(function (event) {
									var mesaj = "";
									var tablex = $('#table_YAZARLAR').DataTable();
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
									var tablex = $('#table_YAZARLAR').DataTable();
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
