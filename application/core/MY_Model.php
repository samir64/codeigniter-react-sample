<?php

abstract class MY_Model extends CI_Model
{
  protected $table = '';

  public function __construct($fields)
  {
    parent::__construct();

    $this->dbforge->add_field($fields);
    $this->dbforge->add_key('id', TRUE);
    $this->dbforge->create_table($this->table, TRUE);
  }

  public function getOne()
  {
    $data = $this->db->get($this->table);
    $result = $data->result();

    if (!!$result) {
      $result = json_decode(json_encode($result[0]));
    }

    return $result;
  }

  public function getAll()
  {
    $data = $this->db->get($this->table);
    $result = $data->result();

    if (!!$result) {
      $result = json_decode(json_encode($result));
    } else {
      $result = array();
    }

    return $result;
  }

  public function insert($data)
  {
    return $this->db->insert($this->table, $data);
  }
}
