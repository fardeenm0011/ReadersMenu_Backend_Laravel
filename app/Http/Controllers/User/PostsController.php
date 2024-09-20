<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Posts;
use Illuminate\Http\Request;
use App\Models\Category;
use Carbon\Carbon;

class PostsController extends Controller
{
    public function getSpotlight()
    {
        // $todayStart = Carbon::today()->startOfDay();
        // $todayEnd = Carbon::today()->endOfDay();

        // Query to get today's posts sorted by popular count in descending order
        $post = Posts::join('users', 'users.id', '=', 'posts.user_id')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'users.name as user_name', 'categories.name as category_name', 'categories.data_query as category_data_query', 'categories.type2 as category_type')
            ->where('posts.isActive', '=', 'yes')
            ->where('categories.type2', 'news')
            ->orderBy('posts.created_at', 'desc')
            ->limit(20)->get();
        return response()->json($post);
    }

    public function getTrendingPosts(Request $request)
    {
        $currentPage = $request->query('currentPage', 1);
        $postsPerPage = $request->query('postsPerPage', 10);
        $lastWeek = Carbon::now()->subWeek();

        if ($postsPerPage === 'all')
            $posts = Posts::join('users', 'users.id', '=', 'posts.user_id')
                ->join('categories', 'categories.id', '=', 'posts.category_id')
                ->select('posts.*', 'users.name as user_name', 'categories.name as category_name')
                ->where('posts.created_at', '>=', $lastWeek)
                ->where('posts.isBreaking', '=', 'yes')
                ->where('posts.isActive', '=', 'yes')
                ->orderBy('posts.created_at', 'desc')
                ->get();
        else
            $posts = Posts::join('users', 'users.id', '=', 'posts.user_id')
                ->join('categories', 'categories.id', '=', 'posts.category_id')
                ->select('posts.*', 'users.name as user_name', 'categories.name as category_name', 'categories.type2 as category.type')
                ->where('posts.created_at', '>=', $lastWeek)
                ->where('posts.isBreaking', '=', 'yes')
                ->where('posts.isActive', '=', 'yes')
                ->orderBy('posts.created_at', 'desc')
                ->paginate($postsPerPage, ['*'], 'page', $currentPage);

        return response()->json($posts, 200);
    }
    public function getSpotlightPosts(Request $request)
    {
        $currentPage = $request->query('currentPage', 1);
        $postsPerPage = $request->query('postsPerPage', 10);
        $lastWeek = Carbon::now()->subWeek();

        if ($postsPerPage === 'all')
            $posts = Posts::join('users', 'users.id', '=', 'posts.user_id')
                ->join('categories', 'categories.id', '=', 'posts.category_id')
                ->select('posts.*', 'users.name as user_name', 'categories.name as category_name', 'categories.type2 as category.type')
                ->where('posts.created_at', '>=', $lastWeek)
                ->where('posts.isActive', '=', 'yes')
                ->where('categories.type2', 'news')
                ->orderBy('posts.created_at', 'desc')
                ->get();
        else
            $posts = Posts::join('users', 'users.id', '=', 'posts.user_id')
                ->join('categories', 'categories.id', '=', 'posts.category_id')
                ->select('posts.*', 'users.name as user_name', 'categories.name as category_name')
                ->where('posts.created_at', '>=', $lastWeek)
                ->where('posts.isActive', '=', 'yes')
                ->where('categories.type2', 'news')
                ->orderBy('posts.created_at', 'desc')
                ->paginate($postsPerPage, ['*'], 'page', $currentPage);

        return response()->json($posts, 200);
    }
    public function getAllNewsPostsSeo(Request $request)
    {
        $posts = Posts::join('categories', 'posts.category_id', 'categories.id')->select('posts.id', 'posts.seo_slug', 'posts.updated_at')->where('categories.type2', 'news')->orderBy('posts.created_at', 'desc')->get();
        return response()->json($posts, 200);
    }

    public function getAllArticlePostsSeo(Request $request)
    {
        $posts = Posts::join('categories', 'posts.category_id', 'categories.id')->select('posts.id', 'posts.seo_slug', 'posts.updated_at')->where('categories.type2', 'article')->orderBy('posts.created_at', 'desc')->get();
        return response()->json($posts, 200);
    }

    public function getSeoPost(Request $request)
    {
        $id = $request->query('id');
        $seo = Posts::select('seo_title', 'seo_keyword', 'seo_description')->where('seo_slug', $id)->first();
        if (!$seo) {
            return response()->json(['error' => 'Post not found'], 404);
        }
        return response()->json($seo, 200);
    }
    public function getAllPosts(Request $request)
    {
        $posts = Posts::orderBy('created_at', 'desc')->where('posts.isActive', '=', 'yes')->get();
        return response()->json($posts, 200);
    }
}
