<template>
    <Head>
        <title>Mentoach - Guiding Your Path, Empowering Your Future</title>
        <meta name="description" content="Transform your career with Mentoach's professional mentoring services. Expert career coaching, student mentorship, motivational speaking, and workshops for personal and professional growth." />
        <meta name="keywords" content="career coaching, professional mentoring, student mentorship, motivational speaking, career development, personal growth" />
        <meta property="og:title" content="Mentoach - Professional Mentoring & Career Coaching" />
        <meta property="og:description" content="Transform your career with Mentoach's professional mentoring services. Expert guidance for your professional journey." />
        <meta property="og:type" content="website" />
        <meta property="og:image" content="/images/og-mentoach.jpg" />
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="Mentoach - Professional Mentoring & Career Coaching" />
        <meta name="twitter:description" content="Transform your career with Mentoach's professional mentoring services. Expert guidance for your professional journey." />
    </Head>
    <div class="min-h-screen bg-gray-50">
        <!-- Navigation -->
        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center space-x-12">
                        <div class="flex items-center py-2">
                            <img src="/logo.png" alt="Mentoach Logo" class="h-16 w-auto">
                        </div>
                        <div class="hidden md:flex space-x-8">
                            <a href="#services" class="text-navy-800 hover:text-orange-500 font-medium text-base">Services</a>
                            <a href="#about" class="text-navy-800 hover:text-orange-500 font-medium text-base">About</a>
                            <a href="#testimonials" class="text-navy-800 hover:text-orange-500 font-medium text-base">Testimonials</a>
                            <a href="#booking" class="text-navy-800 hover:text-orange-500 font-medium text-base">Book a Session</a>
                            <a href="#contact" class="text-navy-800 hover:text-orange-500 font-medium text-base">Contact</a>
                        </div>
                    </div>
                    
                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button @click="isOpen = !isOpen" 
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-indigo-600 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500"
                            aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <!-- Icon when menu is closed -->
                            <svg v-if="!isOpen" class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <!-- Icon when menu is open -->
                            <svg v-else class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <div class="hidden md:flex items-center space-x-4">
                        <template v-if="$page.props.auth.user">
                            <Link :href="route('dashboard')" class="text-gray-700 hover:text-indigo-600 font-medium">
                                Dashboard
                            </Link>
                        </template>
                        <template v-else>
                            <Link :href="route('login')" class="text-navy-800 hover:text-orange-500 font-medium">
                                Log in
                            </Link>
                            <Link v-if="canRegister" :href="route('register')" 
                                class="bg-orange-500 text-white px-5 py-2.5 rounded-md hover:bg-orange-600 font-medium">
                                Register
                            </Link>
                        </template>
                    </div>
                </div>

                <!-- Mobile menu -->
                <transition
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition duration-100 ease-in"
                    leave-from-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95">
                    <div v-show="isOpen" class="md:hidden absolute left-0 right-0 w-full bg-white shadow-lg z-20">
                        <div class="px-2 pt-2 pb-3 space-y-1">
                            <a href="#services" @click="isOpen = false" 
                                class="block px-4 py-2.5 text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md font-medium">Services</a>
                            <a href="#about" @click="isOpen = false"
                                class="block px-4 py-2.5 text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md font-medium">About</a>
                            <a href="#testimonials" @click="isOpen = false"
                                class="block px-4 py-2.5 text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md font-medium">Testimonials</a>
                            <a href="#booking" @click="isOpen = false"
                                class="block px-4 py-2.5 text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md font-medium">Book a Session</a>
                            <a href="#contact" @click="isOpen = false"
                                class="block px-4 py-2.5 text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md font-medium">Contact</a>
                        </div>
                        <div class="pt-4 pb-3 border-t border-gray-200">
                            <div class="px-2 space-y-1">
                                <template v-if="$page.props.auth.user">
                                    <Link :href="route('dashboard')" @click="isOpen = false"
                                        class="block px-4 py-2.5 text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md font-medium">
                                        Dashboard
                                    </Link>
                                </template>
                                <template v-else>
                                    <Link :href="route('login')" @click="isOpen = false"
                                        class="block px-4 py-2.5 text-gray-700 hover:text-indigo-600 hover:bg-gray-50 rounded-md font-medium">
                                        Log in
                                    </Link>
                                    <Link v-if="canRegister" :href="route('register')" @click="isOpen = false"
                                        class="block px-4 py-2.5 text-indigo-600 hover:bg-indigo-50 rounded-md font-medium">
                                        Register
                                    </Link>
                                </template>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative bg-white overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:pb-28 xl:pb-32">
                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 lg:mt-16 lg:px-8 xl:mt-20">
                        <div class="text-center">
                            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                                <span class="block">Guiding Your Path,</span>
                                <span class="block text-orange-500">Empowering Your Future</span>
                            </h1>
                            <p class="mt-3 max-w-md mx-auto text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                                At Mentoach, we believe in the power of mentorship and career coaching to shape futures. Join us and take the first step towards success and fulfillment.
                            </p>
                            <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                                <div class="rounded-md shadow">
                                    <a href="#booking" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-orange-500 hover:bg-orange-600 md:py-4 md:text-lg md:px-10">
                                        Book a Session
                                    </a>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>

        <!-- Services Section -->
        <div id="services" class="py-24 bg-gradient-to-b from-gray-50 via-white to-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20">
                    <span class="text-orange-500 font-semibold tracking-wide uppercase text-sm">What We Offer</span>
                    <h2 class="mt-3 text-4xl md:text-5xl font-bold text-gray-900 tracking-tight">
                        Transform Your Journey
                    </h2>
                    <div class="mt-4 max-w-3xl mx-auto">
                        <p class="text-xl text-gray-500">Choose the path that best fits your goals. Each service is crafted to deliver exceptional results.</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8 lg:gap-12">
                    <div v-for="(service, index) in services" :key="service.title"
                        class="group transform transition-all duration-300 hover:-translate-y-1">
                        <div class="relative h-full bg-white rounded-2xl shadow-lg overflow-hidden transition-shadow duration-300 hover:shadow-2xl">
                            <!-- Top Accent Border with Gradient -->
                            <div class="h-2 bg-gradient-to-r from-orange-500 to-orange-600"></div>
                            
                            <div class="p-8">
                                <div class="flex items-center space-x-4 mb-6">
                                    <div class="p-3 rounded-xl bg-gradient-to-br from-orange-100 to-orange-50 transform transition-transform duration-300 group-hover:scale-110">
                                        <svg class="h-8 w-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="service.icon" />
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-gray-900 group-hover:text-orange-600 transition-colors duration-300">{{ service.title }}</h3>
                                </div>
                                
                                <p class="text-lg text-gray-600 mb-8 leading-relaxed">{{ service.description }}</p>
                                
                                <!-- Features Grid with Animation -->
                                <div class="grid gap-4">
                                    <div v-for="(feature, featureIndex) in service.features" :key="feature"
                                        class="flex items-start transform transition-all duration-300 hover:-translate-y-0.5"
                                        :style="{ transitionDelay: `${featureIndex * 50}ms` }">
                                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-gradient-to-br from-orange-100 to-orange-50 flex items-center justify-center mt-1 group-hover:from-orange-200 group-hover:to-orange-100 transition-colors duration-300">
                                            <svg class="h-4 w-4 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </div>
                                        <span class="ml-3 text-gray-700 group-hover:text-gray-900 transition-colors duration-300">{{ feature }}</span>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="mt-8">
                                    <a href="#booking" 
                                        class="inline-flex items-center text-orange-600 font-medium group-hover:text-orange-700 transition-colors duration-300">
                                        Book Now
                                        <svg class="ml-2 h-5 w-5 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Why Choose Mentoach Section -->
        <div id="about" class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Why Choose Mentoach?</h2>
                    <p class="mt-4 text-xl text-gray-500">
                        We are committed to helping individuals achieve their dreams by providing the guidance, tools, and support needed for personal and professional growth.
                    </p>
                </div>

                <div class="grid gap-8 lg:grid-cols-2 max-w-6xl mx-auto">
                    <div v-for="reason in whyChooseUs" :key="reason.title" 
                        class="relative bg-white p-8 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 flex items-start space-x-6">
                        <div class="h-12 w-12 flex-shrink-0">
                            <div class="h-full w-full flex items-center justify-center rounded-xl bg-navy-800 text-white transform transition-transform duration-300 hover:scale-110">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="reason.icon" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xl font-bold text-gray-900">{{ reason.title }}</h3>
                                <span class="text-orange-500 font-semibold">{{ reason.stats }}</span>
                            </div>
                            <p class="text-gray-600 text-base leading-relaxed">{{ reason.description }}</p>
                            <p class="text-sm text-orange-500 mt-2 font-medium">{{ reason.statsText }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Booking Section -->
        <div id="booking" class="py-16 bg-gradient-to-br from-indigo-50 via-white to-indigo-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Book a Session</h2>
                    <p class="mt-4 text-xl text-gray-500">Begin your journey to success today</p>
                </div>

                <div class="mt-12 max-w-4xl mx-auto">
                    <!-- Progress Steps -->
                    <nav aria-label="Progress">
                        <ol role="list" class="flex items-center justify-center mb-12">
                            <li v-for="(step, index) in steps" :key="step.name" :class="[
                                index !== steps.length - 1 ? 'pr-8 sm:pr-20' : '',
                                'relative'
                            ]">
                                <div class="flex items-center">
                                    <div :class="[
                                        currentStep >= step.number ? 'bg-orange-500' : 'bg-gray-200',
                                        'rounded-full transition-colors duration-200 h-8 w-8 flex items-center justify-center'
                                    ]">
                                        <span :class="[
                                            currentStep >= step.number ? 'text-orange-500' : 'text-gray-500',
                                            'text-sm font-medium'
                                        ]">{{ step.number }}</span>
                                    </div>
                                    <div class="hidden sm:block ml-4">
                                        <p :class="[
                                            currentStep >= step.number ? 'text-orange-500' : 'text-gray-500',
                                            'text-sm font-medium'
                                        ]">{{ step.name }}</p>
                                        <p class="text-sm text-gray-400">{{ step.description }}</p>
                                    </div>
                                </div>
                                <div v-if="index !== steps.length - 1" :class="[
                                    currentStep > step.number ? 'bg-orange-500' : 'bg-gray-200',
                                    'hidden sm:block absolute top-4 -right-4 h-0.5 w-16 transition-colors duration-200'
                                ]" />
                            </li>
                        </ol>
                    </nav>

                    <!-- Form Content -->
                    <div class="bg-white rounded-2xl shadow-xl p-8">
                        <form @submit.prevent="submitBooking" class="space-y-8">
                            <div v-if="showBookingSuccess" class="bg-green-50 p-4 rounded-lg">
                                <p class="text-green-800 font-medium">Thank you for your enquiry! Our team will review your request and get back to you shortly to confirm your session details.</p>
                            </div>

                            <!-- Step 1: Service Selection -->
                            <div v-show="currentStep === 1" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div v-for="service in services" :key="service.title"
                                        @click="() => {
                                            bookingForm.service = service.title;
                                            nextStep();
                                        }"
                                        :class="[
                                            'cursor-pointer p-6 rounded-xl transition-all duration-200',
                                            bookingForm.service === service.title
                                                ? 'bg-orange-50 border-2 border-orange-500 shadow-md'
                                                : 'bg-gray-50 border-2 border-transparent hover:bg-orange-50'
                                        ]">
                                        <div class="flex items-center">
                                            <svg class="h-8 w-8 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="service.icon" />
                                            </svg>
                                            <h3 class="ml-3 text-lg font-medium text-gray-900">{{ service.title }}</h3>
                                        </div>
                                        <p class="mt-2 text-sm text-gray-500">{{ service.description }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Step 2: Schedule -->
                            <div v-show="currentStep === 2" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Date</label>
                                        <DatePicker v-model="selectedDate" :min-date="new Date()" 
                                            class="w-full"
                                            :enable-time-picker="false"
                                            :text-input="true"
                                            :auto-apply="true"
                                            placeholder="Choose a date" />
                                    </div>
                                    <div v-if="selectedDate">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Time</label>
                                        <div class="grid grid-cols-3 gap-2">
                                            <button v-for="time in availableTimeSlots" :key="time"
                                                type="button"
                                                @click="selectedTime = time"
                                                :class="[
                                                    'px-4 py-3 text-sm rounded-lg transition-colors duration-200',
                                                    selectedTime === time
                                                        ? 'bg-orange-600 text-white shadow-md'
                                                        : 'bg-gray-50 text-gray-700 hover:bg-orange-50'
                                                ]">
                                                {{ time }}
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 2 Navigation -->
                                <div class="flex justify-between pt-6">
                                    <button type="button"
                                        @click="prevStep"
                                        class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                        Previous
                                    </button>
                                    <button type="button"
                                        @click="nextStep"
                                        :disabled="!selectedDate || !selectedTime"
                                        class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                        Next Step
                                        <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Step 3: Personal Information -->
                            <div v-show="currentStep === 3" class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Name</label>
                                            <input type="text" v-model="bookingForm.name" required
                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors duration-200">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" v-model="bookingForm.email" required
                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors duration-200">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Subject</label>
                                            <input type="text" v-model="bookingForm.subject" required
                                                placeholder="Brief title for your session"
                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors duration-200">
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Phone</label>
                                            <input type="tel" v-model="bookingForm.phone" required
                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors duration-200">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Message (Optional)</label>
                                            <textarea v-model="bookingForm.message" rows="4"
                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 transition-colors duration-200"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Step 3 Navigation -->
                                <div class="flex justify-between pt-6">
                                    <button type="button"
                                        @click="prevStep"
                                        class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                        Previous
                                    </button>
                                    <button type="button"
                                        @click="nextStep"
                                        :disabled="!bookingForm.name || !bookingForm.email || !bookingForm.phone || !bookingForm.subject"
                                        class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                        Next Step
                                        <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Step 4: Confirmation -->
                            <div v-show="currentStep === 4" class="space-y-6">
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <h4 class="text-lg font-medium text-gray-900 mb-4">Booking Summary</h4>
                                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Service</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ bookingForm.service }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Subject</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ bookingForm.subject }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Date & Time</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ selectedDate ? selectedDate.toLocaleDateString() : '' }}
                                                {{ selectedTime ? `at ${selectedTime}` : '' }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                                            <dd class="mt-1 text-sm text-gray-900">{{ bookingForm.name }}</dd>
                                        </div>
                                        <div>
                                            <dt class="text-sm font-medium text-gray-500">Contact</dt>
                                            <dd class="mt-1 text-sm text-gray-900">
                                                {{ bookingForm.email }}<br>
                                                {{ bookingForm.phone }}
                                            </dd>
                                        </div>
                                    </dl>
                                </div>

                                <ReCaptcha action="booking" @update:token="updateBookingReCaptchaToken" />

                                <div class="flex justify-between pt-6">
                                    <button type="button"
                                        v-if="currentStep > 1"
                                        @click="prevStep"
                                        class="inline-flex items-center px-6 py-3 border border-gray-300 shadow-sm text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                        Previous
                                    </button>

                                    <button type="submit"
                                        :disabled="!canProceedToNextStep || bookingForm.processing || !bookingForm['g-recaptcha-token']"
                                        class="inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 disabled:cursor-not-allowed">
                                        Submit Booking
                                        <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Stories Section -->
        <div id="testimonials" class="py-12 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Success Stories</h2>
                    <p class="mt-4 text-xl text-gray-500">Real stories from people who transformed their lives with Mentoach</p>
                </div>

                <div class="mt-12 grid gap-8 lg:grid-cols-3">
                    <div v-for="story in successStories" :key="story.name" 
                        class="bg-white rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">
                        <div class="px-6 py-8">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-12 w-12">
                                    <template v-if="story.image">
                                        <img class="h-12 w-12 rounded-full" :src="story.image" :alt="story.name">
                                    </template>
                                    <template v-else>
                                        <div :class="[story.bgColor, 'h-12 w-12 rounded-full flex items-center justify-center']">
                                            <span class="text-white font-medium text-lg">{{ story.initials }}</span>
                                        </div>
                                    </template>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-medium text-gray-900">{{ story.name }}</h3>
                                    <p class="text-sm text-indigo-600">{{ story.role }}</p>
                                </div>
                            </div>
                            <p class="mt-4 text-gray-500">{{ story.story }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form Section -->
        <div id="contact" class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Contact Us</h2>
                    <p class="mt-4 text-xl text-gray-500">Have questions? We'd love to hear from you.</p>
                </div>

                <!-- Contact Form -->
                <form @submit.prevent="submitContact" class="space-y-6 bg-white rounded-2xl shadow-xl p-8">
                    <!-- Success Message -->
                    <transition
                        enter-active-class="transform ease-out duration-300 transition"
                        enter-from-class="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                        enter-to-class="translate-y-0 opacity-100 sm:translate-x-0"
                        leave-active-class="transition ease-in duration-200"
                        leave-from-class="opacity-100"
                        leave-to-class="opacity-0">
                        <div v-if="showContactSuccess" class="mb-8 rounded-md bg-green-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800">Message sent successfully</h3>
                                    <p class="mt-2 text-sm text-green-700">Thank you for reaching out! We'll get back to you within 24 hours.</p>
                                </div>
                            </div>
                        </div>
                    </transition>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <div>
                                <label for="contact-name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                <div class="mt-1">
                                    <input type="text" 
                                        id="contact-name"
                                        v-model="contactForm.name" 
                                        required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                        placeholder="John Doe">
                                </div>
                            </div>

                            <div>
                                <label for="contact-email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                <div class="mt-1">
                                    <input type="email" 
                                        id="contact-email"
                                        v-model="contactForm.email" 
                                        required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                        placeholder="you@example.com">
                                </div>
                            </div>

                            <div>
                                <label for="contact-phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                <div class="mt-1">
                                    <input type="tel" 
                                        id="contact-phone"
                                        v-model="contactForm.phone" 
                                        required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                        placeholder="+1 (555) 000-0000">
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div>
                                <label for="contact-subject" class="block text-sm font-medium text-gray-700">Subject</label>
                                <div class="mt-1">
                                    <input type="text" 
                                        id="contact-subject"
                                        v-model="contactForm.subject" 
                                        required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                        placeholder="How can we help?">
                                </div>
                            </div>

                            <div>
                                <label for="contact-message" class="block text-sm font-medium text-gray-700">Message</label>
                                <div class="mt-1">
                                    <textarea 
                                        id="contact-message"
                                        v-model="contactForm.message" 
                                        rows="6" 
                                        required
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500 sm:text-sm"
                                        placeholder="Tell us how we can help..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <ReCaptcha action="contact" @update:token="updateContactReCaptchaToken" />

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit"
                            :disabled="contactForm.processing || !contactForm['g-recaptcha-token']"
                            class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200">
                            <svg v-if="contactForm.processing" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            {{ contactForm.processing ? 'Sending...' : 'Send Message' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center mb-6">
                            <h2 class="text-white text-2xl font-bold">Mentoach</h2>
                        </div>
                        <p class="text-gray-300 text-sm max-w-md mb-6">
                            Guiding your path and empowering your future through expert mentorship and career coaching services.
                        </p>
                        <div class="space-y-3">
                            <div class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>+44 7123 456789</span>
                            </div>
                            <div class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>info@mentoach.com</span>
                            </div>
                            <div class="flex items-center text-gray-300">
                                <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>123 Business Street, London, UK</span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Company</h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="#about" class="text-base text-gray-300 hover:text-white">About</a>
                            </li>
                            <li>
                                <a href="#services" class="text-base text-gray-300 hover:text-white">Services</a>
                            </li>
                            <li>
                                <a href="#testimonials" class="text-base text-gray-300 hover:text-white">Testimonials</a>
                            </li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">Contact</h3>
                        <ul class="mt-4 space-y-4">
                            <li>
                                <a href="#booking" class="text-base text-gray-300 hover:text-white">Book a Session</a>
                            </li>
                            <li>
                                <a href="#contact" class="text-base text-gray-300 hover:text-white">Contact Form</a>
                            </li>
                        </ul>
                        <div class="mt-6">
                            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase mb-4">Follow Us</h3>
                            <div class="flex space-x-4">
                                <a href="https://twitter.com/mentoach" target="_blank" rel="noopener noreferrer" class="text-gray-300 hover:text-white">
                                    <span class="sr-only">Twitter</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                    </svg>
                                </a>
                                <a href="https://linkedin.com/company/mentoach" target="_blank" rel="noopener noreferrer" class="text-gray-300 hover:text-white">
                                    <span class="sr-only">LinkedIn</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                </a>
                                <a href="https://facebook.com/mentoach" target="_blank" rel="noopener noreferrer" class="text-gray-300 hover:text-white">
                                    <span class="sr-only">Facebook</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                                <a href="https://instagram.com/mentoach" target="_blank" rel="noopener noreferrer" class="text-gray-300 hover:text-white">
                                    <span class="sr-only">Instagram</span>
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-8 border-t border-gray-700 pt-8">
                    <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                        <p class="text-base text-gray-400">
                            &copy; 2024 Mentoach. All rights reserved.
                        </p>
                        <p class="text-base text-gray-400">
                            Designed and developed by <a href="https://iiadigital.co.uk" target="_blank" rel="noopener noreferrer" class="text-white hover:text-orange-500 transition-colors duration-200">iiadigital.co.uk</a>
                        </p>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed, onMounted } from 'vue';
import DatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import { useForm, usePage } from '@inertiajs/vue3';
import ReCaptcha from '@/Components/ReCaptcha.vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    mentors: Array,
});

const services = [
    {
        title: 'Career Coaching',
        description: 'Personalized career coaching to help you clarify goals, overcome obstacles, and map out your path to success.',
        features: [
            'Personalized career assessments',
            'Goal-setting strategies',
            'Resume writing and interview preparation',
            'Networking strategies',
            'Career transition support',
            'Access to job opportunities'
        ],
        icon: 'M12 20V4m-7 7l7-7 7 7M5 10v10h14V10',
        image: '/images/services/career-coaching.png'
    },
    {
        title: 'Mentorship for Students',
        description: 'Expert mentorship programs for students at various educational levels, from high school to university.',
        features: [
            'One-on-one mentorship sessions',
            'Academic guidance',
            'Study strategies',
            'Extracurricular advice',
            'Mental well-being support'
        ],
        icon: 'M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5',
        image: '/images/services/student-mentorship.png'
    },
    {
        title: 'Motivational Speaking',
        description: 'Inspiring and dynamic public speaking sessions to help individuals and teams overcome challenges.',
        features: [
            'Motivational talks',
            'Leadership workshops',
            'Resilience building',
            'Team building sessions'
        ],
        icon: 'M12 18.75a6 6 0 006-6v-1.5m-6 7.5a6 6 0 01-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 01-3-3V4.5a3 3 0 116 0v8.25a3 3 0 01-3 3z',
        image: '/images/services/motivational-speaking.png'
    },
    {
        title: 'Workshops and Group Coaching',
        description: 'Collaborative sessions focused on personal and professional development.',
        features: [
            'Group career coaching',
            'Time management workshops',
            'Communication skills training',
            'Networking events'
        ],
        icon: 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z',
        image: '/images/services/group-coaching.png'
    }
];

const successStories = [
    {
        name: 'Rishael',
        role: 'High School Student',
        story: 'Through our mentorship program, she developed better study habits, gained confidence, and secured a place at a prestigious university.',
        image: null,
        initials: 'R',
        bgColor: 'bg-orange-500'
    },
    {
        name: 'Tom',
        role: 'Career Transitioner',
        story: 'Successfully transitioned into a new career in the tech industry after 15 years in a different field.',
        image: null,
        initials: 'T',
        bgColor: 'bg-navy-800'
    },
    {
        name: 'Aisha',
        role: 'Recent Graduate',
        story: 'Landed a full-time position at a leading marketing firm after refining her resume and interview skills.',
        image: null,
        initials: 'A',
        bgColor: 'bg-indigo-600'
    }
];

const whyChooseUs = [
    {
        title: 'Personalized Support',
        description: 'We understand that every individual\'s journey is unique. That\'s why we offer personalized coaching and mentorship tailored to your specific needs, goals, and challenges.',
        icon: 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
        stats: '95%',
        statsText: 'Client Satisfaction',
        color: 'blue'
    },
    {
        title: 'Experienced Mentors and Coaches',
        description: 'Our team of mentors and career coaches are experts in their fields, with years of experience helping individuals achieve their goals.',
        icon: 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10',
        stats: '10+',
        statsText: 'Years Average Experience',
        color: 'indigo'
    },
    {
        title: 'Holistic Approach',
        description: 'We focus not only on career development but also on personal growth, mental well-being, and motivation for long-term success.',
        icon: 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9',
        stats: '360°',
        statsText: 'Development Approach',
        color: 'purple'
    },
    {
        title: 'Proven Results',
        description: 'Our clients have successfully achieved their educational and career goals, with measurable outcomes and lasting impact.',
        icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
        stats: '85%',
        statsText: 'Career Advancement Rate',
        color: 'emerald'
    },
    {
        title: 'Flexible Options',
        description: 'Access our services from anywhere with both in-person and online options, fitting into your busy lifestyle.',
        icon: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
        stats: '24/7',
        statsText: 'Accessibility',
        color: 'rose'
    }
];

// Initialize refs
const selectedDate = ref(null);
const selectedTime = ref(null);
const showBookingSuccess = ref(false);
const showContactSuccess = ref(false);
const currentStep = ref(1);
const isOpen = ref(false);
const totalSteps = 4;

// Booking form
const bookingForm = useForm({
    service: '',
    preferred_date: '',
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
    'g-recaptcha-token': ''
});

const page = usePage();

const submitBooking = () => {
    if (!bookingForm.service || !selectedDate.value || !selectedTime.value || !bookingForm.name || !bookingForm.email || !bookingForm.phone || !bookingForm.subject) {
        alert('Please fill in all required fields');
        return;
    }

    try {
        // Format the date and time for submission
        const dateString = selectedDate.value.toISOString().split('T')[0];
        const timeString = selectedTime.value;
        bookingForm.preferred_date = `${dateString} ${timeString}:00`;

        console.log('Date String:', dateString);
        console.log('Time String:', timeString);
        console.log('Final Preferred Date:', bookingForm.preferred_date);

        bookingForm.post(route('enquiries.store'), {
            preserveScroll: true,
            onSuccess: () => {
                showBookingSuccess.value = true;
                bookingForm.reset();
                selectedDate.value = null;
                selectedTime.value = null;
                currentStep.value = 1;
            },
            onError: (errors) => {
                let errorMessage = 'Please check the following:\n';
                Object.entries(errors).forEach(([field, message]) => {
                    errorMessage += `${message}\n`;
                });
                alert(errorMessage);
            }
        });
    } catch (error) {
        console.error('Submission Error:', error);
        alert('There was an error submitting your booking. Please try again.');
    }
};

// Contact form
const contactForm = useForm({
    name: '',
    email: '',
    phone: '',
    subject: '',
    message: '',
    'g-recaptcha-token': '',
});

const submitContact = () => {
    contactForm.post(route('contact.store'), {
        onSuccess: () => {
            contactForm.reset();
            showContactSuccess.value = true;
        },
        onError: (errors) => {
            let errorMessage = 'Please check the following:\n';
            Object.entries(errors).forEach(([field, message]) => {
                errorMessage += `${message}\n`;
            });
            alert(errorMessage);
        }
    });
};

const updateContactReCaptchaToken = (token) => {
    contactForm['g-recaptcha-token'] = token;
};

const availableTimeSlots = computed(() => [
    '09:00', '10:00', '11:00', '13:00', '14:00', '15:00', '16:00'
]);

const steps = [
    { number: 1, name: 'Service Selection', description: 'Choose your preferred service' },
    { number: 2, name: 'Schedule', description: 'Pick a preferred date and time' },
    { number: 3, name: 'Personal Info', description: 'Tell us about yourself' },
    { number: 4, name: 'Confirmation', description: 'Review and submit' }
];

// Update canProceedToNextStep to include subject validation
const canProceedToNextStep = computed(() => {
    switch (currentStep.value) {
        case 1:
            return bookingForm.service !== '';
        case 2:
            return selectedDate.value && selectedTime.value;
        case 3:
            return bookingForm.name && bookingForm.email && bookingForm.phone && bookingForm.subject;
        default:
            return true;
    }
});

// Update nextStep function
const nextStep = () => {
    // Validate current step before proceeding
    switch (currentStep.value) {
        case 1:
            if (!bookingForm.service) {
                alert('Please select a service to continue');
                return;
            }
            break;
        case 2:
            if (!selectedDate.value || !selectedTime.value) {
                alert('Please select both date and time to continue');
                return;
            }
            break;
        case 3:
            if (!bookingForm.name || !bookingForm.email || !bookingForm.phone || !bookingForm.subject) {
                alert('Please fill in all required fields to continue');
                return;
            }
            break;
    }

    if (currentStep.value < totalSteps) {
        currentStep.value++;
    }
};

const prevStep = () => {
    if (currentStep.value > 1) {
        currentStep.value--;
    }
};

const updateBookingReCaptchaToken = (token) => {
    bookingForm['g-recaptcha-token'] = token;
};

// Add this log to check selectedTime
console.log('Selected Time:', selectedTime);

// Add structured data
const structuredData = {
    "@context": "https://schema.org",
    "@type": "ProfessionalService",
    "name": "Mentoach",
    "description": "Professional mentoring and career coaching services",
    "image": "/logo.png",
    "address": {
        "@type": "PostalAddress",
        "streetAddress": "123 Business Street",
        "addressLocality": "London",
        "addressCountry": "UK"
    },
    "offers": {
        "@type": "Offer",
        "name": "Career Coaching Services",
        "description": "Personalized career coaching and mentorship"
    },
    "hasOfferCatalog": {
        "@type": "OfferCatalog",
        "name": "Mentoring Services",
        "itemListElement": [
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "Service",
                    "name": "Career Coaching",
                    "description": "Personalized career coaching to help you clarify goals"
                }
            },
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "Service",
                    "name": "Student Mentorship",
                    "description": "Expert mentorship programs for students"
                }
            },
            {
                "@type": "Offer",
                "itemOffered": {
                    "@type": "Service",
                    "name": "Motivational Speaking",
                    "description": "Inspiring and dynamic public speaking sessions"
                }
            }
        ]
    }
};

// Add mounted hook to inject structured data
onMounted(() => {
    const script = document.createElement('script');
    script.setAttribute('type', 'application/ld+json');
    script.textContent = JSON.stringify(structuredData);
    document.head.appendChild(script);
});
</script>

<style>
html {
    scroll-behavior: smooth;
}

.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}
</style>
