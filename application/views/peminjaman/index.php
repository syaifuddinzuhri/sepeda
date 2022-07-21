<div class="container">
	<div class="row my-4">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Data Peminjaman</h2>
			</div>
			<div class="pull-right">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah-peminjaman">Tambah Peminjaman</button>
			</div>
		</div>
	</div>
	<div class="row my-4">
		<div class="col-12">
			<div class="card">
				<div class="card-header bg-primary text-white">Data Peminjaman</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover" id="table-peminjaman">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nama Pengguna</th>
									<th scope="col">Nama Sepeda</th>
									<th scope="col">Tanggal Pinjam</th>
									<th scope="col">Tanggal Kembali</th>
									<th scope="col">Aksi</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
					<ul id="pagination" class="pagination-sm"></ul>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Create Peminjaman Modal -->
<div class="modal" tabindex="-1" id="tambah-peminjaman">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Peminjaman</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form data-toggle="validator" action="peminjaman/store" method="POST" id="form-tambah-peminjaman">
					<label class="control-label" for="pengguna_id">Pengguna</label>
					<select class="form-control" name="pengguna_id" id="pengguna_id">
						<option selected disabled>Pilih Pengguna</option>
						<?php foreach ($data_pengguna as $item) { ?>
							<option value="<?= $item->id ?>"><?= $item->nama ?></option>
						<?php } ?>
					</select>
					<small class="text-danger" id="pengguna_id_error"></small>
					<label class="control-label m-2" for="sepeda_id">Sepeda</label>
					<select class="form-control" name="sepeda_id" id="sepeda_id">
						<option selected disabled>Pilih sepeda</option>
						<?php foreach ($data_sepeda as $item) { ?>
							<option value="<?= $item->id ?>"><?= $item->nama ?></option>
						<?php } ?>
					</select>
					<small class="text-danger" id="sepeda_id_error"></small>
					<div class="form-group">
						<label class="control-label" for="tgl_pinjam">Tanggal Pinjam</label>
						<input type="date" name="tgl_pinjam" class="form-control" required placeholder="Masukkan tanggal pinjam" />
						<small class="text-danger" id="tgl_pinjam_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="tgl_kembali">Tanggal kembali</label>
						<input type="date" name="tgl_kembali" class="form-control" required placeholder="Masukkan tanggal kembali" />
						<small class="text-danger" id="tgl_kembali_error"></small>
					</div>
					<div class="form-group">
						<button type="submit" class="btn crud-submit btn-success">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Edit Peminjaman Modal -->
<div class="modal" tabindex="-1" id="edit-peminjaman">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Peminjaman</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form data-toggle="validator" action="" method="PUT" id="form-edit-peminjaman">
					<label class="control-label" for="pengguna_id">Pengguna</label>
					<select class="form-control" name="pengguna_id" id="edit_pengguna_id">
						<option selected disabled>Pilih pengguna</option>
						<?php foreach ($data_pengguna as $item) { ?>
							<option value="<?= $item->id ?>"><?= $item->nama ?></option>
						<?php } ?>
					</select>
					<small class="text-danger" id="pengguna_id_error"></small>
					<label class="control-label m-2" for="sepeda_id">Sepeda</label>
					<select class="form-control" name="sepeda_id" id="edit_sepeda_id">
						<option selected disabled>Pilih sepeda</option>
						<?php foreach ($data_sepeda as $item) { ?>
							<option value="<?= $item->id ?>"><?= $item->nama ?></option>
						<?php } ?>
					</select>
					<small class="text-danger" id="sepeda_id_error"></small>
					<div class="form-group">
						<label class="control-label" for="tgl_pinjam">Tanggal Pinjam</label>
						<input type="date" name="tgl_pinjam" class="form-control" required placeholder="Masukkan tanggal pinjam" />
						<small class="text-danger" id="edit_tgl_pinjam_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="tgl_kembali">Tanggal kembali</label>
						<input type="date" name="tgl_kembali" class="form-control" required placeholder="Masukkan tanggal kembali" />
						<small class="text-danger" id="edit_tgl_kembali_error"></small>
					</div>
					<div class="form-group">
						<button type="submit" class="btn crud-submit-edit btn-success">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	const baseUrlApi = '<?= base_url() ?>peminjaman';
	var page = 1;
	var current_page = 1;
	var total_page = 0;
	var is_ajax_fire = 0;

	manageData();

	/* manage data list */
	function manageData(search = '') {
		$.ajax({
			type: "GET",
			dataType: 'json',
			url: baseUrlApi + '/all',
			data: {
				page: page,
			}
		}).done(function(data) {
			total_page = data.total % 5;
			current_page = page;
			var rows = '';
			if (data.data.length > 0) {
				let i = 1;
				$.each(data.data, function(key, value) {
					rows = rows + '<tr>';
					rows = rows + '<td>' + (i++) + '</td>';
					rows = rows + '<td>' + value.nama_pengguna + '</td>';
					rows = rows + '<td>' + value.nama_sepeda + '</td>';
					rows = rows + '<td>' + value.tgl_pinjam + '</td>';
					rows = rows + '<td>' + value.tgl_kembali + '</td>';
					rows = rows + '<td data-id="' + value.id + '" data-sepeda-id="' + value.sepeda_id + '" data-pengguna-id="' + value.pengguna_id + '">';
					rows = rows + '<button data-toggle="modal" data-target="#edit-peminjaman" class="btn btn-primary edit-peminjaman">Edit</button> ';
					rows = rows + '<button class="btn btn-danger remove-peminjaman">Delete</button>';
					rows = rows + '</td>';
					rows = rows + '</tr>';
				});
			} else {
				rows = rows + '<tr>';
				rows = rows + '<td  colspan="7" class="text-center">Data kosong</td>';
				rows = rows + '</tr>';
			}
			$("tbody").html(rows);
		});
	}

	/* Create new User */
	$(".crud-submit").click(function(e) {
		e.preventDefault();
		var form_action = $("#tambah-peminjaman").find("form").attr("action");
		var pengguna_id = $('#pengguna_id').find(":selected").val();
		var sepeda_id = $('#sepeda_id').find(":selected").val();
		var tgl_pinjam = $("#tambah-peminjaman").find("input[name='tgl_pinjam']").val();
		var tgl_kembali = $("#tambah-peminjaman").find("input[name='tgl_kembali']").val();
		$.ajax({
			url: form_action,
			dataType: 'json',
			type: "POST",
			data: {
				sepeda_id: sepeda_id,
				pengguna_id: pengguna_id,
				tgl_pinjam: tgl_pinjam,
				tgl_kembali: tgl_kembali,
			},
			dataType: "json",
			success: function(data) {
				if (data.status == false) {
					if (data.errors.pengguna_id_error != '') {
						$('#pengguna_id_error').html(data.errors.pengguna_id_error);
					} else {
						$('#pengguna_id_error').html('');
					}
					if (data.errors.sepeda_id_error != '') {
						$('#sepeda_id_error').html(data.errors.sepeda_id_error);
					} else {
						$('#sepeda_id_error').html('');
					}
					if (data.errors.tgl_pinjam_error != '') {
						$('#tgl_pinjam_error').html(data.errors.tgl_pinjam_error);
					} else {
						$('#tgl_pinjam_error').html('');
					}
					if (data.errors.tgl_kembali_error != '') {
						$('#tgl_kembali_error').html(data.errors.tgl_kembali_error);
					} else {
						$('#tgl_kembali_error').html('');
					}
				}
				if (data.status == true) {
					$('#tgl_pinjam_error').html('');
					$('#tgl_kembali_error').html('');
					$('#sepeda_id_error').html('');
					$('#pengguna_id_error').html('');
					$('#form-tambah-peminjaman')[0].reset();

					manageData();
					$(".modal").modal('hide');
					toastr.success('Data berhasil ditambahkan.', 'Success Alert', {
						timeOut: 5000
					});
				}
			}
		})
	});

	$('#search').keyup(function() {
		var search = $(this).val();
		if (search != '') {
			manageData(search);
		} else {
			manageData();
		}
	});

	$("body").on("click", ".edit-peminjaman", function() {
		var id = $(this).parent("td").data('id');
		var sepeda_id = $(this).parent("td").data('sepeda-id');
		var pengguna_id = $(this).parent("td").data('pengguna-id');
		var tgl_kembali = $(this).parent("td").prev("td").text();
		var tgl_pinjam = $(this).parent("td").prev("td").prev("td").text();

		var tgl_kembali1 = new Date(tgl_kembali).toISOString().split('T')[0];
		var tgl_pinjam1 = new Date(tgl_pinjam).toISOString().split('T')[0];

		$("#edit-peminjaman").find("input[name='tgl_pinjam']").val(tgl_pinjam1);
		$("#edit-peminjaman").find("input[name='tgl_kembali']").val(tgl_kembali1);
		$('#edit_pengguna_id').val(pengguna_id).change()
		$('#edit_sepeda_id').val(sepeda_id).change()

		$("#edit-peminjaman").find("form").attr("action", baseUrlApi + '/update/' + id);
	});


	/* Updated new User */
	$(".crud-submit-edit").click(function(e) {
		e.preventDefault();
		var form_action = $("#edit-peminjaman").find("form").attr("action");
		var pengguna_id = $('#edit_pengguna_id').find(":selected").val();
		var sepeda_id = $('#edit_sepeda_id').find(":selected").val();
		var tgl_pinjam = $("#edit-peminjaman").find("input[name='tgl_pinjam']").val();
		var tgl_kembali = $("#edit-peminjaman").find("input[name='tgl_kembali']").val();
		var data = {
			sepeda_id: sepeda_id,
			pengguna_id: pengguna_id,
			tgl_pinjam: tgl_pinjam,
			tgl_kembali: tgl_kembali,
		}
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: form_action,
			data: data,
			success: function(data) {
				if (data.status == false) {
					if (data.errors.pengguna_id_error != '') {
						$('#edit_pengguna_id_error').html(data.errors.pengguna_id_error);
					} else {
						$('#edit_pengguna_id_error').html('');
					}
					if (data.errors.sepeda_id_error != '') {

						$('#edit_sepeda_id_error').html(data.errors.sepeda_id_error);
					} else {
						$('#edit_sepeda_id_error').html('');
					}
					if (data.errors.tgl_pinjam_error != '') {
						$('#edit_tgl_pinjam_error').html(data.errors.tgl_pinjam_error);
					} else {
						$('#edit_tgl_pinjam_error').html('');
					}
					if (data.errors.tgl_kembali_error != '') {
						$('#edit_tgl_kembali_error').html(data.errors.tgl_kembali_error);
					} else {
						$('#edit_tgl_kembali_error').html('');
					}
				}

				if (data.status == true) {
					$('#edit_tgl_pinjam_error').html('');
					$('#edit_tgl_kembali_error').html('');
					$('#edit_sepeda_id_error').html('');
					$('#edit_pengguna_id_error').html('');
					$('#form-edit-peminjaman')[0].reset();


					manageData();
					$(".modal").modal('hide');
					toastr.success('Data berhasil diupdate.', 'Success Alert', {
						timeOut: 5000
					});
				}
			}
		})
	});

	/* Remove User */
	$("body").on("click", ".remove-peminjaman", function() {
		var id = $(this).parent("td").data('id');
		var c_obj = $(this).parents("tr");
		$.ajax({
			dataType: 'json',
			type: 'delete',
			url: baseUrlApi + '/delete/' + id,
		}).done(function(data) {
			c_obj.remove();
			toastr.success('Data berhasil dihapus.', 'Success Alert', {
				timeOut: 5000
			});
			manageData();
		});
	});
</script>
