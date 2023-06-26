<?php

class MotorcycleView {
    public function listMotos($motos) {
        echo "<h1>Liste des Motos</h1>";

        foreach ($motos as $moto) {
            echo "<p>{$moto->getModele()} ({$moto->getType()})</p>";
        }
    }

    public function viewMoto($moto) {
        echo "<h1>Détails de la Moto</h1>";

        echo "<p>Modèle : {$moto->getModele()}</p>";
        echo "<p>Type : {$moto->getType()}</p>";

    }


}
