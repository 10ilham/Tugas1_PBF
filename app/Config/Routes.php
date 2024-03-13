<?php

use CodeIgniter\Router\RouteCollection;
// use App\Controllers\Blog; // Pembahasan Building Responses Poin View


/**
 * @var RouteCollection $routes
 */

// Pembahasan Building Responses Poin View
// $routes->get('blog', [Blog::class, 'index']);

// Route untuk halaman Home
$routes->get('/', 'Home::index');
//Pembahasan Library References Poin Working with Uploaded Files
$routes->get('upload', 'Upload::index');
$routes->post('upload/upload', 'Upload::upload');

$routes->get('form', 'Form::index');
$routes->post('form', 'Form::index');

// // Route untuk halaman News
// use App\Controllers\News;

// // Route untuk menampilkan daftar News (index)
// $routes->get('news', [News::class, 'index']); // Tambah baris ini

// // Route untuk menampilkan form create News
// $routes->get('news/new', [News::class, 'new']); // Tambah baris ini (poin create News items)
// // Route untuk memproses form create News dan menyimpan di database
// $routes->post('news', [News::class, 'create']); // Tambah baris ini (poin create News items)

// // Route untuk menampilkan detail suatu News berdasarkan Deskripsinya
// $routes->get('news/(:segment)', [News::class, 'show']); // Tambah baris ini

// // Route untuk halaman Pages
// use App\Controllers\Pages;

// // Route untuk menampilkan daftar Pages (index)
// $routes->get('pages', [Pages::class, 'index']);
// // Route untuk menampilkan halaman Pages sesuai slugnya
// $routes->get('(:segment)', [Pages::class, 'view']);
