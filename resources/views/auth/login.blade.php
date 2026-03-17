<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="description" content="" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />
    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />

    <script src="{{ asset('assets/js/config.js') }}"></script>
</head>

<body>
    <div class="authentication-wrapper authentication-cover authentication-bg">
        <div class="authentication-inner row">
            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 p-0">
                <div class="auth-cover-bg  d-flex justify-content-center align-items-center m-0">
                    <img src="{{ asset('assets/img/illustrations/auth-login-illustration-light-1.png') }}" alt="auth-login-cover"
                        class="img-fluid auth-illustration login-image" style="object-fit: cover;"
                        data-app-light-img="illustrations/auth-login-illustration-light-1.png"
                        data-app-dark-img="illustrations/auth-login-illustration-light-1.png" />
                </div>
            </div>
            <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand ">
                        <a href="index.html" class="app-brand-link gap-2">
                            <span class="login-logo">
                                <img src="{{ asset('assets/img/illustrations/Logo-image.png') }}" alt="auth-login-cover"
                                    data-app-light-img="illustrations/Logo-image.png"
                                    data-app-dark-img="illustrations/Logo-image.png" />
                            </span>
                        </a>
                    </div>
                    <form class="mb-3" method="POST" action="{{ route('login') }}" id="formAuthentication">
                        @csrf
                        <div class="mb-3">
                            <img src="{{ asset('assets/img/illustrations/mail.png') }}" alt="logo" width="24" height="24" />
                            <label for="email" class="form-label front-design">Email</label>
                            <div class="input-group password-Filed">
                                <input type="text" class="form-control" id="email" name="email"
                                    placeholder="Enter Your email..." aria-describedby="basic-addon1" autofocus />
                            </div>
                        </div>
                        <div class=" password-lable ">
                            <img src="{{ asset('assets/img/illustrations/lock.png') }}" alt="logo" width="24" height="24" />
                            <label class="form-label front-design " for="password">Password</label>

                            <div class="input-group password-Filed  ">
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="Enter Your password" aria-describedby="password" />
                                <span class="input-group-text cursor-pointer">
                                    <i class="ti ti-eye-off"></i>
                                </span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-2 ">
                            <a class="form-label text-primary text-decoration-underline"
                                href="auth-forgot-password-cover.html">
                                <small>Forgot Password?</small>
                            </a>
                        </div>

                        <button class="btn btn-primary d-grid w-100 login-btn">Login</button>
                    </form>
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>
    <!-- Main JS -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- Page JS -->
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
</body>

</html>