
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>UHBK 2 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/bootstrap.min.css');?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/hasil.css');?>" />
  <script type="text/javascript" src="<?php echo base_url('asset/js/jquery-2.1.3.min.js'); ?>"></script>
  <script>
  $(document).ready(function() {
	  $('#<?php echo $terpilih; ?>').addClass('terpilih');
	  $('.calon').click(function(){
		var id=$(this).attr('id');
		$('.calon').removeClass('terpilih');
		$('#'+id).addClass('terpilih');
		$.post('<?php echo base_url().'index.php/pilihan/input_pilihan/'; ?>',{idnya:id},function(hasilnya) {
				$('#hasil').html(hasilnya);
			});
	  });
  });
  </script>
</head>
<body>

<nav class="navbar navbar-custom">

 <div id="top"><img src=""/>
	<div id="title">Pemilihan Ketua OSIS SMP Negeri 1 Kaliwungu</div>
	
	<div class="clock">
	<?php echo anchor('logout','(x) Selesai',array('class'=> 'btn btn-warning','onclick'=>"return confirm('Terima Kasih telah memilih, Ketik OK untuk mengakhiri')")) ?>     	        
	</div>
</div>

</nav>
<div id="wrapper">
	<div id="main">
	<div id="no" class="nav_soal">Klik Salah satu  foto calon ketua OSIS untuk memilih Kemudian Klik Tombol Selesai : </div> <div class="nav_soal" id="soal_no"></div>
		<div id="soal">
		<div id="calon">
		
		<?php
		foreach($calon as $row){
			echo '<div id="'.$row->id_calon.'" class="calon" >
			<div class="no_cln"><p>'.$row->id_calon.'</p></div>
					<div class="pigura">
					
					<div class="foto"><img width="100%" height="90%" src="'.base_url().$row->foto.'"/></div>
					</div>
					<div class="nm_cln"><p>'.$row->nama.'</p></div>
			      </div>';
		}
			?>
			</br>
		</div>
		</div>
	</div>
</div>

<!-- jQuery 2.2.0 -->
</body>
  <footer class="main-footer">
  
      	<div class="keluar-footer">
	<?php echo anchor('logout','(x) Selesai',array('class'=> 'btn btn-danger','onclick'=>"return confirm('Terima Kasih telah memilih, Ketik OK untuk mengakhiri')")) ?>     	        
	</div>
     <strong>SNEIKA&copy2016 <div id="hasil"></div> </strong> 
  </footer>
</html>
