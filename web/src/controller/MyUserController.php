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

        error_log($password);
        error_log($myUser->getPassword());
        if ($myUser->getPassword() != $password) {
            $view = new View('myUserIndex');
            $view->addData("error", "Invalid Password");
            //error_log($view->render());
            echo $view->render();
            return;
        }

        error_log("WE GOT THERE!");
        BankAccountController::indexAction();

//        echo "E: $email P: $password _Post:".print_r($_POST);
    }

    public function createAction() {
        $view = new View('myUserCreate');
        echo $view->render();
    }

    public function createAccountAction() {

    }
}