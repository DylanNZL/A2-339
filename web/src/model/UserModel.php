<?php
/**
 * Created by PhpStorm.
 * User: dylancross
 * Date: 28/09/17
 * Time: 11:33 AM
 */

namespace agilman\a2\model;


class UserModel extends model
{

    /**
     * @var integer User ID
     */
    private $_id;

    /**
     * @var string first name
     */
    private $_fname;

    /**
     * @var string last name
     */
    private $_lname;

    /**
     * @var string address
     */
    private $_address;

    /**
     * @var string phone number
     */
    private $_phone;

    /**
     * @var string email
     */
    private $_email;

    /**
     * @var string password
     */
    private $_password;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return string
     */
    public function getFName()
    {
        return $this->_fname;
    }

    /**
     * @return string
     */
    public function getLName()
    {
        return $this->_lname;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->_address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->_address = $address;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->_email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->_email = $email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param string email
     *
     * @return $this UserModel
     */
    public function load($email) {
        if (!$result = $this->db->query("SELECT * FROM `user` WHERE `email` = $email")) {
            // throw new ...
        }

        $result = $result->fetch_assoc();
        $this->_id = $result['id'];
        $this->_fname = $result['fname'];
        $this->_lname = $result['lname'];
        $this->_address = $result['address'];
        $this->_phone = $result['address'];
        $this->_email = $email;

        return $this;
    }

    /**
     * Saves user information to the database
     *
     * @return $this UserModel
     */
    public function save()
    {
        if (!isset($this->_id)) {
            // New account - Perform INSERT
            if (!$result = $this->db->query("INSERT INTO `user` VALUES (NULL,$this->_fname,$this->_lname,$this->_address,$this->_phone,$this->_email);")) {
                // throw new ...
            }
            $this->_id = $this->db->insert_id;
        } else {
            // saving existing account - perform UPDATE
            if (!$result = $this->db->query("UPDATE `user` SET `address` = $this->_address, `phone` = $this->_phone, `email` =$this->_email WHERE `id` = $this->_id;")) {
                // throw new ...
            }

        }

        return $this;
    }

}