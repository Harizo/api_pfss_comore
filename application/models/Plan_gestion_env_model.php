<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plan_gestion_env_model extends CI_Model
{
    protected $table = 'plan_gestion_env';


    public function add($plan_gestion_env)
    {
        $this->db->set($this->_set($plan_gestion_env))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $plan_gestion_env)
    {
        $this->db->set($this->_set($plan_gestion_env))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($plan_gestion_env)
    {
        return array(            
            'impacts'=> $plan_gestion_env['impacts'],      
            'mesures'=> $plan_gestion_env['mesures'],      
            'responsable'=> $plan_gestion_env['responsable'],
            'calendrier_execution'=> $plan_gestion_env['calendrier_execution'],      
            'cout_estimatif'=> $plan_gestion_env['cout_estimatif'],      
            'id_fiche_env'=> $plan_gestion_env['id_fiche_env']
        );
    }

    public function add_down($plan_gestion_env, $id)  {
        $this->db->set($this->_set_down($plan_gestion_env, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($plan_gestion_env, $id)
    {
        return array(
            'impacts'=> $plan_gestion_env['impacts'],      
            'mesures'=> $plan_gestion_env['mesures'],      
            'responsable'=> $plan_gestion_env['responsable'],
            'calendrier_execution'=> $plan_gestion_env['calendrier_execution'],      
            'cout_estimatif'=> $plan_gestion_env['cout_estimatif'],      
            'id_fiche_env'=> $plan_gestion_env['id_fiche_env']
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
                        ->order_by('id_fiche_env')
                        ->get()
                        ->result();
        if($result)
        {
            return $result;
        }else{
            return null;
        }                 
    }
    

    public function getplan_gestion_envbyfiche($id_fiche_env)
    {
        $result =  $this->db->select("*")
                        ->from($this->table)
                        ->where('id_fiche_env',$id_fiche_env)
                        ->order_by('id_fiche_env')
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
