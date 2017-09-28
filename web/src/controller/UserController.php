<?php
/**
 * Created by PhpStorm.
 * User: dylancross
 * Date: 28/09/17
 * Time: 1:55 PM
 */

namespace agilman\a2\controller;


use agilman\a2\view\View;

class UserController extends Controller
{
    public function indexAction() {
        $view = new View('userIndex');
        echo $view->render();
    }

    public function createAction() {

    }

    public function createAccountAction() {

    }
}