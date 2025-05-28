<?php
//fetch values 
function FETCH($SQL = null, $data = "", $die = false)
{
    if ($SQL != null) {
        if ($die === true) {
            SQL($SQL, true); // this will die() the SQL query
        } else {
            $Query = SQL($SQL); // custom SQL function using PDO
            if ($Query && $Query->rowCount() > 0) {
                $FetchDATA = $Query->fetch(PDO::FETCH_ASSOC);
                $ReturnData = $FetchDATA[$data] ?? null;
                $results = htmlentities(trim($ReturnData));
                return $results ?: null;
            } else {
                return null;
            }
        }
    }

    return null;
}



//fetch all in array / json format (object-based)
function SET_SQL($sql = null, $array = false)
{
    if ($sql != null) {
        $Data = SQL($sql);       // Assuming SQL() returns PDOStatement
        $Count = CHECK($sql);    // Uses PDO-based CHECK()

        if ($Count == 0) {
            return null;
        } else {
            $FetchedColumns = [];

            while ($row = $Data->fetch(PDO::FETCH_OBJ)) {
                $FetchedColumns[] = $row;
            }

            // Return object format (for foreach as $Users usage)
            if ($array === true) {
                return $FetchedColumns; // Already an array of objects
            } else {
                return json_encode($FetchedColumns); // JSON string if needed
            }
        }
    }

    return null;
}


//filter records selects
function FILTER_RECORD_WITH_PARAMETERS($Parameters = [])
{
    if (!empty($Parameters)) {
        $ReturnValues = "";
        foreach ($Parameters as $key => $value) {
            if ($value == null) {
                $ReturnValues .= "";
            } else {
                $ReturnValues .= "$key='$value' and ";
            }
        }

        return $ReturnValues;
    } else {
        return null;
    }
}
