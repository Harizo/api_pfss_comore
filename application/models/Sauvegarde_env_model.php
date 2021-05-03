<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sauvegarde_env_model extends CI_Model
{
    protected $table = 'sauvegarde_env';


    public function add($sauvegarde_env)
    {
        $this->db->set($this->_set($sauvegarde_env))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $sauvegarde_env)
    {
        $this->db->set($this->_set($sauvegarde_env))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($sauvegarde_env)
    {
        return array(
            'info_evaluation_pre'    =>      $sauvegarde_env['info_evaluation_pre'],
            'checklist_evaluation_pre' =>      $sauvegarde_env['checklist_evaluation_pre'],
            'resultats' =>      $sauvegarde_env['resultats'],
            'methodologie' =>      $sauvegarde_env['methodologie'],
            'mesures_environnement' =>      $sauvegarde_env['mesures_environnement'],
            'id_sous_projet_localisation' =>      $sauvegarde_env['id_sous_projet_localisation']                      
        );
    }

    public function add_down($sauvegarde_env, $id)  {
        $this->db->set($this->_set_down($sauvegarde_env, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($sauvegarde_env, $id)
    {
        return array(
            'info_evaluation_pre'    =>      $sauvegarde_env['info_evaluation_pre'],
            'checklist_evaluation_pre' =>      $sauvegarde_env['checklist_evaluation_pre'],
            'resultats' =>      $sauvegarde_env['resultats'],
            'methodologie' =>      $sauvegarde_env['methodologie'],
            'mesures_environnement' =>      $sauvegarde_env['mesures_environnement'],
            'id_sous_projet_localisation' =>      $sauvegarde_env['id_sous_projet_localisation'] 
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
                        ->order_by('id_sous_projet_localisation')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }

    public function getsauvegarde_envbysousprojet_localisation($id_sous_projet_localisation)
    {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where('id_sous_projet_localisation',$id_sous_projet_localisation)
                        ->order_by('id_sous_projet_localisation')
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
