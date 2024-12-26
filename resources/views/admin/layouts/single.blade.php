<!DOCTYPE html>
<html lang="en">

<head>

    @include('admin.includes.head')

</head>

<body class="bg-gradient-primary">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-6 col-lg-6 col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    @yield('single')
                </div>
            </div>
        </div>
    </div>

    @include('admin.includes.scripts')

</body>

</html>
