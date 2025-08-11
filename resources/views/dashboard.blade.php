<x-app-layout>
    <div class="max-w-7xl mx-auto px-6 py-10 space-y-8">
        <div class="text-center space-y-1">
            <h2 class="text-3xl font-semibold text-gray-900 dark:text-gray-100">
                Welcome, {{ Auth::user()->name }}
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Here’s a quick snapshot of your day.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- ==================== Events ==================== --}}
            <div class="rounded-2xl border border-gray-200/70 dark:border-gray-700 bg-white/80 dark:bg-gray-900/60 shadow-sm backdrop-blur">
                <div class="flex items-center justify-between px-6 pt-6 pb-3">
                    <div class="flex items-center gap-2">
                        {{-- Calendar icon --}}
                        <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/>
                        </svg>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100">Upcoming Events</h3>
                    </div>
                    <a href="{{ url('/calendar') }}"
                       class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-indigo-200/70 dark:border-indigo-700 text-indigo-700 dark:text-indigo-300 hover:bg-indigo-50 dark:hover:bg-indigo-900/40 transition">
                        View All
                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M7.293 14.707a1 1 0 010-1.414L9.586 11H4a1 1 0 110-2h5.586L7.293 6.707a1 1 0 111.414-1.414l4.999 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"/>
                        </svg>
                    </a>
                </div>

                <ul class="px-6 pb-6 space-y-4">
                    @forelse($events->take(3) as $event)
                        @php
                            $start = $event->start->dateTime ?? $event->start->date ?? null;
                            $isAllDay = isset($event->start->date) && empty($event->start->dateTime);
                            $date = $start ? \Carbon\Carbon::parse($start) : null;
                        @endphp
                        <li class="group rounded-xl border border-gray-100 dark:border-gray-800 p-4 hover:shadow-sm transition overflow-hidden">
                            <div class="flex items-start gap-3">
                                {{-- Date pill --}}
                                <div class="shrink-0 text-center px-2.5 py-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-900/50">
                                    <div class="text-[10px] uppercase tracking-wider text-indigo-700 dark:text-indigo-300">
                                        {{ $date?->format('D') ?? '—' }}
                                    </div>
                                    <div class="text-sm font-semibold text-indigo-800 dark:text-indigo-200">
                                        {{ $date?->format('d') ?? '—' }}
                                    </div>
                                </div>

                                <div class="min-w-0">
                                    <div class="font-medium text-gray-900 dark:text-gray-100 truncate">
                                        {{ $event->getSummary() ?? 'Untitled event' }}
                                    </div>
                                    <div class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                        @if($date)
                                            {{ $date->format('M j') }}
                                            @unless($isAllDay)
                                                • {{ $date->format('h:i A') }}
                                            @else
                                                • All day
                                            @endunless
                                        @else
                                            —
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="rounded-xl border border-dashed border-gray-300 dark:border-gray-700 p-6 text-center text-sm text-gray-500 dark:text-gray-400">
                            No upcoming events.
                        </li>
                    @endforelse
                </ul>
            </div>

            {{-- ==================== Emails ==================== --}}
            <div class="rounded-2xl border border-gray-200/70 dark:border-gray-700 bg-white/80 dark:bg-gray-900/60 shadow-sm backdrop-blur">
                <div class="flex items-center justify-between px-6 pt-6 pb-3">
                    <div class="flex items-center gap-2">
                        {{-- Mail icon --}}
                        <svg class="w-5 h-5 text-sky-600 dark:text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100">Recent Emails</h3>
                    </div>
                    <a href="{{ url('/emails') }}"
                       class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-sky-200/70 dark:border-sky-700 text-sky-700 dark:text-sky-300 hover:bg-sky-50 dark:hover:bg-sky-900/40 transition">
                        View All
                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor"><path d="M7.293 14.707a1 1 0 010-1.414L9.586 11H4a1 1 0 110-2h5.586L7.293 6.707a1 1 0 111.414-1.414l4.999 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"/></svg>
                    </a>
                </div>

                <ul class="px-6 pb-6 space-y-4">
                    @forelse($emails->take(3) as $email)
                        @php
                            $from = $email['from'] ?? 'Unknown';
                            $initial = strtoupper(mb_substr(strip_tags($from), 0, 1));
                        @endphp
                        <li class="group rounded-xl border border-gray-100 dark:border-gray-800 p-4 hover:shadow-sm transition">
                            <div class="flex items-start gap-3">
                                {{-- Avatar bubble --}}
                                <div class="shrink-0 w-9 h-9 rounded-full grid place-items-center text-sm font-semibold bg-sky-50 text-sky-700 dark:bg-sky-900/50 dark:text-sky-200">
                                    {{ $initial }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-gray-900 dark:text-gray-100 font-medium truncate">{{ $from }}</div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300 truncate">{{ $email['subject'] ?? '(no subject)' }}</div>
                                    <div class="mt-0.5 text-xs text-gray-400">{{ $email['date'] ?? '' }}</div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="rounded-xl border border-dashed border-gray-300 dark:border-gray-700 p-6 text-center text-sm text-gray-500 dark:text-gray-400">
                            No recent emails.
                        </li>
                    @endforelse
                </ul>
            </div>

            {{-- ==================== Tasks ==================== --}}
            <div class="rounded-2xl border border-gray-200/70 dark:border-gray-700 bg-white/80 dark:bg-gray-900/60 shadow-sm backdrop-blur">
                <div class="flex items-center justify-between px-6 pt-6 pb-3">
                    <div class="flex items-center gap-2">
                        {{-- Check icon --}}
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-base font-semibold text-gray-800 dark:text-gray-100">Tasks</h3>
                    </div>
                    <a href="{{ url('/todos') }}"
                       class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1.5 rounded-lg border border-emerald-200/70 dark:border-emerald-700 text-emerald-700 dark:text-emerald-300 hover:bg-emerald-50 dark:hover:bg-emerald-900/40 transition">
                        View All
                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor"><path d="M7.293 14.707a1 1 0 010-1.414L9.586 11H4a1 1 0 110-2h5.586L7.293 6.707a1 1 0 111.414-1.414l4.999 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0z"/></svg>
                    </a>
                </div>

                <ul class="px-6 pb-6 space-y-4">
                    @forelse($todos->take(3) as $todo)
                        @php
                            $isDone = ($todo['status'] ?? '') === 'completed';
                            $dueStr = $todo['due'] ?? null;
                            $dueHuman = $dueStr ? \Carbon\Carbon::parse($dueStr)->diffForHumans(now(), ['parts' => 2, 'short' => true]) : null;
                        @endphp
                        <li class="group rounded-xl border border-gray-100 dark:border-gray-800 p-4 hover:shadow-sm transition">
                            <div class="flex items-start gap-3">
                                <div class="shrink-0 mt-0.5">
                                    <span class="inline-flex w-5 h-5 rounded-md border {{ $isDone ? 'border-emerald-400 bg-emerald-50 dark:bg-emerald-900/40' : 'border-yellow-400 bg-yellow-50 dark:bg-yellow-900/30' }} items-center justify-center">
                                        @if($isDone)
                                            <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-300" viewBox="0 0 20 20" fill="currentColor"><path d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 5.707 10.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l8-8a1 1 0 000-1.414z"/></svg>
                                        @else
                                            <svg class="w-3.5 h-3.5 text-yellow-600 dark:text-yellow-300" viewBox="0 0 20 20" fill="currentColor"><path d="M10 3a1 1 0 011 1v5h3a1 1 0 110 2h-4a1 1 0 01-1-1V4a1 1 0 011-1z"/></svg>
                                        @endif
                                    </span>
                                </div>
                                <div class="min-w-0">
                                    <div class="font-medium text-gray-900 dark:text-gray-100 truncate">{{ $todo['title'] }}</div>
                                    <div class="mt-0.5 text-xs text-gray-500 dark:text-gray-400">
                                        Due: {{ $todo['due'] ?? 'N/A' }}
                                        @if($dueHuman)
                                            • <span class="{{ $isDone ? 'text-emerald-600 dark:text-emerald-400' : 'text-yellow-600 dark:text-yellow-400' }}">
                                                {{ $isDone ? 'done' : $dueHuman }}
                                            </span>
                                        @endif
                                    </div>
                                    <span class="mt-1 inline-block px-2 py-0.5 text-[11px] font-semibold rounded-full
                                        {{ $isDone ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' }}">
                                        {{ ucfirst($todo['status']) }}
                                    </span>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="rounded-xl border border-dashed border-gray-300 dark:border-gray-700 p-6 text-center text-sm text-gray-500 dark:text-gray-400">
                            No tasks found.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
