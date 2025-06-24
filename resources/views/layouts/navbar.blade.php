<div class="iq-menu-bt d-flex align-items-center">
    <div class="wrapper-menu">
        <div class="main-circle"><i class="ri-arrow-left-s-line"></i></div>
        <div class="hover-circle"><i class="ri-arrow-right-s-line"></i></div>
    </div>
    <div class="iq-navbar-logo d-flex justify-content-between">
        <a href="index.html" class="header-logo">
            <img src="images/logo.png" class="img-fluid rounded-normal" alt="">
            <div class="pt-2 pl-2 logo-title">
                <span class="text-danger text-uppercase">Server<span class="text-primary ml-1">360</span></span>
            </div>
        </a>
    </div>
</div>

</div>
<ul class="navbar-list">
    <li class="line-height">
        <a href="#" class="search-toggle iq-waves-effect d-flex align-items-center">
            <img src="{{asset('assets/images/user/user.png')}}" class="img-fluid rounded-circle" alt="user">
        </a>
        <div class="iq-sub-dropdown iq-user-dropdown">
            <div class="iq-card shadow-none m-0">
                <div class="iq-card-body p-0 ">
                    <div class="bg-primary p-3">
                        <h5 class="mb-0 text-white line-height">Hello admin</h5>
                        <span class="text-white font-size-12">Available</span>
                    </div>
                    <!-- <a href="profile.html" class="iq-sub-card iq-bg-primary-hover">
                        <div class="media align-items-center">
                            <div class="rounded iq-card-icon iq-bg-primary">
                                <i class="ri-file-user-line"></i>
                            </div>
                            <div class="media-body ml-3">
                                <h6 class="mb-0 ">My Profile</h6>
                                <p class="mb-0 font-size-12">View personal profile details.</p>
                            </div>
                        </div>
                    </a>
                    <a href="profile-edit.html" class="iq-sub-card iq-bg-primary-hover">
                        <div class="media align-items-center">
                            <div class="rounded iq-card-icon iq-bg-primary">
                                <i class="ri-profile-line"></i>
                            </div>
                            <div class="media-body ml-3">
                                <h6 class="mb-0 ">Edit Profile</h6>
                                <p class="mb-0 font-size-12">Modify your personal details.</p>
                            </div>
                        </div>
                    </a>
                    <a href="account-setting.html" class="iq-sub-card iq-bg-primary-hover">
                        <div class="media align-items-center">
                            <div class="rounded iq-card-icon iq-bg-primary">
                                <i class="ri-account-box-line"></i>
                            </div>
                            <div class="media-body ml-3">
                                <h6 class="mb-0 ">Account settings</h6>
                                <p class="mb-0 font-size-12">Manage your account parameters.</p>
                            </div>
                        </div>
                    </a> -->
                    <!-- <a href="privacy-setting.html" class="iq-sub-card iq-bg-primary-hover">
                        <div class="media align-items-center">
                            <div class="rounded iq-card-icon iq-bg-primary">
                                <i class="ri-lock-line"></i>
                            </div>
                            <div class="media-body ml-3">
                                <h6 class="mb-0 ">Privacy Settings</h6>
                                <p class="mb-0 font-size-12">Control your privacy parameters.</p>
                            </div>
                        </div>
                    </a> -->
                    <div class="d-inline-block w-100 text-center p-3">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </li>
</ul>