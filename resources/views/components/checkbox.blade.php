@props(['label' => '', 'wrapperClass'=>'', ])

<div class="form-check {{$wrapperClass}}">
    <input {!! $attributes->merge(['class' => 'form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-primary checked:border-primary focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer']) !!} type="checkbox">
    <label class="form-check-label inline-block text-gray-800" for="{{ $attributes->get('id')}}">
        {{$label}}
    </label>
</div>
