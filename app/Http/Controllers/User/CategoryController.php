<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Posts;
use Psy\Readline\Hoa\Console;

class CategoryController extends Controller
{
    /**
     * Display category of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $categories = Category::where('parent_id', null)->where('status', 'allow')->orderBy('sortorder', 'asc')->get();
        $fetchChildren = function ($categories) use (&$fetchChildren) {
            foreach ($categories as $category) {
                $child = Category::where('parent_id', $category->id)->where('status', 'allow')->orderBy('sortorder', 'asc')->get();
                if ($child->isNotEmpty()) {
                    $category->child = $fetchChildren($child);
                }
            }
            return $categories; // Return the modified $categories array
        };

        $categories = $fetchChildren($categories);
        return response()->json($categories, 200);
    }

    public function getSubCategory(Request $request)
    {
        $categoryName = $request->query('id');
        $category = Category::where('name', $categoryName)->first();

        if ($category->parent_id == null)
            $subCategory = Category::where('parent_id', $category->id)->get();
        else
            $subCategory = Category::where('parent_id', $category->parent_id)->get();

        return response()->json($subCategory, 200);
    }
    public function homePagecategories()
    {
        $categories = Category::where('isHomepage', 'yes')->where('parent_id', null)->where('type2', 'article')->get();
        return response()->json($categories);
    }
    public function getSeokey()
    {
        $categories = Category::select('seo_key')->get();
        return response()->json($categories);
    }

    public function getPostsById(Request $request)
    {
        $categoryName = $request->query('category');

        if (!$categoryName) {
            return response()->json(['error' => 'Category is required'], 400);
        }
        $category = Category::where('name', '=', $categoryName)->first();
        $posts = Posts::join('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.*', 'users.name as user_name')->where('category_id', '=', $category->id)
            ->where('posts.isActive', '=', 'yes')
            ->orderBy('posts.created_at', 'desc')
            ->get();

        return response()->json($posts, 200);
    }
    public function getPagenationPosts(Request $request)
    {
        $categoryName = $request->query('category');
        $currentPage = $request->query('currentPage', 1);
        $postsPerPage = $request->query('postsPerPage', 10);

        if (!$categoryName) {
            return response()->json(['error' => 'Category is required'], 400);
        }
        $category = Category::where('name', '=', $categoryName)->first();
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        // Collect all category IDs (parent + subcategories)
        $categoryIds = Category::where('parent_id', $category->id)->pluck('id')->toArray();
        $categoryIds[] = $category->id;

        $query = Posts::join('users', 'users.id', '=', 'posts.user_id')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'users.name as user_name', 'categories.name as category_name', 'categories.data_query as category_data_query', 'categories.type2 as category_type')
            ->whereIn('category_id', $categoryIds)
            ->where('posts.isActive', 'yes')
            ->orderBy('posts.created_at', 'desc');

        if ($postsPerPage === 'all') {
            $posts = $query->get();
        } else {
            $posts = $query->paginate($postsPerPage, ['*'], 'page', $currentPage);
        }

        return response()->json($posts, 200);
    }
    public function getHomepagePosts()
    {
        $categories = Category::where('isHomepage', 'yes')
            ->where('parent_id', null)
            ->where('type2', 'article')
            ->get();

        $result = [];

        // Iterate through each category and fetch 9 posts
        foreach ($categories as $category) {
            $childCategories = Category::where('parent_id', $category->id)->pluck('id')->toArray();

            // Add the parent category ID to the array
            array_push($childCategories, $category->id);

            // Fetch posts from the parent category and its child categories
            $posts = Posts::with('user', 'category')
                ->whereIn('category_id', $childCategories)
                ->where('posts.isActive', 'yes')
                ->orderBy('posts.created_at', 'desc')
                ->limit(9)
                ->get();

            // Add to result with the category details
            if ($posts->count() > 0) {
                $result[] = [
                    'category' => $category->name,
                    'posts' => $posts

                ];
            }
        }

        return response()->json($result, 200);
    }
    public function getFindPost(Request $request)
    {
        $postId = $request->query('id');

        if (!$postId) {
            return response()->json(['error' => 'PostID is required'], 400);
        }
        $post = Posts::join('users', 'users.id', '=', 'posts.user_id')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'users.name as user_name', 'categories.name as category_name')
            ->where('posts.seo_slug', '=', $postId)
            ->where('posts.isActive', '=', 'yes')
            ->orderBy('posts.created_at', 'desc')
            ->first();
        return response()->json($post, 200);
    }

    public function getFindPostById(Request $request)
    {
        $postId = $request->query('id');

        if (!$postId) {
            return response()->json(['error' => 'PostID is required'], 400);
        }
        $post = Posts::join('users', 'users.id', '=', 'posts.user_id')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'users.name as user_name', 'categories.name as category_name')
            ->where('posts.id', '=', $postId)
            ->where('posts.isActive', '=', 'yes')
            ->orderBy('posts.created_at', 'desc')
            ->first();
        return response()->json($post, 200);
    }


    public function getPopularPosts()
    {
        $posts = Posts::join('users', 'users.id', '=', 'posts.user_id')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'users.name as user_name', 'categories.name as category_name', 'categories.data_query as category_data_query', 'categories.type2 as category_type')
            ->where('posts.isActive', '=', 'yes')
            ->orderBy('posts.popular', 'desc')
            ->limit(6)
            ->get();
        return response()->json($posts, 200);
    }
    public function getRelatedPost(Request $request)
    {
        $postId = $request->query('id');

        if (!$postId) {
            return response()->json(['error' => 'PostID is required'], 400);
        }
        $me = Posts::where('seo_slug', '=', $postId)->first();

        $posts = Posts::join('users', 'users.id', '=', 'posts.user_id')
            ->join('categories', 'categories.id', '=', 'posts.category_id')
            ->select('posts.*', 'users.name as user_name', 'categories.name as category_name', 'categories.data_query as category_data_query', 'categories.type2 as category_type')->where('posts.category_id', '=', $me->category_id)
            ->where('posts.id', '!=', $me->id)
            ->where('posts.isActive', '=', 'yes')
            ->orderBy('posts.popular', 'desc')
            ->limit(3)
            ->get();
        return response()->json($posts, 200);
    }
    public function getSeoCategory(Request $request)
    {
        $id = $request->query('id');
        $seo = Category::where('data_query', $id)->first();
        if (!$seo) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return response()->json($seo);
    }


    public function checkBreadcrumb(Request $request)
    {
        $name = $request->title;
        $category = Category::where('name', $name)->first();
        $parentCategory = '';
        if (!$category) {
            $post = Posts::where('seo_slug', $name)->first();
            $category = Category::where('id', $post->category_id)->first();
            if ($category->parent_id === null) {
                return response()->json(['category' => $category->name, 'subCategory' => null, 'post' => $post->title], 200);
            }
            $parentCategory = Category::where('id', $category->parent_id)->first();
            return response()->json(['category' => $parentCategory->name, 'subCategory' => $category->name, 'post' => $post->title], 200);
        } else {
            if ($category->parent_id === null) {
                return response()->json(['category' => $category->name, 'subCategory' => null, 'post' => null], 200);
            }
            $parentCategory = Category::where('id', $category->parent_id)->first();
            return response()->json(['category' => $parentCategory->name, 'subCategory' => $category->name, 'post' => null], 200);
        }
    }

    public function getAllCategories(Request $request)
    {
        $categories = Category::select('type2', 'data_query', 'updated_at')->orderBy('created_at', 'desc')->get();
        return response()->json($categories, 200);
    }
}
