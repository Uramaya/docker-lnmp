<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestMailController.php extends Controller
{
    Mail::to('test@example.com')
    ->send(new TestMail());
}
