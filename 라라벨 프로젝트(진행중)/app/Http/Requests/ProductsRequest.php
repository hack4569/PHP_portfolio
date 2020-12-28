<?php
    protected $dontFlash = ['files'];

    public function rules()
    {
        return [
            'files'=>['array'],
            'files.*'=>['mimes:jpg,png,zip', 'max:30000'],
        ];
    }
