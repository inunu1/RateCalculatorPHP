<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('対局結果編集画面') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
 

    <form action="{{ route('results.update', $result->id) }}" method="POST">
                @csrf

                <!-- 勝者 -->
                <div class="mb-4">
                    <label for="" class="block text-sm font-medium text-gray-700 mb-1">勝者ID</label>
                    <input type="number" id="winner_id" name="winner_id" value="{{ old('winner_id', $result->winner_id) }}"
                           class="border border-gray-300 p-2 rounded px-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           min="1" step="1" required>
                </div>

                <!-- 敗者 -->
                <div class="mb-4">
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">敗者ID</label>
                    <input type="number" id="loser_id" name="loser_id" value="{{ old('loser_id', $result->loser_id) }}"
                           class="border border-gray-300 p-2 rounded px-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           min="1" step="1" required>
                </div>

                <!-- 対局日時 -->
                <div class="mb-4">
                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-1">対局日時</label>
                    <input type="datetime-local" id="game_date" name="game_date" value="{{ old('game_date', $result->game_date) }}"
                        class="border border-gray-300 p-2 rounded px-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- 登録ボタン -->
                <x-primary-button color="red">
                    登録
                </x-primary-button>
            </form>
    
</x-app-layout>
