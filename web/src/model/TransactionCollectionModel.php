<?php
/**
 * Dylan Cross ID 15219491
 * Jordan Felix ID 15152699
 * Thomas Sloman ID 15078758
 */


namespace agilman\a2\model;


class TransactionCollectionModel extends Model
{
    private $_transactionIDs;
    private $_numTransactions;

    public function __construct($account, $sort, $order) {
        parent::__construct();

        if ($sort == null) {
            if (!$result = $this->db->query("SELECT `id` FROM `transaction` WHERE `account_id` = $account")) {
                // throw new ...
            }
        } else {
            if (!$result = $this->db->query("SELECT `id` FROM `transaction` WHERE `account_id` = $account ORDER BY `$sort` $order")) {
                // throw new ...
            }
        }

        $this->_transactionIDs = array_column($result->fetch_all(), 0);
        $this->_numTransactions = $result->num_rows;
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