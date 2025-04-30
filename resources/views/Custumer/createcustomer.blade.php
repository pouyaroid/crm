<!DOCTYPE html>
<html lang='fa' dir='rtl'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>فرم ثبت اطلاعات مشتری</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css' rel='stylesheet'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css' rel='stylesheet'>
    <style>
        body {
            font-family: 'Vazir', Tahoma, sans-serif;
            background-color: #eef2f7;
            margin: 0;
            padding: 0;
        }
        
        .form-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem 3rem;
            margin-top: 3rem;
        }

        .form-section-title {
            font-size: 1.3rem;
            font-weight: 500;
            margin-bottom: 1.2rem;
            display: flex;
            align-items: center;
            border-bottom: 3px solid #007bff;
            padding-bottom: 0.5rem;
            color: #007bff;
        }

        .form-section-title i {
            margin-left: 10px;
            color: #0d6efd;
            font-size: 1.4rem;
        }

        .form-label {
            margin-bottom: 0.5rem;
            margin-top: 1rem;
            font-weight: 500;
            color: #495057;
        }

        .form-label i {
            margin-left: 8px;
            color: #17a2b8;
            font-size: 1.1rem;
        }

        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }

        .form-control:focus {
            border-color: #17a2b8;
            box-shadow: 0 0 5px rgba(23, 162, 184, 0.5);
            background-color: #fff;
        }

        .form-control::placeholder {
            font-size: 0.9rem;
            color: #adb5bd;
            opacity: 0.8;
        }

        .btn-primary {
            border-radius: 25px;
            background: linear-gradient(135deg, #6f86d6, #48c6ef);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #48c6ef, #6f86d6);
            transform: scale(1.02);
        }

        .btn-primary i {
            font-size: 1rem;
            color: #fff;
            margin-left: 5px;
        }

    </style>
</head>
<body>
    <div class='container'>
        <div class='row justify-content-center'>
            <div class='col-lg-10 col-xl-8'>
                <div class='form-container'>
                    <h2 class='text-center fw-bold mb-4'>
                        <i class='bi bi-person-lines-fill' style='color: #007bff;'></i>ثبت اطلاعات مشتری
                    </h2>

                    <form action='{{ route('customers.store') }}' method='POST' novalidate>
                        @csrf

                        <!-- اطلاعات شرکت -->
                        <div class='form-section-title'>
                            <i class='bi bi-building'></i>اطلاعات شرکت
                        </div>
                        <div class='row g-3'>
                            <div class='col-md-6'>
                                <label class='form-label' for='company_name'>
                                    <i class='bi bi-card-text'></i>نام شرکت *
                                </label>
                                <input type='text' class='form-control' id='company_name' name='company_name' placeholder='مثال: شرکت پویش' required>
                            </div>
                            <div class='col-md-6'>
                                <label class='form-label' for='company_type'>
                                    <i class='bi bi-diagram-3'></i>نوع شرکت *
                                </label>
                                <input type='text' class='form-control' id='company_type' name='company_type' placeholder='مثال: خصوصی' required>
                            </div>
                        </div>

                        <!-- اطلاعات تماس -->
                        <div class='form-section-title mt-4'>
                            <i class='bi bi-telephone'></i>اطلاعات تماس
                        </div>
                        <div class='row g-3'>
                            <div class='col-md-6'>
                                <label class='form-label' for='personal_name'>
                                    <i class='bi bi-person-circle'></i>نام شخص تماس *
                                </label>
                                <input type='text' class='form-control' id='personal_name' name='personal_name' placeholder='مثال: علی احمدی' required>

                                <label class='form-label' for='email'>
                                    <i class='bi bi-envelope'></i>ایمیل *
                                </label>
                                <input type='email' class='form-control' id='email' name='email' placeholder='info@example.com' required>
                            </div>
                            <div class='col-md-6'>
                                <label class='form-label' for='company_phone'>
                                    <i class='bi bi-telephone-inbound'></i>تلفن شرکت
                                </label>
                                <input type='text' class='form-control' id='company_phone' name='company_phone' placeholder='02112345678'>

                                <label class='form-label' for='mobile_phone'>
                                    <i class='bi bi-phone'></i>تلفن همراه
                                </label>
                                <input type='text' class='form-control' id='mobile_phone' name='mobile_phone' placeholder='09121234567'>
                            </div>
                        </div>

                        <!-- اطلاعات اضافی -->
                        <div class='form-section-title mt-4'>
                            <i class='bi bi-info-circle'></i>اطلاعات اضافی
                        </div>
                        <div class='row g-3'>
                            <div class='col-md-6'>
                                <label class='form-label' for='ceo'>
                                    <i class='bi bi-person-badge'></i>مدیر عامل
                                </label>
                                <input type='text' class='form-control' id='ceo' name='ceo' placeholder='محمد رضایی'>

                                <label class='form-label' for='address'>
                                    <i class='bi bi-geo-alt'></i>آدرس
                                </label>
                                <input type='text' class='form-control' id='address' name='address' placeholder='تهران، خیابان مثال'>

                                <label class='form-label' for='bank'>
                                    <i class='bi bi-bank'></i>بانک
                                </label>
                                <input type='text' class='form-control' id='bank' name='bank' placeholder='بانک ملت'>
                            </div>
                            <div class='col-md-6'>
                                <label class='form-label' for='account_number'>
                                    <i class='bi bi-hash'></i>شماره حساب
                                </label>
                                <input type='text' class='form-control' id='account_number' name='account_number' placeholder='1234567890'>

                                <label class='form-label' for='postal_code'>
                                    <i class='bi bi-mailbox'></i>کد پستی
                                </label>
                                <input type='text' class='form-control' id='postal_code' name='postal_code' placeholder='1234567890'>

                                <label class='form-label' for='id_meli'>
                                    <i class='bi bi-person-vcard'></i>کد ملی
                                </label>
                                <input type='text' class='form-control' id='id_meli' name='id_meli' placeholder='1234567890'>

                                <label class='form-label' for='code_eghtesadi'>
                                    <i class='bi bi-cash-stack'></i>کد اقتصادی
                                </label>
                                <input type='text' class='form-control' id='code_eghtesadi' name='code_eghtesadi' placeholder='123456789012'>
                            </div>
                        </div>

                        <!-- یادداشت -->
                        <div class='mt-4'>
                            <label class='form-label' for='note'>
                                <i class='bi bi-journal-text'></i>یادداشت
                            </label>
                            <textarea class='form-control' id='note' name='note' rows='3' placeholder='توضیحات اضافی را وارد کنید...'></textarea>
                        </div>

                        <!-- دکمه ارسال -->
                        <div class='text-center mt-4'>
                            <button type='submit' class='btn btn-primary px-5 py-2 fw-bold'>
                                <i class='bi bi-check-circle'></i>ثبت اطلاعات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
