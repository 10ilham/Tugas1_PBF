# Ilham Munawar_220102037

![Logo](https://file.notion.so/f/f/c8e21fd1-aa93-4db3-9ae0-6b3890a71ba5/529a07c0-8417-4ba6-85e7-b1cd79fe04a1/Desain_tanpa_judul.gif?id=9d3581c3-d794-4de8-b213-2c6168bc0148&table=block&spaceId=c8e21fd1-aa93-4db3-9ae0-6b3890a71ba5&expirationTimestamp=1710849600000&signature=QNjE8lNpesC9DTZaEfoIruSEOOLkPqF32nEsc6a2c78)

[Penjelasan lebih lengkap tentang project saya, Klik disini](https://responsible-fact-6d4.notion.site/Installation-2e27d7f5103e420f96b0bd21445d2eb2?pvs=4)

## Apa itu CodeIgniter?

CodeIgniter adalah framework web full-stack PHP yang ringan, cepat, fleksibel, dan aman.

Repository ini berisi aplikasi starter yang dapat diinstal menggunakan Composer maupun manual instalasi.

## Installation

#### **Installation Manual**

1. Install Manual CodeIgniter4 pada link berikut,

[CodeIgniter 4.](https://github.com/CodeIgniter4/framework/releases/tag/v4.4.6)

2. Ekstrak Project ke Root folder pada penyimpanan
3. Jalankan server dengan masuk ke dalam root project → code editor (Visual Studio Code) → Terminal → ketik :

```shell
$ cd nama-root
$ php spark serve
```

#### **Installation Composer**

1. Buka folder root yang digunakan untuk menyimpan CodeIgniter, klik kanan lalu buka folder tersebut lewat Terminal.
   Ketikkan :

```shell
$ composer create-project codeigniter4/appstarter nama-project
```

2. Jalankan server

```shell
$ cd nama-root
$ php spark serve
```

#### **Konfigurasi Awal**

Menetapkan konfigurasi dasar yang digunakan pada project melalui file `app/Config/App.php` atau `.env`

1. Menetapkan nilai URL dasar pada **$baseURL (App.php) atau app.baseURL (.env)**

```php
public string $baseURL = 'http://localhost/'; //Pastikan untuk menambahkan slash di akhir (App.php)
app.baseURL = 'http://localhost/' //.env
```

2. Menentukan index page
   Jika tidak ingin menyertakan **index.php** di URI situs setel `$indexPage`ke `''` pada **`app/Config/App.php`**.

```php
public string $indexPage = 'index.php'; -> public string $indexPage = '';
```

3. Atur ke Mode Development

setel `CI_ENVIRONMENT`ke `development` dalam file **.env** untuk memanfaatkan alat debugging.

4. Menambahkan Alias Host

Mengaktifkan vhost_alias_module
Pastikan modul virtual hosting diaktifkan (tidak dikomentari) di file konfigurasi utama, pada laragon buka **`menu→apache→httpd.conf`** :

```makefile
LoadModule vhost_alias_module modules/mod_vhost_alias.so #hilangkan komentar yang sebelumnya ada (#)
```

Tambahkan alias host di file “**hosts**”, biasanya **`C:\Windows\System32\drivers\etc`**

```makefile
127.0.0.1 ilham.com #misalnya disini saya memasukkan domain custom
```

Jalankan pada terminal `php spark serve --host [ilham.com](http://ilham.com/)`

5. Menentukan port server yang akan dijalankan
   Secara default, server berjalan pada port 8080 tetapi bisa dirubah menggunakan `--port`.

```shell
php spark serve --port 8888 ##Pastikan port yang digunakan belum digunakan pada aplikasi lain yang berjalan
```

## Build Your First Application

#### **Static Pages**

Pages controller :

1. Terdapat file Pages controller di `app/Controllers/Pages.php` dengan kode berikut.

```php
<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function view($page = 'home')
    {
        // ...
    }
}
```

2. Buka file rute yang terletak di `app/Config/Routes.php`.

Menambahkan baris berikut, untuk meyambungkan dengan `Pages.php` yang di Controllers.

```php
use App\Controllers\Pages;

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);
```

3. Tampilan

Terdapat folder baru `templates` dan file `header.php` didalamnya, pada folder `app/Views`**.**

Isi code pada `header.php`:

```php
<!doctype html>
<html>

<head>
    <title>CodeIgniter Tutorial</title>
</head>

<body>

    <h1><?= esc($title) ?></h1>
    <!-- esc fungsi global yang disediakan oleh CodeIgniter untuk membantu mencegah serangan XSS -->
```

terdapat footer di **app/Views/templates/footer.php**

```php
<footer>ini footer</footer>
<em>&copy; 2024</em>
</body>

</html>
```

4. Menambahkan Logika ke Controller

Terdapat folder pages di `app/Views/` lalu ada dua file bernama **`home.php`** dan **`about.php`** pada`app/Views/pages/`.

`home.php` :

```php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>

<body>
    <h1>Welcome to the Home Page</h1>
</body>

</html>
```

`about.php` :

```php
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Page</title>
</head>

<body>
    <h1>Tetang saya</h1>
    <p>Ini adalah halaman tentang situs web.</p>
</body>

</html>
```

Pada file `app/controllers/Pages.php`

```php
<?php

namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException; //untuk mengimpor kelas PageNotFoundException
//CodeIgniter\Exceptions. tidak ada folder fisik yang secara langsung menampungnya di struktur proyek standar ini berasal dari default sistem ci

class Pages extends BaseController
{
		//http://localhost:8080/pages menampilkan index() welcome_message
    public function index()
    {
        // Menampilkan halaman utama (welcome_message.php)
        return view('welcome_message');
    }

    public function view($page = 'home')
    {
        //.. Tambahan code

        // Mengecek apakah halaman yang diminta ada
        if (!is_file(APPPATH . 'Views/pages/' . $page . '.php')) {
            // Jika tidak ada, lempar PageNotFoundException
            throw new PageNotFoundException($page);
        }

        // Mengatur judul halaman berdasarkan nama halaman
        $data['title'] = ucfirst($page); // Kapitalkan huruf pertama

        // Memuat template header, halaman statis (home, about), dan footer
        return view('templates/header', $data)
            . view('pages/' . $page, $data)
            . view('templates/footer');
    }
}

```

Masuk ke URL : `http://localhost:8080/home`

Tampilan yang terhubung ke Controllers Pages.php (method `public function view($page = 'home')`)

yang diarahkan pada file Route.php = `$routes->get('(:segment)', [Pages::class, 'view']);`
![Logo](https://responsible-fact-6d4.notion.site/image/https%3A%2F%2Fprod-files-secure.s3.us-west-2.amazonaws.com%2Fc8e21fd1-aa93-4db3-9ae0-6b3890a71ba5%2F5135f6ad-8cc5-4009-8fb5-6cdb738865fb%2FUntitled.png?table=block&id=6193c469-f228-4975-8d3f-ce9b2ff1e1b4&spaceId=c8e21fd1-aa93-4db3-9ae0-6b3890a71ba5&width=580&userId=&cache=v2)

![Logo](https://responsible-fact-6d4.notion.site/image/https%3A%2F%2Fprod-files-secure.s3.us-west-2.amazonaws.com%2Fc8e21fd1-aa93-4db3-9ae0-6b3890a71ba5%2Fb029424f-8522-49f8-956d-e26aa4106cf4%2FUntitled.png?table=block&id=ff04d71b-4ae3-436c-80a2-54953e4fc113&spaceId=c8e21fd1-aa93-4db3-9ae0-6b3890a71ba5&width=580&userId=&cache=v2)

#### **News Section**

Buat Database dengan nama ci4

- Buat tabel :

```sql
CREATE TABLE news (
    id INT AUTO_INCREMENT,
    title VARCHAR(128) NOT NULL,
    description VARCHAR(128) NOT NULL,
    body TEXT NOT NULL,
    PRIMARY KEY (id)
);
```

- Insert Data :

```sql
INSERT INTO news (title, description, body) VALUES
('Pembukaan Pameran Seni', 'Pameran seni lokal', 'Pameran seni lokal dibuka pada hari Minggu di pusat seni kota. Acara ini menampilkan karya seni dari seniman lokal.'),
('Peluncuran Buku Baru', 'Buku terbaru dari penulis terkenal', 'Penulis terkenal meluncurkan buku terbarunya dalam sebuah acara di toko buku utama kota. Buku ini mendapatkan pujian luas dari para kritikus.'),
('Konser Musik Outdoor', 'Penampilan musik langsung di taman kota', 'Acara konser musik outdoor akan diadakan di taman kota pada akhir pekan ini. Banyak musisi lokal dan internasional akan tampil di acara tersebut.');

```

- Hubungkan ke Database
  pada file `.env` hilangkan comment (#) dan ganti database

```php
#--------------------------------------------------------------------
# DATABASE
#--------------------------------------------------------------------

database.default.hostname = localhost
database.default.database = ci4
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.DBPrefix =
database.default.port = 3306

```

- Buat Model News
  Buka direktori `app/Models` dan buat file baru bernama `NewsModel.php` dan tambahkan kode berikut

```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';
}
```

Ini akan membuat kelas database tersedia melalui `$this->db`objek.

- Tambahkan Method `NewsModel::getNews()` pada `app/Models`

```php
    public function getNews($description = false)
    {
        if ($description === false) {
            return $this->findAll();
        }

        return $this->where(['description' => $description])->first();
    }
```

To

```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';

    public function getNews($description = false)
    {
        if ($description === false) {
            return $this->findAll();
        }

        return $this->where(['description' => $description])->first();
    }
}
```

- Menambahkan Routing Rules
  Ubah file `app/Config/Routes.php` , sehingga terlihat seperti berikut:

```php
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

use App\Controllers\Pages;
use App\Controllers\News; // Tambah baris ini

$routes->get('news', [News::class, 'index']);           // Tambah baris ini
$routes->get('news/(:segment)', [News::class, 'show']); // Tambah baris ini

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);
```

- Tambahkan News Controller
  Buat controller baru di **`app/Controllers/News.php`** .

```php
<?php

namespace App\Controllers;

use App\Models\NewsModel;

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews();
    }

    public function show($description= null)
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews($description);
    }
}
```

- Lengkapi Method News::index()

```php
<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException; //baru

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);

        $data = [
            'news'  => $model->getNews(),
            'title' => 'Berita',
        ];

        return view('templates/header', $data)
            . view('news/index')
            . view('templates/footer');
    }
    //..
    public function show($description= null)
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews($description);
    }
}
```

- Buat tampilan untuk `app/Views/news/index.php`

```php
<h2><?= esc($title) ?></h2>

<?php if (!empty($news) && is_array($news)) : ?>

    <?php foreach ($news as $news_item) : ?>

        <h3><?= esc($news_item['title']) ?></h3>

        <div class="main">
            <?= esc($news_item['body']) ?>
        </div>
        <p><a href="/news/<?= esc($news_item['description'], 'url') ?>">View article</a></p> <!-- Terhubung ke controllers News.php public function show($description = null) -->

    <?php endforeach ?>

<?php else : ?>

    <h3>No Berita</h3>

    <p>Tidak dapat menemukan berita apa pun untuk Anda.</p>

<?php endif ?>
```

- Lengkapi Method `News::show()` pada `app/controllers/News.php`

```php
<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException; //baru

class News extends BaseController
{
    public function index()
    {
        $model = model(NewsModel::class);

        $data = [
            'news'  => $model->getNews(),
            'title' => 'Berita',
        ];

        return view('templates/header', $data)
            . view('news/index')
            . view('templates/footer');
    }

    //.. Dari sini News::show()
		// sebagai pencarian berita berdasarkan deskripsi

    public function show($description = null)
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews($description);
        if (empty($data['news'])) {
            throw new PageNotFoundException('Tidak dapat menemukan item berita: ' . $description);
        }

        $data['title'] = $data['news']['title'];

        return view('templates/header', $data)
            . view('news/view')
            . view('templates/footer');
    }
}
```

- Membuat tampilan terkait di `app/Views/news/view.php`

```php
// Menampilkan judul berita. Fungsi 'esc' digunakan untuk mencegah serangan XSS.
<h2><?= esc($news['title']) ?></h2>

// Menampilkan isi berita. Fungsi 'esc' juga digunakan di sini untuk mencegah serangan XSS.
<p><?= esc($news['body']) ?></p>
```

#### **Create News Items**

1. Aktifkan Filter CSRF

   Buka file `app/Config/Filters.php` dan perbarui `$methods` properti seperti berikut:

```php
<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
    // ... ini

    public $methods = [
        'post' => ['csrf'],
    ];

    // ...
}
```

2. Menambahkan Routing Rules

   Menambahkan rule tambahan ke file `app/Config/Routes.php` .

```php
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

use App\Controllers\Pages;
use App\Controllers\News; // Tambah baris ini

$routes->get('news', [News::class, 'index']);           // Tambah baris ini

$routes->get('news/new', [News::class, 'new']); // Tambah baris ini (poin create News items)
$routes->post('news', [News::class, 'create']); // Tambah baris ini (poin create News items)

$routes->get('news/(:segment)', [News::class, 'show']); // Tambah baris ini

$routes->get('pages', [Pages::class, 'index']);
$routes->get('(:segment)', [Pages::class, 'view']);
```

3. Buat Formulir

   Buat tampilan baru di `app/Views/news/create.php` :

```php
<!-- Poin 3 pada Create News Items (Bangun aplikasi pertama) -->
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

    <label for="body">Text</label> <!-- Membuat label untuk field teks -->
    <!-- Membuat field textarea untuk teks, dengan nilai default dari fungsi set_value() -->
    <textarea name="body" cols="45" rows="4"><?= set_value('body') ?></textarea>

    <br> <!-- Membuat baris baru -->

    <input type="submit" name="submit" value="Create news item"> <!-- Membuat tombol submit -->
</form> <!-- Menutup tag form -->
<!-- END Dari Poin 3 pada Create News Items (Bangun aplikasi pertama Anda) -->
```

4. News Controller

   Tambahkan **`News::new()`** pada `app/controllers/News.php`untuk Menampilkan Formulir.

   Pertama, buatlah metode untuk menampilkan form HTML yang telah buat.

```php
<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class News extends BaseController
{
		// ... Dari Poin pembahasan Create News Items (Bangun aplikasi pertama Anda)
    // Terhubung News::create() diViews
    public function new()
    {
        helper('form');

        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/create')
            . view('templates/footer');
    }
    // ...
}
```

5. Tambahkan `News::create()` pada `app/controllers/News.php` untuk Membuat Items Berita

```php
<?php

namespace App\Controllers;

use App\Models\NewsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class News extends BaseController
{
    // ...
		// Dari Poin 5 pembahasan Create News Items (Bangun aplikasi pertama Anda)
    public function create()
    {
        helper('form'); // Memanggil helper form

        $data = $this->request->getPost(['title', 'body']); // Mengambil data dari form

        // Mengecek apakah data yang dikirimkan memenuhi aturan validasi.
        if (!$this->validateData($data, [
            'title' => 'required|max_length[255]|min_length[3]', // Judul harus ada, maksimal 255 karakter, minimal 3 karakter
            'body'  => 'required|max_length[5000]|min_length[10]', // Isi berita harus ada, maksimal 5000 karakter, minimal 10 karakter
        ])) {
            // Jika validasi gagal, kembali ke form.
            return $this->new();
        }

        // Mengambil data yang telah divalidasi.
        $post = $this->validator->getValidated();

        $model = model(NewsModel::class); // Membuat instance dari NewsModel

        // Menyimpan data ke dalam database
        $model->save([
            'title' => $post['title'], // Menyimpan judul
            'description'  => url_title($post['title'], '-', true), // Membuat deskripsi dari judul
            'body'  => $post['body'], // Menyimpan isi berita
        ]);

        // Menampilkan halaman sukses setelah data berhasil disimpan
        return view('templates/header', ['title' => 'Create a news item'])
            . view('news/success')
            . view('templates/footer');
    }
    //...
}
```

6. Buat tampilan di `app/Views/news/success.php` dan tulis pesan sukses.

```php
<p>News item created successfully.</p>
```

7. Edit `NewsModel` → `app/Models/NewsModel.php` untuk memberikannya daftar bidang yang dapat diperbarui di `$allowedFields` properti.

```php
<?php

namespace App\Models;

use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table = 'news';

    //pembahasan poin 7 pada Create News Items (Bangun aplikasi pertama Anda)
    protected $allowedFields = ['title', 'description', 'body'];
    //...
}
```

To :

```php
<?php

namespace App\Models;

use CodeIgniter\Model;

// Kelas NewsModel mewarisi kelas Model dari CodeIgniter
class NewsModel extends Model
{
    // Variabel $table digunakan untuk mendefinisikan tabel yang digunakan oleh model ini
    protected $table = 'news';

    // Variabel $allowedFields mendefinisikan field apa saja yang dapat diisi dalam tabel
    // Ini adalah bagian dari fitur mass assignment protection di CodeIgniter
    //Pembahasan poin 7 pada Create News Items (Bangun aplikasi pertama Anda)
    protected $allowedFields = ['title', 'slug', 'body'];
    //...

    // Fungsi getNews digunakan untuk mengambil data berita
    // Jika parameter $description bernilai false, maka fungsi akan mengembalikan semua berita
    // Jika parameter $description memiliki nilai, maka fungsi akan mencari berita dengan deskripsi yang sesuai
    public function getNews($description = false)
    {
        if ($description === false) {
            return $this->findAll();
        }

        return $this->where(['description' => $description])->first();
    }
}
```

![Logo](https://responsible-fact-6d4.notion.site/image/https%3A%2F%2Fprod-files-secure.s3.us-west-2.amazonaws.com%2Fc8e21fd1-aa93-4db3-9ae0-6b3890a71ba5%2Fe709f939-0346-49e4-bd5c-cc5c3f79c913%2FUntitled.png?table=block&id=ddfad957-d38c-44e0-bbde-f5db89211556&spaceId=c8e21fd1-aa93-4db3-9ae0-6b3890a71ba5&width=670&userId=&cache=v2)

![Logo](https://responsible-fact-6d4.notion.site/image/https%3A%2F%2Fprod-files-secure.s3.us-west-2.amazonaws.com%2Fc8e21fd1-aa93-4db3-9ae0-6b3890a71ba5%2Ff26af911-ece8-48d7-8e1d-3e47d9df6199%2FUntitled.png?table=block&id=3fe6e691-a095-488c-ab6c-bc54a70fb6a2&spaceId=c8e21fd1-aa93-4db3-9ae0-6b3890a71ba5&width=670&userId=&cache=v2)

## CodeIgniter4 Overview

#### **AutoLoading**

Namespace pada CodeIgniter 4 adalah cara untuk mengelompokkan kelas-kelas, fungsi, dan konstanta ke dalam ruang nama yang terpisah.

- Memeriksa konfigurasi namespace

```bash
php spark namespaces
```

- Terdapat custom Namespace atau membuat Namespace baru.
  Masuk ke `app/Config/autoload.php`

```php
    public $psr4 = [
        APP_NAMESPACE => APPPATH, // For custom app namespace
        'Config'      => APPPATH . 'Config',
        // Pembahasan CodeIgniter4 poin 3 AutoLoad
        'MyApp'       => APPPATH . 'MyApp' // Custom Namespace baru
    ];
```

- Buat Folder `MyApp` pada Folder `app/` dan file `MyClass.php` didalam folder `MyApp.`
  Isi file `MyClass.php` :

```php
<?php

namespace App\MyApp;

class MyClass
{
    public function sayHello()
    {
        echo "Hello from MyClass in MyApp!";
    }
}
```

Lalu cek namespace

```bash
php spark namespaces
```

![Untitled](https://responsible-fact-6d4.notion.site/image/https%3A%2F%2Fprod-files-secure.s3.us-west-2.amazonaws.com%2Fc8e21fd1-aa93-4db3-9ae0-6b3890a71ba5%2F8b9ea44e-6117-41a1-84bf-87ce371c4a19%2FUntitled.png?table=block&id=90611010-a665-4e8d-a56c-df3d1ca54142&spaceId=c8e21fd1-aa93-4db3-9ae0-6b3890a71ba5&width=1340&userId=&cache=v2)

Maka akan muncul namespace baru `MyApp.`

#### **Factories**

Factories atau Pabrik adalah alat yang memungkinkan pengguna membuat objek atau instance dari kelas-kelas tertentu secara dinamis

- Command Line untuk menghapus file cache

```bash
php spark cache:clear
```

- Cara Mengaktifkan Konfigurasi Caching
  Batalkan komentar pada kode berikut di **public/index.php** :

```php
// Load Config Cache
// $factoriesCache = new \CodeIgniter\Cache\FactoriesCache();
// $factoriesCache->load('config');
// ^^^ Uncomment these lines if you want to use Config Caching.

// Save Config Cache
// $factoriesCache->save('config');
// ^^^ Uncomment this line if you want to use Config Caching.

// Exits the application, setting the exit code for CLI-based applications
```

To :

```php
<?php

// Check PHP version.
$minPhpVersion = '7.4'; // If you update this, don't forget to update `spark`.
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );

    exit($message);
}

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and fires up an environment-specific bootstrapping.
 */

// Load our paths config file
// This is the line that might need to be changed, depending on your folder structure.
require FCPATH . '../app/Config/Paths.php';
// ^^^ Change this line if you move your application folder

$paths = new Config\Paths();

// Location of the framework bootstrap file.
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load environment settings from .env files into $_SERVER and $_ENV
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

// Define ENVIRONMENT
if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', env('CI_ENVIRONMENT', 'development'));
}

// Pembahasan CodeIgniter4 Overview Poin Factories
// Load Config Cache
$factoriesCache = new \CodeIgniter\Cache\FactoriesCache();
$factoriesCache->load('config');
// ^^^ Uncomment these lines if you want to use Config Caching.
// ...

/*
 * ---------------------------------------------------------------
 * GRAB OUR CODEIGNITER INSTANCE
 * ---------------------------------------------------------------
 *
 * The CodeIgniter class contains the core functionality to make
 * the application run, and does all the dirty work to get
 * the pieces all working together.
 */

$app = Config\Services::codeigniter();
$app->initialize();
$context = is_cli() ? 'php-cli' : 'web';
$app->setContext($context);

/*
 *---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 *---------------------------------------------------------------
 * Now that everything is set up, it's time to actually fire
 * up the engines and make this app do its thang.
 */

$app->run();

// Pembahasan CodeIgniter4 Overview Poin Factories
// Save Config Cache
$factoriesCache->save('config');
// ^^^ Uncomment this line if you want to use Config Caching.
// ...

// Exits the application, setting the exit code for CLI-based applications
// that might be watching.
exit(EXIT_SUCCESS);
```

#### **Working with HTTP Requests**

**Apa itu HTTP?**

HTTP adalah istilah yang digunakan untuk menggambarkan konvensi pertukaran itu. Itu singkatan dari **HyperText Transfer Protocol.**

- Request
  Contoh pada Browser :
  Blok terlebih dahulu misal teks, lalu tekan shorcut `CTRL + SHIFT + I` pilih tab Network → Refresh Halaman → Pilih request yang ada.

```teks
GET / HTTP/1.1
Host codeigniter.com
Accept: text/html
User-Agent: Chrome/46.0.2490.80
```

#### **URI Routing**

Pada file `app/Config/Routes.php` terdapat route yang akan dijalankan atau ditetapkan

```php
<?php
// Route untuk halaman Home
$routes->get('/', 'Home::index');
// Route untuk menampilkan form upload saat kita menautkan /upload pada URL dan proses upload file dari Controller Upload, method=index
$routes->get('upload', 'Upload::index');
$routes->post('upload/upload', 'Upload::upload');

// Route untuk menampilkan form dan proses form (Post data)
$routes->get('form', 'Form::index');
$routes->post('form', 'Form::index');

// Route untuk halaman News
use App\Controllers\News;

// Route untuk menampilkan daftar News (index)
$routes->get('news', [News::class, 'index']); // Tambah baris ini

// Route untuk menampilkan form create News
$routes->get('news/new', [News::class, 'new']); // Tambah baris ini (poin create News items)
// Route untuk memproses form create News dan menyimpan di database
$routes->post('news', [News::class, 'create']); // Tambah baris ini (poin create News items)

// Route untuk menampilkan detail suatu News berdasarkan Deskripsinya
$routes->get('news/(:segment)', [News::class, 'show']); // Tambah baris ini

// Route untuk halaman Pages
use App\Controllers\Pages;

// Route untuk menampilkan daftar Pages (index)
$routes->get('pages', [Pages::class, 'index']);
// Route untuk menampilkan halaman Pages sesuai deskripsinya
$routes->get('(:segment)', [Pages::class, 'view']);
```

- Contoh Perutean Dasar

`app/Config/Routes.php`

```php
// Route untuk menampilkan daftar News (index)
$routes->get('news', [News::class, 'index']); // Tambah baris ini
```

Menuju ke `app/controllers/News.php`

#### **Controllers**

```php
    public function index()
    {
        $model = model(NewsModel::class);

        $data = [
            'news'  => $model->getNews(),
            'title' => 'Berita',
        ];

        return view('templates/header', $data) //Static Content
            . view('news/index')
            . view('templates/footer');
    }
```

Misalnya disini saya berada pada Controllers News.php yang terhubung pada Route.php `$routes->get('news', [News::class, 'index']);`

pada `return view` terhubung ke folder `templates` yang ada pada Views untuk menampilkan header dan footer, view('news/index') ini memanggil file index.phpnya
