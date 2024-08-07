<!-- resources/views/player/create.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('新規会員登録') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('player.store') }}">
                        @csrf

                        <!-- 姓 -->
                        <div class="mb-4">
                            <x-label for="last_name" :value="__('姓')" />
                            <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" required autofocus />
                        </div>

                        <!-- 名 -->
                        <div class="mb-4">
                            <x-label for="first_name" :value="__('名')" />
                            <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" required />
                        </div>

                        <!-- レーティング -->
                        <div class="mb-4">
                            <x-label for="rating" :value="__('レーティング')" />
                            <x-input id="rating" class="block mt-1 w-full" type="number" name="rating" required />
                        </div>

                        <!-- レーティング計算フラグ -->
                        <div class="mb-4">
                            <x-label for="calcrate_flag" :value="__('レーティング計算フラグ')" />
                            <select id="calcrate_flag" class="block mt-1 w-full" name="calcrate_flag">
                                <option value="0">{{ __('No') }}</option>
                                <option value="1">{{ __('Yes') }}</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>
                                {{ __('登録') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
