@props(['label' => '', 'wrapperClass'=>'', ])

<div class="form-check {{$wrapperClass}}">
    <input {!! $attributes->merge(['class' => 'form-check-input appearance-none rounded-full h-4 w-4 border border-gray-300 bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 my-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer']) !!} type="radio">
    <label class="form-check-label inline-block text-gray-800" for="{{ $attributes->get('id')}}">
        {{$label}}
      </label>
</div>
