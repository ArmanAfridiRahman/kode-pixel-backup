
<?php

use App\Enums\StatusEnum;

return [

    "default_template_code"=>[
        'name' => "name",
        'message' => "message"
    ],

    "link_types"=>[
        'regular_link',
        'paid_sponsored',
        'ugc',
        'nofollow',
    ],

    "ticket_settings" => [

        [
            'labels' => 'Subject',
            'name' => 'subject',
            'placeholder' => 'Subject',
            'type' => 'text',
            'required' => StatusEnum::true->status(),
            'default' => StatusEnum::true->status(),
            'multiple' => StatusEnum::false->status()
        ],
        [
            'labels' => 'Message',
            'name' => 'message',
            'placeholder' => 'message',
            'type' => 'textarea',
            'required' => StatusEnum::true->status(),
            'default' => StatusEnum::true->status(),
            'multiple' => StatusEnum::false->status()
        ],
        [
            'labels' => 'Attachments',
            'name' => 'attachment',
            'placeholder' => 'You Can Upload Multiple File Here',
            'type' => 'file',
            'required' => StatusEnum::true->status(),
            'default' => StatusEnum::true->status(),
            'multiple' => StatusEnum::true->status()
        ],
    ],

    "user_registration_input" => [

        [
            'order'=> 1,
            'labels' => 'Name',
            'name' => 'name',
            'placeholder' => 'Name',
            'type' => 'text',
            'width'=> '50',
            'status' => StatusEnum::true->status(),
            'required' => StatusEnum::true->status(),
            'default' => StatusEnum::true->status(),
            'multiple' => StatusEnum::false->status()
        ],

        [
            'order'=> 2,
            'labels' => 'Email',
            'name' => 'email',
            'placeholder' => 'Email',
            'type' => 'email',
            'width'=> '50',
            'required' => StatusEnum::true->status(),
            'default' => StatusEnum::true->status(),
            'status' => StatusEnum::true->status(),
            'multiple' => StatusEnum::false->status()
        ],

        [
            'order'=> 3,
            'labels' => 'Username',
            'name' => 'user_name',
            'placeholder' => 'Enter Your User Name',
            'type' => 'text',
            'width'=> '50',
            'status' => StatusEnum::true->status(),
            'required' => StatusEnum::true->status(),
            'default' => StatusEnum::true->status(),
            'multiple' => StatusEnum::false->status()
        ],

        [
            'order'=> 7,
            'labels' => 'phone',
            'name' => 'phone',
            'placeholder' => 'Enter Your Phone Number',
            'type' => 'text',
            'width'=> '50',
            'status' => StatusEnum::true->status(),
            'required' => StatusEnum::true->status(),
            'default' => StatusEnum::true->status(),
            'multiple' => StatusEnum::false->status()
        ],

        [
            'order'=> 6,
            'labels' => 'Country Code',
            'name' => 'country_code',
            'placeholder' => 'Enter Your Phone Number',
            'type' => 'select',
            'width'=> '50',
            'status' => StatusEnum::true->status(),
            'required' => StatusEnum::true->status(),
            'default' => StatusEnum::true->status(),
            'multiple' => StatusEnum::false->status()
        ],

        [
            'order'=> 8,
            'labels' => 'Password',
            'name' => 'password',
            'placeholder' => 'Enter Password',
            'type' => 'password',
            'width'=> '50',
            'status' => StatusEnum::true->status(),
            'required' => StatusEnum::true->status(),
            'default' => StatusEnum::true->status(),
            'multiple' => StatusEnum::false->status()
        ],
        [
            'order'=> 9,
            'labels' => 'Confirm Password',
            'name' => 'password_confirmation',
            'placeholder' => 'Enter Confirm password',
            'type' => 'password',
            'width'=> '50',
            'status' => StatusEnum::true->status(),
            'required' => StatusEnum::true->status(),
            'default' => StatusEnum::true->status(),
            'multiple' => StatusEnum::false->status()
        ],


    ],

    'file_types'=> ['3dmf',    '3dm',    'avi',    'ai',    'bin',    'bin',    'bmp',    'cab',    'c',    'c++',    'class',    'css',    'csv',    'cdr',    'doc',    'dot',    'docx',    'dwg',    'eps',    'exe',    'gif',    'gz',    'gtar',    'flv',    'fh4',    'fh5',    'fhc',    'help',    'hlp',    'html',    'htm',    'ico',    'imap',    'inf',    'jpe',    'jpeg',    'jpg',    'js',    'java',    'latex',    'log',    'm3u',    'midi',    'mid',    'mov',    'mp3',    'mpeg',    'mpg',    'mp2',    'ogg',    'phtml',    'php',    'pdf',    'pgp',    'png',    'pps',    'ppt',    'ppz',    'pot',    'ps',    'qt',    'qd3d',    'qd3',    'qxd',    'rar',    'ra',    'ram',    'rm',    'rtf',    'spr',    'sprite',    'stream',    'swf',    'svg',    'sgml',    'sgm',    'tar',    'tiff',    'tif',    'tgz',    'tex',    'txt',    'vob',    'wav',    'wrl',    'wrl',    'xla',    'xls',    'xls',    'xlc',    'xml',    'xlsx',    'zip'],

    "role_permissions" =>[

        "language" => [
            "view_language",
            "translate_language",
            "create_language",
            "update_language",
            "delete_language",
        ],

        "service" => [
            "view_service",
            "create_service",
            "update_service",
            "delete_service",
        ],
        "portfolio" => [
            "view_portfolio",
            "create_portfolio",
            "update_portfolio",
            "delete_portfolio",
        ],
        "process" => [
            "view_process",
            "create_process",
            "update_process",
            "delete_process",
        ],
        "team" => [
            "view_team",
            "create_team",
            "update_team",
            "delete_team",
        ],
        "product" => [
            "view_product",
            "create_product",
            "update_product",
            "delete_product",
        ],

        "staff" => [
            "view_staff",
            "create_staff",
            "update_staff",
            "delete_staff",
        ],



        "role" => [
            "view_role",
            "create_role",
            "update_role",
            "delete_role",
        ],




        "frontend" => [
            "view_frontend",
            "update_frontend",
        ],

        "gateway" => [
            "view_gateway",
            "update_gateway",
        ],

        "notification_template" => [
            "view_template",
            "update_template"
        ],


        "notification" => [
            "view_notification",
        ],

        "settings" => [
            "view_settings",
            "update_settings"
        ],

        "dashboard" => [
            "view_dashboard"
        ]

    ],

    "file_path" =>  [
        'profile' => [
            'admin' => [
                'path' => 'assets/images/backend/profile',
                'size' => '150x150',
            ],
            'user' => [
                'path' => 'assets/images/frontend/profile',
                'size' => '150x150',
            ],
        ],

        'site_logo' => [
            'path' => 'assets/images/backend/site_logo',
            'size' => '150x50',
        ],

       
        'service_method' => [
            'path' => 'assets/images/backend/service_method',
            'size' => '740x986',
        ],
        'portfolio_method' => [
            'path' => 'assets/images/backend/portfolio_method',
            'size' => '1901x921',
        ],
        'process_method' => [
            'path' => 'assets/images/backend/process_method',
            'size' => '1901x921',
        ],
        'process_method' => [
            'path' => 'assets/images/backend/team_method',
            'size' => '1901x921',
        ],

        'team_method' => [
            'path' => 'assets/images/backend/section_method',
            'size' => '1380x920',
        ],


        'payment_method' => [
            'path' => 'assets/images/backend/payment_method',
            'size' => '100x100',
        ],

        'user_site_logo' => [
            'path' => 'assets/images/frontend/site_logo',
            'size' => '150x50',
        ],

        'favicon' => [
            'path' => 'assets/images/global/favicon',
            'size' => '25x25',
        ],


        'cta' => [
            'path' => 'assets/images/global/cta',
            'size' => '60x60',
        ],


        'category' => [
            'path' => 'assets/images/global/category',
            'size' => '80x80',
        ],

        'frontend' => [
            'path' => 'assets/images/global/frontend',
        ],


        'payment' => [
            'path' => 'assets/images/global/payment',
        ],

        'ticket' => [
            'path' => 'assets/files/global/ticket',
        ],
    ],

    "payment_methods" => [

        "bkash" => [
            "code" => "bkash",
            "serial_id" => "1",
            "currency" => "BDT",
            "currency_symbol" => "৳",
            "supported_currency" => [
                'BDT'
            ],
            "parameters" =>
                [
                     "api_key" => "#",
                     "username" => "#",
                     "password" => "#",
                     "api_secret" => "#",
                     "sandbox" => StatusEnum::true->status()
                ],
            "extra_parameters" =>
                [
                    "callback"=>"ipn"
                ]
            ,
        ],

        "nagad" => [
            "code" => "nagad",
            "serial_id" => "1",
            "currency" => "BDT",
            "currency_symbol" => "৳",
            "supported_currency" =>
                [
                  'BDT'
                ],
            "parameters" =>
                [
                     "pub_key" => "#",
                     "pri_key" => "#",
                     "marchent_number" => "#",
                     "marchent_id" => "#",
                     "sandbox" => StatusEnum::true->status()
                ],
            "extra_parameters" =>
                [
                    "callback"=>"ipn"
                ],
        ],

        "paypal" => [
            "code" => "paypal",
            "serial_id" => "3",
            "currency" => "USD",
            "currency_symbol" => "$",
            "supported_currency" =>
                [
                  'AUD',
                  'BRL',
                  'CAD',
                  'DKK',
                  'EUR',
                  'HKD',
                  'HUF',
                  'INR',
                  'JPY',
                  'MYR',
                  'MXN',
                  'TWD',
                  'NZD',
                  'PHP',
                  'PLN',
                  'GBP',
                  'RUB',
                  'SGD',
                  'SEK',
                  'CHF',
                  'THB',
                  'USD'
                ],
            "parameters" =>
                [
                     "cleint_id" => "#",
                     "secret" => "#",

                ],
            "extra_parameters" =>
                [],
        ],

        "stripe" => [
            "code" => "stripe",
            "serial_id" => "4",
            "currency" => "USD",
            "currency_symbol" => "$",
            "supported_currency" =>
                [
                  'USD',
                  'AUD',
                  'BRL',
                  'CAD',
                  'CHF',
                  'DKK',
                  'EUR',
                  'GBP',
                  'HKD',
                  'INR',
                  'JPY',
                  'MXN',
                  'MYR',
                  'NOK',
                  'NZD',
                  'PLN',
                  'SEK',
                  'SGD'

                ],
            "parameters" =>
                [
                     "secret_key" => "#",
                     "publishable_key" => "#",

                ],
            "extra_parameters" =>
                [],
        ],

        "paytm" => [
            "code" => "paytm",
            "serial_id" => "5",
            "currency" => "INR",
            "currency_symbol" => "INR",
            "supported_currency" =>
                [
                  "AUD",
                  "ARS",
                  "BDT",
                  "BRL",
                  "BGN",
                  "CAD",
                  "CLP",
                  "CNY",
                  "COP",
                  "CZK",
                  "DKK",
                  "EGP",
                  "EUR",
                  "GEL",
                  "GHS",
                  "HUF",
                  "INR",
                  "IDR",
                  "ILS",
                  "JPY","KES","MYR","MXN","MAD","NPR","NZD","NGN","PKR",'PEN','PHP','PLN','RON','RUB','SGD','ZAR','KRW','LKR','SEK','CHF','THB','TRY','UGX','UAH','AED','GBP','USD','VND','XOF',
                ],
            "parameters" =>
                [
                     "MID" => "#",
                     "merchant_key" => "#",
                     "WEBSITE" => "#",
                     "INDUSTRY_TYPE_ID" => "#",
                     "CHANNEL_ID" => "#",
                     "transaction_url" => "#",
                     "transaction_status_url" => "#"
                ],
            "extra_parameters" =>
                [],
        ],

        "payeer" => [
            "code" => "payeer",
            "serial_id" => "6",
            "currency" => "RUB",
            "currency_symbol" => "RUB",

            "supported_currency" =>
                [
                 "USD",
                 "EUR",
                 "RUB",
                ],
            "parameters" =>
                [
                     "merchant_id" => "#",
                     "secret_key" => "#",

                ],
            "extra_parameters" =>
                [
                    "status"=>"ipn"
                ],
        ],

        "paystack" => [
            "code" => "paystack",
            "serial_id" => "7",
            "currency" => "NGN",
            "currency_symbol" => "NGN",

            "supported_currency" =>
                [
                 "USD",
                 "NGN",

                ],

            "parameters" =>
                [
                     "public_key" => "#",
                     "secret_key" => "#",

                ],
            "extra_parameters" =>
                [
                    "callback"=>"ipn",
                    "webhook"=>"ipn"
                ]
            ,
        ],


        "voguepay" => [
            "code" => "voguepay",
            "serial_id" => "8",
            "currency" => "USD",
            "currency_symbol" => "USD",

            "supported_currency" =>
                [
                    "NGN", "USD", "EUR", "GBP", "ZAR", "JPY", "INR", "AUD", "CAD", "NZD", "NOK", "PLN"
                ],

            "parameters" =>
                [
                     "merchant_id" => "#",

                ],
            "extra_parameters" =>
                [

                ],
        ],

        "flutterwave" => [
            "code" => "flutterwave",
            "serial_id" => "9",
            "currency" => "USD",
            "currency_symbol" => "USD",

            "supported_currency" =>
                [
                    "KES", "GHS", "NGN", "USD", "GBP", "EUR", "UGX", "TZS"
                ],

            "parameters" =>
                [
                     "public_key" => "#",
                     "secret_key" => "#",
                     "encryption_key" => "#"

                ],
            "extra_parameters" =>
                [

                ],
        ],

        "razorpay" => [
            "code" => "razorpay",
            "serial_id" => "10",
            "currency" => "INR",
            "currency_symbol" => "INR",

            "supported_currency" =>
                [
                   "INR"
                ],

            "parameters" =>
                [
                     "key_id" => "#",
                     "key_secret" => "#"

                ]
           ,
            "extra_parameters" =>
                [

                ],
        ],

        "instamojo" => [
            "code" => "instamojo",
            "serial_id" => "11",
            "currency" => "INR",
            "currency_symbol" => "INR",

            "supported_currency" =>
                [
                   "INR"
                ],

            "parameters" =>
                [
                     "api_key" => "#",
                     "auth_token" => "#",
                     "salt" => "#"

                ],
            "extra_parameters" =>
                [

                ]
            ,
        ],

        "mollie" => [
            "code" => "mollie",
            "serial_id" => "12",
            "currency" => "USD",
            "currency_symbol" => "USD",

            "supported_currency" =>
                [
                    "AED", "AUD", "BGN", "BRL", "CAD", "CHF", "CZK", "DKK", "EUR", "GBP", "HKD", "HRK", "HUF", "ILS",
                    "ISK", "JPY", "MXN", "MYR", "NOK", "NZD", "PHP", "PLN", "RON", "RUB", "SEK", "SGD", "THB", "TWD",
                    "USD", "ZAR"
                ],

            "parameters" =>
                [
                     "api_key" => "#",


                ],
            "extra_parameters" =>
                [

                ],
        ],

        "authorize.net" => [
            "code" => "authorizenet",
            "serial_id" => "13",
            "currency" => "USD",
            "currency_symbol" => "USD",

            "supported_currency" =>
                [
                    "AUD", "CAD", "CHF", "DKK", "EUR", "GBP", "NOK", "NZD", "PLN", "SEK", "USD"
                ],

            "parameters" =>
                [
                     "login_id" => "#",
                     "current_transaction_key" => "#"

                ],
            "extra_parameters" =>
                [

                ],
        ],

        "securionpay" => [
            "code" => "securionpay",
            "serial_id" => "14",
            "currency" => "USD",
            "currency_symbol" => "USD",

            "supported_currency" =>
                [
                    "AFN", "DZD", "ARS", "AUD", "BHD", "BDT", "BYR", "BAM", "BWP", "BRL", "BND", "BGN", "CAD", "CLP", "CNY",
                    "COP", "KMF", "HRK", "CZK", "DKK", "DJF", "DOP", "EGP", "ETB", "ERN", "EUR", "GEL", "HKD", "HUF", "ISK",
                    "INR", "IDR", "IRR", "IQD", "ILS", "JMD", "JPY", "JOD", "KZT", "KES", "KWD", "KGS", "LVL", "LBP", "LTL",
                    "MOP", "MKD", "MGA", "MWK", "MYR", "MUR", "MXN", "MDL", "MAD", "MZN", "NAD", "NPR", "ANG", "NZD", "NOK",
                    "OMR", "PKR", "PEN", "PHP", "PLN", "QAR", "RON", "RUB", "SAR", "RSD", "SGD", "ZAR", "KRW", "IKR", "LKR",
                    "SEK", "CHF", "SYP", "TWD", "TZS", "THB", "TND", "TRY", "UAH", "AED", "GBP", "USD", "VEB", "VEF", "VND",
                    "XOF", "YER", "ZMK"
                ],

            "parameters" =>
                [
                     "public_key" => "#",
                     "secret_key" => "#"
                ],
            "extra_parameters" =>
                [

                ],
        ],

        "payumoney" => [
            "code" => "payumoney",
            "serial_id" => "15",
            "currency" => "INR",
            "currency_symbol" => "INR",

            "supported_currency" => (
                [
                   "INR"
                ]
            ),

            "parameters" => (
                [
                     "merchant_key" => "#",
                     "salt" => "#"
                ]
            ),
            "extra_parameters" => (
                [

                ]
            ),
        ],

        "mercadopago" => [
            "code" => "mercadopago",
            "serial_id" => "16",
            "currency" => "BRL",
            "currency_symbol" => "BRL",

            "supported_currency" => (
                [
                    "ARS", "BOB", "BRL", "CLF", "CLP", "COP", "CRC", "CUC", "CUP", "DOP", "EUR", "GTQ", "HNL", "MXN", "NIO",
                    "PAB", "PEN", "PYG", "USD", "UYU", "VEF", "VES"
                ]
            ),

            "parameters" => (
                [
                     "access_token" => "#",

                ]
            ),
            "extra_parameters" => (
                [

                ]
            ),
        ],

        "cashmaal" => [
            "code" => "cashmaal",
            "serial_id" => "17",
            "currency" => "PKR",
            "currency_symbol" => "PKR",

            "supported_currency" => (
                [
                    "USD","PKR"
                ]
            ),

            "parameters" => (
                [
                     "web_id" => "#",
                     "ipn_key" => "#"
                ]
            ),
            "extra_parameters" => (
                [
                  "ipn_url" => "ipn"
                ]
            ),
        ],

        "block.io" => [
            "code" => "blockio",
            "serial_id" => "18",
            "currency" => "BTC",
            "currency_symbol" => "BTC",

            "supported_currency" => (
                [
                    "BTC", "LTC", "DOGE"
                ]
            ),

            "parameters" => (
                [
                     "api_pin" => "#",
                     "api_key" => "#",

                ]
            ),
            "extra_parameters" => json_encode(
                [
                  "cron" => "ipn"
                ]
            ),
        ]

    ] ,

    "notification_template" => [

        "PASSWORD_RESET" => [
            "name" => "Password Reset",
            "subject" => "Password Reset",
            "body" => "We have received a request to reset the password for your account on {{code}} and Request time {{time}}",
            "sms_body" => "",
            "sort_code" => [
                'code' => "Password Reset Code",
                'time' => "Password Reset Time",
            ]
        ],

        "PASSWORD_RESET_CONFIRM" => [
            "name" => "Password Reset Confirm",
            "subject" => "Password Reset Confirm",
            "body" => "<p>We have received a request to reset the password for your account on {{code}} and Request time {{time}}</p>",
            "sms_body" => "",
            "sort_code" => ([
                'code' => "Password Reset Code",
                'time' => "Password Reset Time",
            ])
        ],

        "REGISTRATION_VERIFY" => [
            "name" => "Registration Verify",
            "subject" => "Registration Verify",
            "body" => "<p> We have received a request to create an account, you need to verify email first, your    verification code is {{code}} and request time {{time}}</p>",
            "sms_body" => "",
            "sort_code" => ([
                'code' => "Verification Code",
                'time' => "Time",
            ])
        ],


        "OTP_VERIFY" => [
            "name" => "OTP Verificaton",
            "subject" => "OTP Verificaton",
            "body" => "",
            "sms_body" => "Your Otp {{otp}} and request time {{time}}",
            "sort_code" => ([
                'otp' => "otp",
                'time' => "Time",
            ])
        ],


        "SUBSCRIPTION_EXPIRED" => [
            "name" => "Subscription Expired",
            "subject" => "Subscription Expired",
            "body" => "Your {{name}} Package Subscription Has Been Expired!! at time {{time}}",
            "sms_body" => "",
            "sort_code" => ([
                'time' => "Time",
                'name' => "Package Name",
            ])
        ],


        "SUPPORT_TICKET_REPLY" => [
            "name" => "Support Ticket",
            "subject" => "Support Ticket Reply",
            "body" => "<p>Hello Dear ! To provide a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket &nbsp;<a style=\"background-color:#13C56B;border-radius:4px;color:#fff;display:inline-flex;font-weight:400;line-height:1;padding:5px 10px;text-align:center:font-size:14px;text-decoration:none;\" href=\"{{link}}\">Link</a></p>",
            "sms_body" => "Hello Dear ! To get a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket.  {{link}}",
            "sort_code" => ([
                'ticket_number' => "Support Ticket Number",
                'link' => "Ticket URL For relpy",
            ])
        ],

        "TEST_MAIL" => [
            "name" => "Mail Configuration Test",
            "subject" => "Test Mail",
            "body" => "<h5>This is testing mail for mail configuration.</h5><h5>Request time<span style=\"background-color: rgb(255, 255, 0);\"> {{time}}</span></h5>",
            "sms_body" => "",
            "sort_code" => ([
                'time' => "Time",
            ])
        ],

        "TICKET_REPLY" => [
            "name" => "Ticket Replay",
            "subject" => "Support Ticket Reply",
            "body" => "<p>Hello Dear! ({{role}}) {{name}}!! Just Replied To A Ticket..  To provide a response to Ticket ID {{ticket_number}},&nbsp;<br>kindly click the link provided below in order to reply to the ticket. <a style=\"background-color:#13C56B;border-radius:4px;color:#fff;display:inline-flex;font-weight:400;line-height:1;padding:5px 10px;text-align:center:font-size:14px;text-decoration:none;\" href=\"{{link}}\">Link</a></p>",
            "sms_body" => "Hello Dear! ({{role}}) {{name}}!! Just Replied To A Ticket..
            To provide a response to Ticket ID {{ticket_number}}, kindly click the link provided below in order to reply to the ticket.  {{link}}",

            "sort_code" => ([
                'role' => "Admin Role",
                'name' => "Admin/Agent/User Name",
                'ticket_number' => "Support Ticket Number",
                'link' => "Ticket URL For relpy"
            ])
        ],

        "CONTACT_REPLY" => [
            "name" => "Contact Message",
            "subject" => "Contact Message reply",
            "body" => "Hello Dear! {{email}} {{message}}",
            "sms_body" => "",
            "sort_code" => ([
                'email' => "email",
                'message' => "message"
            ])
        ]

    ] ,





    "mail_gateway" => [
        '101SMTP' => [
            "name" => "SMTP",
            "credential" => ([
                'driver' => "#",
                'host' => "#",
                'port' => "#",
                'encryption' => "#",
                'username' => "#",
                'password' => "#",
                "from" => [
                    "address" => "#",
                    "name" => "#",
                ]
            ]),
            'default' => StatusEnum::true->status()
        ],

        '104PHP' => [
            "name" => "PHP MAIL",
            "credential" => []
        ],
        '102SENDGRID' => [
            "name" => "SendGrid Api",
            "credential" => ([
                'app_key' => "#",
                "from" => [
                    "address" => "#",
                    "name" => "#",
                ]

            ])
        ]

    ]


];
