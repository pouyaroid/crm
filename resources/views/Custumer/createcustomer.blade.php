<div class='container dir-rtl text-end'>
    <h2 class='mb-4 text-center'>ثبت اطلاعات مشتری</h2>

    <form action='{{ route('customers.store') }}' method='POST' class='needs-validation' novalidate>
        @csrf

        <!-- گروه اطلاعات شرکت -->
        <h5 class='mt-4'>اطلاعات شرکت</h5>
        <div class='row g-3'>
            <div class='col-md-6'>
                <div class='mb-3'>
                    <label for='company_name' class='form-label'>نام شرکت</label>
                    <input type='text' class='form-control' id='company_name' name='company_name' placeholder='مثال: شرکت مثال' required>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='mb-3'>
                    <label for='company_type' class='form-label'>نوع شرکت</label>
                    <input type='text' class='form-control' id='company_type' name='company_type' placeholder='مثال: خصوصی' required>
                </div>
            </div>
        </div>

        <!-- گروه اطلاعات تماس -->
        <h5 class='mt-4'>اطلاعات تماس</h5>
        <div class='row g-3'>
            <div class='col-md-6'>
                <div class='mb-3'>
                    <label for='personal_name' class='form-label'>نام شخص تماس</label>
                    <input type='text' class='form-control' id='personal_name' name='personal_name' placeholder='مثال: علی احمدی' required>
                </div>
                <div class='mb-3'>
                    <label for='email' class='form-label'>ایمیل</label>
                    <input type='email' class='form-control' id='email' name='email' placeholder='مثال: info@example.com' required>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='mb-3'>
                    <label for='company_phone' class='form-label'>تلفن شرکت</label>
                    <input type='text' class='form-control' id='company_phone' name='company_phone' placeholder='مثال: 02112345678'>
                </div>
                <div class='mb-3'>
                    <label for='mobile_phone' class='form-label'>تلفن همراه</label>
                    <input type='text' class='form-control' id='mobile_phone' name='mobile_phone' placeholder='مثال: 09121234567'>
                </div>
            </div>
        </div>

        <!-- گروه اطلاعات اضافی -->
        <h5 class='mt-4'>اطلاعات اضافی</h5>
        <div class='row g-3'>
            <div class='col-md-6'>
                <div class='mb-3'>
                    <label for='ceo' class='form-label'>مدیر عامل</label>
                    <input type='text' class='form-control' id='ceo' name='ceo' placeholder='مثال: محمد رضایی'>
                </div>
                <div class='mb-3'>
                    <label for='address' class='form-label'>آدرس</label>
                    <input type='text' class='form-control' id='address' name='address' placeholder='مثال: تهران، خیابان مثال'>
                </div>
                <div class='mb-3'>
                    <label for='bank' class='form-label'>بانک</label>
                    <input type='text' class='form-control' id='bank' name='bank' placeholder='مثال: بانک ملی'>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='mb-3'>
                    <label for='account_number' class='form-label'>شماره حساب</label>
                    <input type='text' class='form-control' id='account_number' name='account_number' placeholder='مثال: 1234567890'>
                </div>
                <div class='mb-3'>
                    <label for='postal_code' class='form-label'>کد پستی</label>
                    <input type='text' class='form-control' id='postal_code' name='postal_code' placeholder='مثال: 1234567890'>
                </div>
                <div class='mb-3'>
                    <label for='id_meli' class='form-label'>کد ملی</label>
                    <input type='text' class='form-control' id='id_meli' name='id_meli' placeholder='مثال: 1234567890'>
                </div>
                <div class='mb-3'>
                    <label for='code_eghtesadi' class='form-label'>کد اقتصادی</label>
                    <input type='text' class='form-control' id='code_eghtesadi' name='code_eghtesadi' placeholder='مثال: 123456789012'>
                </div>
            </div>
        </div>

        <!-- فیلد یادداشت به صورت جداگانه برای جلوگیری از تداخل با grid -->
        <div class='mb-3 mt-4'>
            <label for='note' class='form-label'>یادداشت</label>
            <textarea class='form-control' id='note' name='note' rows='3' placeholder='توضیحات اضافی را اینجا بنویسید...'></textarea>
        </div>

        <!-- دکمه سابمیت -->
        <button type='submit' class='btn btn-primary mt-3'>ثبت اطلاعات</button>
    </form>
</div>
