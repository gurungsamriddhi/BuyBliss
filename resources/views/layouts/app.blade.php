<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BuyBliss</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <header class="sticky top-0 z-50 bg-white">

      <!-- Debugging code placed here -->
        <div class="bg-yellow-100 p-2 text-sm">
            @auth
                <p> Authenticated user: {{ Auth::user()->name ?? 'Unknown' }} (ID: {{ Auth::id() }})</p>
            @else
                <p>Not authenticated user</p>
            @endauth
        </div>



        <nav aria-label="Global" class="flex items-center justify-between p-6 lg:px-8">
            <div class="flex lg:flex-1">
                <a href="route{{ 'home' }}" class="-m-1.5 p-1.5">
                    <span class="sr-only">BuyBliss</span>
                    <!--if logo is made <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600" alt="" class="h-8 w-auto" />-->
                </a>
            </div>
            <div class="flex lg:hidden">
                <button type="button" command="show-modal" commandfor="mobile-menu"
                    class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Open main menu</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" data-slot="icon"
                        aria-hidden="true" class="size-6">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            <div class="hidden lg:flex lg:gap-x-12">
                <a href="{{ route('home') }}" class="text-sm/6 font-semibold text-gray-900">Home</a>
                <a href="{{ route('browse') }}" class="text-sm/6 font-semibold text-gray-900">Browse</a>
                <a href="{{ route('contact') }}" class="text-sm/6 font-semibold text-gray-900">Contact us</a>
                <a href="{{ route('about') }}" class="text-sm/6 font-semibold text-gray-900">About us</a>
                <a href="{{ route('become-seller') }}" class="text-sm/6 font-semibold text-gray-900">Become a seller</a>
            </div>
            <div class="hidden lg:flex lg:flex-1 lg:justify-end lg:gap-x-8">
                @auth
                    <a href="{{ route('profile.edit') }}" class="text-sm/6 font-semibold text-gray-900"> Profile</a>
                    <form action="{{ route('logout') }}" method ="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-sm/6 font-semibold text-gray-900">Log out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-sm/6 font-semibold text-gray-900">Log in <span
                            aria-hidden="true">&rarr;</span></a>
                    <a href="{{ route('register') }}" class="text-sm/6 font-semibold text-gray-900">Register <span
                            aria-hidden="true">&rarr;</span></a>
                @endauth


            </div>
        </nav>

        <!--Mobile Menu -->
        <el-dialog>
            <dialog id="mobile-menu" class="backdrop:bg-transparent lg:hidden">
                <div tabindex="0" class="fixed inset-0 focus:outline-none">
                    <el-dialog-panel
                        class="fixed inset-y-0 right-0 z-50 w-full overflow-y-auto bg-white p-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
                        <div class="flex items-center justify-between">
                            <a href="#" class="-m-1.5 p-1.5">
                                <span class="sr-only">Your Company</span>
                                <img src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=600"
                                    alt="" class="h-8 w-auto" />
                            </a>
                            <button type="button" command="close" commandfor="mobile-menu"
                                class="-m-2.5 rounded-md p-2.5 text-gray-700">
                                <span class="sr-only">Close menu</span>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                    data-slot="icon" aria-hidden="true" class="size-6">
                                    <path d="M6 18 18 6M6 6l12 12" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-6 flow-root">
                            <div class="-my-6 divide-y divide-gray-500/10">
                                <div class="space-y-2 py-6">
                                    <a href="{{ route('home') }}"
                                        class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Home</a>
                                    <a href="{{ route('browse') }}"
                                        class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Browse</a>
                                    <a href="{{ route('contact') }}"
                                        class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Contact
                                        us</a>
                                    <a href="{{ route('about') }}"
                                        class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">About
                                        us</a>
                                    <a href="{{ route('become-seller') }}"
                                        class="-mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Become
                                        a seller</a>
                                </div>
                                <div class="py-6">
                                    @auth
                                        <a href="{{ route('profile.edit') }}"
                                            class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Profile</a>
                                        <form action="{{ route('logout') }}" method="POST"
                                            class="-mx-3 block rounded-lg px-3 py-2.5">
                                            @csrf
                                            <button type="submit"
                                                class="text-base/7 font-semibold text-gray-900 hover:bg-gray-50 w-full text-left">Log
                                                out</button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Log
                                            in</a>
                                        <a href="{{ route('register') }}"
                                            class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-50">Register</a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </el-dialog-panel>
                </div>
            </dialog>
        </el-dialog>
    </header>
    </header>

    {{-- Page Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    <!-- component -->
    <footer class="relative w-full bg-white">
        <div class="mx-auto w-full max-w-7xl px-4">

            <!-- Footer Navigation Links -->
            <div
                class="mx-auto grid w-full grid-cols-1 gap-8 py-12 justify-items-center md:grid-cols-2 lg:grid-cols-4">
                <!-- Column: Company -->
                <ul>
                    <p class="font-sans text-base font-semibold opacity-50 mb-2">Company</p>
                    <li><a href="{{ route('about') }}" class="text-base py-1 hover:text-primary">About us</a></li>
                    <li><a href="#" class="text-base py-1 hover:text-primary">Careers</a></li>
                    <li><a href="#" class="text-base py-1 hover:text-primary">Press</a></li>
                    <li><a href="#" class="text-base py-1 hover:text-primary">News</a></li>
                </ul>

                <!-- Column: Help Center -->
                <ul>
                    <p class="font-sans text-base font-semibold opacity-50 mb-2">Help Center</p>
                    <li><a href="#" class="text-base py-1 hover:text-primary">Discord</a></li>
                    <li><a href="#" class="text-base py-1 hover:text-primary">Twitter</a></li>
                    <li><a href="#" class="text-base py-1 hover:text-primary">GitHub</a></li>
                    <li><a href="{{ route('contact') }}" class="text-base py-1 hover:text-primary">Contact Us</a>
                    </li>
                </ul>

                <!-- Column: Resources -->
                <ul>
                    <p class="font-sans text-base font-semibold opacity-50 mb-2">Resources</p>
                    <li><a href="#" class="text-base py-1 hover:text-primary">Blog</a></li>
                    <li><a href="#" class="text-base py-1 hover:text-primary">Newsletter</a></li>
                    <li><a href="#" class="text-base py-1 hover:text-primary">Free Products</a></li>
                    <li><a href="#" class="text-base py-1 hover:text-primary">Affiliate Program</a></li>
                </ul>

                <!-- Column: Products -->
                <ul>
                    <p class="font-sans text-base font-semibold opacity-50 mb-2">Products</p>
                    <li><a href="#" class="text-base py-1 hover:text-primary">Templates</a></li>
                    <li><a href="#" class="text-base py-1 hover:text-primary">UI Kits</a></li>
                    <li><a href="#" class="text-base py-1 hover:text-primary">Icons</a></li>
                    <li><a href="#" class="text-base py-1 hover:text-primary">Mockups</a></li>
                </ul>
            </div>

            <!-- Footer Bottom Section -->
            <div class="mt-10 flex flex-col items-center justify-center gap-4 border-t border-stone-200 py-4">
                <small class="font-sans text-sm text-center">
                    © 2025 <a href="#" class="hover:underline">BuyBliss</a>. All Rights Reserved.
                </small>

                <!-- Social Media Links -->
                <!--later app store logo to encourage users to download the mobile app instead
      <div class="flex gap-2 mt-2 justify-center">
        <a href="#" class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-transparent text-stone-800 hover:bg-stone-200/10 transition">
          Example Facebook Icon
          <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path d="M17 2H14C12.6739 2 11.4021 2.52678 10.4645 3.46447C9.52678 4.40215 9 5.67392 9 7V10H6V14H9V22H13V14H16L17 10H13V7C13 6.73478 13.1054 6.48043 13.2929 6.29289C13.4804 6.10536 13.7348 6 14 6H17V2Z" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
        Add more icons as needed
      </div>-->
            </div>
        </div>
    </footer>

</body>

</html>
