<?php

// Part one

function Read_Input(string $File_Path): string
{
    $File = fopen($File_Path, "r");
    $Input = fread($File, filesize($File_Path));
    fclose($File);
    return $Input;
}

function Parse_Starting_Stacks($Starting_Stacks_Drawing_Array): array
{
    $Stacks = [];
    foreach ($Starting_Stacks_Drawing_Array as $Box_Line) {
        for ($Index = 1; $Index < count(str_split($Box_Line)); $Index += 4) {
            if (!ctype_space($Box_Line[$Index]) && !ctype_digit($Box_Line[$Index])) {
                $Stack_Index = ($Index - 1) / 4;
                $Stacks[$Stack_Index][] = $Box_Line[$Index];
            }
        }
    }

    return $Stacks;
}

function Execute_Rearrangement_Procedure($Starting_Stacks, $Rearrangement_Procedure_Array): array
{
    $New_Stacks = $Starting_Stacks;
    foreach ($Rearrangement_Procedure_Array as $Rearrangement_Procedure) {
        $Words = explode(' ', $Rearrangement_Procedure);
        $Number_Of_Boxes = $Words[1];
        $First_Stack_Index = $Words[3] - 1;
        $Second_Stack_Index = $Words[5] - 1;

        for ($Index = 0; $Index < $Number_Of_Boxes; $Index++) {
            $Box = array_shift($New_Stacks[$First_Stack_Index]);
            array_unshift($New_Stacks[$Second_Stack_Index], $Box);
        }
    }

    return $New_Stacks;
}

function Execute_Improved_Rearrangement_Procedure($Starting_Stacks, $Rearrangement_Procedure_Array): array
{
    $New_Stacks = $Starting_Stacks;
    foreach ($Rearrangement_Procedure_Array as $Rearrangement_Procedure) {
        $Words = explode(' ', $Rearrangement_Procedure);
        $Number_Of_Boxes = $Words[1];
        $First_Stack_Index = $Words[3] - 1;
        $Second_Stack_Index = $Words[5] - 1;

        $Boxes = array_splice($New_Stacks[$First_Stack_Index], 0, $Number_Of_Boxes);
        $Boxes = array_reverse($Boxes);
        foreach ($Boxes as $Box) {
            array_unshift($New_Stacks[$Second_Stack_Index], $Box);
        }
    }

    return $New_Stacks;
}
function Get_String_Of_Top_Boxes($Stacks): string
{
    $Box_String = "";
    for ($Index = 0; $Index < sizeof($Stacks); $Index++) {
        $Box_String .= array_shift($Stacks[$Index]);
    }

    return $Box_String;    
}

$Starting_Stacks_Drawing_Input = Read_Input("starting_stacks_drawing.txt");
$Starting_Stacks_Drawing_Array = explode(PHP_EOL, $Starting_Stacks_Drawing_Input);
$Starting_Stacks = Parse_Starting_Stacks($Starting_Stacks_Drawing_Array);

$Rearrangement_Procedure_Input = Read_Input("rearrangement_procedure.txt");
$Rearrangement_Procedure_Array = explode(PHP_EOL, $Rearrangement_Procedure_Input);
$New_Stacks = Execute_Rearrangement_Procedure($Starting_Stacks, $Rearrangement_Procedure_Array);

$Box_String = Get_String_Of_Top_Boxes($New_Stacks);

printf("The combined string of all the boxes at the top of each stack is: %s." . PHP_EOL, $Box_String);

// Part 2
Print_Current_Stack_State($Starting_Stacks);

$Improved_New_Stacks = Execute_Improved_Rearrangement_Procedure($Starting_Stacks, $Rearrangement_Procedure_Array);
$Improved_Box_String = Get_String_Of_Top_Boxes($Improved_New_Stacks);

printf("The combined string of all the boxes at the top of each stack after the improved rearrangement is: %s." . PHP_EOL, $Improved_Box_String);
