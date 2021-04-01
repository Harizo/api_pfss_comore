<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Requete_import_model extends CI_Model {
    protected $table = 'contrat_consultant_ong';

    public function Execution_requete($requete) {
		// Selection de tous les enregitrements
 		$query= $this->db->query($requete);		
			return "OK";
   }
    public function Requete_insertion($requete) {
		// Selection de tous les enregitrements
 		$query= $this->db->query($requete);		
			return $this->db->insert_id();
   }
    public function Requete_datefin_date_paiement($requete) {
		// Selection de tous les enregitrements
 		$query= $this->db->query($requete);		
			return $this->db->insert_id();
   }
}
?>