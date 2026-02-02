<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; // Import the Request class


class MoodController extends EntityTypeController

{
    public function store(Request $request)
    {
        
    
        auth()->user()->moods()->create([
            'designation' => $request->mood, 
        ]);
    
        return redirect('/');
    }
    

}
