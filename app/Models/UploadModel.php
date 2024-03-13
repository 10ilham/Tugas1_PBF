<?php

namespace App\Models;

use CodeIgniter\Model;

class UploadModel extends Model
{
    public function saveFile($file)
    {
        $destination = WRITEPATH . 'uploads/'; // Lokasi tujuan penyimpanan file

        if ($file->isValid() && !$file->hasMoved()) {
            if ($file->move($destination, $file->getName())) {
                return $destination . $file->getName(); // Mengembalikan path file yang disimpan
            } else {
                return false; // Gagal menyimpan file
            }
        } else {
            return false; // File tidak valid atau sudah dipindahkan sebelumnya
        }
    }
}
