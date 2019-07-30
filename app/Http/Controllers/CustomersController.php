<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Company;
use App\User;
use App\Zone;
use App\Station;
use Auth;

class CustomersController extends Controller
{
    public function index()
    {
    	$company_id = Auth::user()->company_id;
    	$customers = Company::where('parent_company_id', '=', $company_id)->where('id', '!=', $company_id)->get();
        return view('customer.index', ['customers' => $customers]);
    }

    public function create()
    {
        $company_id = Auth::user()->company_id;
        return view('customer.create');
    }

    public function store(Request $request)
    {
    	$company_id = Auth::user()->company_id;
        $this->validate($request, [
            'name' => 'required|unique:companies',
            'city' => 'required',
            'phone' => 'required',
            'email' => 'sometimes|nullable|email',
            'logo' => 'image|max:1999',
            'status' => 'required'
        ]);

        $user_id = Auth::user()->id;

        if ($request->file('logo') != NULL){ 
            // Get filename with extension
            $filenameWithExt = $request->file('logo')->getClientOriginalName();
            // Get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get extension
            $extension = $request->file('logo')->getClientOriginalExtension();
            // Create new filename
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // Uplaod image
            $path= $request->file('logo')->storeAs('public/logos', $filenameToStore);
        }
        $name = $request->input('name');
        $cuscompany = new Company;
        $cuscompany->name = $name;
        $cuscompany->parent_company_id = $company_id;
        $cuscompany->shortname = strtolower(substr($name, 0, strrpos($name, ' ')));
        $cuscompany->address = $request->input('address');
        $cuscompany->city = $request->input('city');
        $cuscompany->phone = $request->input('phone');
        $cuscompany->email = $request->input('email');
        $cuscompany->status = $request->input('status');
        if ($request->file('logo') != NULL){ 
            $cuscompany->logo = $filenameToStore;
        }
        if ($request->input('pin') != NULL){
            $cuscompany->pin = $request->input('pin');
        }
        $cuscompany->updated_by = $user_id;
        $cuscompany->save();

        return redirect('/customer')->with('success', 'Company Added');
    }

    public function edit($id)
    {
        $company_id = Auth::user()->company_id;
        $customer = Company::find($id);
        return view('customer.edit',['customer'=> $customer]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'email' => 'sometimes|nullable|email',
            'logo' => 'image|max:1999',
            'status' => 'required'
        ]);
        
        $user_id = Auth::user()->id;

        if ($request->file('logo') != NULL){ 
            // Get filename with extension
            $filenameWithExt = $request->file('logo')->getClientOriginalName();
            // Get just the filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            // Get extension
            $extension = $request->file('logo')->getClientOriginalExtension();
            // Create new filename
            $filenameToStore = $filename.'_'.time().'.'.$extension;
            // Uplaod image
            $path= $request->file('logo')->storeAs('public/logos', $filenameToStore);
        }
        $customer = Company::find($id);
        $customer->name = $request->input('name');
        $customer->address = $request->input('address');
        $customer->city = $request->input('city');
        $customer->phone = $request->input('phone');
        $customer->email = $request->input('email');
        if ($request->input('status') != NULL){
            $customer->status = $request->input('status');
        }
        else{
            $customer->status = '1';
        }
        if ($request->file('logo') != NULL){
            $customer->logo = $filenameToStore;
        }
        if ($request->input('pin') != NULL){
            $customer->pin = $request->input('pin');
        }
        $customer->updated_by = $user_id;
        $customer->save();

        return redirect('/customer')->with('success', 'Company details updated');
       
    }

    public function destroy($id)
    {
        $customer = Company::find($id);
        $usercnt = User::select('id')->where('company_id','=',$id)->get()->count();
        if ($usercnt > 0){
            return redirect('/customer')->with('error', 'Company has associated users who should be deleted first');
        }
        $customer->delete();
        return redirect('/customer')->with('success', 'Company Deleted');
    }

    public function cususers($id)
    {
        $company_id = Auth::user()->company_id;
        $cuscompanies = Company::where('parent_company_id', '=', $company_id)->where('id', '=', $id)->where('id', '!=', $company_id)->select('id')->count();
        if ($cuscompanies == 0 ){
            return redirect('/customer')->with('error', 'Company Not Found');
        }
        $users = User::where('company_id', '=', $id)->get();
        $company_name = Company::where('id', '=', $id)->pluck('name')->first();
        return view('cususers.index',['users'=> $users, 'company_id' => $id, 'company_name' => $company_name]);
    }

    public function cuscreate($id)
    {
        /* $company_id = Auth::user()->company_id;
        $stations = Station::where('company_id', '=', $id)->pluck('name','id')->all();
        $cuscompanies = Company::where('parent_company_id', '=', $company_id)->where('id', '=', $id)->where('id', '!=', $company_id)->select('id')->count();
        if ($cuscompanies == 0 ){
            return redirect('/customer')->with('error', 'Company Not Found');
        }
        return view('cususers.create', ['company_id' => $id, 'stations' => $stations]); */
		$parent_company_id = Auth::user()->company_id;
        $stations = Station::where('company_id', '=', $id)->pluck('name','id')->all();
        $cuscompanies = Company::where('parent_company_id', '=', $parent_company_id)->where('id', '=', $id)->where('id', '!=', $parent_company_id)->select('id')->count();
        $company_name = Company::select('name')->where('id', '=', $id)->pluck('name')->first();
        if ($cuscompanies == 0 ){
            return redirect('/customer')->with('error', 'Company Not Found');
        }
        return view('cususers.create', ['company_id' => $id, 'company_name' => $company_name, 'stations' => $stations]);
    }

    public function cusstore(Request $request, $id)
    {
        $company_id = Auth::user()->company_id;
        $user_id = Auth::user()->id;

        $this->validate($request, [
            'username' => 'required|unique:users',
            'firstname' => 'required',
            'lastname' => 'required',
            'pass1' => 'required|same:pass1',
            'pass2' => 'required|same:pass1',
            'station_id' => 'required',
            'phone' => array('required', 'regex:/^[0-9]{9,14}$/'),
            'status' => 'required' 
        ]);

        //Set new random password
        // function randomPassword() {
        //     $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        //     $pass = array(); //remember to declare $pass as an array
        //     $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        //     for ($i = 0; $i < 8; $i++) {
        //         $n = rand(0, $alphaLength);
        //         $pass[] = $alphabet[$n];
        //     }
        //     return implode($pass); //turn the array into a string
        // }

        $company_id = $id;
        
        //$password = randomPassword();
        // $password = 'courier123';
        $password = $request->input('pass1');
        $email = $request->input('email');
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');

        $user = new User;
        $user->username = $request->input('username');
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->fullname = $firstname.' '.$lastname;
        $user->phone = $request->input('phone');
        $user->email = $email;
        $user->password = bcrypt($password);
        $user->company_id = $company_id;
        $user->station_id = $request->input('station_id');
        $user->status = $request->input('status');
        $user->usertype = 'cusadmin';
        $user->updated_by = $user_id;
        $user->save();

        //get new user email

        /*$email = $user->email;
        $phone = $user->phone;
        // Send password via SMS
        if ($phone != NULL)
        {
            $atgusername   = env('ATGUSERNAME');
            $atgapikey     = env('ATGAPIKEY');
            $recipients = '+'.$phone;
            $message    = "Your password is ".$password;
            $gateway    = new AfricasTalkingGateway($atgusername, $atgapikey);
            try 
            { 
              $results = $gateway->sendMessage($recipients, $message);
                        
              foreach($results as $result) {
                // status is either "Success" or "error message"
                echo ' Number: ' .$result->number;
                echo ' Status: ' .$result->status;
                echo ' MessageId: ' .$result->messageId;
                echo ' Cost: '   .$result->cost.'\n';
              }
            }
            catch ( AfricasTalkingGatewayException $e )
            {
              echo 'Encountered an error while sending: '.$e->getMessage();
            }
        }

        if ($email != NULL)
        {
            Mail::to($email)->send(new GeneratePassword($password)); 
        }*/

        return redirect('/cususers/'.$company_id)->with('success', 'User Created');
    }

    public function cususerdestroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect('/customer')->with('success', 'User Deleted');
    }
	
	public function editUser($id)
    {
        $parent_company_id = Auth::user()->company_id;
        $user_id = Auth::user()->id;
        $company_id = User::select('company_id')->where('id', '=', $id)->pluck('company_id')->first();
        $company_name = Company::select('name')->where('id', '=', $company_id)->pluck('name')->first();
        $stations = Station::where('company_id', '=', $company_id)->pluck('name','id')->all();
        $user = User::where('company_id', '!=', $parent_company_id)->find($id);
        if ($user == NULL){
            return redirect('/customer')->with('error', 'User Not Found');
        }

        return view('cususers.edit',['user'=> $user, 'stations' => $stations, 'company_id' => $company_id, 'company_name' => $company_name, ]);
    }

    public function updateUser(Request $request, $id)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $parent_company_id = Auth::user()->company_id;
        $company_id = User::select('company_id')->where('id', '=', $id)->pluck('company_id')->first();

        $this->validate($request, [
            'firstname' => 'required',
            'lastname' => 'required',
            'pass1' => 'same:pass1',
            'pass2' => 'same:pass1',
            'station_id' => 'required',
            'status' => 'required',
            'phone' => ['required', 'regex:/^[0-9]{12}$/']
        ]);
        
        $password = $request->input('pass1');

        $user = User::find($id);
        
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $station_id = $request->input('station_id');
        $user->firstname = $firstname;
        $user->lastname = $lastname;
        $user->fullname = $firstname.' '.$lastname;
        if ($password != NULL)
        {
            $user->password = bcrypt($password);
        }
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->station_id = $station_id;
        $user->status = $request->input('status');
        $user->updated_by = $user_id;
        $user->save();
        
        return redirect('/cususers/'.$company_id)->with('success', 'User details updated');
    }
}
