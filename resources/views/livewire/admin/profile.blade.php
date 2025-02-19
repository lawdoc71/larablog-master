<div>

    <div class="row">

        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">

            <div class="pd-20 card-box height-100-p">

                <div class="profile-photo">
                    <a href="javascript:;" onclick="event.preventDefault();document.getElementById('profilePictureFile').click();" class="edit-avatar">
                        <i class="fa fa-pencil"></i>
                    </a>
                    <img src="{{ $user->picture }}" alt="" class="avatar-photo" id="profilePicturePreview">
                    <input type="file" name="profilePictureFile" id="profilePictureFile" class="d-none" style="opacity: 0">
                </div>

                <h5 class="text-center h5 mb-0">{{ $user->name }}</h5>

                <p class="text-center text-muted font-14">
                    {{ $user->email }}
                </p>

                <div class="profile-social">

                    <h5 class="mb-20 h5 text-blue">Social Links</h5>

                    <ul class="clearfix">

                        @if ( $user->social_links->facebook_url )
                            <li>
                                <a target="_blank" href="{{ $user->social_links->facebook_url }}" class="btn" data-bgcolor="#3b5998" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(59, 89, 152);"><i class="fa fa-facebook"></i></a>
                            </li>
                        @endif

                        @if ( $user->social_links->twitter_url )
                            <li>
                                <a target="_blank" href="{{ $user->social_links->twitter_url }}" class="btn" data-bgcolor="#1da1f2" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(29, 161, 242);"><i class="fa fa-twitter"></i></a>
                            </li>
                        @endif

                        @if ( $user->social_links->linkedin_url )
                            <li>
                                <a target="_blank" href="{{ $user->social_links->linkedin_url }}" class="btn" data-bgcolor="#007bb5" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(0, 123, 181);"><i class="fa fa-linkedin"></i></a>
                            </li>
                        @endif

                        @if ( $user->social_links->instagram_url )
                            <li>
                                <a target="_blank" href="{{ $user->social_links->instagram_url }}" class="btn" data-bgcolor="#f46f30" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(244, 111, 48);"><i class="fa fa-instagram"></i></a>
                            </li>
                        @endif

                        @if ( $user->social_links->youtube_url )
                            <li>
                                <a target="_blank" href="{{ $user->social_links->youtube_url }}" class="btn" data-bgcolor="#c32361" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(195, 35, 97);"><i class="fa fa-youtube"></i></a>
                            </li>
                        @endif

                        @if ( $user->social_links->github_url )
                            <li>
                                <a target="_blank" href="{{ $user->social_links->github_url }}" class="btn" data-bgcolor="#3d464d" data-color="#ffffff" style="color: rgb(255, 255, 255); background-color: rgb(61, 70, 77);"><i class="fa fa-github"></i></a>
                            </li>
                        @endif

                    </ul>

                </div>

            </div>
        </div>

        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
            <div class="card-box height-100-p overflow-hidden">
                <div class="profile-tab height-100-p">
                    <div class="tab height-100-p">

                        <ul class="nav nav-tabs customtab" role="tablist">

                            <li class="nav-item">
                                <a wire:click="selectTab('personal_details')" class="nav-link {{ $tab == 'personal_details' ? 'active' : '' }}" data-toggle="tab" href="#personal_details" role="tab">Personal details</a>
                            </li>

                            <li class="nav-item">
                                <a wire:click="selectTab('update_password')" class="nav-link {{ $tab == 'update_password' ? 'active' : '' }}" data-toggle="tab" href="#update_password" role="tab">Update password</a>
                            </li>

                            <li class="nav-item">
                                <a wire:click="selectTab('social_links')" class="nav-link {{ $tab == 'social_links' ? 'active' : '' }}" data-toggle="tab" href="#social_links" role="tab">Social Links</a>
                            </li>

                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane fade {{ $tab == 'personal_details' ? 'show active' : '' }}" id="personal_details" role="tabpanel">
                                <div class="pd-20">

                                    {{-- personal details --}}
                                    <form wire:submit="updatePersonalDetails()">

                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Full name</label>
                                                    <input type="text" class="form-control" wire:model="name" placeholder="Enter full name">
                                                    @error('name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Email</label>
                                                    <input type="text" class="form-control" wire:model="email" placeholder="Enter email address" disabled>
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Username</label>
                                                    <input type="text" class="form-control" wire:model="username" placeholder="Enter username">
                                                    @error('username')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="">Bio</label>
                                                    <textarea wire:model="bio"  cols="4" rows="4" class="form-control" placeholder="Type your bio..."></textarea>
                                                    @error('bio')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>

                                    </form>

                                </div>
                            </div>
                            <div class="tab-pane fade {{ $tab == 'update_password' ? 'show active' : '' }}" id="update_password" role="tabpanel">
                                <div class="pd-20 profile-task-wrap">

                                    <form wire:submit="updatePassword()">

                                        <div class="row">

                                            <div class="col-md-4">
                                                <div class="form-group">

                                                    <label for="">Current password</label>
                                                    <input type="password" class="form-control" wire:model="current_password" placeholder="Current password">

                                                    @error('current_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">New password</label>
                                                    <input type="password" class="form-control" wire:model="new_password" placeholder="New password">

                                                    @error('new_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Confirm new password</label>
                                                    <input type="password" class="form-control" wire:model="new_password_confirmation" placeholder="Confirm new password">

                                                    @error('new_password_confirmation')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                        </div>

                                        {{-- submit --}}
                                        <button type="submit" class="btn btn-primary">Update password</button>

                                   </form>

                                </div>
                            </div>
                            <div class="tab-pane fade {{ $tab == 'social_links' ? 'show active' : '' }}" id="social_links" role="tabpanel">
                                <div class="pd-20 profile-task-wrap">

                                   <form method="post" wire:submit='updateSocialLinks()'>

                                        {{-- social links --}}
                                        <div class="row">

                                            {{-- facebook --}}
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for=""><b>Facebook</b></label>
                                                    <input type="text" class="form-control" wire:model='facebook_url' placeholder="Facebook Url">

                                                    @error('facebook_url')
                                                        <span class="text-danger ml-1">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                            {{-- instagram  --}}
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for=""><b>Instagram</b></label>
                                                    <input type="text" class="form-control" wire:model='instagram_url' placeholder="Instagram Url">

                                                    @error('instagram_url')
                                                        <span class="text-danger ml-1">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                            {{-- Youtube  --}}
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for=""><b>YouTube</b></label>
                                                    <input type="text" class="form-control" wire:model='youtube_url' placeholder="YouTube Url">

                                                    @error('youtube_url')
                                                        <span class="text-danger ml-1">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                            {{-- linkedin  --}}
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for=""><b>LinkedIn</b></label>
                                                    <input type="text" class="form-control" wire:model='linkedin_url' placeholder="LinkedIn Url">

                                                    @error('linkedin_url')
                                                        <span class="text-danger ml-1">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                            {{-- X --}}
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for=""><b>X/Twitter</b></label>
                                                    <input type="text" class="form-control" wire:model='twitter_url' placeholder="Twitter Url">

                                                    @error('twitter_url')
                                                        <span class="text-danger ml-1">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                            {{-- github  --}}
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label for=""><b>GitHub</b></label>
                                                    <input type="text" class="form-control" wire:model='github_url' placeholder="GitHub Url">

                                                    @error('github_url')
                                                        <span class="text-danger ml-1">{{ $message }}</span>
                                                    @enderror

                                                </div>
                                            </div>

                                        </div>

                                        {{-- submit  --}}
                                        <button type="submit" class="btn btn-primary">Update</button>

                                   </form>

                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
