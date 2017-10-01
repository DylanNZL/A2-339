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
        session_name('UserDetails');
        session_start();
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
        session_name('UserDetails');
        session_start();
        $bankAccount = BankAccountModel::__constructwithvar($_POST["bankaccountname"], $_SESSION['MyUserId']);
        $bankAccount->save();
        $this->indexAction();
        return;
    }

    public function singleAction($id) {
        session_name('UserDetails');
        session_start();
        $bankAccount = new BankAccountModel();
        $bankAccount->load($id);
        // Check we found the account
        if ($bankAccount->getBalance() == null) {
            $this->indexAction();
            return;
        }
        // Check the user owns the account
        if ($bankAccount->getUserID() != $_SESSION['MyUserId']) {
            $this->indexAction();
            return;
        }
        // Render the transactions page of this account
        $_SESSION['currentAccount'] = $bankAccount->getID();
        TransactionController::indexAction();
    }

    public function editAction($id) {

    }
}