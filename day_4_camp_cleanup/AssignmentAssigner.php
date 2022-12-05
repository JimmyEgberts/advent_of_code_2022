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

function Get_Partially_Overlapping_Assignments($Assignment_Pairs_Array): string
{
    $Overlapping_Assignments = 0;

    foreach ($Assignment_Pairs_Array as $Assignment_Pairs) {
        $Assignments = explode(",", $Assignment_Pairs);
        $First_Assignment = explode("-", $Assignments[0]);
        $Second_Assignment = explode("-", $Assignments[1]);

        $First_Assignment_Range = range($First_Assignment[0], $First_Assignment[1]);
        $Second_Assignment_Range = range($Second_Assignment[0], $Second_Assignment[1]);

        foreach ($First_Assignment_Range as $First_Range_Number) {
            // Loop through each number in the second set
            foreach ($Second_Assignment_Range as $Second_Range_Number) {
                // If any number in the first set is equal to any number in the second set,
                // then the sets overlap
                if ($First_Range_Number == $Second_Range_Number) {
                    $Overlapping_Assignments += 1;
                    break 2;
                }
            }
        }
    }

    return $Overlapping_Assignments;
}

$Input = Read_Input("input.txt");
$Assignment_Pairs_Array = explode(PHP_EOL, $Input);
$Fully_Overlapping_Assignments = Get_Fully_Overlapping_Assignments($Assignment_Pairs_Array);

printf("The amount of fully overlapping assignments is: %d." . PHP_EOL, $Fully_Overlapping_Assignments);

// Part 2

$Partially_Overlapping_Assignments = Get_Partially_Overlapping_Assignments($Assignment_Pairs_Array);
printf("The amount of partially overlapping assignments is: %d." . PHP_EOL, $Partially_Overlapping_Assignments);
