<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('会員管理画面') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('players.create') }}">
                        <x-primary-button>
                            会員登録
                        </x-primary-button>
                    </a>

                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">会員ID</th>
                                <th class="py-2 px-4 border-b">姓</th>
                                <th class="py-2 px-4 border-b">名</th>
                                <th class="py-2 px-4 border-b">レート</th>
                                <th class="py-2 px-4 border-b">更新日</th>
                                <th class="py-2 px-4 border-b">登録日</th>
                                <th class="py-2 px-4 border-b">操作</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($players as $player)
                            <tr>
                                <td class="py-2 px-4 border-b">{{$player -> id}}</td>
                                <td class="py-2 px-4 border-b">{{$player -> first_name}}</td>
                                <td class="py-2 px-4 border-b">{{$player -> last_name}}</td>
                                <td class="py-2 px-4 border-b">{{$player -> rating}}</td>
                                <td class="py-2 px-4 border-b">{{$player -> created_at}}</td>
                                <td class="py-2 px-4 border-b">{{$player -> updated_at}}</td>
                                <!-- todo 二行分削除と更新のボタンを追加する、渡すのはIDを渡す  -->
                                <td>
                                    <a href="{{ route('players.create') }}">
                                        <x-primary-button>
                                            編集
                                        </x-primary-button>
                                    </a>
                                </td>
                                <td>
                                    <a href="{{ route('players.create') }}">
                                        <x-primary-button>
                                            出禁
                                        </x-primary-button>
                                    </a>
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
