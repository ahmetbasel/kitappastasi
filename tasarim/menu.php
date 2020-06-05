<?php 
 session_start();  
 error_reporting(0);
$pth="/kitappastasi/";

$m_yayinevi	="";
$m_odunc	= "";
$m_iade	= "";
$m_yazar	= "";
$m_kitap="";
$m_raf="";
$m_bagis="";
$m_uye="";

if(($_SESSION['YETKI']=="TAM") || ($_SESSION['YETKI']=="KISITLI"))
$m_odunc= "
		<li>
          <a href=\"".$pth."sayfalar/oduncekle.php\" class=\"btn btn-success btn\">
            <i class=\"fa fa-th\"></i> <span>Ödünç İşlemleri</span>
            <span class=\"pull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
			";
if(($_SESSION['YETKI']=="TAM") || ($_SESSION['YETKI']=="KISITLI"))
$m_iade= "
		<li>
          <a href=\"".$pth."sayfalar/iadeekle.php\" class=\"btn btn-success btn\">
            <i class=\"fa fa-th\"></i> <span>İade İşlemleri</span>
            <span class=\"pull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
			";
if($_SESSION['YETKI']=="TAM")
$m_uye= "
		<li>
          <a href=\"".$pth."sayfalar/uyeekle.php\" class=\"btn btn-success btn\">
            <i class=\"fa fa-th\"></i> <span>Üye İşlemleri</span>
            <span class=\"pull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
			";
if(($_SESSION['YETKI']=="TAM") || ($_SESSION['YETKI']=="KISITLI"))		
$m_kitap="
		<li>
          <a href=\"".$pth."sayfalar/kitapekle.php\" class=\"btn btn-success btn\">
            <i class=\"fa fa-th\"></i> <span>Kitap İşlemleri</span>
            <span class=\"pull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
			";
if($_SESSION['YETKI']=="TAM")					
$m_yazar= "
		<li>
          <a href=\"".$pth."sayfalar/yazarekle.php\" class=\"btn btn-success btn\">
            <i class=\"fa fa-th\"></i> <span>Yazar İşlemleri</span>
            <span class=\"pull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
			";
if($_SESSION['YETKI']=="TAM")			
$m_raf= "
		<li>
          <a href=\"".$pth."sayfalar/rafekle.php\" class=\"btn btn-success btn\">
            <i class=\"fa fa-th\"></i> <span>Raf İşlemleri</span>
            <span class=\"pull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
			";
if($_SESSION['YETKI']=="TAM")				
$m_yayinevi="
		<li>
          <a href=\"".$pth."sayfalar/yayineviekle.php\" class=\"btn btn-success btn\">
            <i class=\"fa fa-th\"></i> <span>Yayınevi İşlemleri</span>
            <span class=\"pull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
			";



echo "
<aside class=\"main-sidebar\">
    <section class=\"sidebar\">
      <div class=\"user-panel\">
        <div class=\"pull-left \">
          <img src=\"".$pth."logo.png\" width=\"200px\" alt=\"User Image\">
        </div>
      </div>
      <form action=\"#\" method=\"get\" class=\"sidebar-form\">
        
      </form>
      <ul class=\"sidebar-menu\" data-widget=\"tree\">
        <li class=\"navbar\">
          <a href=\"".$pth."index.php\" class=\"btn btn-primary btn\">
            <i class=\"fa fa-th\"></i> <span>Dashboard</span>
            <span class=\"hiddebpull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
       
".
$m_odunc.
$m_iade.
$m_uye.
$m_kitap.
$m_yayinevi.	
$m_yazar.
$m_raf.


"
     <div class=\"dropdown-divider\"></div>
		<li class=\"navbar\">
          <a href=\"".$pth."sayfalar/profil.php\" class=\"btn btn-info btn\">
            <i class=\"fa fa-th\"></i> <span>Profil</span>
            <span class=\"hiddebpull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
		<li class=\"navbar\">
          <a href=\"".$pth."sayfalar/uzerimdekiler.php\" class=\"btn btn-info btn\">
            <i class=\"fa fa-th\"></i> <span>Üzerimdekiler</span>
            <span class=\"hiddebpull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
		<li class=\"navbar\">
          <a href=\"".$pth."sayfalar/iadelerim.php\" class=\"btn btn-info btn\">
            <i class=\"fa fa-th\"></i> <span>İadelerim</span>
            <span class=\"hiddebpull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>
		<li class=\"navbar\">
          <a href=\"".$pth."logout.php\" class=\"btn btn-primary btn\">
            <i class=\"fa fa-th\"></i> <span>Çıkış Yap</span>
            <span class=\"hiddebpull-right-container\">
              <small class=\"label pull-right bg-green\"></small>
            </span>
          </a>
        </li>

      </ul>
    </section>
  </aside>";
?>