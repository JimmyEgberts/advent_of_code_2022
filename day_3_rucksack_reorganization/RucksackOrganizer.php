<?php

// Part one

function Read_Input(string $File_Path): string
{
    $File = fopen($File_Path, "r");
    $Input = fread($File, filesize($File_Path));
    fclose($File);
    return $Input;
}

function Seperate_Rucksack_Compartments($Rucksack_Array): array
{
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

function Find_Double_Item_Type($Compartments_Array): string
{

    $First_Compartment_Array = str_split($Compartments_Array[0]);
    foreach ($First_Compartment_Array as $Item_Type)
    {
        $Item_Type_Is_Double = str_contains($Compartments_Array[1], $Item_Type);
        if ($Item_Type_Is_Double) {
            return $Item_Type;
        }
    }
    return "";
}

function Find_Double_Item_Types($Group_Array): string
{
    $Possible_Badge_Array = [];
    $Splitted_Group = [];
    foreach ($Group_Array as $Group)
    {
        $Group_String = count_chars($Group, 3);
        if (sizeof($Splitted_Group) === 0)
        {
            $Splitted_Group = str_split($Group_String);
            foreach ($Splitted_Group as $Item_Type)
            {
                $Possible_Badge_Array[$Item_Type] = 1;
            }
        }
        else
        {
            foreach ($Splitted_Group as $Item_Type)
            {
                $Item_Type_Is_Double = str_contains($Group_String, $Item_Type);
                if ($Item_Type_Is_Double)
                {
                    $Possible_Badge_Array[$Item_Type] += 1;
                }
            }
        }
    }

    foreach ($Possible_Badge_Array as $Item_Type => $Count) {
        if ($Count == sizeof($Group_Array)) {
            return $Item_Type;
        }
    }

    return "";
}


function Get_Priority_Value($Item_Type): int
{
    $Priority_List = array_merge(range('a', 'z'), range('A', 'Z'));
    $Priority = array_search($Item_Type, $Priority_List) + 1;
    return $Priority;
}

$Double_Item_Priority_Score = 0;

$Input = Read_Input("input.txt");
$Rucksack_Array = explode(PHP_EOL, $Input);
$Rucksack_Compartments_Array = Seperate_Rucksack_Compartments($Rucksack_Array);
foreach ($Rucksack_Compartments_Array as $Compartments_Array)
{
    $Double_Item_Type = Find_Double_Item_Types($Compartments_Array);
    if ($Double_Item_Type) {
        $Double_Item_Priority_Score += Get_Priority_Value($Double_Item_Type);
    }
}

printf("The sum of priorities of the item types that appear in both compartments of each rucksack is: %d." . PHP_EOL, $Double_Item_Priority_Score);

// Part two

$Badge_Priority_Score = 0;

$Groups = array_chunk($Rucksack_Array, 3);
foreach ($Groups as $Group)
{
    $Badge_Item_Type = Find_Double_Item_Types($Group);
    $Badge_Priority_Score += Get_Priority_Value($Badge_Item_Type);
}

printf("The sum of priorities of all badge items is: %d." . PHP_EOL, $Badge_Priority_Score);
