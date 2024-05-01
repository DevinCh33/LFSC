<?php

class DuplicateCheck {
    private $Array = array();

    function Add($id)
    {
        if ($id != null)
        {
            $this->Array[count($this->Array)] = $id;
        }
    }

    function List()
    {
        $string = "(";

        foreach ($this->Array as $id)
        {
            $string = $string.$id.",";
        }

        $string[strlen($string) - 1] = ")";

        return $string;
    }
}
