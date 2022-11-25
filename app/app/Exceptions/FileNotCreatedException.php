<?php


namespace App\Exceptions;

use Exception;

class FileNotCreatedException extends Exception
{
    public function render()
    {
        return response()->json('Произошла ошибка при создании файла',  400);
    }
}
