<?php
/**
 * Dylan Cross ID 15219491
 * Jordan Felix ID 15152699
 * Thomas Sloman ID 15078758
 */


namespace agilman\a2\model;


class TransactionModel extends Model
{
    /**
     * @var integer
     */
    private $_id;

    /**
     * @var integer
     */
    private $_accountID;

    /**
     * @var float
     */
    private $_amount;

    /**
     * @var DateTime
     */
    private $_date;

    /**
     * @var string
     */
    private $_type;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->_id;
    }

    /**
     * @return int
     */
    public function getAccountID()
    {
        return $this->_accountID;
    }

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->_amount;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->_date;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * TransactionModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param int $accountId
     * @param float $amount
     * @param string $type
     *
     * @return TransactionModel
     */
    public static function __constructFromVars($accountId, $amount, $type) {
        $trans = new TransactionModel();
        $trans->_accountID = $accountId;
        $trans->_amount = $amount;
        $trans->_type = $type;
        date_default_timezone_set('Pacific/Auckland');
        $trans->_date = Date("Y-m-d H:i:s");;
        return $trans;
    }

    /**
     * @param int ID
     *
     * @return $this TransactionModel
     */
    public function load($id) {
        if (!$result = $this->db->query("SELECT * FROM `transaction` WHERE `id` = $id")) {
            // throw new ...
        }

        $result = $result->fetch_assoc();
        $this->_id = $id;
        $this->_accountID = $result['account_id'];
        $this->_amount = $result['amount'];
        $this->_date = $result['date'];
        $this->_type = $result['type'];

        return $this;
    }

    /**
     * Saves user information to the database
     *
     * @return $this TransactionModel
     */
    public function save()
    {
        if (!isset($this->_id)) {
            // New account - Perform INSERT
            if (!$result = $this->db->query("INSERT INTO `transaction` VALUES (NULL,$this->_accountID,$this->_amount,'$this->_date','$this->_type');")) {
                // throw new ...
            }
            $this->_id = $this->db->insert_id;
        }

        return $this;
    }
}