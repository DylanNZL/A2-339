<?php
/**
 * Created by PhpStorm.
 * User: dylancross
 * Date: 29/09/17
 * Time: 9:00 PM
 */

namespace agilman\a2\model;


class TransactionCollectionModel extends Model
{
    private $_transactionIDs;
    private $_numTransactions;

    public function __construct($account) {
        parent::__construct();
        if (!$result = $this->db->query("SELECT `id` FROM `transaction` WHERE `account_id` = $account")) {
            // throw new ...
        } //else {
        $this->_transactionIDs = array_column($result->fetch_all(), 0);
        $this->_numTransactions = $result->num_rows;
//        }
    }

    /**
     * Get account collection
     *
     * @return Generator|TransactionModel[] Accounts
     */
    public function getTransactions()
    {
        foreach ($this->_transactionIDs as $id) {
            // Use a generator to save on memory/resources
            // load accounts from DB one at a time only when required
            yield (new TransactionModel())->load($id);
        }
    }

}