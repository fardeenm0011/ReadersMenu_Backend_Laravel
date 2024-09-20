<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\comments;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($language, Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $currentPage = $request->input('page', 1); // Get the current page, default to 1

        echo ($currentPage);
        // Set the current page for the pagination
        Paginator::currentPageResolver(function () use ($currentPage) {
            return $currentPage;
        });

        if ($perPage === 'all') {
            $comments = comments::with(['post', 'user'])->orderBy('comments.updated_at', 'desc')->get();
        } else {
            $comments = comments::with(['post', 'user'])->orderBy('comments.updated_at', 'desc')->paginate($perPage);
        }

        return view('pages.comment.comment', compact('comments', 'perPage', 'currentPage'));
    }

    public function updateIsActive(Request $request)
    {
        $postId = $request->input('postId');
        $isActive = $request->input('isActive');

        // Update isActive in database for the specified post
        $post = comments::find($postId);
        if ($post) {
            $post->isActive = ($isActive === 'yes') ? 'yes' : 'no';
            $post->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false, 'error' => 'Post not found']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function show(comments $comments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $posts = comments::with(['post.user'])->find($id);
        return response()->json($posts);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = comments::find($id);
        $comment->content = $request->content;
        $comment->save();

        return response()->json(['success' => 'Comment updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function destroy(comments $comments)
    {
        //
    }


    //---------------------------------------------API--------------------------------------------//

    public function getComments(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $currentPage = $request->input('current_page', 1);
        $search = $request->input('search');

        // Start a query on the Comment model
        $query = comments::with(['post', 'user'])->newQuery();

        // Apply search filtering if search term is provided
        if (!empty($search)) {
            $query->where('content', 'like', "%$search%");
        }

        // Handle pagination
        if ($perPage == -1) {
            $comments = $query->orderBy('updated_at', 'desc')->get();
        } else {
            $comments = $query->orderBy('updated_at', 'desc')->paginate($perPage, ['*'], 'page', $currentPage);
        }

        return response()->json($comments);
    }

    public function getComment(Request $request)
    {
        $posts = comments::with(['post.user'])->find($request->id);
        return response()->json($posts);
    }

    public function updateComment(Request $request)
    {
        $comment = comments::find($request->id);
        $comment->content = $request->content;
        $comment->save();

        return response()->json(['success' => 'Comment updated successfully']);
    }

    public function getCommentTotalPage(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $totalCount = comments::count(); // You can use count() directly without fetching all records
        $totalPage = (int) ceil($totalCount / $perPage); // Use ceil to round up to the nearest whole number

        return response()->json(['total_page' => $totalPage]);
    }
}
