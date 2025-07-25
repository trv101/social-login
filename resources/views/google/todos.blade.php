<x-app-layout>
    <div class="max-w-6xl mx-auto px-6 py-10">
        <h2 class="text-3xl font-semibold text-gray-800 mb-8 text-center">
            Google ToDos
        </h2>

        <div class="overflow-x-auto rounded-lg shadow-md">
            <table class="min-w-full text-sm text-left text-gray-700 bg-white border border-gray-200">
                <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-4 font-medium">Task</th>
                        <th class="px-6 py-4 font-medium">Due Date</th>
                        <th class="px-6 py-4 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($todos as $todo)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">{{ $todo['title'] }}</td>
                            <td class="px-6 py-4">{{ $todo['due'] }}</td>
                            <td class="px-6 py-4">
                                @if ($todo['status'] === 'completed')
                                    <span class="inline-block px-3 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full">
                                        Completed
                                    </span>
                                @else
                                    <span class="inline-block px-3 py-1 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-full">
                                        Pending
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
