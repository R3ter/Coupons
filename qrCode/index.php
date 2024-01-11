<?php

require_once __DIR__ . './../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\LabelAlignment;
use Endroid\QrCode\Label\Font\NotoSans;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

function convertToQr($id)
{


    $result = Builder::create()
        ->writer(new PngWriter())
        ->writerOptions([]) // Add any writer-specific options here
        ->data($_SERVER['SERVER_NAME'] . "/" . $id)
        ->encoding(new Encoding('UTF-8'))
        ->size(300)
        ->margin(10)
        ->logoPath(__DIR__ . './../logo.png')
        ->logoResizeToWidth(100)
        ->logoPunchoutBackground(true)
        ->labelText('This is the label')
        ->labelFont(new NotoSans(20))
        ->validateResult(false)
        ->build();
    header('Content-Type: ' . $result->getMimeType());
    echo $result->getString();
}
convertToQr($_GET["id"]);
?>