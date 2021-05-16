<?php


class Csv
{
   public function array2csv($array, &$title, &$data) {
        foreach($array as $key => $value) {
            if(is_array($value)) {
                $title .= $key . ",";
                $data .= "" . ",";
                $this->array2csv($value, $title, $data);
            } else {
                $title .= $key . ",";
                $data .= '"' . $value . '",';
            }
        }
    }
}