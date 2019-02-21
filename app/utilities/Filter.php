<?php
/**
 * Created by PhpStorm.
 * User: jlbokass
 * Date: 2019-02-20
 * Time: 05:44
 */

namespace App\Utilities;


/**
 * Class Filter
 *
 * @package App\Utilities
 *
 * PHP version 7.1
 */
abstract class Filter
{

    /**
     * @return array
     */
    public static function profileFilter()
    {
         return  [
            'username' => FILTER_SANITIZE_STRING,
            'password' => FILTER_SANITIZE_STRING,
            'email' => [
                        'filter' => FILTER_VALIDATE_EMAIL,
                        'flags' => FILTER_NULL_ON_FAILURE
                        ],
            'flags' => FILTER_NULL_ON_FAILURE

        ];
    }


    public static function emailFilter()
    {
        return  [
            'firstName' => FILTER_SANITIZE_STRING,
            'lastName' => FILTER_SANITIZE_STRING,
            'message' => FILTER_SANITIZE_STRING,
            'email' => [
                'filter' => FILTER_VALIDATE_EMAIL,
                'flags' => FILTER_NULL_ON_FAILURE
            ],
            'flags' => FILTER_NULL_ON_FAILURE

        ];
    }

    /**
     * @return array
     */
    public static function articleFilter()
    {
        return [
            'title' => FILTER_SANITIZE_STRING,
            'headline' => FILTER_SANITIZE_STRING,
            'content' => FILTER_SANITIZE_STRING,
            'id' => FILTER_SANITIZE_NUMBER_INT,
            'user_id' => FILTER_SANITIZE_NUMBER_INT,
            'flags' => FILTER_NULL_ON_FAILURE
        ];
    }

    /**
     * @return array
     */
    public static function commentFilter()
    {
        return [

            'content' => FILTER_SANITIZE_STRING,
            'FK_user_id' => FILTER_SANITIZE_NUMBER_INT,
            'FK_post_id' => FILTER_SANITIZE_NUMBER_INT,
            'flags' => FILTER_NULL_ON_FAILURE
        ];
    }

    /**
     * @param $string
     *
     * @return mixed
     */
    public static function filterInputString($string)
    {
        return filter_input(INPUT_POST, $string, FILTER_SANITIZE_STRING);
    }

    /**
     * @param $email
     *
     * @return mixed
     */
    public static function filterInputEmail($email)
    {
        return filter_input(INPUT_POST, $email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * @param $int
     *
     * @return mixed
     */
    public static function filterInputInt($int)
    {
        return filter_var(INPUT_POST, $int, FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     * @param $password
     *
     * @return mixed
     */
    public static function filterInputPassword($password)
    {
        return filter_var(INPUT_POST, $password, FILTER_UNSAFE_RAW);
    }

    public static function filterInputServer($server)
    {
        return filter_var('http://' . $_SERVER[$server], FILTER_VALIDATE_URL);
    }

    public static function redirectFilter($redirection)
    {
        return filter_var('Location: http://' . $_SERVER[$redirection]);
    }

}