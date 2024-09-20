<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\comments;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class CommentsController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\comments  $comments
     * @return \Illuminate\Http\Response
     */
    public function getCommentByPostId(Request $request)
    {
        $postId = $request->input('id');
        $currentPage = $request->input('currentPage', 1);
        $commentsPerPage = $request->input('commentsPerPage', 10);

        if ($commentsPerPage === 'all') {
            $comments = comments::with(['post', 'user'])
                ->where('post_id', $postId)
                ->where('parent_id', $postId)
                ->orderBy('comments.updated_at', 'desc')
                ->get();
        } else {
            $comments = comments::with(['post', 'user'])
                ->where('post_id', $postId)
                ->where('parent_id', $postId)
                ->orderBy('comments.updated_at', 'desc')
                ->paginate($commentsPerPage, ['*'], 'page', $currentPage);
        }

        $fetchChildren = function ($comments) use (&$fetchChildren) {
            foreach ($comments as $comment) {
                $children = comments::with(['post', 'user'])
                    ->where('parent_id', $comment->id)
                    ->get();

                if ($children->isNotEmpty()) {
                    $comment->child = $fetchChildren($children);
                } else {
                    $comment->child = collect(); // Set an empty collection for consistency
                }
            }
            return $comments; // Return the modified $comments array
        };

        $comments = $fetchChildren($comments);

        return response()->json($comments);
    }


    public function saveComment(Request $request)
    {
        $comment = new comments();
        $comment->post_id = $request->input('post_id');
        if ($request->input('parent_id'))
            $comment->parent_id = $request->input('parent_id');
        else
            $comment->parent_id = $request->input('post_id');
        $comment->user_id = $request->input('user_id');
        $comment->content = $request->input('comment');

        $comment->save();
        return response()->json($comment);
    }
}
