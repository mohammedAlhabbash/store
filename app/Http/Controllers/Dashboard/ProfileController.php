<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Symfony\Component\Intl\Locales;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use Symfony\Component\Intl\Languages;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        $countries = Countries::getNames();
        $locales = Languages::getNames();
        // dd($countries);
        return view('Dashboard.profile.edit', compact('user', 'countries', 'locales'));
    }
    public function update(Request $request)
    {
        // dd($request);
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'birthday' => ['nullable', 'date', 'before:today'],
            'gender' => ['in:male,female'],
            'country' => ['required', 'string', 'size:2']
        ]);
        $user = $request->user();
        // dd($user);
        // Profile::where('user_id',$user->id)->first();
        //بامكاننا انو نعدل على الكود الي تحت و نخليه بسطر واحد فقط من خلال ميثود fill()
        // $profile = $user->profile;
        // if ($profile->first_name) {
        //     $user->profile->update($request->all());
        // }else{
        //     $user->profile()->create($request->all());
        // }
        $user->profile->fill($request->all())->save();
        // ميثود بتعمل انو اذا يعني بتخزن البيانات في المودل بعدين بتعمل سايف من خلال ميثود سيف علشان ادخلها في الداتا بيز يعني اذا في عندي بياتات في الداتابيز بتعمل عليها ابديت و اذا لا بتعمل عملية كرييت override fill
        return redirect()->route('profile.edit')->with('success', 'profile created / updated successfuly');
    }
}
