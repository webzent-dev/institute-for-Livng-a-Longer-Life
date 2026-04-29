@extends('front.layouts.app')

@section('content')


<section class="bg-gray-50 min-h-screen flex flex-col">
 
    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-12 flex flex-col items-center justify-center">
        <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12 max-w-4xl w-full">
            <div class=" items-center">
                <!-- Illustration Section -->
                <div class=" flex justify-center mb-10 ">
                    <div class="relative">
                        <div class="w-64 h-64 bg-gradient-to-r from-yellow-100 to-orange-100 rounded-full flex items-center justify-center">
                            <div class="w-48 h-48 bg-gradient-to-r from-yellow-200 to-orange-200 rounded-full flex items-center justify-center">
                                <div class="text-center">
                                    <div class="text-8xl font-bold text-gray-800">404</div>
                                    <div class="text-xl font-semibold text-gray-700 mt-2">Page Not Found</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Decorative elements -->
                        <div class="absolute -top-4 -left-4 w-20 h-20 bg-blue-100 rounded-full opacity-70"></div>
                        <div class="absolute -bottom-4 -right-4 w-16 h-16 bg-green-100 rounded-full opacity-70"></div>
                        <div class="absolute top-12 -right-8 w-12 h-12 bg-red-100 rounded-full opacity-70"></div>
                    </div>
                </div>
                
                <!-- Message Section -->
                <div class=" md:pl-12 text-center md:text-left">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Looking for something?</h1>
                    
                    <div class="space-y-4 mb-8">
                        <p class="text-gray-700 text-lg">
                            We're sorry. The page you're looking for cannot be found. It might have been moved, deleted, or perhaps you entered the wrong URL.
                        </p>
                        <p class="text-gray-700 text-lg">
                            Don't worry though! You can find plenty of amazing products on our homepage.
                        </p>
                        
                        <div class="bg-gray-50 p-4 rounded-lg border-l-4 border-yellow-400 mt-6">
                            <div class="flex items-start">
                                <i class="fas fa-lightbulb text-yellow-500 text-xl mr-3 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-gray-800 mb-1">Helpful Tips:</h3>
                                    <ul class="text-gray-700 text-sm space-y-1">
                                        <li>• Check the currect URL.</li>
                                        {{-- <li>• Use the search bar to find what you need</li> --}}
                                        <li>• Browse our categories for similar products</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Homepage Redirect Button -->
                    <div class="mt-8">
                        <a href="{{ url('/') }}" id="homeButton" class="inline-flex items-center justify-center px-8 py-4 text-lg font-medium rounded-lg bg-gradient-to-r from-yellow-400 to-orange-500 text-gray-900 hover:from-yellow-500 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fas fa-home mr-3"></i>
                            Go to Homepage
                        </a>
                    </div>
                    
                    <!-- Additional Links -->
                    <div class="mt-10 pt-6 border-t border-gray-200">
                        <p class="text-gray-600 mb-3">You might also want to:</p>
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 text-primary">
                            <a href="{{url('/cart')}}" class=" hover:text-accent hover:underline flex items-center">
                                <i class="fas fa-shopping-cart mr-2"></i> View Cart
                            </a>
                            <a href="{{url('/contact')}}" class="hover:text-accent hover:underline flex items-center">
                                <i class="fas fa-headset mr-2"></i> Contact Support
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
         
    </main>
 
</section>


    
    <script>
     setTimeout(() => {
         window.location.href = "{{ url('/') }}";
     }, 3000);  
</script>
 




@endsection