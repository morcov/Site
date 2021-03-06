<?php

namespace App\Modules\Product\Controllers;

use BaseController, Input, View, Response;
use App\Modules\Product\Models\Comment;
use App\Modules\User\Models\User;

/**
 * Class CommentController
 * @package App\Modules\Product\Controllers
 */
class CommentController extends BaseController
{

    /**
     * Add comment
     *
     * @return mixed
     */
    public function addComment()
    {
        $data = Input::all();
        $data['user_id'] = User::getUserID();

        $result = Comment::add($data);
        if ($result->status) {
            return $result->commentID;
        } else {
            return $result->errors;
        }
    }


    /**
     * Get comments by productID
     *
     * @param null $productID
     * @return View
     */
    public function getComments($productID = null)
    {
        $id = !empty($productID) ? $productID : Input::get('product_id');
        $result = Comment::getByProductID($id);

        return View::make('product::comments')->with('comments', $result);
    }

    /**
     * Delete comment by commentID
     *
     * @param null $commentID
     * @return boolean
     */
    public function deleteComment($commentID = null)
    {
        $id = !empty($commentID) ? $commentID : Input::get('comment_id');
        $result = Comment::remove($id);
        Response::json($result);
    }
}