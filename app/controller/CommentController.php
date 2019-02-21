<?php
/**
 * Created by PhpStorm.
 * User: jlbokass
 * Date: 01/02/2019
 * Time: 06:37
 */

namespace App\Controller;

use App\Manager\CommentManager;
use App\Model\Comment;
use App\Utilities\Filter;
use Core\View;

/**
 * Class CommentController
 * @package App\Controller
 */
class CommentController extends AuthenticatedController
{
    /**
     *
     */
    public function createAction()
    {
        $filter = Filter::commentFilter();
        $comments = new Comment(filter_input_array(INPUT_POST, $filter));

       // $comments = new Comment($_POST);

        $commentManager = new CommentManager();


        if ($commentManager->save($comments)) {

            $this->redirect('/comment/comment-request');

        } else {

            View::renderTemplate('/Posts/single.html.twig', [
                'comment' => $comments
            ]);
        }
    }

    /**
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function commentRequestAction()
    {
        View::renderTemplate('/Posts/comment_request.html.twig');
    }
}
