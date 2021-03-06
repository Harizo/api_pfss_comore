<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Filtration_env_model extends CI_Model
{
    protected $table = 'filtration_env';


    public function add($filtration_env)
    {
        $this->db->set($this->_set($filtration_env))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)
        {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }


    public function update($id, $filtration_env)
    {
        $this->db->set($this->_set($filtration_env))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)
        {
            return true;
        }else{
            return null;
        }                      
    }

    public function _set($filtration_env)
    {
        return array(
            //'nature_sous_projet' => $filtration_env['nature_sous_projet'],
            'secretariat' => $filtration_env['secretariat'],
            //'intitule_sous_projet' => $filtration_env['intitule_sous_projet'],
            //'type_sous_projet' => $filtration_env['type_sous_projet'],
            //'localisation' => $filtration_env['localisation'],
            //'objectif_sous_projet' => $filtration_env['objectif_sous_projet'],
            //'activite_sous_projet' => $filtration_env['activite_sous_projet'],
            'cout_estime_sous_projet' => $filtration_env['cout_estime_sous_projet'],
            'envergure_sous_projet' => $filtration_env['envergure_sous_projet'],
            'ouvrage_prevu' => $filtration_env['ouvrage_prevu'],
            //'description_sous_projet' => $filtration_env['description_sous_projet'],
            'environnement_naturel' => $filtration_env['environnement_naturel'],
            'date_visa_rt_ibd' => $filtration_env['date_visa_rt_ibd'],
            'date_visa_res' => $filtration_env['date_visa_res'],
            'id_sous_projet_localisation' =>      $filtration_env['id_sous_projet_localisation']                      
        );
    }

    public function add_down($filtration_env, $id)  {
        $this->db->set($this->_set_down($filtration_env, $id))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function _set_down($filtration_env, $id)
    {
        return array(
            //'nature_sous_projet' => $filtration_env['nature_sous_projet'],
            'secretariat' => $filtration_env['secretariat'],
            //'intitule_sous_projet' => $filtration_env['intitule_sous_projet'],
            //'type_sous_projet' => $filtration_env['type_sous_projet'],
            //'localisation' => $filtration_env['localisation'],
            //'objectif_sous_projet' => $filtration_env['objectif_sous_projet'],
            //'activite_sous_projet' => $filtration_env['activite_sous_projet'],
            'cout_estime_sous_projet' => $filtration_env['cout_estime_sous_projet'],
            'envergure_sous_projet' => $filtration_env['envergure_sous_projet'],
            'ouvrage_prevu' => $filtration_env['ouvrage_prevu'],
            //'description_sous_projet' => $filtration_env['description_sous_projet'],
            'environnement_naturel' => $filtration_env['environnement_naturel'],
            'date_visa_rt_ibd' => $filtration_env['date_visa_rt_ibd'],
            'date_visa_res' => $filtration_env['date_visa_res'],
            'id_sous_projet_localisation' =>      $filtration_env['id_sous_projet_localisation'] 
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
    

    public function getfiltration_envbysousprojet_localisation($id_sous_projet_localisation)
    {
        $result =  $this->db->select("
        id as id,
        secretariat as secretariat,
        cout_estime_sous_projet as cout_estime_sous_projet,
        envergure_sous_projet as envergure_sous_projet,
        ouvrage_prevu as ouvrage_prevu,
        environnement_naturel as environnement_naturel,
        DATE_FORMAT(date_visa_rt_ibd, '%d/%m/%Y') as date_visa_rt_ibd,
        date_visa_res as date_visa_res,
        id_sous_projet_localisation as id_sous_projet_localisation")
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
