<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\SetRemoteUser;
use \App\Models\Auth\User;
use App\Models\Auth\UserRole;
use  App\Models\Auth\Preference;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if (Gate::denies('users')) {
        //     return deny();
        // }
        $users = User::orderBy('name')->get();
        $users->load(['roles']);
        // dd($users);
        return view('auth.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('manage-users')) {
            return deny();
        }
        $this->validate($request, [
            'name' => 'required|max:255',
            'role_id' => 'required|integer|min:0',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        $user = UserRole::create([
            'user_id' => $user->id,
            'role_id' =>  $request->role_id
        ]);

        dispatch(new SetRemoteUser());

        return redirect('users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Gate::denies('manage-users')) {
            return deny();
        }
        $user = User::findOrFail($id);
        $user->load('roles');
        return view('auth.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Gate::denies('manage-users')) {
            return deny();
        }
        $rules = [];
        if (isset($request->password) &&  $request->password != '') {
            $rules = [
                'password' => 'required|string|min:6|confirmed',
            ];
        }
        $rules +=  [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role_id' => 'required|integer|exists:roles,id',
        ];

        $this->validate($request, $rules);
        // dd("here");

        $data = $request->all();
        $user = User::findOrFail($id);
        $user->name = $data['name'];
        $user->email = $data['email'];
        if (isset($data['password']) && $data['password']  != '') {
            $user->password = bcrypt($request->password);
        }

        $user->update();
        if (UserRole::where('user_id', $user->id)->first()) {
            $user_role = UserRole::where('user_id', $user->id)->first()->update(['role_id' => $request->role_id]);
        } else {
            $user = UserRole::create([
                'user_id' => $user->id,
                'role_id' =>  $request->role_id
            ]);
        }
        dispatch(new SetRemoteUser());
        return redirect('users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getResetPassword()
    {
        return view('auth.users.update');
    }


    public function updatePassword(Request $request)
    {
        $rules = [];
        $user = $request->user();
        if (!auth()->attempt(['email' => $user->email, 'password' => $request->old_password])) {
            session()->flash('error', 'Wrong old password. Authentication failed!!');
            return redirect()->back();
        }
        $this->validate($request, $rules + [
            'password' => 'required|min:6|confirmed',
        ]);
        $user->password = bcrypt($request['password']);
        $user->update();
        session()->flash('success', 'Password updated successfully!!');
        return redirect()->back();
    }

    // users list in user component
    public function getUsersList(Request $request)
    {
        $rows = 30;
        if ($request->has('term')) {
            $search = $request->has('term') ? $request->input('term', '') : '';
        } else {
            $search = $request->input('search', '');
        }

        $list = User::with('roles')->where('name', 'like', $search . '%');

        $count_filtered = $list->count();
        if ($request->has('page')) {
            if ($request->page > 1) {
                $list->skip(($request->page - 1) * $rows);
            }
            $list = $list->take($rows);
        }
        $list = $list->get();

        return reply('Ok', [
            'results' => $list,
            'count_filtered' => $count_filtered
        ]);
    }

    public function savePreferences(Request $request)
    {
        // dd("here");
        $preferences  = Preference::firstOrNew(['user_id' => auth()->user()->id, 'para_name' => 'sidebar']);
        $preferences->para_value = $request->sidebar;
        $preferences->save();
        return reply(true);
    }
}
