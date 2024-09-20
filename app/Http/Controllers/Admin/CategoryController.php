<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Posts;
use Psy\Readline\Hoa\Console;
use Illuminate\Pagination\Paginator;

class CategoryController extends Controller
{
    /**
     * Display category of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index($language, Request $request, $id)
    {
        $perPage = $request->input('per_page', 10);
        $currentPage = $request->input('page', 1); // Get the current page, default to 1

        echo ($currentPage);
        // Set the current page for the pagination
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        $query = Posts::join('users', 'users.id', '=', 'posts.user_id')
            ->select('posts.*', 'users.name as user_name')
            ->orderBy('posts.updated_at', 'desc');

        if ($id !== "all") {
            $query->where('category_id', '=', $id);
        }

        if ($perPage === 'all') {
            $posts = $query->get();
        } else {
            $posts = $query->paginate($perPage);
        }

        $categories = Category::where('parent_id', null)->get();
        $fetchChildren = function ($categories) use (&$fetchChildren) {
            foreach ($categories as $category) {
                $child = Category::where('parent_id', $category->id)->get();
                if ($child->isNotEmpty()) {
                    $category->child = $fetchChildren($child);
                }
            }
            return $categories; // Return the modified $categories array
        };

        $categories = $fetchChildren($categories);
        return view('pages.category.category', compact('categories', 'posts', 'perPage', 'currentPage'));
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return response()->json($category);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|int',
            'sortorder' => 'required|string|max:255',
            'status' => 'required|in:allow,disable',
            'type' => 'required|in:default,trending',
            'type2' => 'required|in:news,article',
            'position' => 'required|in:main,more',
            'isHomepage' => 'required|in:yes,no',
            'data_query' => 'required|string|max:255|unique:categories,data_query,' . $id, // Unique validation ignoring the current record
            'seo_title' => 'nullable|string|max:255',
            'seo_keyword' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation as needed
        ]);

        $category = Category::find($id);

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = $imageFile->getClientOriginalName();
            $request->file('image')->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
            $category->image = $validated['image'];
        }// Validate request data

        // Find the category

        // Update category fields
        $category->name = $validated['name'];
        $category->status = $validated['status'];
        $category->type = $validated['type'];
        $category->type2 = $validated['type2'];
        $category->position = $validated['position'];
        $category->isHomepage = $validated['isHomepage'];
        $category->sortorder = $validated['sortorder'];
        $category->data_query = $validated['data_query'];
        if ($validated['seo_title'])
            $category->seo_title = $validated['seo_title'];
        else
            $category->seo_title = $validated['name'];
        if ($validated['seo_keyword'])
            $category->seo_keyword = $validated['seo_keyword'];
        else
            $category->seo_keyword = $validated['name'];
        if ($validated['seo_description'])
            $category->seo_description = $validated['seo_description'];
        else
            $category->seo_description = $validated['name'];

        // Save the updated category
        try {
            $category->save();
            return response()->json(['success' => 'Category updated successfully']);
        } catch (\Exception $e) {
            // Debug: Log the exception
            \Log::error('Failed to update category:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update category'], 500);
        }
    }
    public function add(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|int',
            'sortorder' => 'required|string|max:255',
            'status' => 'required|in:allow,disable',
            'type' => 'required|in:default,trending',
            'type2' => 'required|in:news,article',
            'position' => 'required|in:main,more',
            'isHomepage' => 'required|in:yes,no',
            'data_query' => 'required|string|max:255|unique:categories',
            'seo_title' => 'nullable|string|max:255',
            'seo_keyword' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['data_query'] = str_replace(' ', '-', $validated['data_query']);

        $category = new Category();

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = $imageFile->getClientOriginalName();
            $imagePath = 'images/' . $imageName; // Adjust path as needed
            $imageFile->move(public_path("images/category/{$request->type2}"), $imageName);
            $validated['image'] = $imagePath;
            $category->image = $imagePath;
        }

        if ($request->parent_id)
            $category->parent_id = $request->parent_id;
        $category->fill([
            'name' => $validated['name'],
            'status' => $validated['status'],
            'type' => $validated['type'],
            'type2' => $validated['type2'],
            'position' => $validated['position'],
            'isHomepage' => $validated['isHomepage'],
            'sortorder' => $validated['sortorder'],
            'data_query' => $validated['data_query'],
            'seo_title' => $validated['seo_title'] ?? $validated['name'],
            'seo_keyword' => $validated['seo_keyword'] ?? $validated['name'],
            'seo_description' => $validated['seo_description'] ?? $validated['name'],
        ]);

        $category->save();

        return response()->json($category);
    }


    public function delete($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();
            return response()->json(['success' => 'Category deleted successfully']);
        } else {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }

    //---------------------------------------------API----------------------------------------------//

    public function getCategory()
    {
        $categories = Category::where('parent_id', null)->get();
        $fetchChildren = function ($categories) use (&$fetchChildren) {
            foreach ($categories as $category) {
                $child = Category::where('parent_id', $category->id)->get();
                if ($child->isNotEmpty()) {
                    $category->child = $fetchChildren($child);
                } else
                    $category->child = '';
            }
            return $categories; // Return the modified $categories array
        };

        $categories = $fetchChildren($categories);
        return response()->json($categories, 200);
    }
    public function getMainCategories(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $currentPage = $request->input('current_page', 1);
        $search = $request->input('search');

        // Start a query on the Category model
        $query = Category::query();
        $query->where('parent_id', null);

        // Apply search filtering if search term is provided
        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }

        // Order by updated_at descending
        $query->orderBy('sortorder', 'asc');

        // Paginate or get all based on $perPage
        if ($perPage === -1) {
            $mainCategories = $query->get();
        } else {
            $mainCategories = $query->paginate($perPage, ['*'], 'page', $currentPage);
        }

        // Define a function to fetch children recursively
        $fetchChildren = function ($categories) use (&$fetchChildren) {
            foreach ($categories as $category) {
                $childCategories = Category::where('parent_id', $category->id)->get();
                if ($childCategories->isNotEmpty()) {
                    // Extracting only the names of child categories
                    $category->child_names = $childCategories->pluck('name')->toArray();
                    // Recursively fetch children (if needed)
                    $fetchChildren($childCategories);
                }
            }
            return $categories; // Return the modified $categories array
        };

        // Fetch children for main categories
        $fetchChildren($mainCategories);

        // Remove child attribute from main categories
        foreach ($mainCategories as $category) {
            unset($category->child);
        }

        // Return JSON response with modified mainCategories
        return response()->json($mainCategories, 200);
    }
    public function getAllMainCategories(Request $request)
    {
        // Start a query on the Category model
        $query = Category::query();
        $query->where('parent_id', null);

        // Order by updated_at descending
        $query->orderBy('sortorder', 'asc');

        // Paginate or get all based on $perPage

        $mainCategories = $query->get();
        // Define a function to fetch children recursively
        $fetchChildren = function ($categories) use (&$fetchChildren) {
            foreach ($categories as $category) {
                $childCategories = Category::where('parent_id', $category->id)->get();
                if ($childCategories->isNotEmpty()) {
                    // Extracting only the names of child categories
                    $category->child_names = $childCategories->pluck('name')->toArray();
                    // Recursively fetch children (if needed)
                    $fetchChildren($childCategories);
                }
            }
            return $categories; // Return the modified $categories array
        };

        // Fetch children for main categories
        $fetchChildren($mainCategories);

        // Remove child attribute from main categories
        foreach ($mainCategories as $category) {
            unset($category->child);
        }

        // Return JSON response with modified mainCategories
        return response()->json($mainCategories, 200);
    }

    public function getMainCategory(Request $request)
    {
        $category = Category::find($request->id);
        return response()->json($category, 200);
    }
    public function deleteCategory(Request $request)
    {
        $category = Category::find($request->id);

        if ($category) {
            $category->delete();
            return response()->json(['success' => 'Category deleted successfully']);
        } else {
            return response()->json(['error' => 'Category not found'], 404);
        }
    }
    public function getMainCategoryTotalPage(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $totalCount = Category::where('parent_id', null)->count(); // You can use count() directly without fetching all records
        $totalPage = (int) ceil($totalCount / $perPage); // Use ceil to round up to the nearest whole number

        return response()->json(['total_page' => $totalPage]);
    }
    public function getSubcategories(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $currentPage = $request->input('current_page', 1);
        $search = $request->input('search');

        $query = Category::query();
        $query->whereNotNull('parent_id');
        // Apply search filtering if search term is provided
        if (!empty($search)) {
            $query->where('name', 'like', "%$search%");
        }
        if ($perPage == -1) {
            $subCategories = $query->orderBy('sortorder', 'asc')->all();
        } else
            $subCategories = $query->orderBy('sortorder', 'asc')->paginate($perPage, ['*'], 'page', $currentPage);

        foreach ($subCategories as $category) {
            $parent_name = Category::where('id', $category->parent_id)->select('name')->first();
            $category->parent_name = $parent_name;
        }
        return response()->json($subCategories, 200);
    }
    public function getSubCategory(Request $request)
    {
        $categoryId = $request->query('id');
        $subCategory = Category::where('parent_id', $categoryId)->get();

        return response()->json($subCategory, 200);
    }
    public function getSubCategoryTotalPage(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $totalCount = Category::whereNot('parent_id', null)->count(); // You can use count() directly without fetching all records
        $totalPage = (int) ceil($totalCount / $perPage); // Use ceil to round up to the nearest whole number

        return response()->json(['total_page' => $totalPage]);
    }

    public function updateCategory(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|int',
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|int',
            'sortorder' => 'required|string|max:255',
            'status' => 'required|in:allow,disable',
            'type' => 'required|in:default,trending',
            'type2' => 'required|in:news,article',
            'position' => 'required|in:main,more',
            'isHomepage' => 'required|in:yes,no',
            'data_query' => 'required|string|max:255|unique:categories,data_query,' . $request->id, // Unique validation ignoring the current record
            'seo_title' => 'nullable|string|max:255',
            'seo_keyword' => 'nullable|string|max:255',
            'seo_description' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust validation as needed
        ]);
        $id = $validated['id'];
        $category = Category::find($id);

        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
            $imageName = $imageFile->getClientOriginalName();
            $imageFile->move(public_path("images/category/{$request->type2}"), $imageName);
            $validated['image'] = $imageName;
            $category->image = $validated['image'];
        }// Validate request data

        // Find the category

        // Update category fields
        $category->name = $validated['name'];
        $category->status = $validated['status'];
        $category->type = $validated['type'];
        $category->type2 = $validated['type2'];
        $category->position = $validated['position'];
        $category->isHomepage = $validated['isHomepage'];
        $category->sortorder = $validated['sortorder'];
        $category->data_query = $validated['data_query'];
        if ($validated['seo_title'])
            $category->seo_title = $validated['seo_title'];
        else
            $category->seo_title = $validated['name'];
        if ($validated['seo_keyword'])
            $category->seo_keyword = $validated['seo_keyword'];
        else
            $category->seo_keyword = $validated['name'];
        if ($validated['seo_description'])
            $category->seo_description = $validated['seo_description'];
        else
            $category->seo_description = $validated['name'];

        // Save the updated category
        try {
            $category->save();
            return response()->json(['success' => 'Category updated successfully']);
        } catch (\Exception $e) {
            // Debug: Log the exception
            \Log::error('Failed to update category:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update category'], 500);
        }
    }

    public function updateCategorySeo(Request $request)
    {
        $category = Category::find($request->id);
        $category->seo_title = $request->seo_title;
        $category->seo_keyword = $request->seo_keyword;
        $category->seo_description = $request->seo_keyword;
        $category->data_query = $request->data_query;
        $category->save();
        return response()->json(['success' => true]);
    }
}
