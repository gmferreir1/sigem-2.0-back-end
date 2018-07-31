<?php

namespace App\Helpers\InterBase;


class Connection
{

    function __construct($database_file)
    {
        $this->connect($database_file);
    }

    private function connect($database_file)
    {
        $host = 'localhost:'.$database_file;
        $username='SYSDBA';
        $password='masterkey';
        $dbh = ibase_connect ( $host, $username, $password, 'UTF8') or die ("error in db connect");
    }

    public function query($sql)
    {
        $query = ibase_prepare($sql);

        $rs = ibase_execute($query);

        while ($row = ibase_fetch_assoc($rs, IBASE_TEXT)) {
            $arr[] = $row;
        }

        return $arr;
    }

}