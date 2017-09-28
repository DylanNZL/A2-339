<?php
/**
 * Created by PhpStorm.
 * User: dylancross
 * Date: 28/09/17
 * Time: 6:03 PM
 */

namespace agilman\a2\model;


class BankAccountCollectionModel extends Model
{
    private $_accountIDs;
    private $_numAccounts;


    function __construct($user)
    {
        parent::__construct();
        if (!$result = $this->db->query("SELECT `id` FROM `bank_account` WHERE `owner_id` = $user")) {
            // throw new ...
        } //else {
            $this->_accountIDs = array_column($result->fetch_all(), 0);
            $this->_numAccounts = $result->num_rows;
//        }
    }

    /**
     * Get account collection
     *
     * @return Generator|BankAccountModel[] Accounts
     */
    public function getAccounts()
    {
        foreach ($this->_accountIDs as $id) {
            // Use a generator to save on memory/resources
            // load accounts from DB one at a time only when required
            yield (new BankAccountModel())->load($id);
        }
    }
}