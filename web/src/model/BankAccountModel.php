<?php
/**
 * Created by PhpStorm.
 * User: dylancross
 * Date: 28/09/17
 * Time: 11:09 AM
 */

namespace agilman\a2\model;


/**
 * Class BankAccountModel
 *
 * NOTE: Owner ID refers to the UserModel that "owns" the account
 *
 * @package agilman\a2\model
 */
class BankAccountModel extends model
{
    /**
     * @var integer Account ID
     */
    private $_accountID;
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
     * Contains the ID of the owner account
     */
    private $_ownerID;

    /**
     * @return int
     */
    public function getAccountID()
    {
        return $this->_accountID;
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
    public function getOwnerID()
    {
        return $this->_ownerID;
    }

    /**
     * @param int Account ID
     * @param int Owner ID
     *
     * @return $this BankAccountModel
     */
    public function load($accountID, $ownerID) {
        if (!$result = $this->db->query("SELECT * FROM `bank_account` WHERE `account_id` = $accountID AND `owner_id` = $ownerID")) {
            // throw new ...
        }

        $result = $result->fetch_assoc();
        $this->_name = $result['name'];
        $this->_balance = $result['balance'];
        $this->_accountID = $accountID;
        $this->_ownerID = $ownerID;

        return $this;
    }

    /**
     * Saves account information to the database
     * @param int Owner ID
     *
     * @return $this BankAccountModel
     */
    public function save($ownerID)
    {
        $name = $this->_name??"NULL";
        $balance = $this->_balance??0;
        if (!isset($this->_id)) {
            // New account - Perform INSERT
            if (!$result = $this->db->query("INSERT INTO `bank_account` VALUES (NULL,'$name', $balance, $ownerID);")) {
                // throw new ...
            }
            $this->_id = $this->db->insert_id;
        } else {
            // saving existing account - perform UPDATE
            if (!$result = $this->db->query("UPDATE `bank_account` SET `name` = '$name', `balance` = $balance WHERE `id` = $this->_id;")) {
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