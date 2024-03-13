<!-- Menampilkan judul berita. Fungsi 'esc' digunakan untuk mencegah serangan XSS. -->
<h2><?= esc($news['title']) ?></h2>

<!-- Menampilkan isi berita. Fungsi 'esc' juga digunakan di sini untuk mencegah serangan XSS. -->
<p><?= esc($news['body']) ?></p>