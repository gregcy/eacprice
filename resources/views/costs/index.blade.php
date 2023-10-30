<x-app-layout>
    <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
        <a class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-4" href="{{ route('costs.create') }}">{{ __('Add new') }}</a>
        <div class="mt-6 bg-transparent shadow-sm rounded-lg divide-y space-y-4">
            @foreach ($costs as $cost)
                <div class="p-6 bg-white flex space-y-2">
                    <div class="flex-1">
                        <div class="pb-2 flex justify-between items-center">
                            <div>
                                <span class="text-gray-800 font-bold text-lg"> {{ __($cost->name) }}</span>
                            </div>
                            <div>
                                <svg class="inline w-[19px] h-[19px] text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1v3m5-3v3m5-3v3M1 7h18M5 11h10M2 3h16a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1Z"/>
                                </svg>
                                @if ($cost->end_date == null || $cost->end_date == 0 )
                                        {{ date('d/m/Y', strtotime($cost->start_date)) }} - {{ __('Present') }}
                                    @else
                                        {{ date('d/m/Y', strtotime($cost->start_date)) }} - {{ date('d/m/Y', strtotime($cost->end_date)) }}
                                    @endif
                            </div>
                            @if ($cost->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('costs.edit', $cost)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('costs.destroy', $cost) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('costs.destroy', $cost)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                        <div class="flex justify-between items-start">
                            <table>
                                <tr>
                                    <td colspan="2" class="text-grey-800 font-bold pb-1">{{ __('Value') }}</td>
                                </tr>
                                <tr>
                                    <td class="text-grey-800 font-bold">{{ $cost->prefix . $cost->value . $cost->suffix }}</td>
                            </table>
                        </div>
                        <div>
                            <a href="{{ $cost->source }}" target="_blank" class="text-blue-800 font-bold text-lg">{{ __($cost->source_name ) }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
