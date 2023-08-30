<?php

namespace Database\Seeders\Admin;
use App\Enums\StatusEnum;
use App\Models\Admin\Frontend;
use Illuminate\Database\Seeder;

class FrontendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $existingSetup = Frontend::pluck('slug')->toArray();



        $settings = [

                "banner_section" =>[
                    "static_element" => [
                        "primary_heading" => array(
                            "type" => "text",
                            "value" => ""
                        ),

                        "primary_short_description" => array(
                            "type" => "textarea",
                            "value" => ""
                        ),

                        "secondary_heading" => array(
                            "type" => "text",
                            "value" => ""
                        ),

                        "secondary_short_description" => array(
                            "type" => "textarea",
                            "value" => ""
                        ),

                        "banner_image" => array(
                            "type" => "file",
                            "value" => "",
                            "size" => "4000x6000"
                        ),
                    ]
                ],

                "about_section" =>[
                    "static_element" => [
                        "primary_heading" => array(
                            "type" => "text",
                            "value" => ""
                        ),
                        "primary_short_description" => array(
                            "type" => "textarea",
                            "value" => ""
                        ),
                        "banner_image" => array(
                            "type" => "file",
                            "value" => "",
                            "size" => "480x500"
                        ),
                    ]
                ],


                "service_section" =>[
                    "static_element" => [
                        "primary_heading" => array(
                            "type" => "text",
                            "value" => ""
                        ),
                    ]
                ],


                "portfolio_section" =>[
                    "static_element" => [
                        "primary_heading" => array(
                            "type" => "text",
                            "value" => ""
                        ),
                    ]
                ],

                "process_section" => [
                    "static_element" => [
                        "primary_heading" => array(
                            "type" => "text",
                            "value" => ""
                        ),
                    ]
                ],


                "product_section" => [
                    "static_element" => [
                        "primary_heading" => array(
                            "type" => "text",
                            "value" => ""
                        ),
                    ]

                ],

                "support_section" => [
                    "static_element" => [
                        "primary_heading" => array(
                            "type" => "text",
                            "value" => ""
                        ),
                        "banner_image" => array(
                            "type" => "file",
                            "value" => "",
                            "size" => "1901x921"
                        ),
                    ]

                ],

                "team_section" => [
                    "static_element" => [
                        "primary_heading" => array(
                            "type" => "text",
                            "value" => ""
                        ),

                        "primary_short_description" => array(
                            "type" => "textarea",
                            "value" => ""
                        ),
                    ]

                ],

                "contact_section" => [
                    "static_element" => [
                        "primary_heading" => array(
                            "type" => "text",
                            "value" => ""
                        ),

                        "primary_short_description" => array(
                            "type" => "textarea",
                            "value" => ""
                        ),
                        "phone_number" => array(
                            "type" => "text",
                            "value" => ""
                        ),
                        "email" => array(
                            "type" => "email",
                            "value" => ""
                        ),
                    ]
                ],
            ];


        $frontendSection = [];
        foreach($settings as $key=>$value){
            $newSection = [];
            if(!in_array($key,$existingSetup)){
                 $newSection['name'] = ucfirst(str_replace('_',' ',$key));
                 $newSection['slug'] = $key;
                 $newSection['value'] = json_encode($settings[$key]);
                 $newSection['status'] = StatusEnum::true->status();

                 array_push($frontendSection ,$newSection);
            }
        }
        Frontend::insert($frontendSection);

    }
}
