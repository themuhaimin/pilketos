<?php
$form = array(
    'id_calon' => array(
        'name'=>'id_calon',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('id_calon', isset($form_value['id_calon']) ? $form_value['id_calon'] : '')
    ),
    'nama'    => array(
        'name'=>'nama',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('nama', isset($form_value['nama']) ? $form_value['nama'] : '')
    ),    
    'tpt_lahir'    => array(
        'name'=>'tpt_lahir',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('tpt_lahir', isset($form_value['tpt_lahir']) ? $form_value['tpt_lahir'] : '')
    ),
    'tgl_lahir'    => array(
        'name'=>'tgl_lahir',
        'size'=>'30',
        'class'=>'form_field',
        'value'=>set_value('tgl_lahir', isset($form_value['tgl_lahir']) ? $form_value['tgl_lahir'] : ''),
		'onclick' => "displayDatePicker('tgl_lahir')"
    ),
'foto'    => array(
        'name'=>'foto',
        'type'=>'file',
        'class'=>'form_control',

    ),
    'submit'   => array(
        'name'=>'submit',
        'id'=>'submit',
        'value'=>'Simpan',
		'class'=>'btn tambah btn-success'
    )
);
?>


<!-- pesan start -->
<?php if (! empty($pesan)) : ?>
    <div class="pesan">
        <?php echo $pesan; ?>
    </div>
<?php endif ?>
<!-- pesan end -->

<!-- form start -->
     <form action="<?=base_url().$form_action ?>" method="post" enctype="multipart/form-data">
<table>
	<tr>
        <td><?php echo form_label('No Urut Calon', 'id_calon'); ?></td>
        <td><?php echo form_input($form['id_calon']); ?></td>
	</tr>
	<?php echo form_error('id_calon', '<p class="field_error">', '</p>');?>
	<tr>
        <td><?php echo form_label('Nama', 'nama'); ?></td>
        <td><?php echo form_input($form['nama']); ?></td>
	</tr>
	<tr>
        <td><?php echo form_label('Tempat Lahir', 'tpt_lahir'); ?></td>
        <td><?php echo form_input($form['tpt_lahir']); ?></td>
	</tr>
	<?php echo form_error('tpt_lahir', '<p class="field_error">', '</p>');?>	
	<tr>
        <td> <?php echo form_label('Tanggal (dd-mm-yyyy)', 'tgl_lahir'); ?></td>
        <td><?php echo form_input($form['tgl_lahir']); ?><a href="javascript:void(0);" onclick="displayDatePicker('tgl_lahir');"><img src="<?php echo base_url('asset/images/icon_calendar.png'); ?>" alt="calendar" border="0"></a></td>
		 
	</tr>
	<?php echo form_error('tgl_lahir', '<p class="field_error">', '</p>');?>	
	<tr>
        <td><?php echo form_label('Nama', 'foto'); ?></td>
        <td><?php echo form_input($form['foto']); ?></td>
	</tr>
	<?php echo form_error('tgl_lahir', '<p class="field_error">', '</p>');?>	
		<tr>
        <td><?php echo form_label('Kelas', 'id_kelas'); ?></td>
        <td> <?php echo form_dropdown('id_kelas', $option_kelas, set_value('id_kelas', isset($form_value['id_kelas']) ? $form_value['id_kelas'] : '')); ?></td>
	</tr>
	<?php echo form_error('id_kelas', '<p class="field_error">', '</p>');?>
	<tr>
	<tr>
		<td><?php echo form_submit($form['submit']); ?>
        <?php echo anchor('admin/calon','Batal', array('class' => 'btn tambah btn-success')) ?></td>
	</tr>
</table>
<?php echo form_close(); ?>
<!-- form start -->
<?php
/* End of file siswa_form.php */
/* Location: ./application/views/kelas/siswa_form.php */
?>