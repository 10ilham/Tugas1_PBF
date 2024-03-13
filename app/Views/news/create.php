<!-- Poin 3 pada Create News Items (Bangun aplikasi pertama) -->
<!-- Terhubung ke public function new() di News.php pada Controller -->
<!-- Menampilkan judul halaman dengan melakukan escape terhadap variabel $title untuk mencegah XSS -->
<h2><?= esc($title) ?></h2>

<!-- Menampilkan pesan error yang disimpan dalam session jika ada -->
<?= session()->getFlashdata('error') ?>

<!-- Menampilkan daftar kesalahan validasi jika ada -->
<?= validation_list_errors() ?>

<!-- Membuat form dengan metode POST yang akan mengirim data ke URL /news -->
<form action="/news" method="post">

    <!-- Membuat field CSRF untuk mencegah serangan CSRF -->
    <?= csrf_field() ?>

    <!-- Membuat label untuk field judul -->
    <label for="title">Title</label>
    <!-- Membuat field input untuk judul, dengan nilai default dari fungsi set_value() -->
    <input type="input" name="title" value="<?= set_value('title') ?>">

    <br> <!-- Membuat baris baru -->

    <label for="body">Deskripsi</label> <!-- Membuat label untuk field deskripsi -->
    <!-- Membuat field textarea untuk deskripsi, dengan nilai default dari fungsi set_value() -->
    <textarea name="body" cols="45" rows="4"><?= set_value('body') ?></textarea>

    <br> <!-- Membuat baris baru -->

    <input type="submit" name="submit" value="Create news item"> <!-- Membuat tombol submit -->
</form> <!-- Menutup tag form -->
<!-- END Dari Poin 3 pada Create News Items (Bangun aplikasi pertama Anda) -->