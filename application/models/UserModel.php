<?php

class UserModel extends MY_Model
{
  protected $table = 'users';

  public function __construct()
  {
    parent::__construct(
      array(
        'id' => array(
          'type' => 'INT',
          'constraint' => 9,
          'unsigned' => TRUE,
          'auto_increment' => TRUE
        ),
        'firstname' => array(
          'type' => 'VARCHAR',
          'constraint' => 30
        ),
        'lastname' => array(
          'type' => 'VARCHAR',
          'constraint' => 30
        ),
        'username' => array(
          'type' => 'VARCHAR',
          'constraint' => 60,
          'unique' => TRUE
        ),
        'email' => array(
          'type' => 'VARCHAR',
          'constraint' => 60,
          'unique' => TRUE
        ),
        'password' => array(
          'type' => 'VARCHAR',
          'constraint' => 40
        )
      )
    );

    if (!$this->getUserByUsername('test')) {
      $this->setUser('test', md5('test'), 'test@a.com', 'Mr.', 'Tester');
    }
  }

  /**
   * @param {String} $username
   * @param {String} $password
   * @param {String} $email
   * @param {String} $firstname
   * @param {String} $lastname
   */
  public function setUser($username, $password, $email, $firstname, $lastname)
  {
    $data = array();
    $data['username'] = $username;
    $data['password'] = $password;
    $data['email'] = $email;
    $data['firstname'] = $firstname;
    $data['lastname'] = $lastname;

    return $this->insert($data);
  }

  /**
   * @param {String} $username
   */
  public function getUserByUsername($username)
  {
    $this->db->where('username', $username);
    $result = $this->getOne();

    return $result;
  }
}
