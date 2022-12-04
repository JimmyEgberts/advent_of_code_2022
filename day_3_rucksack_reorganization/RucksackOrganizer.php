<?php

// Part one

function Read_Input(string $File_Path): string
{
    $File = fopen($File_Path, "r");
    $Input = fread($File, filesize($File_Path));
    fclose($File);
    return $Input;
}

function Create_Rucksack_Array($Input): array
{
    $Rucksack_Array = explode(PHP_EOL, $Input);
    $Rucksack_Compartments_Array = [];
    foreach ($Rucksack_Array as $Rucksack)
    {
        $Compartment_Size = strlen($Rucksack) / 2;
        $First_Compartment = substr($Rucksack, 0, $Compartment_Size);
        $Second_Compartment = substr($Rucksack, $Compartment_Size, $Compartment_Size);
        
        $Rucksack_Compartments_Array[] = [$First_Compartment, $Second_Compartment];
    }
    return $Rucksack_Compartments_Array;
}

function Find_Double_Item_Key($Compartments_Array): string
{

    $First_Compartment_Array = str_split($Compartments_Array[0]);
    foreach ($First_Compartment_Array as $Item_Key)
    {
        $Item_Key_Is_Double = str_contains($Compartments_Array[1], $Item_Key);
        if ($Item_Key_Is_Double) {
            return $Item_Key;
        }
    }
    return "";
}

function Get_Priority_Value($Item_Key): int
{
    $Priority_List = array_merge(range('a', 'z'), range('A', 'Z'));
    $Priority = array_search($Item_Key, $Priority_List) + 1;
    return $Priority;
}

$Priority_Score = 0;

$Input = Read_Input("input.txt");
$Rucksack_Compartments_Array = Create_Rucksack_Array($Input);
foreach ($Rucksack_Compartments_Array as $Compartments_Array)
{
    $Double_Item_Key = Find_Double_Item_Key($Compartments_Array);
    if ($Double_Item_Key) {
        $Priority_Score += Get_Priority_Value($Double_Item_Key);
    }
}

printf("The sum of priorities of the item types that appear in both compartments of each rucksack is: %d." . PHP_EOL, $Priority_Score);

