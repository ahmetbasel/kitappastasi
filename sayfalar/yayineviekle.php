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
     $id = $_REQUEST["id"];
     $sql = "SELECT * FROM YAYINEVLERI WHERE ID='".$id."' ORDER BY ID asc";
  
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
  
  
  
  if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("getILCE") ){
     $ilce_plaka = $_REQUEST["ilce_plaka"];
     $sql = "SELECT * FROM ilce WHERE ilce_plaka='".$ilce_plaka."' order by ilce_adi";
  
    if ($pdo->query($sql) == false) {
      $result  = 'error';
      $message = 'query error';
    } else {
		  $result  = 'success';
		  $message = 'query success';
		$st = $pdo->prepare($sql);
		$st->execute();
		$mysql_data = $st->fetchAll(PDO::FETCH_ASSOC);
    }	
  $pdo=null;
  //////geni if üstteki { iþaretiyle bitiyor
  // Prepare data
  $data = array(
    "result"  => $result,
    "message" => $message,
    "data"    => $mysql_data
  );
  //echo $data;
  // Convert PHP array to JSON array
  $json_data = json_encode($data);
  //var_dump($mysql_data);
  print $json_data;
  exit;  
  }
  
  
  
  
  
  
else if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("Sil") ){
	 $id = $_REQUEST["ID"];
     $sql = "DELETE FROM YAYINEVLERI WHERE ID=".$id;
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
	$id 						= $_REQUEST["ID"];
	$YAYINEVI_UNVAN 			= $_REQUEST["YAYINEVI_UNVAN"];
	$YAYINEVI_ADRES 			= $_REQUEST["YAYINEVI_ADRES"];
	$YAYINEVI_SEHIR 			= $_REQUEST["YAYINEVI_SEHIR"];
	$YAYINEVI_ILCE 				= $_REQUEST["YAYINEVI_ILCE"];
	$YAYINEVI_TELEFON1 			= $_REQUEST["YAYINEVI_TELEFON1"];
	$YAYINEVI_TELEFON2 			= $_REQUEST["YAYINEVI_TELEFON2"];
	$YAYINEVI_FAKS 				= $_REQUEST["YAYINEVI_FAKS"];
	$YAYINEVI_TICARETSICILNO 	= $_REQUEST["YAYINEVI_TICARETSICILNO"];
	$YAYINEVI_VERGIDAIRESI 		= $_REQUEST["YAYINEVI_VERGIDAIRESI"];
	$YAYINEVI_EPOSTA 			= $_REQUEST["YAYINEVI_EPOSTA"];
	$YAYINEVI_WEBADRESI 		= $_REQUEST["YAYINEVI_WEBADRESI"];
	$YAYINEVI_TEMSILCISI 		= $_REQUEST["YAYINEVI_TEMSILCISI"];
	$YAYINEVI_ACIKLAMA 			= $_REQUEST["YAYINEVI_ACIKLAMA"];
	 
	 $OLUSTURAN = $_SESSION['username'];
	 
	 if ($id!=null){
     $sql = "UPDATE YAYINEVLERI set YAYINEVI_UNVAN='$YAYINEVI_UNVAN',YAYINEVI_ADRES='$YAYINEVI_ADRES',YAYINEVI_SEHIR='$YAYINEVI_SEHIR',YAYINEVI_ILCE='$YAYINEVI_ILCE',YAYINEVI_TELEFON1='$YAYINEVI_TELEFON1',
	 YAYINEVI_TELEFON2='$YAYINEVI_TELEFON2',YAYINEVI_FAKS='$YAYINEVI_FAKS',YAYINEVI_TICARETSICILNO='$YAYINEVI_TICARETSICILNO',
	 YAYINEVI_VERGIDAIRESI='$YAYINEVI_VERGIDAIRESI',YAYINEVI_EPOSTA='$YAYINEVI_EPOSTA',YAYINEVI_WEBADRESI='$YAYINEVI_WEBADRESI',YAYINEVI_TEMSILCISI='$YAYINEVI_TEMSILCISI',YAYINEVI_ACIKLAMA='$YAYINEVI_ACIKLAMA' WHERE ID=".$id;
	 } else 
	 {	  
		$sql = "INSERT INTO YAYINEVLERI (YAYINEVI_UNVAN,YAYINEVI_ADRES,YAYINEVI_SEHIR,YAYINEVI_ILCE,YAYINEVI_TELEFON1,YAYINEVI_TELEFON2,YAYINEVI_FAKS,YAYINEVI_TICARETSICILNO,YAYINEVI_VERGIDAIRESI,YAYINEVI_EPOSTA,YAYINEVI_WEBADRESI,YAYINEVI_TEMSILCISI,YAYINEVI_ACIKLAMA,OLUSTURAN) 
		VALUES 
		('$YAYINEVI_UNVAN', '$YAYINEVI_ADRES', '$YAYINEVI_SEHIR', '$YAYINEVI_ILCE', '$YAYINEVI_TELEFON1', '$YAYINEVI_TELEFON2', '$YAYINEVI_FAKS', '$YAYINEVI_TICARETSICILNO', '$YAYINEVI_VERGIDAIRESI', '$YAYINEVI_EPOSTA', '$YAYINEVI_WEBADRESI', '$YAYINEVI_TEMSILCISI', '$YAYINEVI_ACIKLAMA', '$OLUSTURAN') ";		
	 } 	 
		 
		 
		 if ($pdo->query($sql) == false) {
      $result  = 'error';
      $message = 'query error';
    } else {
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
        Blank page
        <small>Yayınevi İşlemleri</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Yayınevi Oluşturma Ekranı</h3>

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
											<button type="button" id="btnSil" name="Sil" onclick = "" class="btn btn-danger"><span class="fa fa-trash-o fa-2x"></span> Sil</button>
										</div>
										<input type="text" name="ID" id="ID" class="form-control hidden"  placeholder="ID"  >
										
										
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-4"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">Yayınevi Ünvan</span></h4>		
													<textarea rows = "5" cols = "60" class="form-control" name="YAYINEVI_UNVAN" id="YAYINEVI_UNVAN"></textarea>
												</div>
											</div>
											<div class="col-sm-4"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary ">Yayınevi Adres</span></h4>	
														<textarea rows = "5" cols = "60" class="form-control" name="YAYINEVI_ADRES" id="YAYINEVI_ADRES"></textarea>
												</div>
											</div>
											<div class="col-sm-4"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">Yayınevi Açıklama</span></h4>	
														<textarea rows = "5" cols = "60" class="form-control" name="YAYINEVI_ACIKLAMA" id="YAYINEVI_ACIKLAMA"></textarea>
												</div>
											</div>
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">Yayınevi Şehir</span></h4>
													<!--<input type="text" class="form-control" name="YayıneviSEHIR" id="YayıneviSEHIR"/>-->
														<?php
															$smt = $pdo->prepare('SELECT * FROM iller order by il_adi');
															$smt->execute();
															$data = $smt->fetchAll();
														?>
														<select name="YAYINEVI_SEHIR" id="YAYINEVI_SEHIR" class="form-control">
															<option value="0">- Select -</option>
															<?php foreach ($data as $row): ?>
																<option value="<?=$row["il_plaka"]?>" ><?=$row["il_adi"]?></option>
															<?php endforeach ?>
														</select>
														
													
													
													
												</div>
											</div>
											
											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">Yayınevi İlçe</span></h4>	
													<div class="col-lg-8">
														
														<select id="YAYINEVI_ILCE" class="form-control">
															<option value="0">- Select -</option>
														</select>
													</div>
												</div>
											</div>
										</div>
										<script type="text/javascript">
											$(document).ready(function(){
												$("#YAYINEVI_SEHIR").change(function(){
													var ilce_plaka = $(this).val();
													$("#YAYINEVI_ILCE").html("<option value=''>Yükleniyor...</option>");
													$.ajax({
															url: '?op=getILCE&ilce_plaka='+ilce_plaka, type:'GET', 
															contentType: false,
															processData:false,
															cache: false,
															dataType: "json",   
														}).done(function(response){ //
															$("#YAYINEVI_ILCE").empty();
															$.each(response.data,function(i,e){
																$("#YAYINEVI_ILCE").append("<option value='"+e.ilce_id+"'>"+e.ilce_adi+"</option>");
															});
														});
												});
											});
										</script>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">Yayınevi Telefon1</span></h4>	
													<input type="text" class="form-control" name="YAYINEVI_TELEFON1" id="YAYINEVI_TELEFON1"/>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">Yayınevi Telefon2</span></h4>	
														<input type="text" class="form-control" name="YAYINEVI_TELEFON2" id="YAYINEVI_TELEFON2"/>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">Yayınevi Faks</span></h4>
														<input type="text" class="form-control" name="YAYINEVI_FAKS" id="YAYINEVI_FAKS"/>
												</div>
											</div>
										</div>
										
										
										
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
													<h4> <span class="label label-primary">Yayınevi Ticaret Sicil No</span></h4>	
													<input type="text" class="form-control" name="YAYINEVI_TICARETSICILNO" id="YAYINEVI_TICARETSICILNO" required />
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">Yayınevi Vergi Dairesi</span></h4>	
														<input type="text" class="form-control" name="YAYINEVI_VERGIDAIRESI" id="YAYINEVI_VERGIDAIRESI"/>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">Yayınevi Eposta</span></h4>	
														<input type="text" class="form-control" name="YAYINEVI_EPOSTA" id="YAYINEVI_EPOSTA" onblur="kontrolet()" />
												</div>
											</div>
											<script>
												function kontrolet()
													{
														var mail = document.getElementById("YAYINEVI_EPOSTA").value;
														var regex = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+.)+([.])+[a-zA-Z0-9.-]{2,4}$/;
														if (regex.test(mail)==true)
														{alert("Mail adresi geçerli");}
														else
														{alert("Hata geçersiz mail adresi girdiniz!");}
													}
											</script>
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">Yayınevi Web Adresi</span></h4>	
														<input type="text" class="form-control" name="YAYINEVI_WEBADRESI" id="YAYINEVI_WEBADRESI"/>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">Yayınevi Temsilcisi</span></h4>	
														<input type="text" class="form-control" name="YAYINEVI_TEMSILCISI" id="YAYINEVI_TEMSILCISI"/>
												</div>
											</div>
											
										</div>
									</form>
								</div>
							</div>
						<script src="../js/jquery.maskedinput.js" type="text/javascript"></script>
								<script>
								jQuery(function($){
								$("#YAYINEVI_TELEFON1").mask("(999) 999-9999", { autoclear: false });
								$("#YAYINEVI_TELEFON2").mask("(999) 999-9999", { autoclear: false });
								$("#YAYINEVI_FAKS").mask("(999) 999-9999", { autoclear: false });
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
					</div>					
						<div class="col-xs-12">
								<script type="text/javascript">
									$(document).ready(function(){
										$('#table_YAYINEVLERI tbody').on('click', 'tr', function () {
											var table = $('#table_YAYINEVLERI').DataTable();
											var datalar= table.row(this).data();
											var id = datalar['ID'];
											$.ajax({
												url: '?op=getData&id='+id, type:'GET',  
												contentType: false,
												processData:false,
												cache: false,
												dataType: "json",   
											}).done(function(response){ //
											//console.log(response);
											$YAYINEVI_ID									= response.data.ID;
											$YAYINEVI_UNVAN									= response.data.YAYINEVI_UNVAN;
											$YAYINEVI_ADRES									= response.data.YAYINEVI_ADRES;
											$YAYINEVI_SEHIR									= response.data.YAYINEVI_SEHIR;
											$YAYINEVI_ILCE									= response.data.YAYINEVI_ILCE;
											$YAYINEVI_TELEFON1								= response.data.YAYINEVI_TELEFON1;
											$YAYINEVI_TELEFON2								= response.data.YAYINEVI_TELEFON2;
											$YAYINEVI_FAKS									= response.data.YAYINEVI_FAKS;
											$YAYINEVI_TICARETSICILNO						= response.data.YAYINEVI_TICARETSICILNO;
											$YAYINEVI_VERGIDAIRESI							= response.data.YAYINEVI_VERGIDAIRESI;
											$YAYINEVI_EPOSTA								= response.data.YAYINEVI_EPOSTA;
											$YAYINEVI_WEBADRESI								= response.data.YAYINEVI_WEBADRESI;
											$YAYINEVI_TEMSILCISI							= response.data.YAYINEVI_TEMSILCISI;
											$YAYINEVI_ACIKLAMA								= response.data.YAYINEVI_ACIKLAMA;
											document.getElementById("ID").value 			= $YAYINEVI_ID;
											document.getElementById("YAYINEVI_UNVAN").value 			= $YAYINEVI_UNVAN;
											document.getElementById("YAYINEVI_ADRES").value 			= $YAYINEVI_ADRES;
											document.getElementById("YAYINEVI_SEHIR").value 			= $YAYINEVI_SEHIR;
											$('#YAYINEVI_SEHIR').trigger('change');
											document.getElementById("YAYINEVI_ILCE").value				= $YAYINEVI_ILCE;
											document.getElementById("YAYINEVI_TELEFON1").value 			= $YAYINEVI_TELEFON1;
											document.getElementById("YAYINEVI_TELEFON2").value 			= $YAYINEVI_TELEFON2;
											document.getElementById("YAYINEVI_FAKS").value				= $YAYINEVI_FAKS;
											document.getElementById("YAYINEVI_TICARETSICILNO").value 	= $YAYINEVI_TICARETSICILNO;
											document.getElementById("YAYINEVI_VERGIDAIRESI").value		= $YAYINEVI_VERGIDAIRESI;
											document.getElementById("YAYINEVI_EPOSTA").value 			= $YAYINEVI_EPOSTA;
											document.getElementById("YAYINEVI_WEBADRESI").value 		= $YAYINEVI_WEBADRESI;
											document.getElementById("YAYINEVI_TEMSILCISI").value 		= $YAYINEVI_TEMSILCISI;
											document.getElementById("YAYINEVI_ACIKLAMA").value 			= $YAYINEVI_ACIKLAMA;
											});
										});
									});	
								</script>
								
								
								<div id="page_container" class="col-lg-12">
									<h3>Yayınevi Listesi</h3>
									<!--<button type="button" class="button" id="add_company">Add company</button>-->
									<table class="datatable" id="table_YAYINEVLERI">
										<thead>
											<tr>
												<?php 
													//gridBaslikOlustur(array('S.No','Firma Ünvanı','Temsilcisi','Telefonu'));
													gridBaslikOlustur(array('S.No','Yayınevi Ünvanı','Temsilcisi','Telefonu'));
												?>
											</tr>
										</thead>
										<tbody>
										</tbody>
									</table>
									<script type="text/javascript">
										//datatable oluşturduktan sonra çağırıyoruz çünkü görmediği bir alana işlem yapamaz
										var tabloadi= "table_YAYINEVLERI";
										var sayfaadi="../kontroller/yayinevigrid.php";
										var parameter =  [
											   { "data": "row_num"},
											   { "data": "YAYINEVI_UNVAN" },
											   { "data": "YAYINEVI_TEMSILCISI" },
   											   { "data": "YAYINEVI_TELEFON1" },
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
<!--
<div class="modal fade" id="mdl-ayrinti" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
      <form role="form" name="formSonuc" id="formSonuc" method="post" enctype="multipart/form-data" action="" onSubmit="">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title"><i class="fa fa-fw fa-check-square-o"></i> Fatura Ayrıntısı</h4>
        </div>
        
		
        <div class="modal-body">
			<div class="table-responsive">
			
				<?php
				/*
					echo "<table class=\"ayrinti-table table table-striped table-inverse\" border=1px>";
					echo "<thead  >";  
					echo  "<tr bgcolor=\"#449d44\" >";
					echo "<th align=\"left\">Sıra No</th>";
					echo "<th align=\"left\">Firma Adı</th>";
					echo "<th align=\"left\">İletişim</th>";
					echo "</tr>";
					echo "</thead>";           
					*/
				?>          
				<tbody class="ayrinti-table-body"></tbody>
				</table>
			</div>
		</div>
		-->

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
												var tablex = $('#table_YAYINEVLERI').DataTable();
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
									//alert(""+mesaj+"");

    });   
 
															  $("#btnKaydet").click(function (event) {
																var mesaj = "";
																var tablex = $('#table_YAYINEVLERI').DataTable();
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
