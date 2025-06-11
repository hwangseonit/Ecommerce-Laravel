<!DOCTYPE html>
<html lang="en">

    @include('components.admin.head')
<body class="g-sidenav-show  bg-gray-100">
    @include('components.admin.aside')
    <main class="main-content border-radius-lg ">
        <!-- Navbar -->
        @include('components.admin.nav')
        <!-- End Navbar -->
        <!-- content -->
        @yield('content')
        <!-- @include('components.admin.footer') -->
        <!--end content -->
    </main>
    <!--   Core JS Files   -->
    @include('components.admin.scripts')
</body>

</html>