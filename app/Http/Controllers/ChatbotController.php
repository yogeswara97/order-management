<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function index(){
        $title = 'Chatbot';
        return view('chatbot.index', compact('title'));
    }
}
