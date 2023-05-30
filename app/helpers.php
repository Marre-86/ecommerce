<?php

function processFiles($folderPath)
{

    $jsonDataArray = [];

    $files = scandir($folderPath);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') {
            continue;
        }

        $filePath = $folderPath . '/' . $file;
        if (is_file($filePath)) {
            $jsonContents = file_get_contents($filePath);
            $jsonData = json_decode($jsonContents, true);

            if ($jsonData) {
                $jsonDataArray[substr($file, 0, -5)] = json_encode($jsonData, JSON_PRETTY_PRINT);
            }
        }
    }

    return $jsonDataArray;
}
