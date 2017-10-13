<!-- tabel data end -->
<script>
$(document).ready(function(){
setInterval(function(){
$("#grafik").load()
}, 10);
});
</script>

<!-- pesan flash message start -->
<?php $flash_pesan = $this->session->flashdata('pesan')?>
<?php if (! empty($flash_pesan)) : ?>
    <div class="pesan">
        <?php echo $flash_pesan; ?>
    </div>
<?php endif ?>
<!-- pesan flash message end -->

<!-- pesan start -->
<?php if (! empty($pesan)) : ?>
    <div class="pesan">
        <?php echo $pesan; ?>
    </div>
<?php endif ?>
<!-- pesan end -->

<!-- tabel data start -->
<title>Integrasi Open Flash Chart dengan CodeIgniter</title>
<style>
body{
font-family:Tahoma;
font-size:12px;
}
#chart{
margin:0px auto;
width:800px;
float:none;
}
</style>
<div id="chart">
<?php
echo $this->graph->render();
?>
</div>
<!-- tabel data end -->
