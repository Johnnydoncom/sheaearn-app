<x-app-layout>
    <x-slot name="title">{{ $entry->title }}</x-slot>

   <div>
       <div>
           @livewire('show-entry', ['entry'=>$entry, 'shareUrls'=>$shareUrls])
       </div>

       <div class="container mt-10 mb-10">
           <h2 class="font-semibold text-3xl mb-4">Related Products</h2>
           <div class="divider"></div>
           <div class='grid gap-2 lg:gap-4 grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 mb-3'>
               @foreach ($products as $product)
                   <div class="">
                   @livewire('product.product-layout-one', ['product'=>$product])
                   </div>
               @endforeach
           </div>
       </div>
   </div>
</x-app-layout>
