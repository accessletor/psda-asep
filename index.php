<?php 
session_start();
if (!isset($_SESSION["login"])) {
	header("Location: login.php");
	exit;
}
require 'functions.php';
// pagination
$jumlahDataPerhalaman = 2;
$jumlahData = count(query("SELECT * FROM suratm"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
$halamanAktif = (isset($_GET["halaman"])) ? $_GET["halaman"] : 1;
$awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;
// $surat = query("SELECT * FROM suratm ORDER BY id DESC");
$surat = query("SELECT * FROM suratm LIMIT $awalData, $jumlahDataPerhalaman");
// tombol cari di klik

// modal tambah
// cek apakah tombol submit ditekan atau belum
if (isset($_POST['submit'])) {

	// 
	if (tambah($_POST) > 0) {
		echo "<script>
		alert('berhasil menambahkan surat');
		document.location.href = 'index.php';
		</script>";
	}else {
		echo "<script>
		alert('gagal menambahkan surat');
		document.location.href = 'index.php';
		</script>";
	}

}

if (isset($_POST['ubah'])) {
	// 
	if (ubah($_POST) > 0) {
		echo "<script>
		alert('berhasil mengubah data');
		document.location.href = 'index.php';
		</script>";
	}else {
		echo "<script>
		alert('gagal mengubah data');

		</script>";
		echo mysqli_error($conn);
	}
}
if (isset($_POST["cari"])) {
	$surat = search($_POST["keyword"]);
}
// remake
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Input Surat PSDA</title>
	<link rel="stylesheet" href="css/bootstrap.css">
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
		<div class="container">
			<a class="navbar-brand" href="#">PSDA (UMUM)</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav ms-auto">
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
							<path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
						</svg> Surat Masuk</a>
					</li>
					<li class="nav-item">
						<a class="nav-link active" aria-current="page" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-fill" viewBox="0 0 16 16">
							<path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555ZM0 4.697v7.104l5.803-3.558L0 4.697ZM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757Zm3.436-.586L16 11.801V4.697l-5.803 3.546Z"/>
						</svg> Surat Undangan</a>
					</li>
					<li class="nav-item">
						<a href="logout.php"><button type="button" class="btn btn-danger">Logout</button></a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<main>
		<section id="jumbotron">
			<div class="jumbotron">
				<h1>Input Surat Masuk</h1>
			</div>
		</section>
		<br>
		<section id="fitur">
			<div class="container-fluid row">
				<div class="col">
					<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambah" data-bs-whatever="@mdo">Tambah</button>
				</div>
				<div class="col">
					<form action="" method="post">
						<div class="input-group mb-2">
							<input type="text" class="form-control" placeholder="Masukan Keyword Pencarian.." aria-label="Recipient's username" aria-describedby="button-addon2" autofocus autocomplete="off" name="keyword">
							<button class="btn btn-outline-primary" type="cari" id="button-addon2" name="cari">Cari</button>
						</div>
					</form>
				</div>
			</div>
		</section>
		<br>
		<section id="tabel">
			<table class="table table-info table-striped">
				<thead>
					<tr class="table-dark">
						<th scope="col">No</th>
						<th scope="col">Aksi</th>
						<th scope="col">Arsip</th>
						<th scope="col">Tanggal</th>
						<th scope="col">No.Surat</th>
						<th scope="col">Tanggal Surat</th>
						<th scope="col">Asal Surat</th>
						<th scope="col">Perihal</th>
						<th scope="col">Surat</th>
					</tr>
				</thead>
				<tbody>
					<?php $i = 1; ?>
					<?php foreach ($surat as $row) : ?>
						<tr>
							<th scope="row"><?php echo $i; ?></th>
							<td><a href="<?= $row['id']  ?>" id="tombolUbah" data-bs-toggle="modal" data-bs-target="#ubah" data-id="<?= $row['id'] ?>" data-arsip="<?= $row['arsip'] ?>" data-tgl="<?= $row['tgl'] ?>" data-nosurat="<?= $row['nosurat'] ?>" data-tglsurat="<?= $row['tglsurat'] ?>" data-dari="<?= $row['dari'] ?>" data-hal="<?= $row['hal'] ?>" data-surat="<?= $row['surat'] ?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
								<path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
								<path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
							</svg></a> |
							<a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('yakin?')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
								<path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
								<path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
							</svg></a></td>
							<td><?php echo $row['arsip']; ?></td>
							<td><?php echo date('d-m-Y', strtotime($row['tgl'])); ?></td>
							<td><?php echo $row['nosurat']; ?></td>
							<td><?php echo date('d-m-Y', strtotime($row['tglsurat'])); ?></td>
							<td><?php echo $row['dari']; ?></td>
							<td><?php echo $row['hal']; ?></td>
							<td><a href="suratm.php?id=<?php echo $row['id'];?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
								<path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
								<path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
							</svg></a></td>
						</tr>
						<?php $i++; ?>
					<?php endforeach; ?>
				</tbody>
			</table>
		</section>
		<!-- pagination -->
		<div class="container-fluid d-flex justify-content-around">
				<nav aria-label="Page navigation example">
					<ul class="pagination">
						<?php if ($halamanAktif > 1) : ?>
							<li class="page-item">
								<a class="page-link" href="?halaman=<?= $halamanAktif - 1; ?>" aria-label="Previous">
									<span aria-hidden="true">&laquo;</span>
								</a>
							</li>
						<?php endif; ?>
						<?php for ($i=1; $i <= $jumlahHalaman; $i++) : ?>
							<?php if ($i == $halamanAktif) : ?>
								<li class="page-item active" aria-current="page"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
								<?php else : ?>
									<li class="page-item"><a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a></li>
								<?php endif; ?>

							<?php endfor; ?>
							<?php if ($halamanAktif < $jumlahHalaman) : ?>
								<li class="page-item">
									<a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>" aria-label="Next">
										<span aria-hidden="true">&raquo;</span>
									</a>
								</li>
							<?php endif; ?>
						</ul>
					</nav>
				</div>
			</div>

		</main>
		<!--modal tambah  -->
		<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambahLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="tambahLabel">Tambah Surat</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form action="" method="post" enctype="multipart/form-data">
							<div class="mb-3">
								<label for="recipient-name" class="col-form-label">Arsip</label>
								<input type="text" class="form-control" id="recipient-name" name="arsip" required="harus di isi">
							</div>
							<div class="mb-3">
								<label for="tanggal" class="col-form-label">Tanggal</label>
								<input type="date" class="form-control" id="tanggal" name="tgl">
							</div>
							<div class="mb-3">
								<label for="nomor" class="col-form-label">Nomor Surat</label>
								<input type="text" class="form-control" id="nomor" name="nosurat">
							</div>
							<div class="mb-3">
								<label for="tglsurat" class="col-form-label">Tanggal Surat</label>
								<input type="date" class="form-control" id="tglsurat" name="tglsurat">
							</div>
							<div class="mb-3">
								<label for="asal" class="col-form-label">Asal Surat</label>
								<input type="text" class="form-control" id="asal" name="dari" required="harus di isi">
							</div>
							<div class="mb-3">
								<label for="perihal" class="col-form-label">Perihal</label>
								<input type="text" class="form-control" id="perihal" name="hal">
							</div>
							<div class="mb-3">
								<label for="filesurat" class="col-form-label">File Surat</label>
								<input type="file" class="form-control" id="filesurat" name="surat">
							</div>

							<button type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="submit">Tambah</button>

						</form>
					</div>	
				</div>
			</div>
		</div>
		<!-- modal ubah -->
		<div class="modal fade" id="ubah" tabindex="-1" aria-labelledby="ubahLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="ubahLabel">Ubah Data Surat</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form action="" method="post" enctype="multipart/form-data">
							<input type="hidden" name="id" id="id">
							<input type="hidden" name="fileLama" value="<?= $row['surat'] ?>">
							<input type="hidden" name="tglLama" value="<?= $row['tgl'] ?>">
							<input type="hidden" name="tglsuratLama" value="<?= $row['tglsurat'] ?>">
							<div class="mb-3">
								<label for="arsip" class="col-form-label">Arsip</label>
								<input type="text" class="form-control" id="arsip" name="arsip" required="harus di isi">
							</div>
							<div class="mb-3">
								<label for="tanggal" class="col-form-label">Tanggal</label>
								<input type="date" class="form-control" id="tanggal" name="tgl" value="<?= $row['tgl'] ?>">
							</div>
							<div class="mb-3">
								<label for="nomor" class="col-form-label">Nomor Surat</label>
								<input type="text" class="form-control" id="nomor" name="nosurat">
							</div>
							<div class="mb-3">
								<label for="tglsurat" class="col-form-label">Tanggal Surat</label>
								<input type="date" class="form-control" id="tglsurat" name="tglsurat" value="<?= $row['tglsurat'] ?>">
							</div>
							<div class="mb-3">
								<label for="asal" class="col-form-label">Asal Surat</label>
								<input type="text" class="form-control" id="asal" name="dari" required="harus di isi">
							</div>
							<div class="mb-3">
								<label for="perihal" class="col-form-label">Perihal</label>
								<input type="text" class="form-control" id="perihal" name="hal">
							</div>
							<div class="mb-3">

								<label for="filesurat" class="col-form-label">File Surat</label>
								<a href="suratm.php?id=<?php echo $row['id'];?>"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
									<path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z"/>
									<path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z"/>
								</svg></a>
								<input type="file" class="form-control" id="filesurat" name="surat">
							</div>

							<button type="submit" class="btn btn-primary" data-bs-dismiss="modal" name="ubah">Ubah</button>

						</form>
					</div>	
				</div>
			</div>
		</div>
		<script src="js/bootstrap.js"></script>
		<script src="js/sweetalert2.all.min.js"></script>
		<script src="js/jquery.min.js"></script>
		<script>
			$(document).on("click","#tombolUbah", function () {
				let id = $(this).data('id');
				let arsip = $(this).data('arsip');
				let tgl = $(this).data('tgl');
				let nosurat = $(this).data('nosurat');
				let tglsurat = $(this).data('tglsurat');
				let dari = $(this).data('dari');
				let hal = $(this).data('hal');
				let surat = $(this).data('surat');

				$('.modal-body #id').val(id);
				$('.modal-body #arsip').val(arsip);
				$('.modal-body #tanggal').val(tgl);
				$('.modal-body #nomor').val(nosurat);
				$('.modal-body #tglsurat').val(tglsurat);
				$('.modal-body #asal').val(dari);
				$('.modal-body #perihal').val(hal);
				$('.modal-body #filesurat').val(surat);
			})
		</script>
	</body>
	</html>