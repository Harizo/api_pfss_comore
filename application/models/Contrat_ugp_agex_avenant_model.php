<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contrat_ugp_agex_avenant_model extends CI_Model {
    protected $table = 'contrat_ugp_agex_avenant';

    public function add($contrat_ugp_agex_avenant)  {
        $this->db->set($this->_set($contrat_ugp_agex_avenant))
                            ->insert($this->table);
        if($this->db->affected_rows() === 1)  {
            return $this->db->insert_id();
        }else{
            return null;
        }                    
    }

    public function update($id, $contrat_ugp_agex_avenant)  {
        $this->db->set($this->_set($contrat_ugp_agex_avenant))
                            ->where('id', (int) $id)
                            ->update($this->table);
        if($this->db->affected_rows() === 1)  {
            return true;
        }else{
            return null;
        }                      
    }
    public function _set($contrat_ugp_agex_avenant) 
    {
        return array
        (
            
            'id_contrat_ugp_agex'                   => $contrat_ugp_agex_avenant['id_contrat_ugp_agex'],
           
            'objet_contrat'             => $contrat_ugp_agex_avenant['objet_contrat'],
            'montant_contrat'           => $contrat_ugp_agex_avenant['montant_contrat'],
            'date_signature'            => $contrat_ugp_agex_avenant['date_signature'],
            'date_prevu_fin_contrat'    => $contrat_ugp_agex_avenant['date_prevu_fin_contrat'],
            'status_contrat'            => $contrat_ugp_agex_avenant['status_contrat'],
            'note_resiliation'          => $contrat_ugp_agex_avenant['note_resiliation'],
            'type'           => $contrat_ugp_agex_avenant['type']
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
    public function findBy_contrat_ugp_agex($id_contrat_ugp_agex)  {
        $result =  $this->db->select('*')
                        ->from($this->table)
                        ->where("id_contrat_ugp_agex", $id_contrat_ugp_agex)
                        ->order_by('id', 'asc')
                        ->get()
                        ->result();
        if($result) {
            return $result;
        }else{
            return null;
        }                 
    }

    public function get_contrat_en_retard()
    {


        $now_date = date("Y-m-d") ;

       // $array = array('date_prevu_fin_contrat >=' => $now_date, 'date_prevu_fin_contrat <=' => $now_date);

        $sql = 
        "
            select 
                
                cua.numero_contrat,
                cua.date_prevu_fin_contrat
            FROM 
                contrat_ugp_agex_avenant as cua
            WHERE 
                cua.date_prevu_fin_contrat < '".$now_date."'
                and cua.status_contrat = 'En cours'
                
        ";
        return $this->db->query($sql)->result(); 
    }
}
?>