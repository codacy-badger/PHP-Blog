<?php
/**
 * Created by PhpStorm.
 * User: jlbokass
 * Date: 01/02/2019
 * Time: 23:53
 */

namespace App\Controller;

use App\Manager\CommentManager;
use App\Manager\PostManager;
use App\Manager\UsersManager;
use App\Utilities\Auth;
use App\Utilities\Filter;
use App\Utilities\Flash;
use Core\View;

/**
 * Class AdminController
 *
 * PHP version 7.1
 *
 * @package App\Controller
 */
class AdminController extends AuthenticatedController
{

    /**
     * authenticate the admin
     *
     * @return void
     */
    protected function before()
    {
        parent::before();

        $user = Auth::getUser();

        if (! $user->role) {

            $this->redirect('/');
        }
    }



    /**
     * index admin
     *
     * @return void
     */
    public function indexAction()
    {
        View::renderTemplate('Admin/index.html.twig', [
            'user' => Auth::getUser()
        ]);
    }


    /**
     * Before filter - called before each action method
     *
     */
    public function showProfileAction()
    {
        View::renderTemplate('Admin/show-profile.html.twig', [
            'user' => $this->user
        ]);
    }


    /**
     *
     */
    public function editProfileAction()
    {
        View::renderTemplate('Admin/edit-profile.html.twig', [
            'user' => Auth::getUser()
        ]);
    }


    public function updateProfileAction()
    {
        $user = Auth::getUser();

        $input = Filter::profileFilter();

        //$user->updateProfile(filter_input_array(INPUT_POST, $input));

        //var_dump($user);
        //die();

        if ($user->updateProfile(filter_input_array(INPUT_POST, $input))) {

            Flash::addMessage('Changes saved');

            $this->redirect('/admin/index');

        } else {

            View::renderTemplate('admin/edit.html', [
                'user' => $user
            ]);
        }
    }

    /**
     *
     */
    public function showArticleAction()
    {
        $posts = PostManager::getAll();

        View::renderTemplate('Admin/show-article.html.twig', [
            'posts' => $posts
        ]);
    }

    /**
     *
     */
    public function newArticleAction()
    {
        $users = UsersManager::getAll();

        View::renderTemplate('Admin/new-article.html.twig', [
            'users' => $users
        ]);
    }

    /**
     *
     */
    public function createArticleAction()
    {
        $post = new PostManager($_POST);

        if ($post->save()) {
            Flash::addMessage('article created');
            $this->redirect('/admin/show-article');
        }
    }


    /**
     *
     */
    public function editArticleAction()
    {
        $users = UsersManager::getAll();
        $id = $this->route_params['id'];
        $single = PostManager::getSingle($id);

        View::renderTemplate('/Admin/edit-article.html.twig', [
            'single' => $single,
            'users' => $users
        ]);
    }

    /**
     *
     */
    public function updateArticleAction()
    {
        $filter = Filter::articleFilter();
        $post = new PostManager(filter_input_array(INPUT_POST, $filter));

        if ($post->update(filter_input_array(INPUT_POST, $filter))) {
            Flash::addMessage('the article was updated');

            $this->redirect('/admin/show-article');
        }

        View::renderTemplate('Profile/show-article.html.twig', [
            'post' => $post
        ]);
    }

    /**
     *
     */
    public function deleteArticle()
    {
        $users = UsersManager::getAll();
        $id = $this->route_params['id'];
        $single = PostManager::getSingle($id);

        View::renderTemplate('/Admin/delete-article.html.twig', [
            'single' => $single,
            'users' => $users
        ]);
    }


    /**
     *
     */
    public function deleteArticleConfirmationAction()
    {
        $filter = Filter::articleFilter();
        $post = new PostManager(filter_input_array(INPUT_POST, $filter));
        //$post = new PostManager($_POST);

        if ($post->delete()) {

            Flash::addMessage('Article deleted');
            $this->redirect('/admin/show-article');

        } else {

            View::renderTemplate('Admin/delete-article.html.twig' , [
                'post' => $post
            ]);
        }
    }



    /**
     *
     */
    public function showCommentAction()
    {
        $comments = CommentManager::getAllComment();

        View::renderTemplate('Admin/show-comment.html.twig', [
            'comments' => $comments
        ]);
    }

    /**
     *
     */
    public function editCommentAction()
    {
        $id = $this->route_params['id'];

        $comment = CommentManager::getAComment($id);

        View::renderTemplate('/Admin/edit-comment.html.twig', [
            'comment' => $comment
        ]);
    }

    /**
     *
     */
    public function updateCommentAction()
    {
        $commentId = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
        //$commentId = $_POST['comment_id'];

        CommentManager::update($commentId);

        Flash::addMessage('changes saved');

        $this->redirect('/admin/show-comment');
    }

    /**
     *
     */
    public function deleteCommentAction()
    {
        $id = $this->route_params['id'];

        $comment = CommentManager::getAComment($id);

        View::renderTemplate('/Admin/delete-comment.html.twig', [
            'comment' => $comment
        ]);
    }

    /**
     *
     */
    public function confirmDeleteCommentAction()
    {
        $commentId = filter_input(INPUT_POST, 'comment_id', FILTER_SANITIZE_NUMBER_INT);
        //$commentId = $_GET['comment_id'];

        CommentManager::delete($commentId);

        Flash::addMessage('comment deleted');

        $this->redirect('/admin/show-comment');
    }

    /**
     *
     */
    public function showUserAction()
    {
        $users = UsersManager::getAll();
        View::renderTemplate('Admin/show-user.html.twig', [
            'users' => $users
        ]);
    }
}
