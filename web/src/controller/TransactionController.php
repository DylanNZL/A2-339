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
    public function indexAction($id) {
        session_name('UserDetails');
        session_start();

        $bankAccount = new BankAccountModel();
        $bankAccount->load($id);
        // Check we found the account
        if ($bankAccount->getBalance() == null) {
            BankAccountController::indexAction();
            return;
        }
        // Check the user owns the account
        if ($bankAccount->getUserID() != $_SESSION['MyUserId']) {
            BankAccountController::indexAction();
            return;
        }
        // Render the transactions page of this account
        $_SESSION['currentAccount'] = $bankAccount->getID();
        $_SESSION['currentAccountName'] = $bankAccount->getName();

        $sorter = urldecode(substr($_SERVER["REQUEST_URI"], 12));
        $sorter = explode('?', $sorter);
        error_log($sorter[1]);
        if ($sorter[1] != null) {
            parse_str($sorter[1], $out);
            $sort = $out['sort'];
            $order = $out['order'];
            error_log($sort);
            error_log($order);
            $_SESSION['sort'] = $sort;
            $_SESSION['order'] = $order;
        }

        $transactions = new TransactionCollectionModel($bankAccount->getID(),$sort??null, $order??null);
        $transactions = $transactions->getTransactions();

        $view = new View('transactionIndex');
        $view->addData("account", $bankAccount);
        $view->addData("transactions", $transactions);
        echo $view->render();
    }

    private function IndexActionWithError($error) {
        session_name('UserDetails');
        session_start();

        if (!isset($_SESSION['currentAccount']) || $_SESSION['currentAccount'] == null) {
            BankAccountController::indexAction();
            return;
        }

        $bankAccount = new BankAccountModel();
        $bankAccount->load($_SESSION['currentAccount']);

        $transactions = new TransactionCollectionModel($bankAccount->getID());
        $transactions->getTransactions();

        $view = new View('transactionIndex');
        $view->addData("account", $bankAccount);
        $view->addData("transactions", $transactions);
        $view->addData("error", $error);
        echo $view->render();
    }

    public function createAction() {
        session_name('UserDetails');
        session_start();

        if ($_POST['amount'] == null || $_POST['type'] == null) {
            return $this->indexActionWithError("Make sure to enter values into your transaction");
        }

        $amount = $_POST['amount'];
        $type = substr($_POST['type'], 0,1);
        $accountID = $_SESSION['currentAccount'];

        $account = new BankAccountModel();
        $account->load($accountID);

        if ($amount <= 0) {
            return $this->indexActionWithError("Enter a valid amount");
        }
        if ($type == "W" && ($account->getBalance() - $amount) < 0) {
            return $this->indexActionWithError("You can't withdraw that much");
        }

        $account->transaction($amount, $type);

        $transaction = TransactionModel::__constructFromVars($accountID, $amount, $type);
        $transaction->save();

        $this->indexAction($accountID);
    }
}