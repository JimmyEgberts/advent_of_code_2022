<?php

// Part one

function Read_Input(string $File_Path): string
{
    $File = fopen($File_Path, "r");
    $Input = fread($File, filesize($File_Path));
    fclose($File);
    return $Input;
}

function Create_Simulated_Data_Buffer($DataString) {
    foreach (str_split($DataString) as $Character) {
        yield $Character;
        usleep(10000);
    }
}

$Data_Stream_Input = Read_Input("input.txt");
$Simulated_Data_Stream_Buffer = Create_Simulated_Data_Buffer($Data_Stream_Input);

foreach ($Simulated_Data_Stream_Buffer as $Character) {
    echo $Character;
}
