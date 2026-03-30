<?php

function calculaMultaVeiculo($velocidadeReal, $velocidadePermitida, $ehZonaEscolar) {
   
    if ($velocidadeReal <= 0 || $velocidadePermitida <= 0) return "erro";
    if ($velocidadePermitida < 20 || $velocidadePermitida > 120) return "erro";
    if ($velocidadeReal > 300) return "erro";

 
    if ($velocidadeReal <= $velocidadePermitida) {
        return "R$ 0,00";
    }


    $excessoPercentual = (($velocidadeReal - $velocidadePermitida) / $velocidadePermitida) * 100;
    $valorMulta = 0;

   
    if ($excessoPercentual <= 20) {
        $valorMulta = 130.16;
    } elseif ($excessoPercentual > 20 && $excessoPercentual <= 50) {
        $valorMulta = 195.23;
    } else {
        $valorMulta = 880.41;
    }

    
    if ($ehZonaEscolar === true) {
        $valorMulta *= 2;
    }


    return "R$ " . number_format($valorMulta, 2, ',', '.');
}


echo calculaMultaVeiculo(60, 60, false);  
echo calculaMultaVeiculo(70, 60, false);  
echo calculaMultaVeiculo(100, 60, false);  
echo calculaMultaVeiculo(70, 60, true);   
echo calculaMultaVeiculo(-10, 60, false); 

?>
