<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mdp_model extends CI_Model {
    protected $table = 'mdp';

    public function add($mdp)  {
        $this->db->set($this->_set($mdp))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $mdp)  {
        $this->db->set($this->_set($mdp))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($mdp) 
    {
        return array
        (
            'type'                                      => $mdp['type'],
            'intitule_micro_projet'                     => $mdp['intitule_micro_projet'],
            'numero_vague_zip'                          => $mdp['numero_vague_zip'],
            'cout_total_sous_projet'                    => $mdp['cout_total_sous_projet'],
            'cout_total_agr'                            => $mdp['cout_total_agr'],
            'renumeration_enex'                         => $mdp['renumeration_enex'],
            'date_approbation_ser_deg'                  => $mdp['date_approbation_ser_deg'],
            'objectif_micro_projet'                     => $mdp['objectif_micro_projet'],
            'description_sous_projet'                   => $mdp['description_sous_projet'],
            'context_justification'                     => $mdp['context_justification'],
            'mdp_cout_investissement_agr'               => $mdp['mdp_cout_investissement_agr'],
            'mdp_cout_investissement_agr_formation'     => $mdp['mdp_cout_investissement_agr_formation']
        );
    }


    public function delete($id) {
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }  
    }
   
    public function findById($id) {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id", $id)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    public function findAll($type)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("type", $type)
                        ->order_by('intitule_micro_projet', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
}
?>