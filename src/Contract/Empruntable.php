<?php 
  declare(strict_types=1);

  namespace App\Contract;

  interface Empruntable
  {
    public function estDisponible():bool;
    public function retirerExemplaire():void;
    public function ajouterExemplaire():void;
    public function calculerDateRetour(\DateTimeImmutable $debut):\DateTimeImmutable;
    public function getDureeEmpruntJours():int;
    public function getTarifPenaliteJour():int;
    public function getType():string;
  }
?>