<div class="mb-[50px]">
    
<nav class="bg-white :bg-gray-900 fixed w-full z-20 top-0 left-0 border-b border-gray-200 :border-gray-600">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="#" class="flex items-center">
        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 mr-3" alt="Flowbite Logo">
        <span class="self-center text-2xl font-semibold whitespace-nowrap :text-white">{{ Auth::user()->role }}</span>
    </a>
    <div class="flex md:order-2">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="text-white bg-blue-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center mr-3 md:mr-0 :bg-blue-600 :hover:bg-blue-700 :focus:ring-blue-800">Log Out</button>
        </form>
        <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 :text-gray-400 :hover:bg-gray-700 :focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
          </svg>
      </button>
    </div>
    @if (Auth::user()->role === 'super admin')
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
        <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white :bg-gray-800 md::bg-gray-900 :border-gray-700">
          
          <x-nav-link :href="route('inventories')" :active="request()->routeIs('inventories')">
            Inventories
          </x-nav-link>
          <x-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')">
            Sales
          </x-nav-link>
          <x-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.index')">
            Purchases
        </x-nav-link>
        </ul>
      </div>
    @elseif (Auth::user()->role === 'sales')
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
        <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white :bg-gray-800 md::bg-gray-900 :border-gray-700">
          <x-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')">
            Sales
          </x-nav-link>
        </ul>
      </div>
    @elseif (Auth::user()->role === 'purchase')
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
        <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white :bg-gray-800 md::bg-gray-900 :border-gray-700">
          <x-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.index')">
            Purchases
        </x-nav-link>
        </ul>
      </div>
    @elseif (Auth::user()->role === 'manager')
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
        <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white :bg-gray-800 md::bg-gray-900 :border-gray-700">
          <x-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')">
            Sales
          </x-nav-link>
          <x-nav-link :href="route('purchases.index')" :active="request()->routeIs('purchases.index')">
            Purchases
        </x-nav-link>
        </ul>
      </div>
    @endif
    </div>
  </nav>  
</div>