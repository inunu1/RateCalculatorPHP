<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('players.index') }}">
                        <x-primary-button>
                            会員管理
                        </x-primary-button>
                    </a>

                    <a href="{{ route('results.index') }}">
                        <x-primary-button>
                            対局管理
                        </x-primary-button>
                    </a>

                    <a href="{{ route('calcrate.index') }}">
                        <x-primary-button>
                            レーティング計算
                        </x-primary-button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
