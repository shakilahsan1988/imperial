<?php require_once 'includes/header.php'; ?>
<main>
	<!-- Hero Carousel -->
	<section class="relative h-[500px] md:h-[600px] w-full overflow-hidden bg-gray-900">
		<!-- Slide 1 -->
		<div class="slide active">
			<img src="https://images.pexels.com/photos/6129653/pexels-photo-6129653.jpeg?_gl=1*1frn09b*_ga*MTQwMTA2MjU5NC4xNzY4OTY5ODkw*_ga_8JE65Q40S6*czE3Njg5Njk4ODkkbzEkZzEkdDE3Njg5Njk5MjgkajIxJGwwJGgw" 
				 onerror="this.src='https://picsum.photos/seed/health1/1920/1080'"
				 alt="Healthcare Anywhere" class="w-full h-full object-cover">
			<div class="absolute inset-0 bg-black/40"></div>
			<div class="absolute inset-0 flex items-center justify-center text-center px-4">
				<div class="max-w-3xl text-white">
					<h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">Healthcare Anytime, Anywhere</h1>
					<p class="text-lg md:text-xl mb-8 opacity-90">Let us take care of your health</p>
					<a href="#" class="inline-block bg-imperial-primary text-white px-8 py-3 rounded font-medium hover:bg-imperial-dark transition">Explore our services</a>
				</div>
			</div>
		</div>

		<!-- Slide 2 -->
		<div class="slide">
			<img src="https://images.pexels.com/photos/6129502/pexels-photo-6129502.jpeg?_gl=1*1tue3ij*_ga*MTQwMTA2MjU5NC4xNzY4OTY5ODkw*_ga_8JE65Q40S6*czE3Njg5Njk4ODkkbzEkZzEkdDE3Njg5Njk5ODckajQzJGwwJGgw" 
				 onerror="this.src='https://picsum.photos/seed/health2/1920/1080'"
				 alt="Affordable Health Checks" class="w-full h-full object-cover">
			<div class="absolute inset-0 bg-black/40"></div>
			<div class="absolute inset-0 flex items-center justify-center text-center px-4">
				<div class="max-w-3xl text-white">
					<h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">Affordable Health Checks & Packages</h1>
					<p class="text-lg md:text-xl mb-8 opacity-90">imperial has designed health checks and packages tailored to your needs, based on age and gender, that fit within your budget</p>
					<a href="#" class="inline-block bg-imperial-primary text-white px-8 py-3 rounded font-medium hover:bg-imperial-dark transition">Explore your options</a>
				</div>
			</div>
		</div>

		<!-- Slide 3 -->
		<div class="slide">
			<img src="https://images.pexels.com/photos/6129644/pexels-photo-6129644.jpeg" 
				 onerror="this.src='https://picsum.photos/seed/health3/1920/1080'"
				 alt="Lab Tests" class="w-full h-full object-cover">
			<div class="absolute inset-0 bg-black/40"></div>
			<div class="absolute inset-0 flex items-center justify-center text-center px-4">
				<div class="max-w-3xl text-white">
					<h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight">Hassle-Free Lab Tests</h1>
					<p class="text-lg md:text-xl mb-8 opacity-90">We offer lab tests at home, especially during busy schedules, harsh weather and heavy traffic.</p>
					<a href="#" class="inline-block bg-imperial-primary text-white px-8 py-3 rounded font-medium hover:bg-imperial-dark transition">Book a test</a>
				</div>
			</div>
		</div>

		<!-- Carousel Controls -->
		<div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex gap-3 z-20">
			<button class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition" onclick="goToSlide(0)"></button>
			<button class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition" onclick="goToSlide(1)"></button>
			<button class="carousel-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition" onclick="goToSlide(2)"></button>
		</div>
		
		<!-- Arrows -->
		<button class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/30 text-white p-3 rounded-full backdrop-blur-sm z-20 transition" onclick="changeSlide(-1)">
			<i class="fa-solid fa-chevron-left"></i>
		</button>
		<button class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/10 hover:bg-white/30 text-white p-3 rounded-full backdrop-blur-sm z-20 transition" onclick="changeSlide(1)">
			<i class="fa-solid fa-chevron-right"></i>
		</button>
	</section>

	<!-- Stats Section -->
	<section class="py-12 md:py-20 bg-white">
		<div class="container mx-auto px-6">
			<div class="flex flex-col md:flex-row gap-12 items-center">
				<div class="md:w-5/12">
					<h2 class="text-4xl font-bold mb-4">About <span class="text-imperial-primary">imperial</span></h2>
					<p class="text-imperial-gray text-lg leading-relaxed">imperial exists to provide a better patient experience. We are a one-stop-shop for your health, offering caring doctors, world-class diagnostics, in-house pharmacy, and much more.</p>
				</div>
				<div class="md:w-7/12 grid grid-cols-3 gap-8 w-full">
					<div class="text-center md:text-left">
						<div class="text-4xl font-bold text-imperial-primary mb-2">27</div>
						<h3 class="text-xl font-medium text-imperial-text">Departments</h3>
					</div>
					<div class="text-center md:text-left">
						<div class="text-4xl font-bold text-imperial-primary mb-2">84</div>
						<h3 class="text-xl font-medium text-imperial-text">Doctors</h3>
					</div>
					<div class="text-center md:text-left">
						<div class="text-4xl font-bold text-imperial-primary mb-2">914K</div>
						<h3 class="text-xl font-medium text-imperial-text">Patients Served</h3>
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- Why imperial Sections -->
	<!-- Section 1 -->
	<section class="py-12 md:py-24 bg-imperial-primary">
		<div class="container mx-auto px-6">
			<div class="flex flex-col md:flex-row items-top gap-12">
				<div class="md:w-5/12 order-2 md:order-1">
					<h4 class="text-sm font-semibold text-imperial-primary tracking-wider uppercase mb-2">Why imperial</h4>
					<h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">Doctors Who Listen</h2>
					<p class="text-lg text-white leading-relaxed">Our doctors spend time to get to know you and your health. They treat you with respect and empathy you deserve and have years of local and international experience to give you advice you can rely on.</p>
					<p class="text-lg text-white leading-relaxed">Our doctors spend time to get to know you and your health. They treat you with respect and empathy you deserve and have years of local and international experience to give you advice you can rely on.</p>
					<p class="text-lg text-white leading-relaxed">Our doctors spend time to get to know you and your health. They treat you with respect and empathy you deserve and have years of local and international experience to give you advice you can rely on.</p>
				</div>
				<div class="md:w-7/12 order-1 md:order-2">
					<img src="https://media.istockphoto.com/id/1861987830/photo/beautiful-female-doctor-talking-while-explaining-medical-treatment-with-digital-tablet-to.jpg?s=1024x1024&w=is&k=20&c=xMXaa_bbYSd6gie6ud8M5H7OjxKz2FiRfteOymy-JIM=" 
						 onerror="this.src='https://picsum.photos/seed/doclist/800/600'"
						 alt="Doctors Listening" class="w-full h-auto rounded-lg shadow-lg object-cover">
				</div>
			</div>
		</div>
	</section>

	<!-- Section 2 -->
	<section class="py-12 md:py-24 bg-white">
		<div class="container mx-auto px-6">
			<div class="flex flex-col md:flex-row items-center gap-12">
				<div class="md:w-6/12">
					<img src="https://images.pexels.com/photos/7108317/pexels-photo-7108317.jpeg?_gl=1*1l3mdqn*_ga*MTQwMTA2MjU5NC4xNzY4OTY5ODkw*_ga_8JE65Q40S6*czE3Njg5Njk4ODkkbzEkZzEkdDE3Njg5NzAwOTUkajYwJGwwJGgw" 
						 onerror="this.src='https://picsum.photos/seed/lab/800/600'"
						 alt="Diagnosis Lab" class="w-full h-auto rounded-lg shadow-lg object-cover">
				</div>
				<div class="md:w-5/12 md:ml-auto">
					<h4 class="text-sm font-semibold text-imperial-primary tracking-wider uppercase mb-2">Why imperial</h4>
					<h2 class="text-3xl md:text-4xl font-bold mb-4 text-imperial-text">Diagnosis You Can Trust</h2>
					<p class="text-lg text-imperial-gray leading-relaxed mb-6">You can depend on quality of our diagnosis and test results. Our laboratories are set up according to international standards and protocols.</p>
					<a href="#" class="text-imperial-primary font-medium hover:underline flex items-center gap-2">Our services <i class="fa-solid fa-arrow-right"></i></a>
				</div>
			</div>
		</div>
	</section>

	<!-- Section 3 -->
	<section class="py-12 md:py-24 bg-imperial-primary">
		<div class="container mx-auto px-6">
			<div class="flex flex-col md:flex-row items-center gap-12">
				<div class="md:w-5/12">
					<h4 class="text-sm font-semibold text-white tracking-wider uppercase mb-2">Why imperial</h4>
					<h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">Healthcare Anytime, Anywhere</h2>
					<p class="text-lg text-white leading-relaxed">We use technology to make healthcare accessible to you no matter where you are. You can access your health data, book appointments, review your prescriptions, and view your medical records, anywhere at your convenience.</p>
				</div>
				<div class="md:w-7/12">
					<img src="https://images.pexels.com/photos/6129653/pexels-photo-6129653.jpeg?_gl=1*1frn09b*_ga*MTQwMTA2MjU5NC4xNzY4OTY5ODkw*_ga_8JE65Q40S6*czE3Njg5Njk4ODkkbzEkZzEkdDE3Njg5Njk5MjgkajIxJGwwJGgw" 
						 onerror="this.src='https://picsum.photos/seed/tech/800/600'"
						 alt="Digital Health" class="w-full h-auto rounded-lg shadow-lg object-cover">
				</div>
			</div>
		</div>
	</section>

	<!-- Section 4 (Floating Layout) - FIXED LAYOUT -->
	<section class="py-12 md:py-24  text-white relative overflow-hidden">
		<div class="container mx-auto px-6 relative z-10">
			<!-- Grid Layout for stability -->
			<div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
				
				<!-- Left Side: Text Card (White) - Takes up 7 columns -->
				<div class="md:col-span-7 bg-white text-imperial-text p-8 md:p-12 rounded-lg shadow-xl relative z-20">
					<h4 class="text-sm font-semibold text-imperial-primary tracking-wider uppercase mb-2">Why imperial</h4>
					<h2 class="text-3xl md:text-4xl font-bold mb-4">Take A Tour Of Our Facility</h2>
					<p class="text-lg text-imperial-gray leading-relaxed mb-6">Visit us at our flagship facility in Banani, Dhaka, and find out what makes us different</p>
					<a href="#" class="bg-imperial-primary text-white px-6 py-3 rounded font-medium hover:bg-imperial-dark transition inline-block">Book a guided tour</a>
				</div>

				<!-- Right Side: Spacer - Takes up 5 columns -->
				<div class="hidden md:block md:col-span-5"></div>
			</div>

			<!-- Background Image (Absolute Right) -->
			<div class="absolute right-0 top-0 h-full w-1/2 z-0 hidden md:block">
				<img src="https://images.pexels.com/photos/6129490/pexels-photo-6129490.jpeg?_gl=1*1lf45h6*_ga*MTQwMTA2MjU5NC4xNzY4OTY5ODkw*_ga_8JE65Q40S6*czE3Njg5Njk4ODkkbzEkZzEkdDE3Njg5NzAxMzUkajIwJGwwJGgw" 
					 onerror="this.src='https://picsum.photos/seed/facility/800/600'"
					 alt="Facility Tour" class="w-full h-full object-cover opacity-80">
			</div>
		</div>
	</section>

	<!-- Section 5 -->
	<section class="py-12 md:py-24 bg-white">
		<div class="container mx-auto px-6">
			<div class="flex flex-col md:flex-row items-center gap-8">
				<div class="md:w-6/12 order-2 md:order-1">
					<img src="https://images.pexels.com/photos/6291063/pexels-photo-6291063.jpeg" 
						 onerror="this.src='https://www.pexels.com/photo/man-in-blue-and-white-scrub-suit-holding-white-printer-paper-6129118/'"
						 alt="Care Like Family" class="w-full h-auto rounded-lg shadow-lg object-cover">
				</div>
				<div class="md:w-5/12 md:ml-auto order-1 md:order-2">
					<h4 class="text-sm font-semibold text-imperial-primary tracking-wider uppercase mb-2">Why imperial</h4>
					<h2 class="text-3xl md:text-4xl font-bold mb-4 text-imperial-text">We Care For You Like Family</h2>
					<p class="text-lg text-imperial-gray leading-relaxed mb-6">Open every day from 8AM - 10PM</p>
					<a href="#" class="border border-imperial-primary text-imperial-primary px-6 py-2 rounded font-medium hover:bg-imperial-primary hover:text-white transition inline-block">Book Appointment</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Services / Health Checks Slider Section -->
	<section class="py-16">
		<div class="container mx-auto px-6">
			<h2 class="text-3xl font-bold text-center mb-12">Health Checks & Packages</h2>
			
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
				<!-- Card 1 -->
				<div class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden group">
					<div class="h-48 overflow-hidden">
						<img src="https://images.pexels.com/photos/11198228/pexels-photo-11198228.jpeg?_gl=1*15gjlk*_ga*MTQwMTA2MjU5NC4xNzY4OTY5ODkw*_ga_8JE65Q40S6*czE3Njg5Njk4ODkkbzEkZzEkdDE3Njg5NzAyMjMkajE5JGwwJGgw" 
							 onerror="this.src='https://picsum.photos/seed/card1/400/300'"
							 alt="Her Health Check" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
					</div>
					<div class="p-6">
						<h3 class="font-bold text-lg mb-2">Her Health Check (< 40 Years)</h3>
						<p class="text-sm text-gray-500 mb-4">Comprehensive check-up designed for women under 40.</p>
						<div class="flex justify-between items-center">
							<span class="font-bold text-imperial-primary">BDT 13,800</span>
							<button class="text-sm font-medium text-imperial-primary border border-imperial-primary px-4 py-1 rounded hover:bg-imperial-primary hover:text-white transition">Book</button>
						</div>
					</div>
				</div>

				<!-- Card 2 -->
				<div class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden group">
					<div class="h-48 overflow-hidden">
						<img src="https://www.imperialhealth.com/media-images/NXxvdL8UsEuZvEMpWy2MJloernw=/140/fill-782x517-c0/HER_Health_Check_age_40-65_yrs.png" 
							 onerror="this.src='https://picsum.photos/seed/card2/400/300'"
							 alt="Her Health Check 40-65" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
					</div>
					<div class="p-6">
						<h3 class="font-bold text-lg mb-2">Her Health Check (40-65 Years)</h3>
						<p class="text-sm text-gray-500 mb-4">Advanced screening for women's health in this age group.</p>
						<div class="flex justify-between items-center">
							<span class="font-bold text-imperial-primary">BDT 22,200</span>
							<button class="text-sm font-medium text-imperial-primary border border-imperial-primary px-4 py-1 rounded hover:bg-imperial-primary hover:text-white transition">Book</button>
						</div>
					</div>
				</div>

				<!-- Card 3 -->
				<div class="bg-white rounded-lg shadow-sm hover:shadow-md transition overflow-hidden group">
					<div class="h-48 overflow-hidden">
						<img src="https://images.pexels.com/photos/6303643/pexels-photo-6303643.jpeg?_gl=1*1o1bmoi*_ga*MTQwMTA2MjU5NC4xNzY4OTY5ODkw*_ga_8JE65Q40S6*czE3Njg5Njk4ODkkbzEkZzEkdDE3Njg5NzAyNTIkajYwJGwwJGgw" 
							 onerror="this.src='https://picsum.photos/seed/card3/400/300'"
							 alt="His Health Check" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
					</div>
					<div class="p-6">
						<h3 class="font-bold text-lg mb-2">His Health Check (< 40 Years)</h3>
						<p class="text-sm text-gray-500 mb-4">Essential health screening for men.</p>
						<div class="flex justify-between items-center">
							<span class="font-bold text-imperial-primary">BDT 13,800</span>
							<button class="text-sm font-medium text-imperial-primary border border-imperial-primary px-4 py-1 rounded hover:bg-imperial-primary hover:text-white transition">Book</button>
						</div>
					</div>
				</div>
			</div>

			<div class="text-center mt-12">
				<a href="#" class="text-imperial-primary font-medium hover:underline">View All Packages</a>
			</div>
		</div>
	</section>

	<!-- FAQ Section -->
	<section class="py-16 bg-white">
		<div class="container mx-auto px-6 max-w-4xl">
			<h2 class="text-3xl font-bold text-center mb-8">Frequently Asked Questions</h2>
			<p class="text-center text-gray-500 mb-12">Take a look at most commonly asked questions. We are here to help.</p>
			
			<div class="space-y-4">
				<!-- Question 1 -->
				<div class="border border-gray-200 rounded-lg overflow-hidden faq-item">
					<button class="w-full flex justify-between items-center p-5 bg-gray-50 hover:bg-gray-100 transition text-left" onclick="toggleFaq(this)">
						<span class="font-semibold text-lg">What is a Health Check?</span>
						<i class="fa-solid fa-chevron-down text-imperial-primary faq-icon transition-transform duration-300"></i>
					</button>
					<div class="faq-content bg-white px-5">
						<div class="py-4 text-gray-600">
							A Health Check is a thorough check-up of your health, recommended once a year. Health checks can identify health problems you may not know you have, such as development of chronic conditions or if you are at risk of developing a chronic condition.
						</div>
					</div>
				</div>

				<!-- Question 2 -->
				<div class="border border-gray-200 rounded-lg overflow-hidden faq-item">
					<button class="w-full flex justify-between items-center p-5 bg-gray-50 hover:bg-gray-100 transition text-left" onclick="toggleFaq(this)">
						<span class="font-semibold text-lg">How does a health check help me?</span>
						<i class="fa-solid fa-chevron-down text-imperial-primary faq-icon transition-transform duration-300"></i>
					</button>
					<div class="faq-content bg-white px-5">
						<div class="py-4 text-gray-600">
							<p class="mb-2"><strong>Early detection of health problems:</strong> A health check can help identify potential issues when they are most treatable.</p>
							<p class="mb-2"><strong>Assessment of risk factors:</strong> Health checks can help assess your risk of developing certain health conditions based on factors such as your family history.</p>
							<p><strong>Preventive care:</strong> Health checks can provide an opportunity for preventive care, such as immunizations and screening tests.</p>
						</div>
					</div>
				</div>

				<!-- Question 3 -->
				<div class="border border-gray-200 rounded-lg overflow-hidden faq-item">
					<button class="w-full flex justify-between items-center p-5 bg-gray-50 hover:bg-gray-100 transition text-left" onclick="toggleFaq(this)">
						<span class="font-semibold text-lg">How will I receive my reports?</span>
						<i class="fa-solid fa-chevron-down text-imperial-primary faq-icon transition-transform duration-300"></i>
					</button>
					<div class="faq-content bg-white px-5">
						<div class="py-4 text-gray-600">
							Your reports will be delivered to you via imperial’s mobile app and also by email at the suggested time mentioned on your invoice.
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>
<?php require_once 'includes/footer.php'; ?>