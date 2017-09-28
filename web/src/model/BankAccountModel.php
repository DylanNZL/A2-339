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
        $this->_balance = 0;
    }
    public static function __constructwithvar($name, $id) {
        $newaccount = new BankAccountModel();
        $newaccount -> _name = $name;
        $newaccount -> _id = $id;
        return $newaccount;
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
        $this->_ownerID = $result['owner_id'];

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
        $name = $this->_name??"NULL";
        $balance = $this->_balance??0;
        if (!isset($this->_id)) {
            // New account - Perform INSERT
            if (!$result = $this->db->query("INSERT INTO `bank_account` VALUES (NULL,'$name', $balance, $this->userID);")) {
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