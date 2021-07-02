<?php
class Request
{
    public function getBodyParams($fields)
    {
        $result = [];
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $result[$field] = $_POST[$field];
            } else {
                throw new Exception("Missing field '$field'");
            }
        }

        return $result;
    }
}
