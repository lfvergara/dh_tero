<?php


interface Peticionable {
    public function enviarPost();
    public function enviarGet();
    public function enviarDelete();
    public function enviarPut();
    const POST = 0;
    const GET = 1;
    const DELETE = 2;
    const PUT = 3;
}

?>