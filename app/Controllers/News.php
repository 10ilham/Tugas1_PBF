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

        return view('templates/header', $data) //Static Content
            . view('news/index')
            . view('templates/footer');
    }

    //..Dari sini News::show()
    // sebagai pencarian berita berdasarkan deskripsi

    public function show($description = null)
    {
        $model = model(NewsModel::class);

        $data['news'] = $model->getNews($description);
        if (empty($data['news'])) {
            throw new PageNotFoundException('Tidak dapat menemukan item berita: ' . $description);
        }

        $data['title'] = $data['news']['title'];

        return view('templates/header', $data) //Static Content
            . view('news/view') //Static Content
            . view('templates/footer'); //Static Content
    }

    // ... Dari Poin pembahasan Create News Items (Bangun aplikasi pertama Anda)
    // Terhubng News::create() diViews
    public function new() //Untuk pemanggilan news/new
    {
        helper('form');

        return view('templates/header', ['title' => 'Create a news item']) //Static Content
            . view('news/create')
            . view('templates/footer');
    }
    //...

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
