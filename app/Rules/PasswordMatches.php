<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PasswordMatches implements Rule
{
    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function passes($attribute, $value)
    {
        $user = User::where('email', $this->email)->first();
        return $user && Hash::check($value, $user->password);
    }

    public function message()
    {
        return 'Invalid password.';
    }
}
