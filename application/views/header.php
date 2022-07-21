<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

	<!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

	<title>Aplikasi Peminjaan</title>
</head>

<body>

	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container">
			<a class="navbar-brand" href="<?= base_url('/') ?>">PEMINJAMAN</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('/') ?>">Dashboard</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('/pengguna') ?>">Pengguna</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('/sepeda') ?>">Sepeda</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('/peminjaman') ?>">Peminjaman</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="<?= base_url('/auth/logout') ?>">Logout</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
