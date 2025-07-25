<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8 text-center">
            Google Calendar Events
        </h2>

        <div class="overflow-x-auto rounded-lg shadow-md">
            <table class="min-w-full text-sm text-left text-gray-700 bg-white border border-gray-200">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-medium">Event</th>
                        <th class="px-6 py-4 font-medium">Start</th>
                        <th class="px-6 py-4 font-medium">End</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($events as $event)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">{{ $event->getSummary() }}</td>
                            <td class="px-6 py-4">{{ $event->start->dateTime ?? $event->start->date }}</td>
                            <td class="px-6 py-4">{{ $event->end->dateTime ?? $event->end->date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
