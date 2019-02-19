<?php
/**
 * Created by PhpStorm.
 * UsersManager: jlbokass
 * Date: 13/01/2019
 * Time: 04:28
 */

namespace App\Controller;

use App\Manager\CommentManager;
use App\Manager\PostManager;
use App\Utilities\Paginator;
use Core\Controller;
use Core\View;

/**
 * Class Posts
 * @package App\Controller
 */
class PostController extends Controller
{
    /**
     *
     */
    public function indexAction()
    {

       $posts = PostManager::getAll();
        //$paginator = new Paginator(1, 4);
       //$posts = PostManager::getPage($paginator->limit,$paginator->offset);

        View::renderTemplate('/Posts/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    public function singleAction()
    {
        $id = $this->route_params['id'];

        $post = PostManager::getSingle($id);

        $comments = CommentManager::getAllPostComment($id);

        View::renderTemplate('/Posts/single.html.twig', [
            'post' => $post,
            'comments' => $comments
        ]);
    }
}
