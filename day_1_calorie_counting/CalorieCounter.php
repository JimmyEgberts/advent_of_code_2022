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

function Get_Ordinal_Suffix($Number): string
{
    $Ordinal_Suffixes = array("th", "st", "nd", "rd", "th", "th", "th", "th", "th", "th");
    $Elf_Number_Suffix = ($Number % 100) >= 11 && ($Number % 100) <= 13 ? "th" : $Ordinal_Suffixes[$Number % 10];
    return $Elf_Number_Suffix;
}

$Input = Read_Input("input.txt");
$Calorie_Array = explode(PHP_EOL, $Input);
$Calorie_Groups = Get_Calorie_Groups($Calorie_Array);

$Highest_Number_Of_Calories = max($Calorie_Groups);
$Elf_Number = array_search($Highest_Number_Of_Calories, $Calorie_Groups) + 1;
$Elf_Number_Suffix = Get_Ordinal_Suffix($Elf_Number);

printf("The elf carrying the most calories is the %s elf. They are carrying %d calories." . PHP_EOL, $Elf_Number . $Elf_Number_Suffix, $Highest_Number_Of_Calories);

// Part two

rsort($Calorie_Groups);

$Calory_Group_Size = sizeof($Calorie_Groups);
$Second_Highest_Number_Of_Calories = $Calorie_Groups[1];
$Third_Highest_Number_Of_Calories = $Calorie_Groups[2];
$Top_Three_Highest_Number_Of_Calories_Combined = $Highest_Number_Of_Calories + $Second_Highest_Number_Of_Calories + $Third_Highest_Number_Of_Calories;

printf("The top three elves are carrying %d, %d and %d calories respectively. Combined, this makes a total of %d calories." . PHP_EOL, $Highest_Number_Of_Calories, $Second_Highest_Number_Of_Calories, $Third_Highest_Number_Of_Calories, $Top_Three_Highest_Number_Of_Calories_Combined);
