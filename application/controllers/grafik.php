<?php
class Grafik extends CI_Controller{
private $this_url;
function __construct(){
parent::__construct();
$this->this_url = site_url().'grafik';
}
 
function index(){
$str = "<ol>
        <li><a href=".$this->this_url."/create_graph>Create Graph</a></li></ol>";
 
echo $str;
}
function create_graph(){
$data[0] = array(
        'Jan' => 112,
        'Feb' => 25,
        'Mar' => 0,
        'Apr' => 7,
        'May' => 80,
        'Jun' => 67,
        'Jul' => 45,
        'Aug' => 66,
        'Sep' => 23,
        'Oct' => 23,
        'Nov' => 78,
        'Dec' => 23
    );
$data[1] = array(
        'Jan' => 20,
        'Feb' => 75,
        'Mar' => -35,
        'Apr' => 17,
        'May' => 8,
        'Jun' => 7,
        'Jul' => 15,
        'Aug' => 26,
        'Sep' => 43,
        'Oct' => 33,
        'Nov' => 48,
        'Dec' => 13
    );
/* load library PhpGraph yang dibuat */
$phpgraph = $this->load->library('PhpGraph');
$chart_type = 'vertical-line-graph';
/* konfigurasi lebar dan tinggi gambar */
$cfg['width'] = 700;
$cfg['height'] = 500;
/* set $cfg['compare'] = true , untuk menampilkan grafik dengan perbandingan. $cfg['compare'] pada defaultnya tidak ada */
$cfg['compare'] = true;
/* create_graph($konfigurasi_grafik, $data, $tipe_grafik, $judul_pd_grafik, $nama_berkas) */
$this->phpgraph->create_graph($cfg, $data,'vertical-simple-column-graph','Grafik dengan Tipe vertical-simple-column-graph','compare-'.$chart_type);
 
$cfg['compare'] = false;
$this->phpgraph->create_graph($cfg, $data[0],$chart_type,'Grafik dengan Tipe '.$chart_type,$chart_type);
/* tampilkan grafik */
echo '<img src="'.base_url().$chart_type.'" title="'.$chart_type.'"/>';
echo '<img src="'.base_url().'compare-'.$chart_type.'" title="'.$chart_type.'"/>';
}
}