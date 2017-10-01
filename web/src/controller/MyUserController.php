<?php
/**
 * Created by PhpStorm.
 * User: dylancross
 * Date: 28/09/17
 * Time: 1:55 PM
 */

namespace agilman\a2\controller;


use agilman\a2\model\MyUserModel;
use agilman\a2\view\View;

class MyUserController extends Controller
{
    public function indexAction() {
        $view = new View('myUserIndex');
        echo $view->render();
    }

    public function loginAction() {
        $email = $_POST["email"];
        $password = $_POST["pw"];
        $myUser = new MyUserModel();

         $myUser->load($email);

        if ($myUser->getId() == null) {
            $view = new View('myUserIndex');
            $view->addData("error", "Invalid Email");
            //error_log($view->render());
            echo $view->render();
            return;
        }

        if ($myUser->getPassword() != $password) {
            $view = new View('myUserIndex');
            $view->addData("error", "Invalid Password");
            //error_log($view->render());
            echo $view->render();
            return;
        }

        // Set cookie
        session_name('UserDetails');
        session_start();
        $_SESSION['MyUserId'] = $myUser->getId();
        $_SESSION['MyUserFName'] = $myUser->getFName();
        BankAccountController::indexAction();
    }

    public function createAction() {
        $view = new View('myUserCreate');
        echo $view->render();

    }

    public function createAccountAction()
    {
        foreach ($_POST as $key => $value) {
            if ($value == null) {
                $view = new View('myUserCreate');
                $view->addData("error", "Pease fill out all fields");
                echo $view->render();
                return;
            }
        }
        if ($_POST["password"] != $_POST["confirmpassword"]) {
            $view = new View('myUserCreate');
            $view->addData("error", "Passwords do not match");
            echo $view->render();
            return;
        }
        $tempuser = MyUserModel::__constructwithvar($_POST["fname"], $_POST["lname"], $_POST["phone"], $_POST["address"], $_POST["email"], $_POST["password"]);
        error_log($tempuser->getAddress());
        $tempuser->save();
        $view = new View('myUserIndex');
        echo $view->render();
        return;
    }

    public function logoutAction() {
        session_name('UserDetails');
        session_start();
        session_unset();
        session_destroy();

        $view = new View('myUserIndex');
        echo $view->render();
    }
}