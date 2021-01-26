<?php

return [
    'public' => [
        'done' => 'تمت العملية ينجاح',
        'server_error' => 'حدث خطأ ما، يرجى المحاولة لاحقاً',
    ],
    'auth' => [
        'validation_error' => 'خطأ في التحقق',
        'invalid_route' => 'الرابط المطلوب غير موجود',
        'method_invalid' => 'العملية غير صالحة',
        'related_resource' => 'تعذر إكمال الطلب بسبب وجود تعارض مع الحالة الحالية للمورد الهدف.',
        'unauthinicated' => 'الرجاء إعادة المصادقة، انتهت الجلسة',
        'login' => 'تم تسجيل الدخول بنجاح',
        'register' => 'تم التسجيل بنجاح',
        'verify_SMS_already' => 'الحساب مؤكّد بالفعل',
        'verify_SMS_done' => 'تم تأكيد الحساب بنجاح',
        'resent_SMS_done' => 'تم إرسال رسالة إلى رقمك بنجاح',
        'forget_password_config' => 'تم إرسال الإعدادات إلى رقمك',
        'loggedout' => 'تم تسجيل الخروج بنجاح',
        'password_reset' => 'تم تهيئة كلمة المرور',
        'password_updated' => 'تم تحديث كلمة السر بنجاح',
        'old_password_incorrect' => 'كلمة المرور السابقة غير صحيحة',
        'code_sent_successfully' => 'تم إرسال الرمز بنجاح',
        'enter_verify_code' => 'ادخل رمز التحقق',
        'verify_code_approved' => 'تم قبول رمز التحقق',
        'invalid_credentials' => 'المعلومات المدخلة غير صحيحة، الرجاء المحاولة مرة أخرى'
    ],
    'verification' => [
        'invalid' => 'رمز التحقق المدخل غير صحيح',
    ],
    'order' => [
        'cancel' => 'تم إلغاء الطلب بنجاح',
        'coupon_expired' => 'الكوبون المدخل غير صحيح أو منتهي الصلاحية',
        'min_max' => 'الكمية المطلوبة اكبر أو أصغر من الحد المسموح به',
        'prevent_cancel' => 'لا يمكن إلغاء الطلب',
        'already_taken' => 'احدى المنتجات مستخدمة من قبل زيون اخر في هذه التاريخ',
        'submit' => 'تم تقديم طلبك بنجاح'
    ],
    'customer' => [
        'not_found' => 'حساب المستخدم غير موجود',
    ],
    'driver' => [
        'not_found' => 'حساب السائق غير موجود',
    ],
    'redeem' => [
        'limit' => 'تحتاج إلى 10 نقاط على الأقل لإكمال العملية',
    ],
    'social' => [
        'unable_login' => 'لا يمكن تسجيل الدخول باستخدام :service. الرجاء المحاولة لاحقاً'
    ],
    'tawseleh' => [
        'already_taken' => 'هذا الطلب مستخدم حالياً من قبل سائق آخر',
    ],
    'anythingOrder' => [
        'already_taken' => 'هذا الطلب مستخدم حالياً من قبل سائق آخر',
    ],
    'driverSchedule' => [
        'cannot_edit_old_value' => 'لا يمكن تعديل الجدولة السابقة',
    ],
];
