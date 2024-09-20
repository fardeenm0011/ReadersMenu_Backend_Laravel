<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Posts;
use App\Models\Category;
use App\Models\User;
use App\Models\Roles;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use \Ladumor\OneSignal\OneSignal;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($language, $id)
    {
        $categories = Category::all();
        if ($id == 'new') {
            $post = null;
            return view('pages.category.add_post', compact('categories', 'post'));
        } else {
            $post = Posts::find($id);
            return view('pages.category.add_post', compact('categories', 'post'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'sub_title' => 'nullable|max:255',
            'category_id' => 'required|integer',
            'user_id' => 'required|integer',
            'is_breaking' => 'required|in:yes,no',
            'seo_title' => 'nullable|max:255',
            'seo_keyword' => 'nullable|max:255',
            'seo_description' => 'nullable|max:255',
            'seo_slug' => 'required|max:255|unique:posts,seo_slug,' . ($request->post_id ?? 'null'), // Unique validation ignoring the current record if updating
            'message' => 'required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = $request->post_id ? Posts::find($request->post_id) : new Posts;
        $post->title = $validatedData['title'];
        $post->sub_title = $validatedData['sub_title'];
        $post->category_id = $validatedData['category_id'];
        $post->user_id = $validatedData['user_id'];
        $post->isBreaking = $validatedData['is_breaking'];
        if ($validatedData['seo_title'])
            $post->seo_title = $validatedData['seo_title'];
        else
            $post->seo_title = $validatedData['title'];
        if ($validatedData['seo_keyword'])
            $post->seo_keyword = $validatedData['seo_keyword'];
        else
            $post->seo_keyword = $validatedData['title'];
        if ($validatedData['seo_description'])
            $post->seo_description = $validatedData['seo_description'];
        else
            $post->seo_description = $validatedData['title'];
        if ($validatedData['seo_slug'])
            $post->seo_slug = $validatedData['seo_slug'];
        else
            $post->seo_slug = $validatedData['title'];

        $post->description = $validatedData['message'];
        $post->isActive = 'no';

        if ($request->hasFile('img')) {
            $imageFile = $request->file('img');
            $imageName = $imageFile->getClientOriginalName();
            $request->img->move(public_path('images'), $imageName);
            $post->img = $imageName;
        }

        $post->save();
        return redirect()->back()->with('success', 'Post saved successfully!');
    }

    public function updateIsActive(Request $request)
    {
        $postId = $request->input('postId');
        $isActive = $request->input('isActive');

        // Update isActive in database for the specified post
        $post = Posts::find($postId);
        if ($post) {
            $post->isActive = ($isActive === 'yes') ? 'yes' : 'no';
            $post->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'error' => 'Post not found']);
    }
    public function updateIsBreaking(Request $request)
    {
        $postId = $request->input('postId');
        $isBreaking = $request->input('isBreaking');

        // Update isBreaking in database for the specified post
        $post = Posts::find($postId);
        if ($post) {
            $post->isBreaking = ($isBreaking === 'yes') ? 'yes' : 'no';
            $post->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'error' => 'Post not found']);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $posts = Posts::query()
            ->where('title', 'LIKE', "%{$searchTerm}%")
            ->orWhere('sub_title', 'LIKE', "%{$searchTerm}%")
            ->orWhere('description', 'LIKE', "%{$searchTerm}%")
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Adjust pagination as needed

        $categories = Category::all();
        $perPage = 10;
        $currentPage = 1;
        return view('pages.category.category', compact('categories', 'posts', 'perPage', 'currentPage'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function show(posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function edit(posts $posts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, posts $posts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\posts  $posts
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $post = Posts::find($id);

        if ($post) {
            $post->delete();
            return response()->json(['success' => 'Post deleted successfully']);
        } else {
            return response()->json(['error' => 'Post not found'], 404);
        }
    }


    //---------------------------------------------API----------------------------------------------//

    public function getPosts(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $currentPage = $request->input('current_page', 1);
        $search = $request->input('search');

        // Start a query on the Employee model
        $query = Posts::with('user');
        if (!empty($search)) {
            $query->where('title', 'like', "%$search%")
                ->orWhere('sub_title', 'like', "%$search%")
                ->orWhere('description', 'like', "%$search%");
        }
        if ($perPage == -1) {
            $posts = $query->orderBy('created_at', 'desc')->all();
        } else
            $posts = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $currentPage);
        foreach ($posts as $post) {
            $category = Category::find($post->category_id);
            if ($category->parent_id === null) {
                $post->category_name = $category->name;
                $post->parent_name = '';
            } else {
                $post->category_name = $category->name;
                $post->parent_name = Category::find($category->parent_id)->name;
            }
        }

        return response()->json($posts);
    }
    public function updateStatus(Request $request)
    {
        $postId = $request->input('postId');
        $isActive = $request->input('isActive');


        // Update isActive in database for the specified post
        $post = Posts::find($postId);

        $subscribedDevices = OneSignal::getDevices();
        $fields = [];
        // echo url('images/'.$post->img);exit;
        $arr2 = array_map(function ($subscribedDevicesObj) {
            return $subscribedDevicesObj['id'];
        }, $subscribedDevices['players']);

        //print_r($arr2);
        if ($isActive == "yes" && ($post->category_id == 3 || $post->category_id == 13 || $post->category_id == 14 || $post->category_id == 15)) {

            $fields['include_player_ids'] = $arr2;
            $message = $post->title;

            OneSignal::sendPush($fields, $message);
        }


        //$sids = array_map(function ($ar) {return $ar['id'];}, $subscribedDevices);

        //         $lookfor = array('id');
// $found   = array_filter($subscribedDevices, function($item) use ($lookfor) {
//     return in_array($item, $lookfor);
// });

        // $filteredArray = array_filter($subscribedDevices, function($v) use ($onlyKeys) {
//     return in_array($v, $onlyKeys);
// }, ARRAY_FILTER_USE_KEY);
        $existingToken = DeviceToken::where('user_id', $post->user_id)->first();
        if ($post) {
            $post->isActive = ($isActive === 'yes') ? 'yes' : 'no';
            $post->save();
            return response()->json(['success' => true, 'deviceToken' => $existingToken->token]);
        }

        return response()->json(['success' => false, 'error' => 'Post not found', 'deviceToken' => $existingToken]);
        // return response()->json(['success' => false, 'error' => 'Post not found']);
    }

    public function savePost(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'sub_title' => 'nullable|max:255',
            'category_id' => 'required|integer',
            'user_id' => 'required|integer',
            'message' => 'nullable|string',
            'seo_title' => 'nullable|string|max:255',
            'seo_keyword' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',
            'seo_slug' => 'nullable|string|max:255',
            'img' => 'nullable|image|max:2048' // Optional, if you want to validate the image
        ]);

        $post = $request->post_id ? Posts::find($request->post_id) : new Posts;
        $post->title = $validatedData['title'];
        $post->sub_title = $validatedData['sub_title'] ?? null;
        $post->category_id = $validatedData['category_id'];
        $post->user_id = $validatedData['user_id'];
        $post->description = $validatedData['message'] ?? null;
        $post->isActive = 'no';
        $post->isBreaking = 'no';

        $post->seo_title = $validatedData['seo_title'] ?? $validatedData['title'];
        $category = Category::find($validatedData['category_id']);
        $category_seo_keyword = $category->seo_keyword ?? '';

        if ($category->parent_id) {
            $parentCategory = Category::find($category->parent_id);
            $parentCategory_seo_keyword = $parentCategory->seo_keyword ?? '';
            $post->seo_keyword = $validatedData['seo_keyword'] ?? $category_seo_keyword . $parentCategory_seo_keyword;
        } else {
            $post->seo_keyword = $validatedData['seo_keyword'] ?? $category_seo_keyword;
        }

        //$post->seo_description = $validatedData['seo_description'] ?? $validatedData['title'];
        //$seoSlug = $validatedData['seo_slug'] ?? $validatedData['title'];

        // $post->seo_slug = str_replace(' ', '-', $seoSlug)."-".str()->random(5);
        $post->seo_slug = "news-details-info-" . str()->random(5);
        $post->seo_keyword = "seo-keyword-" . str()->random(5);
        $post->seo_title = "seo-title-" . str()->random(5);
        $post->seo_description = "seo-description-" . str()->random(5);
        //testing code enters

        if ($request->hasFile('img')) {
            $imageFile = $request->file('img');
            $imageName = $imageFile->getClientOriginalName(); // Added timestamp to avoid overwriting files
            $type = $category->type2 === 'news' ? 'news_detail' : 'article_detail';
            $imageFile->move(public_path("images/post/{$type}"), $imageName);
            $post->img = $imageName;
        }

        $post->save();

        return response()->json(['success' => 'Post saved successfully']);
    }
    public function countOfPosts(Request $request)
    {
        $categoryId = $request->query('id');
        $count = Posts::where('category_id', $categoryId)->count();

        return response()->json($count, 200);
    }
    public function unreadCountOfPosts()
    {
        $count = Posts::where('readStatus', 0)->count();

        return response()->json($count, 200);
    }

    public function getAllPosts(Request $request)
    {
        $posts = Posts::orderBy('created_at', 'desc')->get();
        return response()->json($posts, 200);
    }

    public function getPost(Request $request)
    {
        $post = Posts::find($request->id);
        return response()->json($post, 200);
    }
    public function loggedinUserPosts(Request $request)
    {
        $userId = $request->input('userId');
        $user = User::find($userId);
        $role = Roles::find($user->role);
        // Retrieve posts where the user ID matches the query parameter
        if ($role->name === 'admin' || $role->name === 'editor')
            $posts = Posts::with('category')->orderBy('created_at', 'desc')->get();
        else
            $posts = Posts::where('user_id', $userId)->with('user')->with('category')->orderBy('created_at', 'desc')->get();
        // Transform the posts to include category and subcategory names
        $postsWithCategoryNames = $posts->map(function ($post) {
            $category = $post->category;
            if ($category->parent_id) {
                $parentCategory = Category::find($category->parent_id);
                $subCategory = $category;
            } else {
                $parentCategory = $category;
                $subCategory = null;
            }

            return [
                'post' => $post,
                'category_name' => $parentCategory ? $parentCategory->name : $category->name,
                'subcategory_name' => $subCategory ? $subCategory->name : null,
            ];
        });

        return response()->json($postsWithCategoryNames, 200);
    }
    public function loggedinUserPaginationposts(Request $request)
    {
        $userId = $request->input('userId');
        $user = User::find($userId);
        $role = Roles::find($user->role);

        // Retrieve pagination parameters from the request, with defaults
        $page = $request->input('page', 1);
        $perPage = $request->input('perPage', 10);

        // Retrieve posts where the user ID matches the query parameter, with pagination
        if ($role->name === 'admin' || $role->name === 'editor') {
            $posts = Posts::with('category')->with('user')->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);
        } else {
            $posts = Posts::where('user_id', $userId)->with('user')->with('category')->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $page);
        }

        // Transform the posts to include category and subcategory names
        $postsWithCategoryNames = $posts->getCollection()->map(function ($post) {
            $category = $post->category;
            if ($category->parent_id) {
                $parentCategory = Category::find($category->parent_id);
                $subCategory = $category;
            } else {
                $parentCategory = $category;
                $subCategory = null;
            }

            return [
                'post' => $post,
                'category_name' => $parentCategory ? $parentCategory->name : $category->name,
                'subcategory_name' => $subCategory ? $subCategory->name : null,
            ];
        });

        // Replace the collection in the paginator with the transformed data
        $paginatedResults = new \Illuminate\Pagination\LengthAwarePaginator(
            $postsWithCategoryNames,
            $posts->total(),
            $posts->perPage(),
            $posts->currentPage(),
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return response()->json($paginatedResults, 200);
    }

    public function getPostsCount()
    {
        $activePosts = Posts::where('isActive', 'yes')->count();
        $inactivePosts = Posts::where('isActive', 'no')->count();

        $fetchCategoriesWithCounts = function ($categories) use (&$fetchCategoriesWithCounts) {
            $result = [];

            foreach ($categories as $category) {
                // Fetch direct children of the current category
                $childCategories = Category::where('parent_id', $category->id)->get();
                $childCount = $childCategories->count();

                // Count posts associated with this category
                $postCount = $category->posts()->count();

                // Recursively calculate total post count for children
                $totalChildPostCount = 0;
                if ($childCount > 0) {
                    // Fetch post count for each child category
                    foreach ($childCategories as $childCategory) {
                        $totalChildPostCount += $fetchCategoriesWithCounts([$childCategory])[0]['total_post_count'];
                    }
                }

                // Calculate total post count for the current category (including children)
                $totalPostCount = $postCount + $totalChildPostCount;

                // Build the category node with its total post count
                $categoryNode = [
                    'name' => $category->name,
                    'total_post_count' => $totalPostCount,
                ];

                // Recursively fetch children and append to current category node
                if ($childCount > 0) {
                    $categoryNode['children'] = $fetchCategoriesWithCounts($childCategories);
                }

                // Append the current category node to the result
                $result[] = $categoryNode;
            }

            return $result;
        };

        // Fetch top-level categories
        $topLevelCategories = Category::where('parent_id', null)->get();

        // Get categories with counts and their hierarchy
        $categoriesWithCounts = $fetchCategoriesWithCounts($topLevelCategories);

        return response()->json(['Total Active Posts' => $activePosts, 'Total InActive Posts' => $inactivePosts, 'Category Wise Post' => $categoriesWithCounts, 200]);
    }
    public function getPostsCountByUser(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);
        $role = Roles::find($user->role);

        if ($role->name === 'admin' || $role->name === 'editor') {
            $activePosts = Posts::where('isActive', 'yes')->count();
            $inactivePosts = Posts::where('isActive', 'no')->count();
        } else {
            $activePosts = Posts::where('user_id', $id)->where('isActive', 'yes')->count();
            $inactivePosts = Posts::where('user_id', $id)->where('isActive', 'no')->count();
        }
        $fetchCategoriesWithCounts = function ($categories, $userId) use (&$fetchCategoriesWithCounts) {
            $result = [];

            foreach ($categories as $category) {
                // Fetch direct children of the current category
                $childCategories = Category::where('parent_id', $category->id)->get();
                $childCount = $childCategories->count();

                // Count posts associated with this category and user
                if ($userId === 'all')
                    $postCount = $category->posts()->count();
                else
                    $postCount = $category->posts()->where('user_id', $userId)->count();

                // Recursively calculate total post count for children
                $totalChildPostCount = 0;
                if ($childCount > 0) {
                    // Fetch post count for each child category
                    foreach ($childCategories as $childCategory) {
                        if ($userId === 'all')
                            $totalChildPostCount += $fetchCategoriesWithCounts([$childCategory], 'all')[0]['total_post_count'];
                        else
                            $totalChildPostCount += $fetchCategoriesWithCounts([$childCategory], $userId)[0]['total_post_count'];
                    }
                }

                // Calculate total post count for the current category (including children)
                $totalPostCount = $postCount + $totalChildPostCount;

                // Build the category node with its total post count
                $categoryNode = [
                    'name' => $category->name,
                    'categoryId' => $category->id,
                    'total_post_count' => $totalPostCount,
                ];

                // Recursively fetch children and append to current category node
                if ($childCount > 0) {
                    if ($userId === 'all')
                        $categoryNode['children'] = $fetchCategoriesWithCounts($childCategories, 'all');
                    else
                        $categoryNode['children'] = $fetchCategoriesWithCounts($childCategories, $userId);
                }

                // Append the current category node to the result
                $result[] = $categoryNode;
            }

            return $result;
        };

        // Fetch top-level categories
        $topLevelCategories = Category::where('parent_id', null)->get();

        // Get categories with counts and their hierarchy
        if ($role->name === 'admin' || $role->name === 'editor')
            $categoriesWithCounts = $fetchCategoriesWithCounts($topLevelCategories, 'all');
        else
            $categoriesWithCounts = $fetchCategoriesWithCounts($topLevelCategories, $id);

        return response()->json(['TotalActivePosts' => $activePosts, 'TotalInActivePosts' => $inactivePosts, 'CategoryWisePost' => $categoriesWithCounts, 200]);
    }
    public function postsbyCategory(Request $request)
    {
        $categoryId = $request->query('id');

        // Retrieve subcategories of the specified category
        $subCategories = Category::where('parent_id', $categoryId)->get();

        // Start building the query to fetch posts
        $query = Posts::where('category_id', $categoryId);

        // If there are subcategories, add them to the query with OR condition
        if ($subCategories->isNotEmpty()) {
            foreach ($subCategories as $subCategory) {
                $query->orWhere('category_id', $subCategory->id);
            }
        }

        // Execute the query and fetch the posts
        $posts = $query->orderBy('created_at', 'desc')->get();

        // Return the posts as JSON response
        return response()->json($posts, 200);
    }
    public function postsbyCategoryPagination(Request $request)
    {
        $categoryId = $request->query('id');
        $perPage = $request->query('perPage', 10); // Default items per page to 10
        $currentPage = $request->query('currentPage', 1); // Default to page 1
        $userId = $request->input('userId');
        $user = User::find($userId);
        $role = Roles::find($user->role);

        if ($role->name === 'admin' || $role->name === 'editor') {
            $query = Posts::with('user');
            if ($perPage == -1) {
                $posts = $query->orderBy('created_at', 'desc')->all();
            } else
                $posts = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $currentPage);
            foreach ($posts as $post) {
                $category = Category::find($post->category_id);

                if ($category->parent_id === null) {
                    $post->category_name = $category->name;
                    $post->parent_name = '';
                } else {
                    $post->category_name = $category->name;
                    $post->parent_name = Category::find($category->parent_id)->name;
                }
            }
        }
        // Retrieve subcategories of the specified category
        else {
            $subCategories = Category::where('parent_id', $categoryId)->get();

            // Start building the query to fetch posts
            $query = Posts::with('user')->where('category_id', $categoryId);

            // If there are subcategories, add them to the query with OR condition
            if ($subCategories->isNotEmpty()) {
                foreach ($subCategories as $subCategory) {
                    $query->orWhere('category_id', $subCategory->id);
                }
            }

            // Execute the query and paginate the results
            $posts = $query->orderBy('created_at', 'desc')->paginate($perPage, ['*'], 'page', $currentPage);
        }

        // Customize the response to include current_page and per_page
        $response = [
            'current_page' => $posts->currentPage(),
            'per_page' => $posts->perPage(),
            'total' => $posts->total(),
            'last_page' => $posts->lastPage(),
            'data' => $posts->items(),
        ];

        // Return the custom response as JSON
        return response()->json($response, 200);
    }

    public function deletePost(Request $request)
    {
        $post = Posts::find($request->id);
        if ($post) {
            $post->delete();
            return response()->json(['success' => 'Post deleted successfully']);
        } else {
            return response()->json(['error' => 'Post not found'], 404);
        }
    }

    public function getPostTotalPage(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $totalCount = Posts::count(); // You can use count() directly without fetching all records
        $totalPage = (int) ceil($totalCount / $perPage); // Use ceil to round up to the nearest whole number

        return response()->json(['total_page' => $totalPage]);
    }
    public function updateIsBreakingStatus(Request $request)
    {
        $postId = $request->input('postId');
        $isBreaking = $request->input('isBreaking');

        // Update isBreaking in database for the specified post
        $post = Posts::find($postId);
        if ($post) {
            $post->isBreaking = ($isBreaking === 'yes') ? 'yes' : 'no';
            $post->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'error' => 'Post not found']);
    }

    public function updatePostSeo(Request $request)
    {
        $post = Posts::find($request->id);
        $post->seo_title = $request->seo_title;
        $post->seo_description = $request->seo_description;
        $post->seo_keyword = $request->seo_keyword;
        $post->seo_slug = $request->seo_slug;
        $post->save();
        return response()->json(['success' => true]);
    }
}
