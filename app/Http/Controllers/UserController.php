<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;


class UserController extends Controller{
    public function register(Request $request)
    {
        // Validácia vstupných údajov
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:100|unique:users,email',
            'phone_number' => 'required|string|max:15',
            'country' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Vytvorenie používateľa
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'country' => $request->country,
            'password' => Hash::make($request->password),
        ]);

        // Prihlasenie používateľa po registrácii, laravelovska autentifikacia
        Auth::login($user);

        // Presmerovanie na domovsku stránku
        return redirect()->route('homepage');
    }


    public function login(Request $request){
        // Validacia prihlasovacich údajov
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator, 'login')
                ->withInput();
        }

        //kontrola, aby sa mohol cez tento login prihlasit len bezny user
        $user = User::where('email', $request->email)->first();
        if ($user && $user->is_admin) {
            return redirect()->route('login')
                ->withErrors(['email' => 'Cannot log in through this form.'], 'login')
                ->withInput();
        }
    
        // Pokus o prihlasenie bezneho usera
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended($request->input('redirect', route('homepage')));
        } else {
            return redirect()->route('login')
                ->withErrors(['email' => 'Invalid email or password'], 'login')
                ->withInput();
        }
    }

    public function profile(){ //ked si chces zobrazit tvoj profil, zobrazi ti tvoje objednavky z databazy
        $user = Auth::user(); 
        $orders = $user->orders()->with('items')->get();
        return view('profile', compact('user', 'orders'));
    }

    public function logout(Request $request){ //pri tlacidle logout
        Auth::logout();
        $request->session()->invalidate(); //vymaze vsetky relacie zo session
        $request->session()->regenerateToken(); //regeneruje csrf token
        return redirect()->route('homepage');
    }
}