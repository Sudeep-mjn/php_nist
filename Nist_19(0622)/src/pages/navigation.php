<nav class="bg-white shadow-md sticky top-0 z-50 dark:bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="#home" class="flex-shrink-0 flex items-center">
                    <img style="width: 65px; height: 65px;" src="images/logo.jpg" alt="NIST19 Logo">
                  
                    <!-- Wrap both <p> tags in a column -->
                    <div class="flex flex-col ml-2">
                      <p class="dark:text-white font-bold">नेपाल ईन्भेष्टमेण्ट एण्ड</p>
                      <p class="dark:text-white font-bold">सेक्युरिटिज ट्रेडिङ्ग (प्रा.) लि.</p>
                    </div>
                  </a>
                  
            <div class="hidden md:ml-6 md:flex md:items-center md:space-x-8">
                <a href="#home" class="text-primary hover:text-secondary px-3 py-2 font-medium dark:text-white">Home</a>
                
                <div class="relative group">
                    <button class="text-primary hover:text-secondary px-3 py-2 font-medium flex items-center dark:text-white">
                        Services <i class="fas fa-chevron-down ml-1 text-xs"></i> 
                    </button>
                    <div class="absolute z-10 left-0 mt-2 w-48 bg-white shadow-lg rounded-md py-1 hidden group-hover:block dark:bg-gray-700">
                        <a href="#services" class="block px-4 py-2 text-gray-800 hover:bg-primary hover:text-white dark:text-gray-200">All Services</a>
                        <a href="https://tms19.nepsetms.com.np/client-registration" target="_blank" class="block px-4 py-2 text-gray-800 hover:bg-primary hover:text-white dark:text-gray-200">Online Account Opening</a>
                        <a href="#purchase" class="block px-4 py-2 text-gray-800 hover:bg-primary hover:text-white dark:text-gray-200">Purchase Orders</a>
                        <a href="#ckyc" class="block px-4 py-2 text-gray-800 hover:bg-primary hover:text-white dark:text-gray-200">CKYC</a>
                    </div>
                </div>
                
                <a href="#about" class="text-primary hover:text-secondary px-3 py-2 font-medium dark:text-white">About Us</a>
                <a href="#contact" class="text-primary hover:text-secondary px-3 py-2 font-medium dark:text-white">Contact</a>
                
                <div class="relative group">
                    <button class="text-primary hover:text-secondary px-3 py-2 font-medium flex items-center dark:text-white">
                        Downloads <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <div class="absolute z-10 left-0 mt-2 w-64 bg-white shadow-lg rounded-md py-1 hidden group-hover:block dark:bg-gray-700">
                        <a href="pdf/KYC-individual-normal.pdf" target="_blank" class="block px-4 py-2 text-gray-800 hover:bg-primary hover:text-white dark:text-gray-200">KYC Individual (Normal)</a>
                        <a href="pdf/Agriment_new_individual.pdf" target="_blank" class="block px-4 py-2 text-gray-800 hover:bg-primary hover:text-white dark:text-gray-200">KYC Individual (Editable)</a>
                        <a href="pdf/company-kyc-form.pdf" target="_blank" class="block px-4 py-2 text-gray-800 hover:bg-primary hover:text-white dark:text-gray-200">KYC Company (Editable)</a>
                        <a href="pdf/new_Natural_Person_details.pdf" target="_blank" class="block px-4 py-2 text-gray-800 hover:bg-primary hover:text-white dark:text-gray-200">Online Trading Agreement (Editable)</a>
                        <a href="pdf/TMS-Request.pdf" target="_blank" class="block px-4 py-2 text-gray-800 hover:bg-primary hover:text-white dark:text-gray-200">TMS Request</a>
                    </div>
                </div>

                <!-- FAQ Button -->
                <a href="#faq" class="text-primary hover:text-secondary px-3 py-2 font-medium dark:text-white" >FAQ</a>

                <!-- Language Toggle Button -->
                <!-- <button id="language-toggle" class="text-primary hover:text-secondary px-3 py-2 font-medium flex items-center dark:text-white">
                    <span id="language-text">EN</span> <i class="fas fa-chevron-down ml-1 text-xs"></i>
                </button>
                
                <div id="google_translate_element" class="relative z-10 overflow-hidden w-28"></div> -->

                <!-- Dark Mode Toggle Button -->
                <!-- <button id="dark-mode-toggle" class="text-primary hover:text-secondary px-3 py-2 font-medium flex items-center dark:text-white">
                    <i class="fas fa-moon" id="dark-mode-icon"></i>
                </button> -->
            </div>
            
            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="mobile-menu-button" class="text-primary hover:text-secondary focus:outline-none dark:text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

        
        <!-- Mobile menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-white shadow-lg dark:bg-gray-700">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#home" class="block px-3 py-2 text-base font-medium text-primary hover:text-secondary dark:text-white">Home</a>
                
                <div class="relative">
                    <button id="services-menu-button" class="w-full text-left px-3 py-2 text-base font-medium text-primary hover:text-secondary flex justify-between items-center dark:text-white">
                        Services <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <div id="services-menu" class="hidden pl-4">
                        <a href="#services" class="block px-3 py-2 text-sm font-medium text-gray-800 hover:text-primary dark:text-gray-200">All Services</a>
                        <a href="#sales" class="block px-3 py-2 text-sm font-medium text-gray-800 hover:text-primary dark:text-gray-200">Sales Orders</a>
                        <a href="#purchase" class="block px-3 py-2 text-sm font-medium text-gray-800 hover:text-primary dark:text-gray-200">Purchase Orders</a>
                        <a href="#ckyc" class="block px-3 py-2 text-sm font-medium text-gray-800 hover:text-primary dark:text-gray-200">CKYC</a>
                    </div>
                </div>
                
                <a href="#commissions" class="block px-3 py-2 text-base font-medium text-primary hover:text-secondary dark:text-white">Commissions</a>
                <a href="#about" class="block px-3 py-2 text-base font-medium text-primary hover:text-secondary dark:text-white">About Us</a>
                <a href="#activities" class="block px-3 py-2 text-base font-medium text-primary hover:text-secondary dark:text-white">Activities</a>
                <a href="#contact" class="block px-3 py-2 text-base font-medium text-primary hover:text-secondary dark:text-white">Contact</a>
                
                <div class="relative">
                    <button id="downloads-menu-button" class="w-full text-left px-3 py-2 text-base font-medium text-primary hover:text-secondary flex justify-between items-center dark:text-white">
                        Downloads <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>
                    <div id="downloads-menu" class="hidden pl-4">
                        <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-800 hover:text-primary dark:text-gray-200">KYC Individual (Normal)</a>
                        <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-800 hover:text-primary dark:text-gray-200">KYC Individual (Editable)</a>
                        <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-800 hover:text-primary dark:text-gray-200">KYC Company (Editable)</a>
                        <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-800 hover:text-primary dark:text-gray-200">Online Trading Agreement (Editable)</a>
                        <a href="#" class="block px-3 py-2 text-sm font-medium text-gray-800 hover:text-primary dark:text-gray-200">TMS Request</a>
                    </div>
                </div>
                
                <!-- Language and Dark Mode Toggle for Mobile -->
                <!-- <div class="flex justify-between px-3 py-2">
                    <button id="mobile-language-toggle" class="text-primary font-medium dark:text-white">
                        <i class="fas fa-language mr-2"></i> <span id="mobile-language-text">English</span>
                    </button>
                    <button id="mobile-dark-mode-toggle" class="text-primary font-medium dark:text-white">
                        <i class="fas fa-moon mr-2" id="mobile-dark-mode-icon"></i> Dark Mode
                    </button>
                </div> -->
            </div>
        </div>
    </nav>