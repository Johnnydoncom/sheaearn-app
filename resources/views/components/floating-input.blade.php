@props(['label' => '','placeholder'=>'', 'inputClass'=>''])

<div {!! $attributes->merge(['class' => 'form-floating w-full']) !!}>
    <input type="email" class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none {{$inputClass}}" id="floatingInput" placeholder="{{$placeholder}}">
    <label for="floatingInput" class="text-gray-700">{{$label}}</label>
</div>
