<?php

namespace App\Controllers;

class Blog extends BaseController
{
    public function index()
    {
        //Pembahasan Building Responses Poin View
        $data['title']   = 'My Real Title';
        $data['heading'] = 'My Real Heading';
        return view('blog/blog_view', $data); //menghubungkan ke Views/blog
    }
}
