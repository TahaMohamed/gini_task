<?php

namespace Task\Bank;

/**
 * Deal with CSV File
 */
class CSVFile
{
    public static function readFile($csv_file)
    {
        //1 - Check File
        if (!is_readable($csv_file)) {
            return "Cant Read File";
        }
    }

    public static function autorun()
    {
        return "U Use PSR-4";
    }


}
