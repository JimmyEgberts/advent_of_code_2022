<?php

// Part one

function Read_Input(string $File_Path): string
{
    $File = fopen($File_Path, "r");
    $Input = fread($File, filesize($File_Path));
    fclose($File);
    return $Input;
}

function Get_Matrix_Coordinate($Character): int
{
    return match ($Character) {
        "X", "A" => 0,
        "Y", "B" => 1,
        "Z", "C" => 2,
    };
}

function Get_Score_Of_Strategy_Guide($Strategy_Guide_Array): int
{
    $Strategy_Score_Matrix =
    [
        [3, 6, 0],
        [0, 3, 6],
        [6, 0, 3]
    ];

    $Score = 0;
    foreach ($Strategy_Guide_Array as $Strategy) {
        $Shape    = substr($Strategy, 0, 1);
        $Response = substr($Strategy, 2, 3);

        $X = Get_Matrix_Coordinate($Shape);
        $Y = Get_Matrix_Coordinate($Response);
    
        $Score += $Strategy_Score_Matrix[$X][$Y];
        $Score += match ($Response) {
            "X", => 1,
            "Y", => 2,
            "Z", => 3,
        };
    }
    return $Score;
}

$Input = Read_Input("input.txt");
$Strategy_Guide_Array = explode(PHP_EOL, $Input);
$Strategy_Guide_Score = Get_Score_Of_Strategy_Guide($Strategy_Guide_Array);

printf("The final score after following the strategy guide and playing %d matches of rock papers, scissors is: %d." . PHP_EOL, sizeof($Strategy_Guide_Array), $Strategy_Guide_Score);