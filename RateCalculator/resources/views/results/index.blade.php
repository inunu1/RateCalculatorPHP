<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('対局管理画面') }}
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
                    <a href="{{ route('results.create') }}">
                        <x-primary-button>
                            対局登録
                        </x-primary-button>
                    </a>

                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">対局ID</th>
                                <th class="py-2 px-4 border-b">勝者</th>
                                <th class="py-2 px-4 border-b">敗者</th>
                                <th class="py-2 px-4 border-b">勝者レート</th>
                                <th class="py-2 px-4 border-b">敗者レート</th>
                                <th class="py-2 px-4 border-b">対局日時</th>
                                <th class="py-2 px-4 border-b">更新日</th>
                                <th class="py-2 px-4 border-b">登録日</th>
                                <th class="py-2 px-4 border-b">操作</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($results as $result)
                            <tr>
                                <td class="py-2 px-4 border-b">{{$result -> id}}</td>
                                <td class="py-2 px-4 border-b">{{$result -> first_name}}</td>
                                <td class="py-2 px-4 border-b">{{$result -> last_name}}</td>
                                <td class="py-2 px-4 border-b">{{$result -> rating}}</td>
                                <td class="py-2 px-4 border-b">{{$result -> created_at}}</td>
                                <td class="py-2 px-4 border-b">{{$result -> updated_at}}</td>
                                <!-- todo 二行分削除と更新のボタンを追加する、渡すのはIDを渡す  -->
                                <td>
                                    <form action="{{ route('players.edit',['id' => $player -> id]) }}" method="GET">
                                        <x-primary-button>
                                            編集
                                        </x-primary-button>
                                    </form>
                                </td>
                                <td>
                                    <form action="{{ route('players.delete',['id' => $player -> id]) }}" method="POST">
                                        @csrf
                                        <x-primary-button>
                                            出禁
                                        </x-primary-button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
