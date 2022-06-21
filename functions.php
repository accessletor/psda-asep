<?php 
$conn = mysqli_connect("localhost", "root", "", "psda");
function query($query){
	global $conn;
	$result = mysqli_query($conn, $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc($result)) {
		$rows[] = $row;
	}
	return $rows;
}

// tambah
function tambah($data){
	global $conn;
	$arsip =htmlspecialchars($data['arsip']);
	$tgl = htmlspecialchars($data['tgl']);
	$nosurat = htmlspecialchars($data['nosurat']);
	$tglsurat = htmlspecialchars($data['tglsurat']);
	$dari = htmlspecialchars($data['dari']);
	$hal = htmlspecialchars($data['hal']);

	// $message = htmlspecialchars($data['surat']);
	// upload
	$message = upload();
	if (!$message) {
		return false;
	}

	$query = "INSERT INTO suratm VALUES ('','$arsip','$tgl','$nosurat','$tglsurat','$dari','$hal','$message')";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}
function upload(){
	$namaFile = $_FILES['surat']['name'];
	$ukuranFile = $_FILES['surat']['size'];
	$error = $_FILES['surat']['error'];
	$tmpName = $_FILES['surat']['tmp_name'];
	// cek apakah tidak ada file yang diupload
	// if ($error === 4) {
	// 	echo "<script>
	// 	alert('upload file terlebih dahulu');
	// 	</script>";
	// 	return false;
	// }
	// cek file apakah data surat atau bukan
	$ekstensiFileValid = ['pdf','docx','doc','xls','xlsx','xlsb','xlsm','csv','jpg','jpeg','png'];
	$ekstensiFile = explode('.', $namaFile);
	$ekstensiFile = strtolower(end($ekstensiFile));
	if (!in_array($ekstensiFile, $ekstensiFileValid)) {
		echo "<script>
		alert('file tidak diizinkan atau kosong');
		</script>";
	}
	if ($ukuranFile > 1000000000) {
		echo "<script>
		alert('file terlalu besar);
		</script>";
	}
	// generate nama file baru
	$namaFileBaru = uniqid();
	$namaFileBaru .= '.';
	$namaFileBaru .= $ekstensiFile;
	// lolos pengecekan
	move_uploaded_file($tmpName, 'file/' . $namaFileBaru);
	return $namaFileBaru;
}
// hapus
function hapus($id){
	global $conn;
	mysqli_query($conn, "DELETE FROM suratm WHERE id = $id");
	return mysqli_affected_rows($conn);
}
// ubah data
function ubah($data){
	global $conn;
	$id = $data['id'];
	$arsip =htmlspecialchars($data['arsip']);
	$tgl = htmlspecialchars($data['tgl']);
	$nosurat = htmlspecialchars($data['nosurat']);
	$tglsurat = htmlspecialchars($data['tglsurat']);
	$dari = htmlspecialchars($data['dari']);
	$hal = htmlspecialchars($data['hal']);
	$messageLama = htmlspecialchars($data['fileLama']);
	// cek apakah user upload file baru?
	if ($_FILES['surat']['error'] === 4) {
		$message = $messageLama;
	}else {
		$message = upload();
	}
	

	$query = "UPDATE suratm SET 
	arsip = '$arsip',
	tgl = '$tgl',
	nosurat = '$nosurat',
	tglsurat = '$tglsurat',
	dari = '$dari',
	hal = '$hal',
	surat = '$message'
	WHERE id = $id
	";
	mysqli_query($conn, $query);

	return mysqli_affected_rows($conn);
}
// cari
function search($keyword){
	$query = "SELECT * FROM suratm 
	WHERE arsip LIKE '%$keyword%' OR 
	nosurat LIKE '%$keyword%' OR
	dari LIKE '%$keyword%' OR
	hal LIKE '%$keyword%' OR
	surat LIKE '%$keyword%'
	";
	return query($query);
}
function registrasi($data){
	global $conn;
	$username = strtolower(stripcslashes($data['username']));
	$password = mysqli_real_escape_string($conn,$data['password']);
	$password2 = mysqli_real_escape_string($conn,$data['password2']);
// username sudah ada atau belum
	$result=mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
	if (mysqli_fetch_assoc($result)) {
		echo "<script>
		alert('username sudah terdaftar');
		</script>";
		return false;
	}
	// cek konfirmasi password
	if ($password !== $password2) {
		echo "<script>
		alert('konfirmasi password gagal');
		</script>";
		return false;
	}
	// enkripsi password
	$password = password_hash($password, PASSWORD_DEFAULT);
	mysqli_query($conn, "INSERT INTO user VALUES('', '$username','$password')");
	return mysqli_affected_rows($conn);
	// tambahkan user baru ke database
}
?>