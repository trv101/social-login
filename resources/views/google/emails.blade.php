<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8 text-center">
            Gmail Emails
        </h2>

        <div class="overflow-x-auto rounded-lg shadow-md">
            <table class="min-w-full text-sm text-left text-gray-700 bg-white border border-gray-200">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-medium">From</th>
                        <th class="px-6 py-4 font-medium">Subject</th>
                        <th class="px-6 py-4 font-medium">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($emails as $email)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">{{ $email['from'] }}</td>
                            <td class="px-6 py-4">{{ $email['subject'] }}</td>
                            <td class="px-6 py-4">{{ $email['date'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
