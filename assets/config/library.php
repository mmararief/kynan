<?php
date_default_timezone_set('Asia/Jakarta'); // PHP 6 mengharuskan penyebutan timezone.
$seminggu = array("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");
$hari = date("w");
$hari_ini = $seminggu[$hari];

$tgl_sekarang = date("Ymd");
$tgl_skrg     = date("d");
$bln_sekarang = date("m");
$thn_sekarang = date("Y");
$jam_sekarang = date("H:i:s");

$nama_bln=array(1=> "Januari", "Februari", "Maret", "April", "Mei", 
                    "Juni", "Juli", "Agustus", "September", 
                    "Oktober", "November", "Desember");

function generateRandomString($length = 10) {
    return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
}
    
class rss {
 var $feed;
     function rss($feed){
        $this->feed = $feed;   
     }

    function parse(){
        $rss = simplexml_load_file($this->feed);
        $rss_split = array();
        foreach ($rss->channel->item as $item) {
          $title = (string) $item->title; // Judul
          $link   = (string) $item->link; // Link URL
          $view   = (string) $item->view;
          $description = (string) $item->description; // Deskripsi  
          $rss_split[] = '
                <li style="padding: 0px 0;" class="item">
                  <div class="product-img">
                    <img class="img-circle img-thumbnail" src="http://localhost/lokomedia_ci/asset/admin/dist/img/users.gif" alt="Product Image">
                  </div>
                  <div class="product-info">
                    <a target="_BLANK" href="'.$link.'" class="product-title">'.$title.'
                      <span class="label label-success pull-right">'.$view.' Kali</span></a>
                        <span class="product-description">
                          '.$description.'
                        </span>
                  </div>
                </li>';
        }
        return $rss_split;
    }
      
    function display($numrows,$head){
        $rss_split = $this->parse();
        $i = 0;
        $rss_data = '
        <div class="box box-warning">
            <div class="box-header with-border">
            <i class="fa fa-users"></i>
              <h3 class="box-title">'.$head.'</h3>
                <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>

            <div class="box-body">
              <ul class="products-list product-list-in-box">';
        while ( $i < $numrows ){
          $rss_data .= $rss_split[$i];
          $i++;
        }
        $trim = str_replace('', '',$this->feed);
        $user = str_replace('&lang=en-us&format=rss_200','',$trim);
        $rss_data.='</ul></div>
                    <div class="box-footer text-center">
                      <a class="btn btn-default btn-sm btn-block" target="_BLANK" href="https://members.phpmu.com/forum" class="uppercase">View All Topic</a><br>
                    </div></div>';
        return $rss_data;
    }
}
?>
