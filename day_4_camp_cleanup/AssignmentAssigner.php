<?php

// Part one

function Read_Input(string $File_Path): string
{
    $File = fopen($File_Path, "r");
    $Input = fread($File, filesize($File_Path));
    fclose($File);
    return $Input;
}

function Get_Fully_Overlapping_Assignments($Assignment_Pairs_Array): string
{
    $Fully_Overlapping_Assignments = 0;

    foreach ($Assignment_Pairs_Array as $Assignment_Pairs) {
        $Assignments = explode(",", $Assignment_Pairs);
        $First_Assignment = explode("-", $Assignments[0]);
        $Second_Assignment = explode("-", $Assignments[1]);
    
        if ($First_Assignment[0] >= $Second_Assignment[0] && $First_Assignment[1] <= $Second_Assignment[1] ||
            $Second_Assignment[0] >= $First_Assignment[0] && $Second_Assignment[1] <= $First_Assignment[1])
        {
            $Fully_Overlapping_Assignments++;
        }
    }

    return $Fully_Overlapping_Assignments;
}

$Input = Read_Input("input.txt");
$Assignment_Pairs_Array = explode(PHP_EOL, $Input);
$Fully_Overlapping_Assignments = Get_Fully_Overlapping_Assignments($Assignment_Pairs_Array);

printf("The amount of fully overlapping assignments is: %d." . PHP_EOL, $Fully_Overlapping_Assignments);
