<!DOCTYPE html>
<html lang="vi">

@include('components.client.head')

<body>
    <!-- header  -->
    @include('components.client.header')
    <!-- header  -->

    <!-- NAVIGATION -->
    @include('components.client.nav')
    <!-- /NAVIGATION -->
    <!-- contetnt  -->


    <!-- contetnt  -->
    <!-- banner -->
    <!-- end banner -->

    <!-- product  -->
    @yield('content')
    <!--end  product  -->

    <!-- end contetnt  -->

    <!-- FOOTER -->
    @include('components.client.footer')
    @include('components.client.breadcrumbs')

    <!-- /FOOTER -->
    @include('components.client.script')

</body>

</html>