<?php

// Part one

function Read_Input(string $File_Path): string
{
    $File = fopen($File_Path, "r");
    $Input = fread($File, filesize($File_Path));
    fclose($File);
    return $Input;
}

function Create_Simulated_Datastream_Buffer($DataString): mixed
{
    foreach (str_split($DataString) as $Character)
    {
        yield $Character;
        // usleep(1000);
    }
}

function Get_Start_Of_Packet_Marker($Simulated_Datastream_Buffer): mixed
{
    $Data_Stream = "";
    $Start_Of_Packet_Marker = "";
    foreach ($Simulated_Datastream_Buffer as $Character)
    {
        $Data_Stream .= $Character;
    
        if (strlen($Data_Stream) > 3) {
            $Start_Of_Packet_Marker = substr($Data_Stream, strlen($Data_Stream) - 4);
            if (sizeof(array_unique(str_split($Start_Of_Packet_Marker))) == 4) {
                break;
            }
        }
    }
    return [$Start_Of_Packet_Marker, strlen($Data_Stream)];
}

$Datastream_Input = Read_Input("input.txt");
$Simulated_Datastream_Buffer = Create_Simulated_Datastream_Buffer($Datastream_Input);
$Start_Of_Packet_Marker_Object = Get_Start_Of_Packet_Marker($Simulated_Datastream_Buffer);

printf("The start-of-packet marker is located at position %d, and is the following four letters: %s.", $Start_Of_Packet_Marker_Object[1], $Start_Of_Packet_Marker_Object[0]);
