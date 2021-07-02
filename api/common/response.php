<?php
class Response
{
    public function error($message, $code = 500)
    {
        $this
            ->status($code)
            ->send(["error" => $message]);
    }

    public function status($code)
    {
        http_response_code($code);
        return $this;
    }

    public function send($data = null)
    {
        if (!$data) {
            return $this;
        }

        echo json_encode($data);
        return $this;
    }
}
