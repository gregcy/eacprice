<x-app-layout>
    <div class="max-w-3xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('costs.store') }}">
            @csrf
            <label for="name">{{ __('Name') }}</label>
            <input type="text"
                name="name"
                value = "{{ old('name') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            <label for="start_date">{{ __('Start Date') }}</label>
            <input type="date"
                name="start_date"
                value = "{{ old('start_date') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            />
            <label for="end_date">{{ __('End Date') }}</label>
            <input type="date"
                name="end_date"
                value = "{{ old('end_date') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            />
            <label for="prefix">{{ __('Prefix') }}</label>
            <input type="text"
                name="prefix"
                value = "{{ old('prefix') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            <label for="suffix">{{ __('Suffix') }}</label>
            <input type="text"
                name="suffix"
                value = "{{ old('suffix') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            <label for="code">{{ __('Tariff Code') }}</label>
            <select name="code"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <option value="">{{ __('None') }}</option>
                <option value="01">{{ __('01 - Single Rate Domestic Use') }}</option>
                <option value="02">{{ __('02 - Two Rate Domestic Use') }}</option>
                <option value="08">{{ __('08 - Special for Vulnerable Customers') }}</option>
            </select>
            <label for="value">{{ __('Value') }}</label>
            <input type="number"
                name="value"
                step = "0.00000001"
                min="0"
                placeholder="0.00000000"
                value = "{{ old('value') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                >
            <div class="flex w-full pb-1 pt-4">
                <label for="source" class="inline w-32 align-middle pt-2.5 pr-2.5">{{ __('Source:') }}</label>
                <input type="text"
                    name="source"
                    value="{{ old('source') }}"
                    class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    />
            </div>
            <div class="flex w-full pb-1 pt-4">
                <label for="source_name" class="inline w-32 align-middle pt-2.5 pr-2.5">{{ __('Source Name:') }}</label>
                <input type="text"
                    name="source_name"
                    value="{{ old('source_name') }}"
                    class="inline-block grow border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    />
            </div>
            @if ($errors->any())
                <div class="block p-2 text-red-800 bg-opacity-30 bg-red-300 w-full border-red-500 focus:border-red-700 focus:ring focus:ring-red-300 focus:ring-opacity-50 rounded-md shadow-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <x-primary-button class="mt-4">{{ __('Save') }}</x-primary-button>
        </form>
    </div>
</x-app-layout>
