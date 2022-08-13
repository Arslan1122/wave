@if($paginator->hasPages())
<div class="flex flex-col items-center my-4">
    <div class="flex text-gray-700">
        <div wire:click="previousPage" class="h-12 w-12 mr-1 flex justify-center items-center rounded-full cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left w-6 h-6">
                <polyline points="15 18 9 12 15 6"></polyline>
            </svg>
        </div>
        <div class="flex h-12 font-medium rounded-full">
        @foreach ($elements as $element)
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <div wire:click="gotoPage({{$page}})" class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full border-blue-500 bg-gradient-to-r from-wave-500 via-blue-500 to-purple-600 text-white ">{{ $page }}</div>
                    @else    
                        <div wire:click="gotoPage({{$page}})" class="w-12 md:flex justify-center items-center hidden  cursor-pointer leading-5 transition duration-150 ease-in  rounded-full  ">{{ $page }}</div>
                    @endif    
                @endforeach
            @endif
        @endforeach
        </div>
        @if($paginator->hasMorePages())
        <div wire:click="nextPage" class="h-12 w-12 ml-1 flex justify-center items-center rounded-full cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right w-6 h-6">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
        @else
        <div class="h-12 w-12 ml-1 flex justify-center items-center rounded-full cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right w-6 h-6">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
        </div>
        @endif
    </div>
</div>
@endif