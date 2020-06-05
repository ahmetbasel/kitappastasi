<?php 
header('Content-type: text/html; charset=utf-8');
include "tasarim/menu.php";
include "sessionkontrol.php";


include 'connection/baglanti.php';

include "tasarim/ustalan.php";


$pth="/kitappastasi/";
//var_dump($_SESSION);

?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1254">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Kitap Pastası | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo $pth; ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo $pth; ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo $pth; ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $pth; ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $pth; ?>dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo $pth; ?>bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo $pth; ?>bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo $pth; ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo $pth; ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo $pth; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  
  <!-- Left side column. contains the logo and sidebar -->

  <!-- Content Wrapper. Contains page content -->
 
 
 
 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Anasayfaya Hoşgeldiniz
        <small></small>
      </h1>
      
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Kullanım İstatistikler</h3>

          
        </div>
        <div class="box-body">
          <!--Start creating your amazing application!-->
		  
					<div class="col-lg-12">
						<div class="col-lg-12">
							<div class="row">
								<div class="col-xs-12">
									<form id="form1">	
										<div class="row">
											<div class="col-xs-6">
												<div id="page_container" class="col-lg-12">
												<?php 
												if($_SESSION['YETKI']=="TAM")
												{
													echo "
													<h3>Kullanıcı Giriş Zamanları</h3>
													<table class=\"datatable\" id=\"table_KULLANICILAR\">
													<thead>
														<tr>
															";
													//gridBaslikOlustur(array('S.No','Giriş Yapan','Giriş Tarihi'));
													echo "</tr>
													</thead>
													<tbody>
													</tbody>
												</table>";
												}
												else
												{}
												?>
												<script type="text/javascript">
													//datatable oluşturduktan sonra çağırıyoruz çünkü görmediği bir alana işlem yapamaz
													var tabloadi= "table_KULLANICILAR";
													var sayfaadi="kontroller/listelogingrid.php";
													var parameter =  [
														   { "data": "row_num"},
														   { "data": "LOGINOLAN" },
														   { "data": "LOGINTARIHI" },
													   ];
													gridbas(tabloadi,sayfaadi,parameter);
												</script>
												</div>
											</div> 	
											
											<?php
											if($_SESSION['YETKI']=="TAM")
												{
												$dataPoints = array();
												try{
													$handle = $pdo->prepare(' select count(kitaplar.kitap_kategoriid) as sayi , kategoriler.isim as isim from kitaplar
 left join kategoriler on kategoriler.id=kitaplar.kitap_kategoriid
 GROUP BY kategoriler.isim'); 
													$handle->execute(); 
													$result = $handle->fetchAll(PDO::FETCH_OBJ);
													foreach($result as $row){
														array_push($dataPoints, array("label"=> $row->isim, "y"=> $row->sayi));
													}
													$pdo = null;
												}
												catch(PDOException $ex){
													print($ex->getMessage());
												}
												}
												else{}
											?>
											<script>
											window.onload = function() {
											var chart = new CanvasJS.Chart("kategorikdagilim", {
												animationEnabled: true,
												theme: "light2",
												title:{
													text: "Kitapların Kategorik Dağılımı"
												},
												axisY: {
													title: "İşlem bazında"
												},
												data: [{
													type: "pie",
													dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
												}]
											});
											chart.render();
											}
											</script>
											<div class="col-xs-6">
											<?php 
											if($_SESSION['YETKI']=="TAM")
												{
													echo "<div id=\"kategorikdagilim\" style=\"height: 370px; width: 100%;\"></div>";
												}
											?>
											</div>
										</div>
									</form>
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

  
  
  
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo $pth; ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo $pth; ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo $pth; ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo $pth; ?>bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo $pth; ?>bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo $pth; ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $pth; ?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo $pth; ?>bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo $pth; ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo $pth; ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo $pth; ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $pth; ?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->

</body>
</html>
