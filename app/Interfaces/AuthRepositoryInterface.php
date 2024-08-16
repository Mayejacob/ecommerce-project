<?php

namespace App\Interfaces;

interface AuthRepositoryInterface
{
    public function signIn($request);
    public function signUp($request);
}
