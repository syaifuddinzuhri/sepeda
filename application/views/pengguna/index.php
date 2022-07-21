<div class="container">
	<div class="row my-4">
		<div class="col-lg-12 margin-tb">
			<div class="pull-left">
				<h2>Data Pengguna</h2>
			</div>
			<div class="pull-right">
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#tambah-pengguna">Tambah Pengguna</button>
			</div>
		</div>
	</div>
	<div class="row my-4">
		<div class="col-12">
			<div class="card">
				<div class="card-header bg-primary text-white">Data Pengguna</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover" id="table-pengguna">
							<thead>
								<tr>
									<th scope="col">#</th>
									<th scope="col">Nama</th>
									<th scope="col">Email</th>
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

<!-- Create Pengguna Modal -->
<div class="modal" tabindex="-1" id="tambah-pengguna">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Tambah Pengguna</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form data-toggle="validator" action="pengguna/store" method="POST" id="form-tambah-pengguna">
					<div class="form-group">
						<label class="control-label" for="nama">Nama</label>
						<input type="text" name="nama" class="form-control" required placeholder="Masukkan nama" />
						<small class="text-danger" id="nama_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="email">Email</label>
						<input type="email" name="email" class="form-control" required placeholder="Masukkan email" />
						<small class="text-danger" id="email_error"></small>
					</div>
					<div class="form-group">
						<button type="submit" class="btn crud-submit btn-success">Submit</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Edit Pengguna Modal -->
<div class="modal" tabindex="-1" id="edit-pengguna">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Edit Pengguna</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form data-toggle="validator" action="" method="PUT" id="form-edit-pengguna">
					<div class="form-group">
						<label class="control-label" for="edit_nama">Nama</label>
						<input type="text" name="edit_nama" class="form-control" required placeholder="Masukkan nama" />
						<small class="text-danger" id="edit_nama_error"></small>
					</div>
					<div class="form-group">
						<label class="control-label" for="edit_email">Email</label>
						<input type="email" name="edit_email" class="form-control" required placeholder="Masukkan email" />
						<small class="text-danger" id="edit_email_error"></small>
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
	const baseUrlApi = '<?= base_url() ?>pengguna';
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
					rows = rows + '<td>' + value.email + '</td>';
					rows = rows + '<td data-id="' + value.id + '">';
					rows = rows + '<button data-toggle="modal" data-target="#edit-pengguna" class="btn btn-primary edit-pengguna">Edit</button> ';
					rows = rows + '<button class="btn btn-danger remove-pengguna">Delete</button>';
					rows = rows + '</td>';
					rows = rows + '</tr>';
				});
			} else {
				rows = rows + '<tr>';
				rows = rows + '<td  colspan="6" class="text-center">Data kosong</td>';
				rows = rows + '</tr>';
			}
			$("tbody").html(rows);
		});
	}

	/* Create new User */
	$(".crud-submit").click(function(e) {
		e.preventDefault();
		var form_action = $("#tambah-pengguna").find("form").attr("action");
		var email = $("#tambah-pengguna").find("input[name='email']").val();
		var nama = $("#tambah-pengguna").find("input[name='nama']").val();
		$.ajax({
			url: form_action,
			dataType: 'json',
			type: "POST",
			data: {
				email: email,
				nama: nama,
			},
			dataType: "json",
			success: function(data) {
				if (data.status == false) {
					if (data.errors.nama_error != '') {
						$('#nama_error').html(data.errors.nama_error);
					} else {
						$('#nama_error').html('');
					}
					if (data.errors.email_error != '') {
						$('#email_error').html(data.errors.email_error);
					} else {
						$('#email_error').html('');
					}
				}
				if (data.status == true) {
					$('#nama_error').html('');
					$('#email_error').html('');
					$('#form-tambah-pengguna')[0].reset();

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

	$("body").on("click", ".edit-pengguna", function() {
		var id = $(this).parent("td").data('id');
		var email = $(this).parent("td").prev("td").text();
		var nama = $(this).parent("td").prev("td").prev("td").text();
		$("#edit-pengguna").find("input[name='edit_nama']").val(nama);
		$("#edit-pengguna").find("input[name='edit_email']").val(email);
		$("#edit-pengguna").find("form").attr("action", baseUrlApi + '/update/' + id);
	});


	/* Updated new User */
	$(".crud-submit-edit").click(function(e) {
		e.preventDefault();
		var form_action = $("#edit-pengguna").find("form").attr("action");
		var nama = $("#edit-pengguna").find("input[name='edit_nama']").val();
		var email = $("#edit-pengguna").find("input[name='edit_email']").val();
		$.ajax({
			dataType: 'json',
			type: 'POST',
			url: form_action,
			data: {
				email: email,
				nama: nama,
			},
			success: function(data) {
				if (data.status == false) {
					if (data.errors.nama_error != '') {
						$('#edit_nama_error').html(data.errors.nama_error);
					} else {
						$('#edit_nama_error').html('');
					}
					if (data.errors.email_error != '') {
						$('#edit_email_error').html(data.errors.email_error);
					} else {
						$('#edit_email_error').html('');
					}
				}
				if (data.status == true) {
					$('#edit_nama_error').html('');
					$('#edit_email_error').html('');
					$('#form-edit-pengguna')[0].reset();

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
	$("body").on("click", ".remove-pengguna", function() {
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
