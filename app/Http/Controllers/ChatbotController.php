<?php

namespace App\Http\Controllers;

use App\Models\Chatbot;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    protected $lang = 'en';
    public function index(){
        $title = 'Chatbot';
        $chatbot = Chatbot::where('lang', $this->lang)->firstOrFail();

        return view('chatbot.index', compact('title', 'chatbot'));
    }

    public function update(Request $request){
        $chatbot = Chatbot::where('lang', $this->lang)->firstOrFail();
        $data = $request->validate([
            'prompt_template' => "required|string"
        ]);
        $chatbot->update($data);

        return redirect()->route('chatbot.index')->with('success', 'Prompt Template updated successfully.');
    }
}
