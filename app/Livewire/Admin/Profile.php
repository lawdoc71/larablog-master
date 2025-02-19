<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Helpers\CMail;
use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\UserSocialLink;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class Profile extends Component
{
    public $tab = null;
    public $tabname = 'personal_details';

    protected $queryString = ['tab'=>['keep'=>true]];

    // update personal details form
    public $name, $email, $username, $bio;

    // update password form
    public $current_password, $new_password, $new_password_confirmation;

    // update social links form
    public $facebook_url, $instagram_url, $youtube_url, $linkedin_url, $twitter_url, $github_url;

    protected $listeners = [
        'updateProfile'=>'$refresh'
    ];

    public function selectTab($tab){
        $this->tab = $tab;
    }

    public function mount(){
        $this->tab = Request('tab') ? Request('tab') : $this->tabname;

        //Populate
        $user = User::with('social_links')->findOrFail(auth()->id());
        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->bio = $user->bio;

        //Populate Social Links Form
        if( !is_null($user->social_links) ){
            $this->facebook_url = $user->social_links->facebook_url;
            $this->instagram_url = $user->social_links->instagram_url;
            $this->youtube_url = $user->social_links->youtube_url;
            $this->linkedin_url = $user->social_links->linkedin_url;
            $this->twitter_url = $user->social_links->twitter_url;
            $this->github_url = $user->social_links->github_url;
        }
    }

    public function updatePersonalDetails(){

        $user = User::findOrFail(auth()->id());

        $this->validate([
            'name'=>'required',
            'username'=>'required|unique:users,username,'.$user->id,
        ]);

        //Update User Info
        $user->name = $this->name;
        $user->username = $this->username;
        $user->bio = $this->bio;
        $updated = $user->save();

        sleep(0.5);

        if( $updated ){
            $this->dispatch('showToastr',['type'=>'success','message'=>'Your personal details were updated successfully.']);
            $this->dispatch('updateTopUserInfo')->to(TopUserInfo::class);
        }else{
            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    // update password method
    public function updatePassword(){

        $user = User::findOrFail(auth()->id());

        //Validate form
        $this->validate([
            'current_password'=>[
                'required',
                'min:5',
                function($attribute, $value, $fail) use ($user){
                    if( !Hash::check($value, $user->password) ){
                        return $fail(__('Your current password does not match our records.'));
                    }
                }
            ],

            // validattion of new password
            'new_password'=>'required|min:5|confirmed'
        ]);

        //Update User password
        $updated = $user->update([
            'password'=>Hash::make($this->new_password)
        ]);

        if( $updated ){

            //Send email notification to this user
            $data = array(
                'user'=>$user,
                'new_password'=>$this->new_password
            );

            // improve the email template - it looks like shit!
            $mail_body = view('email-templates.password-changes-template',$data)->render();

            $mail_config = array(
                'recipient_address'=>$user->email,
                'recipient_name'=>$user->name,
                'subject'=>'Password Changed',
                'body'=>$mail_body
            );

            CMail::send($mail_config);

            //Logout and Redirect User to login page
            auth()->logout();

            Session::flash('info','Your password was successfully changed. Please login with the new password.');

            // redirect to login page
            $this->redirectRoute('admin.login');

        } else {

            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    // update social links from profile page
    public function updateSocialLinks(){
        // validate
        $this->validate([
            'facebook_url'=>'nullable|url',
            'instagram_url'=>'nullable|url',
            'youtube_url'=>'nullable|url',
            'linkedin_url'=>'nullable|url',
            'twitter_url'=>'nullable|url',
            'github_url'=>'nullable|url',
        ]);

        //Get User Details
        $user = User::findOrFail(auth()->id());

        // update user profile in db
        $data = array(
            'facebook_url'=>$this->facebook_url,
            'instagram_url'=>$this->instagram_url,
            'youtube_url'=>$this->youtube_url,
            'linkedin_url'=>$this->linkedin_url,
            'twitter_url'=>$this->twitter_url,
            'github_url'=>$this->github_url,
        );

        if( !is_null($user->social_links) ){

           //Update records
           $query = $user->social_links()->update($data);

        } else {

           //Insert new data
           $data['user_id'] = $user->id;
           $query = UserSocialLink::insert($data);

        }

        if( $query ){

            $this->dispatch('showToastr',['type'=>'success','message'=>'Your social links are successfully updated!']);

        } else {

            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);

        }
    }

    public function render()
    {
        return view('livewire.admin.profile',[
            'user'=>User::findOrFail(auth()->id())
        ]);
    }

}
