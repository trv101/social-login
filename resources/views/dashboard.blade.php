<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-10">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8 text-center">
            Welcome, {{ Auth::user()->name }}
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Calendar -->
            <a href="{{ url('/calendar') }}" class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 p-6 text-center">
                <div class="text-4xl mb-3">📅</div>
                <div class="text-xl font-semibold text-gray-700 mb-1">Google Calendar</div>
                <p class="text-sm text-gray-500">View your upcoming events and meetings.</p>
            </a>

            <!-- Emails -->
            <a href="{{ url('/emails') }}" class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 p-6 text-center">
                <div class="text-4xl mb-3">📧</div>
                <div class="text-xl font-semibold text-gray-700 mb-1">Gmail Emails</div>
                <p class="text-sm text-gray-500">Check your latest emails directly.</p>
            </a>

            <!-- ToDos -->
            <a href="{{ url('/todos') }}" class="bg-white border border-gray-200 rounded-2xl shadow-sm hover:shadow-md transition-all duration-200 p-6 text-center">
                <div class="text-4xl mb-3">✅</div>
                <div class="text-xl font-semibold text-gray-700 mb-1">Google To-Dos</div>
                <p class="text-sm text-gray-500">Stay on top of your tasks and lists.</p>
            </a>
        </div>
    </div>
</x-app-layout>
