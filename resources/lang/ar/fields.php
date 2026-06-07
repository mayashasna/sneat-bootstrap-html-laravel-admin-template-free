<?php

return [

    // ============================
    // Top-level
    // ============================
    'title'        => 'إنشاء حقل جديد',   // يستعملها create
    'title_create' => 'إنشاء حقل جديد',
    'title_edit'   => 'تعديل الحقل',

    // ============================
    // Flat keys (يستعملها edit.blade)
    // ============================
    'bind_to'            => 'ربط الحقل مع',
    'bind_category'      => 'التصنيف الرئيسي',
    'bind_subcategory'   => 'التصنيف الفرعي',
    'select_category'    => 'اختر التصنيف',
    'select_subcategory' => 'اختر التصنيف الفرعي',
    'name_ar'            => 'الاسم بالعربية',
    'name_en'            => 'الاسم بالإنكليزية',
    'field_type'         => 'نوع الحقل',

    'type_text'     => 'نص',
    'type_number'   => 'رقم',
    'type_select'   => 'قائمة اختيار',
    'type_checkbox' => 'خانة اختيار',
    'type_radio'    => 'زر اختيار',
    'type_date'     => 'تاريخ',

    'required'   => 'إجباري',
    'filterable' => 'قابل للفلترة',
    'active'     => 'فعال',
    'update'     => 'تحديث',
    'back'       => 'رجوع',

    // Options section (edit)
    'field_options'    => 'خيارات الحقل',
    'value_ar'         => 'القيمة بالعربية',
    'value_en'         => 'القيمة بالإنكليزية',
    'add_option'       => 'إضافة خيار',
    'existing_options' => 'الخيارات الحالية',
    'actions'          => 'الإجراءات',
    'value_en_col'     => 'القيمة (إنجليزي)',
    'value_ar_col'     => 'القيمة (عربي)',
    'edit'             => 'تعديل',
    'delete'           => 'حذف',
    'delete_confirm'   => 'هل أنت متأكد من الحذف؟',
    'save_changes'     => 'حفظ التغييرات',
    'no_options'       => 'لا توجد خيارات.',
    'status_active'    => 'فعال',
    'status_inactive'  => 'غير فعال',

    // ============================
    // Nested keys (يستعملها create.blade)
    // ============================
    'form' => [
        'bind_to'               => 'ربط الحقل مع',
        'select_binding_target' => 'اختر الجهة المرتبطة',
        'main_category'         => 'التصنيف الرئيسي',
        'subcategory'           => 'التصنيف الفرعي',
        'select_category'       => 'اختر التصنيف',
        'select_subcategory'    => 'اختر التصنيف الفرعي',
        'name_ar'               => 'الاسم بالعربية',
        'name_en'               => 'الاسم بالإنكليزية',
        'field_type'            => 'نوع الحقل',
        'required'              => 'إجباري',
        'filterable'            => 'قابل للفلترة',
        'active'                => 'فعال',
        'save'                  => 'حفظ',
        'back'                  => 'رجوع',
    ],

    'types' => [
        'text'     => 'نص',
        'number'   => 'رقم',
        'select'   => 'قائمة اختيار',
        'checkbox' => 'خانة اختيار',
        'radio'    => 'زر اختيار',
        'date'     => 'تاريخ',
    ],
'options_section' => [
        'title'    => 'خيارات الحقل',
        'add'      => 'إضافة خيار',
        'value_ar' => 'القيمة بالعربية',
        'value_en' => 'القيمة بالإنكليزية',
        'remove'   => 'حذف الخيار',
        'hint'     => 'أضف خياراً واحداً على الأقل لهذا النوع من الحقول. الصفوف الفارغة سيتم تجاهلها.',
    ],
    'created_successfully' => 'تم إنشاء الحقل بنجاح',
];
