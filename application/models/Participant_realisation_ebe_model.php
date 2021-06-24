<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Participant_realisation_ebe_model extends CI_Model {
    protected $table = 'participant_realisation_ebe';

    public function add($tutelle)  {
		// Ajout d'un enregitrement
        $this->db->set($this->_set($tutelle))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }
    public function update($id, $tutelle)  {
		// Mise à jour d'un enregitrement
        $this->db->set($this->_set($tutelle))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($tutelle) {
		// Affectation des valeurs
        return array(
            'id_menage' => $tutelle['id_menage'],
            'id_realisation_ebe' => $tutelle['id_realisation_ebe'],
            'date_presence' => $tutelle['date_presence']
        );
    }
    public function delete($id) {
		// Suppression d'un enregitrement
        $this->db->where('id', (int) $id)->delete($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }  
    }
    public function findAll() {
		// Selection de tous les enregitrements
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }
    
    public function get_participantByrealisationgroupe($id_realisation_ebe,$id_groupe_ml_pl) {
        $this->db->select("
                            menage.id as id_menage_prevu,
                            menage.nombre_enfant_moins_six_ans as nombre_enfant_moins_six_ans,
                            menage.identifiant_menage,
                            menage.nomchefmenage");
    
            $this->db ->select("(select participant_real.id 
                                 from participant_realisation_ebe as participant_real 
                                    where participant_real.id_realisation_ebe='".$id_realisation_ebe."' 
                                        and participant_real.id_menage=id_menage_prevu
                                ) as id",FALSE);
            $this->db ->select("(select participant_real.id_menage 
                                 from participant_realisation_ebe as participant_real 
                                    where participant_real.id_realisation_ebe='".$id_realisation_ebe."'
                                    and participant_real.id_menage=id_menage_prevu
                                ) as id_menage",FALSE);
            $this->db ->select("(select participant_real.date_presence 
                                 from participant_realisation_ebe as participant_real 
                                    where participant_real.id_realisation_ebe='".$id_realisation_ebe."'
                                    and participant_real.id_menage=id_menage_prevu
                                ) as date_presence",FALSE);
            $this->db ->select("(select participant_real.id_realisation_ebe 
                                 from participant_realisation_ebe as participant_real 
                                    where participant_real.id_realisation_ebe='".$id_realisation_ebe."'
                                    and participant_real.id_menage=id_menage_prevu
                                ) as id_realisation_ebe",FALSE);
                
    
        $result =  $this->db->from('menage')
                            ->join('liste_menage_ml_pl','liste_menage_ml_pl.menage_id=menage.id')
                            ->where('liste_menage_ml_pl.id_groupe_ml_pl',$id_groupe_ml_pl)
                            //->order_by('activite_realise_auparavant.id')
                            ->get()
                            ->result();
            if($result)
            {
                return $result;
            }else{
                return null;
            }                 
    }
    /*public function findById_realisation_ebe($id_realisation_ebe) {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_realisation_ebe",$id_realisation_ebe)
                        ->order_by('id')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }*/
    public function findById($id) {
		// Selection par id
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
}
?>