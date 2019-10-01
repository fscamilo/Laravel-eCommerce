<?php

namespace App\Http\Controllers;

use App\User;
use App\Address;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateUser;
use App\Http\Requests\CreateAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function __construct(){
        
    }

    public function index()
    {
        $users = User::select('id', 'name', 'email', 'created_at')->where('role', 'client')->get();
        return view('admin.pages.clients.index', compact('users'));
    }


    public function create()
    {
        return view('admin.pages.clients.create');
    }


    public function store(Request $request)
    {
        //
    }


    public function show($id)
    {
        //
    }


    public function edit(Request $request, $id)
    {
        $user = User::find($id);

		if(Auth::user()->role == 'administrator' || Auth::user()->id == $user->id){
			if($request->has('update_delivery')){
				$user->primary_address_id = $request->input('primary-address');
				$user->save();
			}

			if($request->has('add_delivery')){
				return view('admin.pages.clients.address', compact(['user']));
			}

			return view('admin.pages.clients.edit', compact(['user']));
		}else{
            return redirect()->back();
		}
	}

	
	public function addAddress(CreateAddress $request, $id) {
		$user = User::find($id);

		$address = new Address;
		$address->user_id = Auth::user()->id;
		$address->line_1 = $request->input('line_1');
		$address->line_2 = $request->input('line_2');
		$address->city = $request->input('city');
		$address->postcode = $request->input('postcode');

		$address->save();
		return view('admin.pages.clients.edit', compact(['user']));
	}


	public function deleteAddress($id) {
		$address = Address::find($id);
		if(Auth::user()->id == $address->user_id){
			$address->destroy($id);
		}
		return redirect()->back();
	}


    public function update(UpdateUser $request, $id)
    {
        $user = Auth::user();
		$updateFields = ['name', 'email'];

        // Only if logged in user is editing their own profile
        if($id == $user->id){

            // Hash password
            if($request['password']){
                $user->password = Hash::make($request['password']);
                $updateFields[] = 'password';
			}

            $user->update(request($updateFields));
            return redirect()->back()->with(['response' => ['success', 'Profile updated succesfully']]);
        }
    }

	
    public function destroy($id)
    {
        $currUser = Auth::user();
        $user = User::find($id);

        if($currUser->id == $id):
            return redirect()->back()->with(['user_delete_response' => ['message' => 'You cannot delete yourself']]);
        else:
            $returnData = [
                'data' => [$user->id, $user->name, $user->email, $user->role],
                'headings' => ['ID', 'Name', 'Email', 'Role'],
                'message' => 'The following client was successfully deleted'
            ];
            $user->delete();
            
            return redirect('/admin/clients')->with(['delete_response' => $returnData]);
        endif;
    }
}