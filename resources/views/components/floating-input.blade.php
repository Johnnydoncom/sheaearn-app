@props(['label' => '', 'wrapperClass'=>''])

<div class="form-floating {{$wrapperClass}}">
    <input {!! $attributes->merge(['class' => 'form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:ring-primary focus focus:border-primary focus:outline-none']) !!} id="floatingInput">
    <label for="floatingInput" class="text-gray-700">{{$label}}</label>
</div>
