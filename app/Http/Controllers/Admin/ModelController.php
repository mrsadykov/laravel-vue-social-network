<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function index()
    {
        $models = [
            [
                'title' => 'Категории',
                'routeName' => 'admin.categories.index',
            ],
            [
                'title' => 'Чаты',
                'routeName' => 'admin.chats.index',
            ],
            [
                'title' => 'Сообщения',
                'routeName' => 'admin.messages.index',
            ],
            [
                'title' => 'Статьи',
                'routeName' => 'admin.posts.index',
            ],
            [
                'title' => 'Теги',
                'routeName' => 'admin.tags.index',
            ]
        ];

        return inertia("Admin/Model/Index", compact("models"));
    }
}
