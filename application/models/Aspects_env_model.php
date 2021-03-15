<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aspects_env_model extends CI_Model
{
    protected $table = 'aspects_env';


    public function add($aspect_env)
    {
        $this->db->set($this->_set($aspect_env))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $aspect_env)
    {
        $this->db->set($this->_set($aspect_env))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($aspect_env)
    {
        return array(
            'type_sous_projet' => $aspect_env['type_sous_projet'],
            'emplace_site' => $aspect_env['emplace_site'],
            'etat_initial_recepteur' => $aspect_env['etat_initial_recepteur'],
            'classification_sous_projet' => $aspect_env['classification_sous_projet'],
            'id_sous_projet' =>      $aspect_env['id_sous_projet']                      
        );
    }

    public function add_down($aspect_env, $id)  {
        $this->db->set($this->_set_down($aspect_env, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($aspect_env, $id)
    {
        return array(
            'type_sous_projet' => $aspect_env['type_sous_projet'],
            'emplace_site' => $aspect_env['emplace_site'],
            'etat_initial_recepteur' => $aspect_env['etat_initial_recepteur'],
            'classification_sous_projet' => $aspect_env['classification_sous_projet'],
            'id_sous_projet' =>      $aspect_env['id_sous_projet'] 
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
                        ->order_by('id_sous_projet')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    

    public function getaspects_envbysousprojet($id_sous_projet)
    {
        $result =  $this->db->select("*")
                        ->from($this->table)
                        ->where('id_sous_projet',$id_sous_projet)
                        ->order_by('id_sous_projet')
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
