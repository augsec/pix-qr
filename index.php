<?php
require_once 'PIX.php';
include 'phpqrcode/qrlib.php';

use App\PIX;


// PEGA OS DADOS DO PIX NO ARQUIVO data.json
// FIQUE A VONTADE PARA ALTERAR CONFORME A SUA NECESSIDADE
$jsonData = file_get_contents('data.json');
$data = json_decode($jsonData, true);

$pix = new PIX(
    $data['chavePix'],
    $data['nome'],
    $data['cidade'],
    $data['cep'],
    $data['descricao'],
    $data['valor']
);

// GERA O PAYLOAD DO PIX
$payload = $pix->payload();

$tempDir = 'temp/';
$qrCodeFileName = 'qrcode.png';
$qrCodePath = $tempDir . $qrCodeFileName;

if (!file_exists($tempDir)) {
    mkdir($tempDir, 0755, true);
}

// GERA O QR CODE
QRcode::png($payload, $qrCodePath, QR_ECLEVEL_L, 4);

// EXIBIÇÃO DO QRCODE NA PÁGINA
echo '<img src="' . $qrCodePath . '" alt="QR Code PIX" /><br>';

// EXIBIÇÃO DO PAYLOAD/CHAVE COPIA E COLA NA PÁGINA
echo $payload;
