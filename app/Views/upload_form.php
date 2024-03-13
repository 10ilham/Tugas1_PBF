<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Mengatur judul halaman -->
    <title>Upload Form</title>
</head>

<body>

    <!-- Jika ada kesalahan, tampilkan dalam daftar -->
    <?php if (!empty($errors)) : ?>
        <ul>
            <?php foreach ($errors as $error) : ?>
                <!-- Menghindari serangan XSS dengan melarikan diri dari kesalahan -->
                <li><?= esc($error) ?></li>
            <?php endforeach ?>
        </ul>
    <?php endif ?>

    <!-- Membuka form yang memungkinkan pengunggahan file. Formulir akan dikirimkan ke rute 'upload/upload' -->
    <?= form_open_multipart('upload/upload') ?>
    <!-- Membuat bidang input file -->
    <input type="file" name="userfile" size="100">
    <br><br>
    <!-- Membuat tombol submit -->
    <input type="submit" value="upload">
    <!-- Menutup form -->
    </form>

</body>

</html>