<?php
/**
 * Created by PhpStorm.
 * User: dylancross
 * Date: 28/09/17
 * Time: 3:02 PM
 */

namespace agilman\a2\controller;


use agilman\a2\view\View;

class BankAccountController extends Controller
{
    public function createAction() {
        $view = new View("bankAccountCreate");
        echo $view->render();
    }

}