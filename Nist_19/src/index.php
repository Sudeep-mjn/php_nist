<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NIST19 - Leading Stock Broker in Nepal</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Custom animations */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        
        .floating {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }
        
        /* Custom tooltip */
        .tooltip {
            position: relative;
            display: inline-block;
        }
        
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 200px;
            background-color: #333;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -100px;
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        /* Dark mode styles
        body.dark-mode {
            background-color: #1a202c;
            color: #e2e8f0;
        }

        body.dark-mode .bg-white {
            background-color: #2d3748;
        }

        body.dark-mode .text-gray-800,
        body.dark-mode .text-gray-700,
        body.dark-mode .text-gray-600 {
            color: #e2e8f0;
        }

        body.dark-mode .bg-gray-50 {
            background-color: #4a5568;
        }

        body.dark-mode .border-gray-200 {
            border-color: #4a5568;
        }

        body.dark-mode .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -1px rgba(0, 0, 0, 0.12);
        } */

        /* Notice section styles */
        .notice-container {
            position: fixed;
            right: 0;
            top: 0;
            height: 100vh;
            width: 300px;
            background-color: #f8f9fa;
            box-shadow: -2px 0 5px rgba(0,0,0,0.1);
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
            overflow-y: auto;
        }

        .notice-container.open {
            transform: translateX(0);
        }

        .notice-toggle {
                    position: fixed;
                    right: 0;
                    top: 50%;
                    transform: translateY(-50%) rotate(-90deg);
                    transform-origin: right center;
                    background-color: #37517E;
                    color: white;
                    padding: 10px 15px 30px 15px;
                    border-radius: 5px 5px 0 0;
                    cursor: pointer;
                    z-index: 1001;
                    transition: all 0.3s ease;
                    font-size: 14px;
                }
                .notice-toggle.open {
            right: 300px;
        }

         .notice-toggle.open {
            right: 300px;
        }

        @media (max-width: 768px) {
            .notice-container {
                width: 280px;
            }
            
            .notice-toggle {
                font-size: 12px;
                padding: 8px 12px;
            }
            
            .notice-toggle.open {
                right: 280px;
            }
        }

        @media (max-width: 480px) {
            .notice-container {
                width: 85vw;
            }
            
            .notice-toggle.open {
                right: 85vw;
            }
        }

          /* Section Dividers */
        .section-divider {
            position: relative;
            margin: 60px 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, #47B2E4, transparent);
        }
        
        .section-divider::before {
            content: "";
            position: absolute;
            left: 50%;
            top: -5px;
            transform: translateX(-50%);
            width: 10px;
            height: 10px;
            background: #47B2E4;
            border-radius: 50%;
        }

    
        
    </style>
 
</head>
<body class="font-sans antialiased text-gray-800">
    <!-- Splash Screen -->
    <!-- <div id="splash-screen" class="fixed inset-0 bg-primary flex items-center justify-center z-50 transition-opacity duration-500">
        <img src="images/logo.jpg" alt="NIST19 Logo" class="w-60 h-60 animate-pulse " style=" border-radius: 10%;"> 
        <h1 style="padding-left: 10px; font-size: 50px;color: white; font-weight: bold; " class="animate-pulse" >नेपाल ईन्भेष्टमेण्ट एण्ड सेक्युरिटिज ट्रेडिङ्ग (प्रा.) लि.</h1><br>

    </div> -->
    
    <!-- Notice Toggle Button -->
    <div class="notice-toggle" id="noticeToggle">
        <i class="fas fa-bell mr-2"></i> Notices
    </div>

    <!-- Notice Section -->
   <?php include'pages/notice.php'?>

    <!-- Top Bar -->
    <div class="bg-primary text-white text-sm py-2 px-4 flex justify-between items-center">
        <div class="flex space-x-4">
            <span><i class="fas fa-phone-alt mr-1"></i> +977 1-4782309</span>
            <span><i class="fas fa-envelope mr-1"></i> info@nist19.com</span>
        </div>
        <!-- <img src="images/logo.jpg" style="width: 100px; height:100px;"class=" mr-1" alt="logo"> -->
        <div class="flex space-x-3">
            <a href="https://www.facebook.com/nist19/?locale=ne_NP" target="_blank" class="hover:text-secondary"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="hover:text-secondary"><i class="fab fa-twitter"></i></a>
            <a href="#" class="hover:text-secondary"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="hover:text-secondary"><i class="fab fa-instagram"></i></a>
        </div>
    </div>

   <!-- Navigation -->
    <?php include'pages/navigation.php' ?>

   <!-- Hero Section -->
    <?php include'hero.php' ?>

    <!-- <div class="section-divider"></div> -->

    <!-- Services Section -->
    <?php include'pages/services.php'?>

    <!-- FAQ Section -->
    <?php include'pages/faq.php'?>
    <!-- comission section  -->
    <?php include'pages/comission.php' ?>

    <!-- About Us Section -->
   <?php include'pages/about.php' ?>

    <!-- Activities Section -->
   <?php include'pages/activity.php'?>

    <!-- Our Presence Section -->
   <?php include'pages/ourPresence.php' ?>

      <!-- Contact Section -->
    <?php include'pages/contact.php'?>

   <!-- Footer section -->
    <?php include 'footer.php'; ?>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-6 right-6 bg-secondary text-white p-3 rounded-full shadow-lg hover:bg-blue-600 transition duration-300 hidden">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>

         // Splash Screen
        const splashScreen = document.getElementById('splash-screen');
        window.addEventListener('load', () => {
            setTimeout(() => {
                splashScreen.style.opacity = '0';
                setTimeout(() => {
                    splashScreen.style.display = 'none';
                }, 500);
            }, 1500); // Show for 1.5 seconds
        });

        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
                
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
                
        // Mobile submenu toggles
        const servicesMenuButton = document.getElementById('services-menu-button');
        const servicesMenu = document.getElementById('services-menu');
        const downloadsMenuButton = document.getElementById('downloads-menu-button');
        const downloadsMenu = document.getElementById('downloads-menu');
                
        servicesMenuButton.addEventListener('click', () => {
            servicesMenu.classList.toggle('hidden');
        });
                
        downloadsMenuButton.addEventListener('click', () => {
            downloadsMenu.classList.toggle('hidden');
        });
                
        // Back to top button
        const backToTopButton = document.getElementById('back-to-top');
                
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('hidden');
            } else {
                backToTopButton.classList.add('hidden');
            }
        });
                
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
                
        // Form submission (placeholder)
        const contactForm = document.querySelector('form');
        if (contactForm) {
            contactForm.addEventListener('submit', (e) => {
                e.preventDefault();
                alert('Thank you for your message! We will get back to you soon.');
                contactForm.reset();
            });
        }

        // Notice Section Toggle
        const noticeToggle = document.getElementById('noticeToggle');
        const noticeContainer = document.getElementById('noticeContainer');
        const closeNotice = document.getElementById('closeNotice');

        noticeToggle.addEventListener('click', () => {
            noticeContainer.classList.toggle('open');
            noticeToggle.classList.toggle('open');
        });

        closeNotice.addEventListener('click', () => {
            noticeContainer.classList.remove('open');
            noticeToggle.classList.remove('open');
        });

        // Close notice when clicking outside
        document.addEventListener('click', (e) => {
            if (!noticeContainer.contains(e.target) && e.target !== noticeToggle) {
                noticeContainer.classList.remove('open');
                noticeToggle.classList.remove('open');
            }
        });

            // Highlight Support Information
            const supportButton = document.querySelector('.bg-secondary.hover\\:bg-blue-600');
            const supportInfo = document.querySelector('.font-medium + p');

            supportButton.addEventListener('click', () => {
                supportInfo.classList.add('highlight');
            });

            // Remove highlight after 3 seconds
            document.addEventListener('click', () => {
                setTimeout(() => {
                    supportInfo.classList.remove('highlight');
                }, 3000);
            });

            document.querySelectorAll('details').forEach((faq) => {
                faq.addEventListener('toggle', () => {
                    if (faq.open) {
                        faq.querySelector('summary').classList.add('#6C88B4', 'text-white');
                    } else {
                        faq.querySelector('summary').classList.remove('bg-primary', 'text-white');
                    }
                });
            });    

    </script>

<script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,ne',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE
      }, 'google_translate_element');
    }
  </script>
  
  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  
</body>
</html>

