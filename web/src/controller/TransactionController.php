<?php
/**
 * Created by PhpStorm.
 * User: dylancross
 * Date: 28/09/17
 * Time: 3:03 PM
 */

namespace agilman\a2\controller;


use agilman\a2\model\BankAccountModel;
use agilman\a2\model\TransactionCollectionModel;
use agilman\a2\model\TransactionModel;
use agilman\a2\view\View;

class TransactionController extends Controller
{
    public function indexAction() {
        session_name('UserDetails');
        session_start();

        if (!isset($_SESSION['currentAccount']) || $_SESSION['currentAccount'] == null) {
            BankAccountController::indexAction();
            return;
        }

        $bankAccount = new BankAccountModel();
        $bankAccount->load($_SESSION['currentAccount']);
        error_log($bankAccount->getID());

        $transactions = new TransactionCollectionModel($bankAccount->getID());
        $transactions->getTransactions();

        $testTrans = new TransactionModel();
        $testTrans->load(1);

        $view = new View('transactionIndex');
        $view->addData("account", $bankAccount);
        $view->addData("transactions", $transactions);
        echo $view->render();
    }
}