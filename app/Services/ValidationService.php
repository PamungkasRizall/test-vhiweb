<?php

namespace App\Services;

use App\Models\Tag;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ValidationService
{ 
    public static function login()
    {
        $validator = Validator::make(
            request()->all(), 
            [
                'email' => [
                    'required',
                    'email',
                    'string'
                ],
                'password' => [
                    'required',
                    'string'
                ]
            ]
        );

        if ($validator->fails())
            return $validator->messages()->first();

        return false;
    }

    public static function createPhoto()
    {
        $tags = Tag::pluck('id');

        $validator = Validator::make(
            request()->all(), 
            [
                'image' => [
                    'required'
                ],
                'caption' => [
                    'required',
                    'min:5'
                ],
                'tags' => [
                    'required',
                    'array',
                    Rule::in($tags)
                ]
            ]
        );

        if ($validator->fails())
            return $validator->messages()->first();

        return false;
    }

    public static function updatePhoto()
    {
        $tags = Tag::pluck('id');

        $validator = Validator::make(
            request()->all(), 
            [
                'caption' => [
                    'required',
                    'min:5'
                ],
                'tags' => [
                    'required',
                    'array',
                    Rule::in($tags)
                ]
            ]
        );

        if ($validator->fails())
            return $validator->messages()->first();

        return false;
    }
}