<?php

class ProjectModel extends MY_Model
{
  protected $table = 'projects';

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
        'title' => array(
          'type' => 'VARCHAR',
          'constraint' => 30
        ),
        'description' => array(
          'type' => 'VARCHAR',
          'constraint' => 60,
          'unique' => TRUE
        ),
        'date' => array(
          'type' => 'INT',
          'constraint' => 9
        ),
        'file' => array(
          'type' => 'VARCHAR',
          'constraint' => 60
        )
      )
    );
  }

  /**
   * @param {String} $title
   * @param {String} $description
   * @param {String} $file
   */
  public function setProject($title, $description, $file)
  {
    $project = $this->getProjectByTitle($title);

    if (!$project) {
      $data = array();
      $data['title'] = $title;
      $data['description'] = $description;
      $data['date'] = time();
      $data['file'] = $file;

      return $this->insert($data);
    } else {
      return FALSE;
    }
  }

  /**
   * @param {String} $id
   */
  public function getProjectById($id)
  {
    $this->db->where('id', $id);
    $result = $this->getOne();

    return $result;
  }

  /**
   * @param {String} $title
   */
  public function getProjectByTitle($title)
  {
    $this->db->where('title', $title);
    $result = $this->getOne();

    return $result;
  }
}
