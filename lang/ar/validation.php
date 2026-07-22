<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'failed' => 'يوجد أخطاء في البيانات المدخلة.',
    'accepted' => 'يجب الموافقة على :attribute.',
    'accepted_if' => 'يجب الموافقة على :attribute عندما تكون قيمة :other هي :value.',
    'active_url' => 'يجب أن يكون :attribute رابطًا صحيحًا.',
    'after' => 'يجب أن يكون :attribute تاريخًا بعد :date.',
    'after_or_equal' => 'يجب أن يكون :attribute تاريخًا بعد أو مساويًا لـ :date.',
    'alpha' => 'يجب أن يحتوي :attribute على حروف فقط.',
    'alpha_dash' => 'يجب أن يحتوي :attribute على حروف وأرقام وشرطات وشرطة سفلية فقط.',
    'alpha_num' => 'يجب أن يحتوي :attribute على حروف وأرقام فقط.',
    'array' => 'يجب أن يكون :attribute قائمة.',
    'boolean' => 'يجب أن تكون قيمة :attribute صحيحة أو خاطئة.',
    'confirmed' => 'تأكيد :attribute غير مطابق.',
    'date' => 'يجب أن يكون :attribute تاريخًا صحيحًا.',
    'date_equals' => 'يجب أن يكون :attribute مساويًا للتاريخ :date.',
    'date_format' => 'يجب أن يكون :attribute بالتنسيق :format.',
    'before' => 'يجب أن يكون :attribute تاريخًا قبل :date.',
    'before_or_equal' => 'يجب أن يكون :attribute تاريخًا قبل أو مساويًا لـ :date.',
    'exists' => 'القيمة المحددة في :attribute غير موجودة.',
    'filled' => 'يجب إدخال :attribute إذا تم إرساله.',
    'image' => 'يجب أن يكون :attribute صورة.',
    'in' => 'القيمة المحددة في :attribute غير صحيحة.',
    'required' => 'حقل :attribute مطلوب.',
    'nullable' => 'يمكن أن تكون قيمة :attribute فارغة.',
    'string' => 'يجب أن يكون :attribute نصًا.',
    'integer' => 'يجب أن يكون :attribute رقمًا صحيحًا.',
    'numeric' => 'يجب أن يكون :attribute رقمًا.',
    'decimal' => [
        'numeric' => 'يجب أن يكون :attribute رقمًا عشريًا بعدد منازل صحيح.',
    ],
    'unique' => 'قيمة :attribute مستخدمة بالفعل.',
    'max' => [
        'string'=>'يجب ألا يزيد :attribute عن :max أحرف.'
    ],
    'mimes'=>'يجب أن يكون :attribute من نوع: :values.',
    'same'=>'يجب أن يطابق :attribute قيمة :other.',
    'different' => 'يجب أن يختلف :attribute عن :other.',
    'regex' => 'صيغة :attribute غير صحيحة.',


    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [

        // User
        'name' => 'الاسم',

        'email' => 'البريد الإلكتروني',

        'phone' => 'رقم الهاتف',

        'password' => 'كلمة المرور',

        'password_confirmation' => 'تأكيد كلمة المرور',

        'avatar' => 'الصورة الشخصية',


        // Profile
        'city' => 'المدينة',

        'address' => 'العنوان',


        // Roles
        'role' => 'نوع المستخدم',


        // Cars
        'brand_id' => 'الشركة المصنعة',

        'model_id' => 'موديل السيارة',

        'year' => 'سنة الصنع',

        'color' => 'اللون',

        'fuel_type' => 'نوع الوقود',

        'transmission' => 'ناقل الحركة',

        'price_per_day' => 'السعر اليومي',

        'description' => 'الوصف',


        // Booking
        'start_date' => 'تاريخ البداية',

        'end_date' => 'تاريخ النهاية',

        'pickup_location' => 'مكان الاستلام',

        'return_location' => 'مكان التسليم',


        // Images
        'image' => 'الصورة',

        'images' => 'الصور',

    ]

];
