<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    //Thêm một comment
    public function AddComment(Request $request, $id)
    {
        if (Session::has('user')) {
            $input = [
                'username' => Session::get('user')->full_name,
                'comment' => $request->comment,
                'id_product' => $id
            ];
            Comment::create($input);
            return redirect()->back();
        } else {
            return '<script>alert("Vui lòng đăng nhập để sử dụng chức năng này.");window.location.assign("/getLogin");</script>';
        }
    }
}