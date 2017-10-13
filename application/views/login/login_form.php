<html>
<head>
<title>Aplikasi Pemilihan Ketua OSIS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="<?php echo base_url('asset/css/login.css');?>" />
 <script type="text/javascript" src="<?php echo base_url('asset/js/jquery-2.1.3.min.js'); ?>"></script>
 <script>
$(this).ready(function(){  
$("#username").focus();
});
 </script>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="error">
    <!-- pesan start -->
    <?php if (! empty($pesan)) : ?>
        <p id="message">
            <?php echo $pesan; ?>
        </p>
    <?php endif ?>
    <!-- pesan end -->
	<?php echo form_error('username', '<p class="field_error">', '</p>');?>
</div>
	<?php
		$attributes = array('name' => 'login_form', 'id' => 'login_form');
		echo form_open('login', $attributes);
	?>
<div id="login_box">
	<h1>APLIKASI PEMILIHAN KETUA OSIS TAHUN 2017</h1>
	<div id="logo">
	</div><div id="label">Masukkan Kode Akses Anda:</div>
	<div id="login_form">
<div id="nis">
			<input type="text" id="username" name="username" class="form_field text">
	</div>
		<div id="login">
		<input type="submit" class="btn btn-primary" name="submit" id="submit" value="Mulai"/>
		</div>
		</div>
	
</div></form>
</body>
</html>