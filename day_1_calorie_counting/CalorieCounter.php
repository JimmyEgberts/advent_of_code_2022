<?php

// Part one

function Read_Input(string $File_Path): string
{
    $File = fopen($File_Path, "r");
    $Input = fread($File, filesize($File_Path));
    fclose($File);
    return $Input;
}

function Get_Calorie_Groups($Calorie_Array): array
{
    $Calorie_Groups = [];
    $Current_Calories = 0;
    for ($i = 0; $i < sizeof($Calorie_Array); $i++) {
        if ($Calorie_Array[$i] == null) {
            $Calorie_Groups[] = $Current_Calories;
            $Current_Calories = 0;
        } else {
            $Current_Calories += $Calorie_Array[$i];
        }
    }
    return $Calorie_Groups;
}

$Input = Read_Input("input.txt");
$Calorie_Array = explode(PHP_EOL, $Input);
$Calorie_Groups = Get_Calorie_Groups($Calorie_Array);
