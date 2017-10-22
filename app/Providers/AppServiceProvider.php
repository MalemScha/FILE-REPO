<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
       

        Validator::extend('is_mime', function($attribute, $value, $parameters, $validator) {
            $acceptedTypes = [
                "application/pdf",

                "image/vnd.adobe.photoshop",
                "image/png",
                "image/tiff",
                "image/jpeg",
                "image/gif",
                "image/svg+xml",
                "image/x-icon",

                "application/cdr",
                "application/coreldraw",
                "application/x-cdr",
                "application/x-coreldraw",
                "image/cdr",
                "image/x-cdr",
                "zz-application/zz-winassoc-cdr",


                "application/vnd.ms-excel",
                "application/pptx",
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                "application/vnd.ms-powerpoint",
                "application/vnd.openxmlformats-officedocument.presentationml.presentation",
                "application/vnd.openxmlformats-officedocument.presentationml.slideshow",
                "application/msword",
                "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                "application/rtf",

                "application/xml",
                "application/vnd.oasis.opendocument.text",
                "application/vnd.oasis.opendocument.spreadsheet",
                "application/vnd.oasis.opendocument.presentation	",

                "text/plain",

                "application/x-zip-compressed",
                 "application/zip",
                "application/x-rar-compressed",
                "application/x-7z-compressed",

                "video/mpeg",
                "video/mp4",
                "video/x-ms-wmv",

            ];
            $acceptedExt= [
                "doc",
                "docx",
                "ppt",
                "pps",
                "pptx",
                "ppxs",
                "xls",
                "xlsx",
                "psd",
                "xd",
                "cdr",
                "xml",
                "odt",
                "odp",
                "ods"

            ];
            $mimetype = "";
            $ext = "";
            foreach ($value as $file) {
                $mimetype = $file->getClientMimeType();
                $ext = $file->getClientOriginalExtension();
            }
            if(in_array($mimetype,$acceptedTypes)){
                return true;
            }elseif(in_array($ext,$acceptedExt)){
                return true;
            }
            return false;
        });


        Validator::extend('match', function($attribute, $value, $parameters, $validator) {

            $check = Hash::check($value, Auth::user()->password);

            if($check)
            {
                return true;
            }
            else {
                return false;
            }

        });

         Validator::extend('fill', function($attribute, $value, $parameters, $validator) {

          if ($value == '')
          {
              return false;
          }
          else{
              return true;
          }
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
