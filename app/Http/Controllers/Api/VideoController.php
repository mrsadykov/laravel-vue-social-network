<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Support\Facades\Request;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Video::all();
    }

    public function destroy(Video $video)
    {
        dd('destroy');
    }

    public function store(Video $video, Request $request)
    {
        dd('store');
    }
}
