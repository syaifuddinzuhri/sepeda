<div class="container">
	<div class="row my-4">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Data Sepeda</h2>
			</div>
			<div class="pull-right">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah-sepeda">Tambah Sepeda</button>
			</div>
		</div>
	</div>
	<div class="row my-4">
		<div class="col-12">
			<div class="card">
				<div class="card-header bg-primary text-white">Data Sepeda</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover" id="table-sepeda">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nama</th>
									<th scope="col">Merk</th>
									<th scope="col">Plat Nomor</th>
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

<!-- Create Sepeda Modal -->
<div class="modal" tabindex="-1" id="tambah-sepeda">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Sepeda</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form data-toggle="validator" action="sepeda/store" method="POST" id="form-tambah-sepeda">
					<div class="form-group">
						<label class="control-label" for="nama">Nama</label>
						<input type="text" name="nama" class="form-control" required placeholder="Masukkan nama" />
						<small class="text-danger" id="nama_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="merk">Merk</label>
						<input type="text" name="merk" class="form-control" required placeholder="Masukkan merk" />
						<small class="text-danger" id="merk_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="plat_no">Plat Nomor</label>
						<input type="text" name="plat_no" class="form-control" required placeholder="Masukkan plat_no" />
						<small class="text-danger" id="plat_no_error"></small>
					</div>
					<div class="form-group">
						<button type="submit" class="btn crud-submit btn-success">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Edit Sepeda Modal -->
<div class="modal" tabindex="-1" id="edit-sepeda">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Sepeda</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form data-toggle="validator" action="" method="PUT" id="form-edit-sepeda">
					<div class="form-group">
						<label class="control-label" for="nama">Nama</label>
						<input type="text" name="edit_nama" class="form-control" required placeholder="Masukkan nama" />
						<small class="text-danger" id="edit_nama_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="merk">Merk</label>
						<input type="text" name="edit_merk" class="form-control" required placeholder="Masukkan merk" />
						<small class="text-danger" id="edit_merk_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="plat_no">Plat Nomor</label>
						<input type="text" name="edit_plat_no" class="form-control" required placeholder="Masukkan plat_no" />
						<small class="text-danger" id="edit_plat_no_error"></small>
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
	const baseUrlApi = '<?= base_url() ?>sepeda';
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
					rows = rows + '<td>' + value.nama + '</td>';
					rows = rows + '<td>' + value.merk + '</td>';
					rows = rows + '<td>' + value.plat_no + '</td>';
					rows = rows + '<td data-id="' + value.id + '">';
					rows = rows + '<button data-toggle="modal" data-target="#edit-sepeda" class="btn btn-primary edit-sepeda">Edit</button> ';
					rows = rows + '<button class="btn btn-danger remove-sepeda">Delete</button>';
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
		var form_action = $("#tambah-sepeda").find("form").attr("action");
		var nama = $("#tambah-sepeda").find("input[name='nama']").val();
		var merk = $("#tambah-sepeda").find("input[name='merk']").val();
		var plat_no = $("#tambah-sepeda").find("input[name='plat_no']").val();
		$.ajax({
			url: form_action,
			dataType: 'json',
			type: "POST",
			data: {
				nama: nama,
				merk: merk,
				plat_no: plat_no,
			},
			dataType: "json",
			success: function(data) {
				if (data.status == false) {
					if (data.errors.merk_error != '') {
						$('#merk_error').html(data.errors.merk_error);
					} else {
						$('#merk_error').html('');
					}
					if (data.errors.nama_error != '') {
						$('#nama_error').html(data.errors.nama_error);
					} else {
						$('#nama_error').html('');
					}
					if (data.errors.plat_no_error != '') {
						$('#plat_no_error').html(data.errors.plat_no_error);
					} else {
						$('#plat_no_error').html('');
					}
				}
				if (data.status == true) {
					$('#merk_error').html('');
					$('#nama_error').html('');
					$('#plat_no_error').html('');
					$('#form-tambah-sepeda')[0].reset();

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

	$("body").on("click", ".edit-sepeda", function() {
		var id = $(this).parent("td").data('id');
		var plat_no = $(this).parent("td").prev("td").text();
		var merk = $(this).parent("td").prev("td").prev("td").text();
		var nama = $(this).parent("td").prev("td").prev("td").prev("td").text();
		$("#edit-sepeda").find("input[name='edit_merk']").val(merk);
		$("#edit-sepeda").find("input[name='edit_nama']").val(nama);
		$("#edit-sepeda").find("input[name='edit_plat_no']").val(plat_no);
		$("#edit-sepeda").find("form").attr("action", baseUrlApi + '/update/' + id);
	});


	/* Updated new User */
	$(".crud-submit-edit").click(function(e) {
		e.preventDefault();
		var form_action = $("#edit-sepeda").find("form").attr("action");
		var nama = $("#edit-sepeda").find("input[name='edit_nama']").val();
		var merk = $("#edit-sepeda").find("input[name='edit_merk']").val();
		var plat_no = $("#edit-sepeda").find("input[name='edit_plat_no']").val();
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: form_action,
			data: {
				nama: nama,
				merk: merk,
				plat_no: plat_no,
			},
			success: function(data) {
				if (data.status == false) {
					if (data.errors.merk_error != '') {
						$('#merk_error').html(data.errors.merk_error);
					} else {
						$('#merk_error').html('');
					}
					if (data.errors.nama_error != '') {
						$('#nama_error').html(data.errors.nama_error);
					} else {
						$('#nama_error').html('');
					}
					if (data.errors.plat_no_error != '') {
						$('#plat_no_error').html(data.errors.plat_no_error);
					} else {
						$('#plat_no_error').html('');
					}
				}
				if (data.status == true) {
					$('#merk_error').html('');
					$('#nama_error').html('');
					$('#plat_no_error').html('');
					$('#form-tambah-sepeda')[0].reset();


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
	$("body").on("click", ".remove-sepeda", function() {
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
