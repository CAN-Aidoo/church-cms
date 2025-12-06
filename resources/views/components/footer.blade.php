<footer class="bg-white border-t border-gray-200 py-4 px-6">
    <div class="flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="text-sm text-gray-600">
            &copy; {{ date('Y') }} {{ config('church.name', config('app.name')) }}. All rights reserved.
        </div>

        <div class="flex items-center gap-6 text-sm text-gray-600">
            <a href="#" class="hover:text-primary-600 transition-colors">Help</a>
            <a href="#" class="hover:text-primary-600 transition-colors">Privacy Policy</a>
            <a href="#" class="hover:text-primary-600 transition-colors">Terms of Service</a>
        </div>

        <div class="text-sm text-gray-500">
            Version 1.0.0
        </div>
    </div>
</footer>
