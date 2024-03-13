<?php

namespace App\Controllers;

use CodeIgniter\Files\File;


// Kelas Upload yang mengextend BaseController
class Upload extends BaseController
{
    // Memuat helper 'form' untuk membantu dalam pembuatan form
    protected $helpers = ['form'];

    // Fungsi index untuk menampilkan form upload
    public function index()
    {
        // Mengembalikan view 'upload_form'
        return view('upload_form');
    }

    // Fungsi upload untuk menangani proses upload file
    public function upload()
    {
        // Aturan validasi untuk file yang diupload
        $validationRule = [
            'userfile' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[userfile]', // File harus diupload
                    'is_image[userfile]', // File harus berupa gambar
                    'mime_in[userfile,image/jpg,image/jpeg,image/gif,image/png,image/webp]', // File harus berformat jpg, jpeg, gif, png, atau webp
                    'max_size[userfile,100]', // Ukuran file maksimal 100KB
                    'max_dims[userfile,1024,768]', // Dimensi maksimal gambar 1024x768
                ],
            ],
        ];
        // Jika validasi gagal
        if (!$this->validate($validationRule)) {
            // Mengumpulkan kesalahan validasi
            $data = ['errors' => $this->validator->getErrors()];

            // Mengembalikan view 'upload_form' dengan data kesalahan
            return view('upload_form', $data);
        }

        // Mendapatkan file yang diupload
        $img = $this->request->getFile('userfile');

        // Jika file belum dipindahkan
        if (!$img->hasMoved()) {
            // Menyimpan file ke direktori 'upload' dan mendapatkan path file
            $filepath = WRITEPATH . 'upload/' . $img->store('');

            // Membuat objek File dengan path file
            $data = ['uploaded_fileinfo' => new File($filepath)];

            // Mengembalikan view 'upload_success' dengan data file yang diupload
            return view('upload_success', $data);
        }

        // Jika file sudah dipindahkan
        $data = ['errors' => 'The file has already been moved.'];

        // Mengembalikan view 'upload_form' dengan pesan kesalahan
        return view('upload_form', $data);
    }
}
