<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

	<title>Aplikasi Peminjaman</title>
</head>

<body class="bg-primary">
	<div class="container">
		<div class="row my-5">
			<div class="col-md-6 offset-md-3">
				<div class="card">
					<div class="card-body">
						<h1>LOGIN</h1>
						<form action="" method="POST">
							<div class="form-group">
								<label for="username">Username</label>
								<input type="text" class="form-control <?= form_error('username') ? 'invalid' : '' ?>" id="usernam" name="username" value="<?= set_value('username') ?>">
								<div class="invalid-feedback">
									<?= form_error('username') ?>
								</div>
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" class="form-control <?= form_error('password') ? 'invalid' : '' ?>" id="password" name="password" value="<?= set_value('password') ?>">
								<div class="invalid-feedback">
									<?= form_error('password') ?>
								</div>
							</div>
							<button type="submit" class="btn btn-primary">Login</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>
