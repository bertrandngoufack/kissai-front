<?php

namespace App\Controllers;

use App\Models\ApplicationModel;

class FrontController extends BaseController
{
    public function index()
    {
        $query = trim((string) $this->request->getGet('q'));
        $model = new ApplicationModel();
        $apps = [];
        if ($query !== '') {
            $apps = $model->where('is_active', 1)
                ->groupStart()
                ->like('name', $query)
                ->orLike('tags', $query)
                ->orLike('description', $query)
                ->groupEnd()
                ->orderBy('name', 'ASC')
                ->findAll(50);
        } else {
            $apps = $model->where('is_active', 1)->orderBy('name', 'ASC')->findAll(20);
        }

        return view('front/home', [
            'title' => 'Portail des Applications',
            'apps'  => $apps,
            'q'     => $query,
        ]);
    }
}

