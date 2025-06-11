@extends ('layouts.client.main')
@section('content')
    @include('components.client.alert')
    <div class="container ">
        @include('breadcrumbs::bootstrap4')
        <!-- section title -->
        <div class="col-md-12 ">
            <div class="section-title my-4 ms-3">
                <h3 class="title">Liên hệ</h3>
            </div>
        </div>
        <!-- /section title -->
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <div class="fshop-contact-form">
                    <h4>Cửa hàng điện thoại di động CELLPHONES</h4>
                    <p>Địa chỉ: 12 P.Chùa Bộc</p>
                    <p>Số điện thoại: 1800.2097</p>
                    <p>Email: cskh@cellphones.com.vn</p>
                    <form id="form-contact" class="form" novalidate="novalidate">
                        <p>Đừng ngần ngại, hãy liên hệ ngay với chúng tôi </p>
                        <p>
                            <input type="text" name="name" value="" placeholder="Họ và tên"
                                class="name form-control" data-rule-required="true" aria-required="true">
                        </p>
                        <p>
                            <input type="text" name="phone" value="" placeholder="Số điện thoại của bạn"
                                class="phone form-control" data-rule-required="true" aria-required="true">
                        </p>
                        <p>
                            <input type="text" name="emailCustomer" value="" placeholder="Email của bạn"
                                class="emailCustomer form-control" data-rule-required="true" aria-required="true">
                        </p>
                        <p>
                            <textarea class="content form-control" name="content" placeholder="Nội dung cần liên hệ" data-rule-required="true"
                                aria-required="true"></textarea>
                        </p>
                        <p>
                            <select class="emailContact form-control" id="emailContact" name="emailContact">
                                <option value="frt.sale@fpt.com.vn">Bộ phận hỗ trợ bán hàng</option>
                                <option value="frt.contact@fpt.com.vn">Bộ phần hỗ trợ tài khoản, các vấn đề khác </option>
                                <option value="fptshop@fpt.com.vn">Bộ phận hỗ trợ phản ánh, góp ý </option>
                            </select>
                        </p>
                        <p class="text-right">
                            <input type="submit" value="Gửi đi" class="btn btn-danger">
                        </p>
                    </form>
                </div>
            </div>
            <div class="col-sm-6 col-xs-12">
                <div class=" row fshop-contact-maps">
                    <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.5979336511796!2d105.82611581151583!3d21.008748188383557!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac800f450807%3A0x419a49bcd94b693a!2sBanking%20Academy!5e0!3m2!1sen!2s!4v1748335890713!5m2!1sen!2s" 
                    width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                       
                </div>
            </div>
        </div>
    </div>
@endsection
