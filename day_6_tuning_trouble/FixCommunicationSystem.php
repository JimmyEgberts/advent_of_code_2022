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

function Get_Marker($Datastream_String, $Marker_Size): mixed
{
    $Start_Of_Packet_Marker = "";
    if (strlen($Datastream_String) > $Marker_Size - 1) {
        $Start_Of_Packet_Marker = substr($Datastream_String, strlen($Datastream_String) - $Marker_Size);
        if (sizeof(array_unique(str_split($Start_Of_Packet_Marker))) == $Marker_Size) {
            return [$Start_Of_Packet_Marker, strlen($Datastream_String)];
        }
    }

    return false;
}

function Process_Datastream_Buffer($Simulated_Datastream_Buffer): array
{
    $Datastream_String = "";
    $Start_Of_Packet_Marker_Object = false;
    $Start_Of_Message_Marker_Object = false;

    foreach ($Simulated_Datastream_Buffer as $Character)
    {
        $Datastream_String .= $Character;

        if (!$Start_Of_Packet_Marker_Object) {
            $Start_Of_Packet_Marker_Object = Get_Marker($Datastream_String, 4);
        }

        if (!$Start_Of_Message_Marker_Object) {
            $Start_Of_Message_Marker_Object = Get_Marker($Datastream_String, 14);
        }
    }

    return [$Start_Of_Packet_Marker_Object, $Start_Of_Message_Marker_Object];
}

$Datastream_Input = Read_Input("input.txt");

$Simulated_Datastream_Buffer = Create_Simulated_Datastream_Buffer($Datastream_Input);
$Markers = Process_Datastream_Buffer($Simulated_Datastream_Buffer);

printf("The start-of-packet marker is located at position %d, and is the following four letters: \"%s\"." . PHP_EOL, $Markers[0][1], $Markers[0][0]);

// Part 2

printf("The start-of-message marker is located at position %d, and is the following four letters: \"%s\"." . PHP_EOL, $Markers[1][1], $Markers[1][0]);
