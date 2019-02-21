<?php
/**
 * Created by PhpStorm.
 * UsersManager: jlbokass
 * Date: 25/01/2019
 * Time: 06:50
 */

namespace App\Controller;

use App\Manager\UsersManager;
use App\Utilities\Filter;
use Core\Controller;
use Core\View;

/**
 * Class Password
 * @package App\Controller
 *
 * PHP version 7.1
 */
class PasswordController extends Controller
{

    /**
     * Show the forgotten password page
     *
     * @return void
     */
    public function forgotAction()
    {
        View::renderTemplate('Password/forgot.html.twig');
    }


    /**
     * Send the password reset link to the supplied email
     *
     * @return void
     */
    public function requestResetAction()
    {
        UsersManager::sendPasswordReset(Filter::filterInputEmail('email'));
        //UsersManager::sendPasswordReset($_POST['email']);

        View::renderTemplate('Password/reset_requested.html.twig');
    }



    /**
     * Show the reset password form
     *
     * @return void
     *
     * @throws \Exception
     */
    public function resetAction()
    {
        $token = $this->route_params['token'];

        $user = $this->getUserOrExit($token);

        View::renderTemplate('Password/reset.html.twig', [
            'token' => $token

        ]);
    }

    /**
     * Reset the user's password
     *
     * @return void
     *
     * @throws \Exception
     */
    public function resetPasswordAction()
    {
        $token = Filter::filterInputString('token');
        //$token = $_POST['token'];

        $user = $this->getUserOrExit($token);

        if ($user->resetPassword(Filter::filterInputString('password'))) { // $user->resetPassword($_POST['password'])

            View::renderTemplate('Password/reset_success.html.twig');

        } else {

            View::renderTemplate('Password/reset.html.twig', [
                'token' => $token,
                'user' => $user
            ]);
        }
    }


    /**
     * Find the user model associated with the password reset token, or end the request with a message
     *
     * @param string $token Password reset token sent to user
     *
     * @return mixed User object if found and the token hasn't expired, null otherwise
     * @throws \Exception
     */
    protected function getUserOrExit($token)
    {
        $user = UsersManager::findByPasswordReset($token);

        if ($user) {

            return $user;

        } else {

            View::renderTemplate('Password/token_expired.html.twig');
            exit;
        }
    }
}
