<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\MoodController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();



Route::post('/send-to-slack', function (Request $request) {
    Log::info('Requête Slack reçue', $request->all());

    $validated = $request->validate([
        'channel'     => 'required|string',
        'message'     => 'required|string|min:10',
        'user_email'  => 'nullable|email', // facultatif
    ]);

    $token = config('services.slack.bot_token');

    if (!$token) {
        Log::error('Token Slack manquant');
        return response()->json(['error' => 'Token Slack manquant'], 500);
    }

    $mention = '';

    // Si un email utilisateur est fourni → chercher le Slack ID
    if (!empty($validated['user_email'])) {
        $lookupResponse = Http::withToken($token)
            ->get('https://slack.com/api/users.lookupByEmail', [
                'email' => $validated['user_email']
            ]);

        $lookupData = $lookupResponse->json();
        dd($lookupResponse->successful() && $lookupData['ok'] && isset($lookupData['user']['id']));

        if ($lookupResponse->successful() && $lookupData['ok'] && isset($lookupData['user']['id'])) {

            $mention = "<@{$lookupData['user']['id']}>";
            dd($mention);
        } else {
            Log::warning("Slack user not found for email: {$validated['user_email']}", $lookupData);
            $mention = "@Utilisateur inconnu";
        }
    }

    // Insertion de la mention dans le message
    $message =   $validated['message'];
    // $message =   $validated['message']. "\n" .$mention;

    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token,
        'Content-Type'  => 'application/json; charset=utf-8'
    ])->post('https://slack.com/api/chat.postMessage', [
        'channel' => $validated['channel'],
        'text'    => $message,
        'mrkdwn'  => true
    ]);

    Log::info('Réponse Slack API', $response->json());

    if ($response->successful() && $response->json()['ok']) {
        return response()->json(['success' => 'Message envoyé à Slack']);
    }

    return response()->json([
        'error'          => 'Erreur Slack API',
        'slack_response' => $response->json()
    ], 400);
});

// Route::post('/send-to-slack', function (Request $request) {
//     Log::info('Requête Slack reçue', $request->all());

//     $validated = $request->validate([
//         'channel' => 'required|string',
//         'message' => 'required|string|min:10'
//     ]);

//     $token = config('services.slack.bot_token');

//     if (!$token) {
//         Log::error('Token Slack manquant');
//         return response()->json(['error' => 'Token Slack manquant'], 500);
//     }

//     $response = Http::withHeaders([
//         'Authorization' => 'Bearer ' . $token,
//         'Content-Type'  => 'application/json; charset=utf-8'
//     ])->post('https://slack.com/api/chat.postMessage', [
//         'channel' => $validated['channel'],
//         'text'    => $validated['message'],
//         'mrkdwn'  => true
//     ]);

//     Log::info('Réponse Slack API', $response->json());

//     if ($response->successful() && $response->json()['ok']) {
//         return response()->json(['success' => 'Message envoyé à Slack']);
//     }

//     return response()->json([
//         'error'           => 'Erreur Slack API',
//         'slack_response'  => $response->json()
//     ], 400);
// });

Route::post('/save-mood', [MoodController::class, 'store'])->name('mood.store');


Route::get('/', 'HomeController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/page/{namepage}', 'HomeController@namepage');
Route::get('/pages/{namepage}/{prefixepermission?}', 'HomeController@namepage');

Route::post('login', 'Auth\LoginController@authenticate')->name('login.post');
Route::post('password/email', 'Auth\ForgotPasswordController@sendPasswordResetToken')->name('password.email.post');
Route::get('reset-password/{token}', 'Auth\ForgotPasswordController@showPasswordResetForm');

// Route::post('login', 'AuthController@login')->name('back.login');
// Route::post('auth/password-update', 'AuthController@setPassword')->name('back.password.update');
// Route::post('auth/password-reset', 'AuthController@resetPassword')->name('back.password.reset');
// Route::get('auth/activate-account/{token}', 'AuthController@activate')->name('back.activate.user');


// Route::post('/newsletter/save','NewsLetterController@save');
Route::post('/contactsiteweb/save','ContactController@save');
Route::post('/tache-assigne/save','TacheAssigneController@save');
Route::post('/tache/save','TacheController@save');


Route::get('/generate-pdf-etatcaisse-hebdomadaire/{filter}', 'PdfExcelController@generate_pdf_etatcloturehebdomadairecaisse');
Route::get('/generate-excel-etatcaisse-hebdomadaire/{filter}', 'PdfExcelController@generate_excel_etatcloturehebdomadairecaisse');
Route::get('/generate-ticket-depense-pdf/{filter}', 'PdfExcelController@generate_ticket_depense');

// Etat Route
Route::get('/etat-{queryname}-{type}', 'PdfExcelController@generateEtatQueryName');

// Exports Route
Route::get('/generate-{queryname}-{type}', 'PdfExcelController@generateListQueryName');
Route::get('/generate-{queryname}-{type}/{id}', 'PdfExcelController@generateListQueryName');

// Tests
// Route::get('test_geolocalisation', 'TestController@test_geolocalisation');
// Route::get('test_ticket', 'TestController@test_ticket');
// Route::get('/test_query', 'TestController@test_query');
// Route::get('/tesCommande', 'TestController@tesCommande');

// route translate
Route::get('lang/{locale}', function ($locale)
{
    session()->put('locale', $locale);
    return redirect()->back();
});

// Notification
Route::post('/notifpermuser/deleteallview', 'NotifPermUserController@deleteallview');

// Save, Import, Statut, Delete Routes
Route::post('/{table_name}', 'ViewController@redirectToController');
Route::post('/{table_name}/{methode?}', 'ViewController@redirectToController');
Route::post('/{table_name}/{methode?}/{id?}', 'ViewController@redirectToController');
Route::get('/{table_name}.{methode?}/{id?}', 'ViewController@redirectToController');

