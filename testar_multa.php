<?php
// Sua função original
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

// Lógica para capturar o teste do formulário
$resultado = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vReal = floatval($_POST['vReal']);
    $vPerm = floatval($_POST['vPerm']);
    $zona = isset($_POST['zona']) ? true : false;
    $resultado = calculaMultaVeiculo($vReal, $vPerm, $zona);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Testar Cálculo de Multa</title>
    <link rel="stylesheet" href="style.css"> <style>
        .container-teste { max-width: 450px; margin: 50px auto; }
        .res { 
            margin-top: 20px; 
            padding: 15px; 
            border-radius: 8px; 
            background: #0b1220; 
            text-align: center;
            border: 1px solid var(--line);
        }
        .valor { font-size: 24px; font-weight: bold; color: #3b82f6; display: block; margin-top: 5px; }
        .erro { color: #ef4444; }
    </style>
</head>
<body>

<div class="wrap container-teste">
    <section class="card">
        <h3>🧪 Simulador de Teste</h3>
        <form method="POST">
            <div style="margin-bottom: 15px;">
                <label>Velocidade Real (km/h)</label>
                <input type="number" name="vReal" step="0.1" required placeholder="Ex: 100">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label>Velocidade Permitida (km/h)</label>
                <input type="number" name="vPerm" step="0.1" required placeholder="Ex: 60">
            </div>

            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                <input type="checkbox" name="zona" id="zona" style="width: 20px; margin: 0;">
                <label for="zona" style="margin: 0; cursor: pointer;">É Zona Escolar?</label>
            </div>

            <button type="submit" class="btn-add" style="background: #3b82f6; width: 100%; border: none; cursor: pointer;">
                Calcular Multa
            </button>
        </form>

        <?php if ($resultado !== ""): ?>
            <div class="res">
                <small class="muted">Resultado do Cálculo:</small>
                <span class="valor <?= ($resultado == 'erro') ? 'erro' : '' ?>">
                    <?= $resultado ?>
                </span>
            </div>
        <?php endif; ?>
    </section>
    
    <section class="card" style="margin-top: 20px; font-size: 12px;">
        <h4>Casos de Teste Padrão:</h4>
        <table style="width: 100%;">
            <tr><th>Entrada</th><th>Esperado</th></tr>
            <tr><td>60, 60, false</td><td>R$ 0,00</td></tr>
            <tr><td>70, 60, false</td><td>R$ 130,16</td></tr>
            <tr><td>100, 60, false</td><td>R$ 880,41</td></tr>
            <tr><td>70, 60, true</td><td>R$ 260,32</td></tr>
        </table>
    </section>
</div>

</body>
</html>