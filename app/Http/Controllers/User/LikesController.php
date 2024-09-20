<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Likes;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function getLikesByUser(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:users,id',
        ]);

        $userId = $validated['id'];
        $likes = Likes::where('user_id', $userId)->get();

        if ($likes->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No likes found for this user.'], 404);
        }
        $arrayLikes = [];
        foreach ($likes as $like) {
            $arrayLikes = [...$arrayLikes, $like->post_id];
        }
        return response()->json(['success' => true, 'likes' => $arrayLikes]);
    }
    public function updateLikes(Request $request)
    {
        // Validate the request inputs
        $validated = $request->validate([
            'userId' => 'required|integer|exists:users,id',
            'postId' => 'required|integer|exists:posts,id',
        ]);

        $userId = $validated['userId'];
        $postId = $validated['postId'];

        // Check if the like already exists
        $likes = Likes::where('user_id', $userId)->where('post_id', $postId)->first();

        // If like doesn't exist, create a new one
        if (!$likes) {
            $likes = new Likes();
            $likes->user_id = $userId;
            $likes->post_id = $postId; // Use post_id instead of postId
            $likes->save(); // Save the new like

            return response()->json(['success' => true, 'message' => 'Like is created successfully!']);
        }

        // If like exists, delete it
        $likes->delete();
        return response()->json(['success' => true, 'message' => 'Like is deleted successfully!']);
    }

}
