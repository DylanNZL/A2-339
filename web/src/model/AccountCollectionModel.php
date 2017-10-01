<?php
/**
 * Dylan Cross ID 15219491
 * Jordan Felix ID 15152699
 * Thomas Sloman ID 15078758
 */

namespace agilman\a2\model;

/**
 * Class AccountCollectionModel
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class AccountCollectionModel extends Model
{
    private $_accountIds;

    private $_N;

    function __construct()
    {
        parent::__construct();
        if (!$result = $this->db->query("SELECT `id` FROM `account`;")) {
            // throw new ...
        }
        $this->_accountIds = array_column($result->fetch_all(), 0);
        $this->_N = $result->num_rows;
    }

    /**
     * Get account collection
     *
     * @return Generator|AccountModel[] Accounts
     */
    public function getAccounts() 
    {
        foreach ($this->_accountIds as $id) {
            // Use a generator to save on memory/resources
            // load accounts from DB one at a time only when required
            yield (new AccountModel())->load($id);
        }
    }


}