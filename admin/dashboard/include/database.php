<?php

class DatabaseAdministration{
    private $dbHost     = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "123456";
    private $dbName     = "bitex";
    private $userTbl    = "settings";

    public function __construct($table){
        $this->userTbl = $table;
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){
                die("Failed to connect with MySQL: " . $conn->connect_error);
            }else{
                $this->db = $conn;
            }
        }
    }

    public function getSettings($conditions = array()) {
        $arr = array();
        $data = $this->getRows($conditions);
        foreach ($data as $key => $value) {
            $arr[ $data[$key]['name'] ] = $data[$key]['value'];
        }
        return $arr;
    }

    public function saveSettings($post) {
        if(empty($post) || !is_array($post)){
            return array('ERROR' => 'Incorrect or no data received.');
        }

        // Separa los campos con ,
        foreach($post as $key => $val){
            $query = "UPDATE {$this->userTbl} SET value = '{$val}' WHERE name ='{$key}'";
            $this->db->query($query);
        }
        return array('INFO' => 'Changes were saved.');
    }

    public function addPair($data) {
        if( !is_array($data) || empty($data) ) {
            return array('ERROR' => 'Incorrect or no data received.');
        }

        $coin = filter_var($data['coin'], FILTER_SANITIZE_STRING);
        $market = filter_var($data['market'], FILTER_SANITIZE_STRING);
        $query = "INSERT INTO {$this->userTbl} (coin, market) VALUES ('{$coin}', '{$market}')";

        $insert = $this->db->query($query);

        if ($this->db->insert_id > 0) {
            return array('INFO' => $data['coin'] . ' pair added.');
        }

        return array('ERROR' => 'This pair already exists.');
    }

    public function getPairs($conditions = array()) {
        return $this->getRows($conditions);
    }

    public function updatePair($id, $bool) {
        $pairId = filter_var($id, FILTER_VALIDATE_INT);
        $bool = filter_var($bool, FILTER_VALIDATE_INT);
        $query = "UPDATE {$this->userTbl} SET pair_suspended={$bool}";
        $query .= " WHERE id ={$pairId}";
        echo $query;
        return $this->db->query($query);
    }

    public function removePair($id) {
        $pairId = filter_var($id, FILTER_VALIDATE_INT);
        $query = "DELETE FROM {$this->userTbl} WHERE id={$pairId}";
        if ($this->db->query($query)) {
            return array('INFO' => 'Pair removed');
        }
        return array('ERROR' => 'Pair not removed');
    }

    public function addMarket($data) {
        if( !is_array($data) || empty($data) ) {
            return array('ERROR' => 'Incorrect or no data received.');
        }

        $symbol = filter_var($data['symbol'], FILTER_SANITIZE_STRING);
        $query = "INSERT INTO {$this->userTbl} (symbol) VALUES ('{$symbol}')";
        $insert = $this->db->query($query);

        if ($this->db->insert_id > 0) {
            return array('ERROR' => $data['symbol'] . ' Market added.');
        }

        return array('ERROR' => 'This market already exists.');
    }

    public function removeMarket($id) {
        $marketId = filter_var($id, FILTER_VALIDATE_INT);
        $query = "DELETE FROM {$this->userTbl} WHERE id={$marketId}";
        return $this->db->query($query);

    }

    public function updateMarket($id, $bool) {
        $marketId = filter_var($id, FILTER_VALIDATE_INT);
        $query = "UPDATE {$this->userTbl} SET market_suspended='" . $bool . "'";
        $query .= " WHERE id ='" . $marketId . "'";
        return $this->db->query($query);
    }

    public function getMarkets($conditions = array()) {
        $arr = array();
        $data = $this->getRows($conditions);
        foreach ($data as $key => $value) {
            $arr[ $data[$key]['symbol'] ] = $value;
        }
        return $arr;
    }

    public function addCoin($data) {
        if( !is_array($data) || empty($data) ) {
            return array('ERROR' => 'Incorrect or no data received.');
        }

        $symbol = filter_var($data['symbol'], FILTER_SANITIZE_STRING);
        $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $min_deposit = filter_var($data['min_deposit'], FILTER_SANITIZE_STRING);
        $min_withdrawal = filter_var($data['min_withdrawal'], FILTER_SANITIZE_STRING);
        $fee_withdrawal = filter_var($data['fee_withdrawal'], FILTER_SANITIZE_STRING);

        $query = "INSERT INTO {$this->userTbl} (symbol, name, min_deposit,
            min_withdrawal, fee_withdrawal) VALUES ('{$symbol}', '{$name}',
                '{$min_deposit}', '{$min_withdrawal}', '{$fee_withdrawal}')";

        $this->db->query($query);

        if ($this->db->insert_id > 0) {
            return array('INFO' => $data['symbol'] . ' added.');
        }

        return array('ERROR' => 'This coin already exists.');
    }

    public function getCoins($conditions = array()) {
        $arr = array();
        $data = $this->getRows($conditions);
        foreach ($data as $key => $value) {
            $arr[ $data[$key]['symbol'] ] = $value;

        }
        return $arr;
    }

    public function updateCoin($post) {
        $query = "UPDATE {$this->userTbl} SET symbol='{$post['symbol']}',
        min_deposit='{$post['min_deposit']}', min_withdrawal ='{$post['min_withdrawal']}',
        fee_withdrawal ='{$post['fee_withdrawal']}', name='{$post['name']}'
        WHERE id ='{$post['id']}'";

        $this->db->query($query);
    }

    public function removeCoin($post) {
        $coinId = filter_var($post['id'], FILTER_VALIDATE_INT);
        $query = "DELETE FROM {$this->userTbl} WHERE id={$coinId}";
        return $this->db->query($query);
    }

    public function countRows() {
        $query = "SELECT COUNT(*) AS total FROM " . $this->userTbl;
        $result = $this->db->query($query);
        return $result->fetch_assoc()['total'];
    }

    /*
     * Returns rows from the database based on the conditions
     * @param string name of the table
     * @param array select, where, order_by, limit and return_type conditions
     */
    public function getRows($conditions = array()){
        $sql = 'SELECT ';
        $sql .= array_key_exists("select",$conditions)?$conditions['select']:'*';
        $sql .= ' FROM '.$this->userTbl;
        if(array_key_exists("where",$conditions)){
            $sql .= ' WHERE ';
            $i = 0;
            foreach($conditions['where'] as $key => $value){
                $pre = ($i > 0)?' AND ':'';
                $sql .= $pre.$key." = '".$value."'";
                $i++;
            }
        }

        if(array_key_exists("order_by",$conditions)){
            $sql .= ' ORDER BY '.$conditions['order_by'];
        }

        if(array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['start'].','.$conditions['limit'];
        }elseif(!array_key_exists("start",$conditions) && array_key_exists("limit",$conditions)){
            $sql .= ' LIMIT '.$conditions['limit'];
        }

        $result = $this->db->query($sql);

        if(array_key_exists("return_type",$conditions) && $conditions['return_type'] != 'all'){
            switch($conditions['return_type']){
                case 'count':
                    $data = $result->num_rows;
                    break;
                case 'single':
                    $data = $result->fetch_assoc();
                    break;
                default:
                    $data = '';
            }
        }else{
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $data[] = $row;
                }
            }
        }

        return !empty($data)?$data:false;
    }
}
