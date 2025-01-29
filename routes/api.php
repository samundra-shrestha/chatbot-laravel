<?php

use App\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/api/interactions', function (Request $request) {
    $validated = $request->validate([
        'unique_key' => 'required|exists:widgets,unique_key',
        'question' => 'required|string',
        'answer' => 'required|string',
    ]);

    $widget = Widget::where('unique_key', $validated['unique_key'])->firstOrFail();

    $interaction = $widget->interactions()->create([
        'question' => $validated['question'],
        'answer' => $validated['answer'],
    ]);

    return response()->json(['message' => 'Interaction stored successfully', 'interaction' => $interaction], 201);
});
