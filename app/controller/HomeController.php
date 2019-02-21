<?php
/**
 * Created by PhpStorm.
 * UsersManager: jlbokass
 * Date: 13/01/2019
 * Time: 05:02
 */

namespace App\Controller;

use App\Manager\HomeManager;
use App\Model\Message;
use App\Utilities\Filter;
use App\Utilities\Mail;
use Config\Config;
use Core\Controller;
use Core\View;

/**
 * Class Home
 * @package app\controller
 */
class HomeController extends Controller
{
    /**
     *
     */
    public function indexAction()
    {
        View::renderTemplate('/Home/index.html.twig');
    }


    /**
     *
     */
    public function emailAction()
    {
        $filter = Filter::emailFilter();

        $email = new HomeManager(filter_input_array(INPUT_POST, $filter));

        if ($email->sendEmailToAdmin()) {

            $text = View::getTemplate('Home/email.txt', ['emailFromBlog' => $email]);
            $html = View::getTemplate('Home/email.html', ['emailFromBlog' => $email]);

            Mail::send(Config::USER_NAME, 'Blog PHP-MVC', $text, $html);

            $this->redirect('/home/success');

        } else {

            View::renderTemplate('Home/index.html.twig', [
                'emailFromBlog' => $email
            ]);
        }
    }


    /**
     *
     */
    public function successAction()
    {
        View::renderTemplate('Home/success.html.twig');
    }
}
