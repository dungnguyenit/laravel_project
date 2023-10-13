<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\PostMedia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function getPosts()
    {
        $posts = DB::table('posts')
            ->leftJoin('users', 'posts.user_id', '=', 'users.id')
            ->leftJoin('post_media', 'posts.id', '=', 'post_media.post_id')
            ->selectRaw('posts.*,users.id as user_id,post_media.id as post_media_id, users.name, post_media.media_url,post_media.post_id')
            // ->groupBy('post_id')
            ->orderBy('posts.created_at', 'desc')
            ->get();
        $result = [];
        foreach ($posts as $post) {
            $result[$post->id][] = $post;
        }
        return view('home', ['posts' => $result]);
    }
    public function store(Request $request, Post $post, PostMedia $postMedia)
    {


        $userId = Auth::id();
        $params = $request->all();

        if ($params['title'] == null) {
            return redirect()->route('home')->with('error', 'Content cannot be empty.');
        }

        // Lưu bài viết
        $post = new Post();
        $post->content = $params['title'];
        $post->user_id = $userId;
        $post->save();

        // Xử lý upload tệp và lưu vào thư mục img
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $mediaType = $file->getMimeType();
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('img'), $fileName);

                // Lưu thông tin về tệp vào cơ sở dữ liệu
                $postMedia = new PostMedia();
                $postMedia->media_url = 'img/' . $fileName;
                $postMedia->media_type = $mediaType;
                $postMedia->post_id = $post->id;
                $postMedia->save();
            }
        }

        return redirect()->route('home');
    }

    public function personal($id = null)
    {
        $userId = $id ? $id : Auth::id();

        $posts = DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->join('post_media', 'post_media.post_id', '=', 'posts.id')
            ->select('users.name', 'posts.content', 'posts.created_at', 'post_media.media_url', 'post_media.post_id')
            ->where('users.id', '=', $userId)
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return view('personalPage', ['posts' => $posts]);
    }

    public function deletePost($id)
    {
        $user_id = DB::table('posts')->where('id', $id)->value('user_id');
        if ($user_id == Auth::id()) {
            try {
                PostMedia::where('post_id', $id)->delete();
                Post::destroy($id);
                return redirect()->route('home')->with('success', 'Bài đăng đã được xoá thành công.');
            } catch (\Exception $e) {
                return redirect()->route('home')->with('error', 'Đã xảy ra lỗi khi xoá bài đăng.');
            }
        } else {
            return redirect()->route('home')->with('error', 'Bạn không có quyền xoá');
        }
    }
    public function editPost($id)
    {
        $posts = DB::table('posts')
            ->join('users', 'users.id', '=', 'posts.user_id')
            ->join('post_media', 'post_media.post_id', '=', 'posts.id')
            ->select('users.name', 'posts.content', 'posts.created_at', 'post_media.media_url', 'post_media.post_id')
            ->where('post_id', '=', $id)
            ->orderBy('posts.created_at', 'desc')
            ->get();
        return view('edit', ['posts' => $posts]);
    }

    public function updatePost(Request $request, $id)
    {
        $user_id = DB::table('posts')->where('id', $id)->value('user_id');
        if ($user_id == Auth::id()) {
            $post = Post::findOrFail($id);
            $post->content = $request->input('title');
            $post->save();

            if ($request->hasFile('file')) {
                // Xóa media cũ nếu có
                if ($post->postMedia) {
                    $postMedia = $post->postMedia;
                    $file = $request->file('file');
                    $path = $file->store('images');
                    $postMedia->media_url = $path;
                    $postMedia->save();
                }
            }
            return redirect()->route('home');
        } else {
            return redirect()->route('home');
        }
    }
}
