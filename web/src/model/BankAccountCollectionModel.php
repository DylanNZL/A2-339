<?php
/**
 * Dylan Cross ID 15219491
 * Jordan Felix ID 15152699
 * Thomas Sloman ID 15078758
 */


namespace agilman\a2\model;


class BankAccountCollectionModel extends Model
{
    private $_accountIDs;
    private $_numAccounts;


    function __construct($user)
    {
        parent::__construct();
        if (!$result = $this->db->query("SELECT `id` FROM `bank_account` WHERE `user_id` = $user")) {
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