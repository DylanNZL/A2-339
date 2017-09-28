<?php
/**
 * Created by PhpStorm.
 * User: dylancross
 * Date: 28/09/17
 * Time: 3:02 PM
 */

namespace agilman\a2\controller;


use agilman\a2\model\BankAccountCollectionModel;
use agilman\a2\model\BankAccountModel;
use agilman\a2\view\View;

class BankAccountController extends Controller
{
    public function createAction() {
        $view = new View("bankAccountCreate");
        echo $view->render();
    }

    public function indexAction() {
        error_log($_SESSION['MyUserId']);
        // Check user has logged in
        if (!isset($_SESSION['MyUserId']) || $_SESSION['MyUserId'] == null) {
            $view = new View('myUserIndex');
            echo $view->render();
            echo $_SESSION['MyUserId'];
            return;
        }

        // Get users bank accounts
        $bankAccountCollection = new BankAccountCollectionModel($_SESSION['MyUserId']);
        $bankAccounts = $bankAccountCollection->getAccounts();

        // Render
        $view = new View('bankAccountIndex');
        $view->addData("bankAccounts", $bankAccounts);
        echo $view->render();
    }

    public function createBankAccountAction() {
        $bankAccount = new BankAccountModel();
        $bankAccount->setName("test");
        $bankAccount->
        $bankAccount->save();
        $this->indexAction();


    }
}