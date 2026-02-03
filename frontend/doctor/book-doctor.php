<?php require_once '../includes/header.php'; ?>

<!-- Main Content Start -->
<main class="min-h-screen bg-gray-50 font-sans text-imperial-text pb-20">

    <!-- Breadcrumbs -->
    <section class="bg-white border-b border-gray-200 py-3">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-sm text-gray-500">
                <a href="/" class="hover:text-imperial-primary transition">Home</a>
                <span class="mx-2 text-gray-400">/</span>
                <a href="/our-doctors" class="hover:text-imperial-primary transition">Praava Doctors</a>
                <span class="mx-2 text-gray-400">/</span>
                <span class="text-gray-900 font-medium">Dr. Ahmed Farukh</span>
            </nav>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- LEFT COLUMN: Doctor Profile (Spans 8 on large screens) -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Profile Header Card -->
                <div class="bg-white rounded-xl shadow-sm p-6 md:p-8 border border-gray-100">
                    <div class="flex flex-col md:flex-row gap-8">
                        <!-- Doctor Image -->
                        <div class="w-full md:w-48 flex-shrink-0 mx-auto md:mx-0">
                            <img src="https://www.praavahealth.com/media-images/S5vvz8VMrp494ay1xlabYZhcFUg=/70/fill-500x666-c0/Dr._Ahmed_Farukh.png" 
                                 alt="Dr. Ahmed Farukh" 
                                 class="w-full h-auto rounded-lg object-cover shadow-md bg-gray-100">
                        </div>

                        <!-- Doctor Info -->
                        <div class="flex-1 text-center md:text-left">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Dr. Ahmed Farukh</h1>
                            <p class="text-lg text-imperial-primary font-medium mb-6">Consultant - Energetic medicine & acupuncture</p>

                            <!-- Info Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-4 gap-x-6 mb-6">
                                <div>
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Specialities</h4>
                                    <p class="text-gray-800 font-medium">Acupuncture</p>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Qualification</h4>
                                    <p class="text-gray-800 font-medium">MBBS (RMC)</p>
                                </div>
                                <div class="sm:col-span-2 md:col-span-2 lg:col-span-1">
                                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Consultation Fee</h4>
                                    <p class="text-xl font-bold text-imperial-primary">৳ 1200</p>
                                </div>
                            </div>

                            <hr class="border-gray-100 my-6 hidden md:block">

                            <!-- Description -->
                            <div class="prose max-w-none text-gray-600 text-sm leading-relaxed">
                                <p>Dr. Ahmed Farukh completed his MBBS from RMC and is a bio-energetic medicine specialist. He has over 21 years of experience including working at Health Complex, Mitford Hospital, and as a Resident Medical Officer in hospitals under the Ministry of Health, Saudi Arabia. Over the course of his career, Dr. Ahmed attended several training sessions at home and abroad in Germany, Switzerland, Singapore, and Bangkok.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Appointment Schedule & Time Selection -->
                <div class="bg-white rounded-xl shadow-sm p-6 md:p-8 border border-gray-100">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <i class="fa-regular fa-calendar-check text-imperial-primary"></i> 
                        Select Schedule
                    </h3>

                    <!-- Type Toggle (In Hub / Online) -->
                    <div class="flex items-center gap-6 mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="appt_type" value="hub" checked class="w-4 h-4 text-imperial-primary focus:ring-imperial-primary border-gray-300">
                            <span class="font-medium text-gray-700">In Hub</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="appt_type" value="online" class="w-4 h-4 text-imperial-primary focus:ring-imperial-primary border-gray-300">
                            <span class="font-medium text-gray-700">Online Consultation</span>
                        </label>
                    </div>

                    <!-- Date Grid -->
                    <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Available Dates</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                        
                        <!-- Date Card 1 -->
                        <div class="border rounded-lg p-4 hover:border-imperial-primary hover:bg-blue-50 transition cursor-pointer flex justify-between items-center relative group selected-date">
                            <div>
                                <div class="text-xs text-gray-500 font-medium">Thu</div>
                                <div class="text-lg font-bold text-gray-900">22 Jan</div>
                            </div>
                            <div class="text-sm font-bold text-imperial-primary">16:00-19:59</div>
                            <!-- Hidden radio for logic -->
                            <input type="radio" name="appointment_slot" class="absolute opacity-0 w-full h-full top-0 left-0 cursor-pointer" checked>
                        </div>

                        <!-- Date Card 2 -->
                        <div class="border rounded-lg p-4 hover:border-imperial-primary hover:bg-blue-50 transition cursor-pointer flex justify-between items-center relative group">
                            <div>
                                <div class="text-xs text-gray-500 font-medium">Fri</div>
                                <div class="text-lg font-bold text-gray-900">23 Jan</div>
                            </div>
                            <div class="text-sm font-bold text-imperial-primary">16:00-19:59</div>
                            <input type="radio" name="appointment_slot" class="absolute opacity-0 w-full h-full top-0 left-0 cursor-pointer">
                        </div>

                        <!-- Date Card 3 -->
                        <div class="border rounded-lg p-4 hover:border-imperial-primary hover:bg-blue-50 transition cursor-pointer flex justify-between items-center relative group">
                            <div>
                                <div class="text-xs text-gray-500 font-medium">Sat</div>
                                <div class="text-lg font-bold text-gray-900">24 Jan</div>
                            </div>
                            <div class="text-sm font-bold text-imperial-primary">16:00-19:59</div>
                            <input type="radio" name="appointment_slot" class="absolute opacity-0 w-full h-full top-0 left-0 cursor-pointer">
                        </div>

                        <!-- Date Card 4 -->
                        <div class="border rounded-lg p-4 hover:border-imperial-primary hover:bg-blue-50 transition cursor-pointer flex justify-between items-center relative group">
                            <div>
                                <div class="text-xs text-gray-500 font-medium">Sun</div>
                                <div class="text-lg font-bold text-gray-900">25 Jan</div>
                            </div>
                            <div class="text-sm font-bold text-imperial-primary">12:00-15:59</div>
                            <input type="radio" name="appointment_slot" class="absolute opacity-0 w-full h-full top-0 left-0 cursor-pointer">
                        </div>

                         <!-- Date Card 5 -->
                         <div class="border rounded-lg p-4 hover:border-imperial-primary hover:bg-blue-50 transition cursor-pointer flex justify-between items-center relative group">
                            <div>
                                <div class="text-xs text-gray-500 font-medium">Mon</div>
                                <div class="text-lg font-bold text-gray-900">26 Jan</div>
                            </div>
                            <div class="text-sm font-bold text-imperial-primary">16:00-19:59</div>
                            <input type="radio" name="appointment_slot" class="absolute opacity-0 w-full h-full top-0 left-0 cursor-pointer">
                        </div>

                         <!-- Date Card 6 -->
                         <div class="border rounded-lg p-4 hover:border-imperial-primary hover:bg-blue-50 transition cursor-pointer flex justify-between items-center relative group">
                            <div>
                                <div class="text-xs text-gray-500 font-medium">Tue</div>
                                <div class="text-lg font-bold text-gray-900">27 Jan</div>
                            </div>
                            <div class="text-sm font-bold text-imperial-primary">16:00-19:59</div>
                            <input type="radio" name="appointment_slot" class="absolute opacity-0 w-full h-full top-0 left-0 cursor-pointer">
                        </div>

                    </div>
                    
                    <!-- Disclaimer Note -->
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fa-solid fa-circle-exclamation text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Thank you for choosing our services! Please note, requests do not guarantee a confirmed appointment. Our contact center will reach out to you shortly to confirm your booking and appointment time slot. For any urgent assistance, please call <strong>10648</strong>.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- RIGHT COLUMN: Booking Summary & Action (Spans 4 on large screens, Sticky) -->
            <div class="lg:col-span-4">
                <div class="sticky top-24 space-y-6">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900 mb-4 border-b pb-2">Booking Summary</h3>
                            
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Doctor</span>
                                    <span class="font-medium text-gray-900">Dr. Ahmed Farukh</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Speciality</span>
                                    <span class="font-medium text-gray-900">Acupuncture</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Type</span>
                                    <span class="font-medium text-imperial-primary" id="summary-type">In Hub</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Date</span>
                                    <span class="font-medium text-gray-900" id="summary-date">22 Jan (Thu)</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Time</span>
                                    <span class="font-medium text-gray-900" id="summary-time">16:00-19:59</span>
                                </div>
                                <div class="border-t my-2 pt-2 flex justify-between items-center">
                                    <span class="text-gray-900 font-bold">Total Fee</span>
                                    <span class="text-xl font-bold text-imperial-primary">৳ 1200</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="px-6 pb-6">
                            <button type="button" onclick="alert('Proceeding to payment/confirmation...')" class="w-full bg-imperial-primary hover:bg-blue-700 text-white font-bold py-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center gap-2 text-lg">
                                <span>Book Appointment</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</main>
<!-- Main Content End -->

<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        // --- 1. Handle Appointment Type Selection ---
        const typeRadios = document.querySelectorAll('input[name="appt_type"]');
        const summaryType = document.getElementById('summary-type');

        typeRadios.forEach(radio => {
            radio.addEventListener('change', (e) => {
                if(summaryType) {
                    summaryType.textContent = e.target.value === 'hub' ? 'In Hub' : 'Online Consultation';
                }
            });
        });

        // --- 2. Handle Date/Time Selection ---
        const slotCards = document.querySelectorAll('input[name="appointment_slot"]');
        const summaryDate = document.getElementById('summary-date');
        const summaryTime = document.getElementById('summary-time');

        slotCards.forEach(radio => {
            radio.addEventListener('change', (e) => {
                // Remove active styling from all cards
                slotCards.forEach(r => {
                    const card = r.closest('div.border'); // Find parent card
                    card.classList.remove('border-imperial-primary', 'bg-blue-50');
                    card.classList.add('border-gray-200'); // Reset border (optional)
                });

                // Add active styling to selected card
                const selectedCard = e.target.closest('div.border');
                selectedCard.classList.add('border-imperial-primary', 'bg-blue-50');
                selectedCard.classList.remove('border-gray-200');

                // Update Summary Panel
                const textContent = selectedCard.querySelector('.text-lg').textContent + " (" + selectedCard.querySelector('.text-xs').textContent + ")";
                const timeText = selectedCard.querySelector('.text-imperial-primary').textContent;
                
                if(summaryDate) summaryDate.textContent = textContent;
                if(summaryTime) summaryTime.textContent = timeText;
            });
        });

        // Initialize first selection visual state
        const defaultRadio = document.querySelector('input[name="appointment_slot"]:checked');
        if(defaultRadio) {
            defaultRadio.dispatchEvent(new Event('change'));
        }
    });
</script>

<?php require_once '../includes/footer.php'; ?>