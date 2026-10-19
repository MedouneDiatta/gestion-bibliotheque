<?php 
  declare(strict_types=1);

  namespace App\Entity;

 //la class qui permet de reprenter une reservation de document effectué par memgre et implement jsonserializable pour une conversin porpore en json   
  final class Reservation implements \JsonSerializable
  {
    public function __construct
    (
        public readonly ?int $id,
        public readonly int $documentId,
        public readonly int $membreId,
        public readonly \DateTimeImmutable $dateDemande,
        private string $statut
    ){}

    // unej methode qui retourne le statut actuel de la rersevation
    public function getStatut():string 
    {
        return $this->statut;
    }

    // celle ci permet de modifier le statut de la reservation 
    public function setStatut(string $statut):void 
    {
        $this->statut=$statut;
    }

    // celle ci permet de serialiser l'obet en tableau pour un usage json
    public function jsonSerialize():array 
    {
        return 
        [
            'id' => $this->id,
            'document_id' => $this->documentId,
            'membre_id' => $this->membreId,
            'date_demande' => $this->dateDemande->format('Y-m-d H:i:s'),
            'statut' => $this->statut,
        ];
    }
  }
?>