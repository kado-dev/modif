<h3 >Data Registrasi</h3>
<?php
	echo $this->session->flashdata('report');
?>
<p class="lead">
	<table class="table table-condensed table-striped">
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>Email</th>
			<th>Handphone</th>
			<th>Status</th>
			<th>Keyid</th>
			<th>Aksi</th>
		</tr>
		<?php
		foreach($data->result() as $dt){
			echo "<tr>";
			echo "<td>".$dt->id."</td>";
			echo "<td>".$dt->Username."</td>";
			echo "<td>".$dt->Email."</td>";
			echo "<td>".$dt->Handphone."</td>";
			echo "<td>".$dt->Approve."</td>";
			echo "<td>".$dt->keys."</td>";
			echo "<td><a href='".site_url('home/registrasi_approve/'.$dt->id)."'>Approve</a></td>";
			echo "</tr>";
		}
		?>
	</table>
</p>
