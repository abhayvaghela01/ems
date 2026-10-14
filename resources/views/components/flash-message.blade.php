@if(session()->has('message'))
<div x-data="{ show: true }" 
     x-init="setTimeout(() => show = false, 2000)" 
     x-show="show" 
     class="fixed top-16 left-1/2 transform -translate-x-1/2 bg-green-500 text-green font-semibold px-6 py-3 rounded-md shadow-md transition-opacity duration-300 ease-in-out">
    <p>{{ session('message') }}</p>
</div>
@endif
