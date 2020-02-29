<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use Illuminate\Http\Request;

class PapersController extends Controller
{
    // 生成试卷
    public function show(Paper $paper)
    {
        return view('paper.show', compact('paper'));
    }
}
