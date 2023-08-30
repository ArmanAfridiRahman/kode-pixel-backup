<?php

namespace Database\Seeders\Admin;

use App\Models\Seo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SeoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    

        $existingSetup = Seo::pluck('identifier')->toArray();

        /** page name must be unqiue */
        $settings = [

            "home" =>[
                "title" => [
                    'en'=>"home"
                ],

                "slug" => "/",

                "meta_title" => [
                    'en'=>"home"
                ],

                "meta_description" => [
                    'en'=>"home"
                ],

                "meta_keywords" => [
                    "home"
                ],
            ],

     
       

            "contacts" =>[
                "title" => [
                    'en'=>"contacts"
                ],

                "slug" => "contacts",
                

                "meta_title" => [
                    'en'=>"contacts"
                ],

                "meta_description" => [
                    "contacts"
                ],

                "meta_keywords" => [
                    "contacts"
                ],
            ],


            "feedback" =>[
                "title" => [
                    'en'=>"feedback"
                ],

                "slug" =>"feedback",

                "meta_title" => [
                    'en'=>"feedback"
                ],

                "meta_description" => [
                    'en'=>"feedback"
                ],

                "meta_keywords" => [
                    "feedback"
                ],
            ],



            "login" =>[
                "title" => [
                    'en'=>"login"
                ],

                "slug" =>"login",

                "meta_title" => [
                    'en'=>"login"
                ],

                "meta_description" => [
                    'en'=>"login"
                ],

                "meta_keywords" => [
                    "login"
                ],
            ],

            "register" =>[
                "title" => [
                    'en'=>"register"
                ],

                "slug" =>"register",

                "meta_title" => [
                    'en'=>"register"
                ],

                "meta_description" => [
                    'en'=>"register"
                ],

                "meta_keywords" => [
                    "register"
                ],
            ],
            
            "verification" =>[
                "title" => [
                    'en'=>"auth_verification"
                ],

                "slug" =>"verification",

                "meta_title" => [
                    'en'=>"auth_verification"
                ],

                "meta_description" => [
                    'en'=>"auth_verification"
                ],

                "meta_keywords" => [
                    "auth_verification"
                ],
            ],
            
        ];

        foreach($settings as $key => $value){
            if(!in_array($key,$existingSetup)){
                Seo::create([
                    'identifier' =>  $key,
                    'title' => $value['title'],
                    'slug' =>  $value['slug'],
                    'meta_title' =>  $value['meta_title'],
                    'meta_description' =>  $value['meta_description'],
                    'meta_keywords' =>  $value['meta_keywords'],
                ]);
            }
        }
        optimize_clear();

   
    }
}
