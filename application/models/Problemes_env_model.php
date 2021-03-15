<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Problemes_env_model extends CI_Model
{
    protected $table = 'problemes_env';


    public function add($problemes_env)
    {
        $this->db->set($this->_set($problemes_env))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $problemes_env)
    {
        $this->db->set($this->_set($problemes_env))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($problemes_env)
    {
        return array(
            'libelle'    =>      $problemes_env['libelle'],
            'description' =>      $problemes_env['description'],
            'id_aspects_env' =>      $problemes_env['id_aspects_env']                      
        );
    }

    public function add_down($problemes_env, $id)  {
        $this->db->set($this->_set_down($problemes_env, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($problemes_env, $id)
    {
        return array(
            'id' => $id,
            'libelle' => $problemes_env['libelle'],
            'description' => $problemes_env['description'],
            'id_aspects_env' =>      $problemes_env['id_aspects_env'] 
        );
    }

    public function delete($id)
    {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }  
    }


    public function findAll()
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('libelle')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getproblemes_envbyaspects($id_aspects_env)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_aspects_env',$id_aspects_env)
                        ->order_by('libelle')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function findById($id)
    {
        $this->db->where("id", $id);
        $q = $this->db->get($this->table);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return null;
    }

}
