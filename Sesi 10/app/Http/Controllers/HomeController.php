<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Users data for table view
        $users = [
            ['name' => 'John Doe', 'age' => 30, 'address' => '123 Main St'],
            ['name' => 'Jane Smith', 'age' => 25, 'address' => '456 Oak Ave'],
            ['name' => 'Alice Johnson', 'age' => 35, 'address' => '789 Pine Rd'],
            ['name' => 'Bob Brown', 'age' => 40, 'address' => '321 Elm St'],
        ];
        if (empty($users)) {
            $users = ['No users found.'];
        }
        return view('home.index', compact('users'));
    }

    public function index2()
    {
        return view('home.index2');
    }
}
