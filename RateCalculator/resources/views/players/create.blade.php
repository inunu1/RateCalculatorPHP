<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('会員登録画面') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
 

    <form action="{{ route('player.store') }}" method="POST">
                @csrf

                <!-- 姓 -->
                <div class="mb-4">
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">姓</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}"
                           class="border border-gray-300 p-2 rounded px-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <!-- 名 -->
                <div class="mb-4">
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">名</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}"
                           class="border border-gray-300 p-2 rounded px-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <!-- レーティング -->
                <div class="mb-4">
                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">レーティング</label>
                    <input type="number" id="rating" name="rating" value="{{ old('rating') }}"
                           class="border border-gray-300 p-2 rounded px-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <!-- 登録ボタン -->
                <x-primary-button color="red">
                    登録
                </x-primary-button>
            </form>
    
</x-app-layout>
