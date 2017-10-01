<?php
/**
 * Dylan Cross ID 15219491
 * Jordan Felix ID 15152699
 * Thomas Sloman ID 15078758
 */

namespace agilman\a2\model;

use mysqli;

/**
 * Class Model
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class Model
{
    protected $db;

    // is this the best place for these constants?
    const DB_HOST = 'mysql';
    const DB_USER = 'root';
    const DB_PASS = 'root';
    const DB_NAME = 'legitBankDatabase';

    function __construct()
    {
        $this->db = new mysqli(
            Model::DB_HOST,
            Model::DB_USER,
            Model::DB_PASS
        //            Model::DB_NAME
        );

        if (!$this->db) {
            // can't connect to MYSQL???
            // handle it...
            // e.g. throw new someException($this->db->connect_error, $this->db->connect_errno);
        }

        //----------------------------------------------------------------------------
        // This is to make our life easier
        // Create your database and populate it with sample data
        $this->db->query("CREATE DATABASE IF NOT EXISTS ".Model::DB_NAME.";");

        if (!$this->db->select_db(Model::DB_NAME)) {
            // somethings not right.. handle it
            error_log("Mysql database not available!",0);
        }

            //----------------------------------------------------------------------------
            //------------------------------ MY USER TABLE -------------------------------
            //----------------------------------------------------------------------------

        $result = $this->db->query("SHOW TABLES LIKE 'my_user';");
        if ($result->num_rows == 0) {

            $result = $this->db->query(
                "CREATE TABLE `my_user` (
                                          `id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                                          `fname` VARCHAR(256) NOT NULL,
                                          `lname` VARCHAR(256) NOT NULL,
                                          `address` VARCHAR(256) NOT NULL,
                                          `phone` VARCHAR(256) NOT NULL,
                                          `email` VARCHAR(256) NOT NULL,
                                          `password` VARCHAR(256) NOT NULL,
                                          PRIMARY KEY (`id`) );"
            );

            if (!$result) {
                // handle appropriately
                error_log("Failed creating table account", 0);
            }

            if (!$this->db->query(
                "INSERT INTO `my_user` VALUES (NULL,'Dylan', 'Cross', '12 Real Street', '0123456789', 'dylan@email.com', '123'), 
                    (NULL,'Tom', 'Sloman', '34 Fake Ave', '123456789', 'tom@email.com', '456'),
                    (NULL,'Jordan', 'Felix', '34 Pretend Road', '234567890', 'jordan@email.com', '789');"


            )) {
                // handle appropriately
                error_log("Failed creating sample data!", 0);
            }
        }

            //----------------------------------------------------------------------------
            //------------------------- BANK ACCOUNT TABLE -------------------------------
            //----------------------------------------------------------------------------

        $result = $this->db->query("SHOW TABLES LIKE 'bank_account';");
        if ($result->num_rows == 0) {
            $result = $this->db->query(
                "CREATE TABLE `bank_account` (
                                              `id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                                              `name` VARCHAR(256) DEFAULT NULL,
                                              `balance` FLOAT(10, 2) NOT NULL,
                                              `user_id` INT(8) NOT NULL,
                                              PRIMARY KEY (`id`) );"
            );

            if (!$result) {
                // handle appropriately
                error_log("Failed creating table account", 0);
            }

            if (!$this->db->query(
                "INSERT INTO `bank_account` VALUES (NULL, 'Cheque', 65.2, 1), 
                        (NULL, 'Credit', 65.2, 1),
                        (NULL, 'Cheque', 98, 2);"
            )) {
                // handle appropriately
                error_log("Failed creating sample data!", 0);
            }
        }

            //----------------------------------------------------------------------------
            //-------------------------- TRANSACTION TABLE -------------------------------
            //----------------------------------------------------------------------------

        $result = $this->db->query("SHOW TABLES LIKE 'transaction';");
        if ($result->num_rows == 0) {
            $result = $this->db->query(
                "CREATE TABLE `transaction` (
                                              `id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                                              `account_id` INT(8) NOT NULL,
                                              `amount` FLOAT(10,2) NOT NULL,
                                              `date` DATETIME NOT NULL,
                                              `type` VARCHAR(256) NOT NULL,
                                              PRIMARY KEY (`id`) );"
            );

            if (!$result) {
                // handle appropriately
                error_log("Failed creating table account", 0);
            }

            // date time 'YYYY-MM-DD HH:MM:SS'
            if (!$this->db->query(
                "INSERT INTO `transaction` VALUES (NULL, 1, 25, '2017-09-01 10:00:00', 'D'), 
                        (NULL, 1, 13, '2017-09-01 10:00:00', 'W'),
                        (NULL, 1, 45.2, '2017-09-01 10:00:00', 'D');"
            )) {
                // handle appropriately
                error_log("Failed creating sample data!", 0);
            }
        }

    }
}