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

$username = $_SESSION['username'];
	error_reporting(0);
if(isset($_REQUEST['op']) && strtoupper($_REQUEST['op'])==strtoupper("Kaydet") ){
	
	
	$UYE_ADI 				= $_REQUEST["UYE_ADI"];
	$UYE_SOYADI 			= $_REQUEST["UYE_SOYADI"];
	$UYE_EPOSTA 			= $_REQUEST["UYE_EPOSTA"];
	$UYE_SIFRE 				= $_REQUEST["UYE_SIFRE"];
	$UYE_CINSIYET 			= $_REQUEST["UYE_CINSIYET"];
	$UYE_DOGUMTARIHI 		= $_REQUEST["UYE_DOGUMTARIHI"];
	$UYE_YETKI 				= $_REQUEST["UYE_YETKI"];
	$UYE_SABITTEL 			= $_REQUEST["UYE_SABITTEL"];
	$UYE_CEPTEL 			= $_REQUEST["UYE_CEPTEL"];
	$UYE_USERNAME 			= $_REQUEST["UYE_USERNAME"];
	//şifre değiştirmek istiyorsak bu alanı kontrol ediyoruz. 
	$checkdeger 			= $_REQUEST["checkdeger"];
	$md5li= md5(sha1($UYE_SIFRE)); 
	
	
	if ($checkdeger == '1')
	{
	$sql = "UPDATE UYELER set UYE_ADI='$UYE_ADI', UYE_SOYADI='$UYE_SOYADI', UYE_CINSIYET='$UYE_CINSIYET', UYE_SIFRE='$md5li',UYE_CEPTEL='$UYE_CEPTEL',UYE_DOGUMTARIHI='$UYE_DOGUMTARIHI',UYE_SABITTEL='$UYE_SABITTEL', UYE_EPOSTA='$UYE_EPOSTA' WHERE UYE_USERNAME='".$username."' ";
	}
	else
	{
		$sql = "UPDATE UYELER set UYE_ADI='$UYE_ADI', UYE_SOYADI='$UYE_SOYADI', UYE_CINSIYET='$UYE_CINSIYET', UYE_CEPTEL='$UYE_CEPTEL',UYE_DOGUMTARIHI='$UYE_DOGUMTARIHI',UYE_SABITTEL='$UYE_SABITTEL', UYE_EPOSTA='$UYE_EPOSTA' WHERE UYE_USERNAME='".$username."' ";
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
  <script src="../js/bootstrap.min.js"></script>
  
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
        <small>Profil İşlemleri</small>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Profil Yönetim Ekranı</h3>

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
											<button type="button" id="btnKaydet" name="Kaydet"  class="btn btn-warning"  ><span class="fa fa-save fa-2x"></span> Kaydet</button>
										</div>
										<input type="text" name="ID" id="ID" class="form-control hidden"  placeholder="ID">
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">KULLANICI ADI</span></h4>
													
														<?php 
														$sql = "SELECT ID, UYE_ADI, UYE_SOYADI, UYE_EPOSTA, UYE_SIFRE, UYE_CINSIYET, UYE_DOGUMTARIHI, UYE_YETKI, UYE_SABITTEL, UYE_CEPTEL, UYE_USERNAME FROM UYELER where UYE_USERNAME ='".$kullaniciadi."'";
														if ($pdo->query($sql) == false) {
														  $result  = 'error';
														  $message = 'query error';
														} else {
														  $result  = 'success';
														  $message = 'query success';
														$st = $pdo->prepare($sql);
														$st->execute();
														$mysql_data 		= $st->fetch(PDO::FETCH_ASSOC);
														$kul_id				= $mysql_data['ID'];
														$kul_name			= $mysql_data['UYE_ADI'];
														$kul_surname		= $mysql_data['UYE_SOYADI'];
														$kul_email			= $mysql_data['UYE_EPOSTA'];
														$kul_cinsiyet		= $mysql_data['UYE_CINSIYET'];
														$kul_password		= $mysql_data['UYE_SIFRE'];
														$kul_sex			= $mysql_data['UYE_CINSIYET'];
														$kul_bday			= $mysql_data['UYE_DOGUMTARIHI'];
														$kul_telephone1		= $mysql_data['UYE_SABITTEL'];
														$kul_telephone2		= $mysql_data['UYE_CEPTEL'];
														$kul_username		= $mysql_data['UYE_USERNAME'];
														}
															echo "<input type=\"text\" class=\"form-control\" name=\"UYE_USERNAME\"  id=\"UYE_USERNAME\" value=\"".$kul_username."\" readonly>";
														?>
														<div class="form-group has-success" class="col-sm-3" id ="divChck">
															<input type="checkbox" id="chckSifre" />
															<h5><span class="label label-primary" size="6">Şifre Güncelle</span></h5>
															<input type="text" class="form-control" name="checkdeger" id="checkdeger" style="display:none;"  />
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
												 <script type="text/javascript">
												  $(document).ready(function() {
													showCheckDiv();
													hideSifre();
												});
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
													
													
													
											</div>
											<div id="divSifre" class="col-sm-6" >
													<div class="col-sm-6"	>
														<div class="form-group has-success">
															<h4> <span class="label label-primary">ŞİFRE</span></h4>
															<?php 
															echo "<input type=\"text\" class=\"form-control\" name=\"UYE_SIFRE\"  id=\"UYE_SIFRE\" >";
															?>
														</div>
													</div>
												<div class="col-sm-6"	>
													<div class="form-group has-success">
															<h4> <span class="label label-primary">ŞİFRE TAKRAR</span></h4>	
															<input type="password" class="form-control" name="UYE_SIFRETEKRAR" id="UYE_SIFRETEKRAR"/>
													</div>
												</div>
											</div>
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span for="UYE_ADI" class="label label-primary">ADI</span></h4>	
														<?php 
															echo "<input type=\"text\" class=\"form-control\" name=\"UYE_ADI\"  id=\"UYE_ADI\" value=\"".$kul_name."\" >";
														?>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">SOYADI</span></h4>	
														<?php 
															echo "<input type=\"text\" class=\"form-control\" name=\"UYE_SOYADI\"  id=\"UYE_SOYADI\" value=\"".$kul_surname."\" >";
														?>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">E-POSTA</span></h4>	
														<?php 
															echo "<input type=\"text\" class=\"form-control\" name=\"UYE_EPOSTA\"  id=\"UYE_EPOSTA\" value=\"".$kul_email."\" >";
														?>
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
													
													<label class="radio-inline"><input type="radio" name="UYE_CINSIYET" id="ERKEK" Value="ERKEK" <?php if ($kul_cinsiyet=='ERKEK') {echo "checked";} else {} ?>  >Erkek</label>
													<label class="radio-inline"><input type="radio" name="UYE_CINSIYET" id = "KADIN" Value="KADIN" <?php if ($kul_cinsiyet=='KADIN') {echo "checked";} else {} ?> >Kadın</label>
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">DOĞUM TARİHİ</span></h4>
														
														<?php 
															echo "<input type=\"text\" class=\"form-control\" name=\"UYE_DOGUMTARIHI\"  id=\"UYE_DOGUMTARIHI\" value=\"".$kul_bday."\" >";
														?>
														
												</div>
											</div>
										</div>
										<div class="row" style="margin-top:10px">	
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">SABİT TELEFON</span></h4>		
														<?php 
															echo "<input type=\"text\" class=\"form-control\" name=\"UYE_SABITTEL\"  id=\"UYE_SABITTEL\" value=\"".$kul_telephone1."\" >";
														?>
														
														
														
												</div>
											</div>
											<div class="col-sm-3"	>
												<div class="form-group has-success">
														<h4> <span class="label label-primary">CEP TELEFON</span></h4>	
														
														<?php 
															echo "<input type=\"text\" class=\"form-control\" name=\"UYE_CEPTEL\"  id=\"UYE_CEPTEL\" value=\"".$kul_telephone2."\" >";
														?>
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
							
								$("#btnKaydet").click(function (event) {
																var mesaj = "";
																//var tablex = $('#table_firmalar').DataTable();
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
																									$("#divChck").show();
																									$("#divSifre").hide();
																									$(form1.reset());
																									
																					},
																					error: function (e) {
																									
																								//	alert(result.message+' HATA:'+e);
																					},
																					complete: function(data) {
																						//tablex.ajax.reload();
																						
																				}
																		});//ajax
																});  
							</script>
</body>
</html>
