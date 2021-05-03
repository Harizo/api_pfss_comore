<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Etude_env_model extends CI_Model
{
    protected $table = 'etude_env';


    public function add($etude_env)
    {
        $this->db->set($this->_set($etude_env))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $etude_env)
    {
        $this->db->set($this->_set($etude_env))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($etude_env)
    {
        return array(
            'introduction' => $etude_env['introduction'],
            'description_sour_recep' => $etude_env['description_sour_recep'],
            'description_impacts' => $etude_env['description_impacts'],
            'mesure' => $etude_env['mesure'],
            'plan_gestion' => $etude_env['plan_gestion'],
            'id_sous_projet_localisation' =>      $etude_env['id_sous_projet_localisation']                      
        );
    }

    public function add_down($etude_env, $id)  {
        $this->db->set($this->_set_down($etude_env, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($etude_env, $id)
    {
        return array(
            'introduction' => $etude_env['introduction'],
            'description_sour_recep' => $etude_env['description_sour_recep'],
            'description_impacts' => $etude_env['description_impacts'],
            'mesure' => $etude_env['mesure'],
            'plan_gestion' => $etude_env['plan_gestion'],
            'id_sous_projet_localisation' =>      $etude_env['id_sous_projet_localisation'] 
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
    

    public function getetude_envbysousprojet_localisation($id_sous_projet_localisation)
    {
        $result =  $this->db->select("*")
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
