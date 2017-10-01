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

        $view = new View('transactionIndex');
        $view->addData("account", $bankAccount);
        $view->addData("transactions", $transactions);
        echo $view->render();
    }

    public function createAction() {
        session_name('UserDetails');
        session_start();

        if (!isset($_POST['amount']) || !isset($_POST['type'])) {
            return $this->indexAction();
        }

        $amount = $_POST['amount'];
        $type = substr($_POST['type'], 0,1);

        $transaction = TransactionModel::__constructFromVars($_SESSION['currentAccount'], $amount, $type);

        $transaction->save();

        $this->indexAction();
    }
}