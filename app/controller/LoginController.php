<?php
/**
 * Created by PhpStorm.
 * UsersManager: jlbokass
 * Date: 20/01/2019
 * Time: 15:30
 */

namespace App\Controller;

use App\Model\User;
use App\Utilities\Auth;
use App\Utilities\Filter;
use App\Utilities\Flash;
use Core\Controller;
use Core\View;
use App\Manager\UsersManager;

/**
 * Class Login
 * @package App\Controller
 *
 * PHP version 7.1
 */
class LoginController extends Controller
{

    /**
     * show the login page
     *
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Login/new.html.twig');
    }


    /**
     * Log in a user
     *
     * @return void
     */
    public function createAction()
    {
        //$user = UsersManager::authenticate($_POST['email'], $_POST['password']);
        $user = UsersManager::authenticate(Filter::filterInputEmail('email'), Filter::filterInputString('password'));

        $remember_me = isset($_POST['remember_me']);

        if ($user) {

            Auth::login($user, $remember_me);

            Flash::addMessage('Login successful');

            $this->redirect(Auth::getReturnToPage());

        }

        Flash::addMessage('Login unsuccessful, please try again', Flash::WARNING);

        View::renderTemplate('Login/new.html.twig', [
            'email' => Filter::filterInputEmail('email'), // $_POST['email']
            'remember_me' => $remember_me
        ]);
    }


    /**
     * Log out a user
     *
     * @return void
     */
    public function destroyAction()
    {
        Auth::logout();

        $this->redirect('/login/show-logout-message');
    }

    /**
     * Show a "logged out" flash message and redirect to the homepage. Necessary to use the flash messages
     * as they use the session and at the end of the logout method (destroyAction) the session is destroyed
     * so a new action needs to be called in order to use the session.
     *
     * @return void
     */
    public function showLogoutMessageAction()
    {
        Flash::addMessage('logout successful');

        $this->redirect('/');
    }
}
