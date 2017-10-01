<?php
/**
 * Dylan Cross ID 15219491
 * Jordan Felix ID 15152699
 * Thomas Sloman ID 15078758
 */


namespace agilman\a2\model;


/**
 * Class BankAccountModel
 *
 * NOTE: Owner ID refers to the MyUserModel that "owns" the account
 *
 * @package agilman\a2\model
 */
class BankAccountModel extends Model
{
    /**
     * @var integer Account ID
     */
    private $_id;
    /**
     * @var string Account Name
     */
    private $_name;
    /**
     * @var float Balance
     */
    private $_balance;
    /**
     * @var integer Owner ID
     * Contains the ID of the owner User
     */
    private $_userID;


    public function __construct()
    {
        parent::__construct();
    }

    public static function __constructwithvar($name, $id) {
        $newAccount = new BankAccountModel();
        $newAccount->_balance = 0;
        $newAccount->_name = $name;
        $newAccount->_userID = $id;
        return $newAccount;
    }

    /**
     * @return int
     */
    public function getID()
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return float
     */
    public function getBalance()
    {
        return $this->_balance;
    }

    /**
     * @return int
     */
    public function getUserID()
    {
        return $this->_userID;
    }

    /**
     * @param float $amount
     * @param string $type
     */
    public function transaction($amount, $type) {
        if ($type == "W") {
            $this->_balance = $this->_balance - $amount;
        } else if ($type == "D") {
            $this->_balance = $this->_balance + $amount;
        }
        $this->save();
    }

    /**
     * @param int Bank Account ID
     * @param int User ID
     *
     * @return $this BankAccountModel
     */
    public function load($id) {
        if (!$result = $this->db->query("SELECT * FROM `bank_account` WHERE `id` = $id")) {
            // throw new ...
        }

        $result = $result->fetch_assoc();
        $this->_name = $result['name'];
        $this->_balance = $result['balance'];
        $this->_id = $id;
        $this->_userID = $result['user_id'];

        return $this;
    }

    /**
     * Saves account information to the database
     * @param int User ID
     *
     * @return $this BankAccountModel
     */
    public function save()
    {
        if (!isset($this->_id)) {
            // New account - Perform INSERT
            if (!$result = $this->db->query("INSERT INTO `bank_account` VALUES (NULL,\"$this->_name\", $this->_balance, $this->_userID);")) {
                // throw new ...
            }
            $this->_id = $this->db->insert_id;
        } else {
            // saving existing account - perform UPDATE
            if (!$result = $this->db->query("UPDATE `bank_account` SET `name` = \"$this->_name\", `balance` = \"$this->_balance\" WHERE `id` = \"$this->_id\";")) {
                // throw new ...
            }

        }

        return $this;
    }

    /**
     * Deletes account from the database

     * @return $this BankAccountModel
     */
    public function delete()
    {
        if (!$result = $this->db->query("DELETE FROM `bank_account` WHERE `id` = $this->_id;")) {
            //throw new ...
        }

        return $this;
    }
}