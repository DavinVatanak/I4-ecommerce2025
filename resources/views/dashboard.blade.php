<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Project Management Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 shadow-sm">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Welcome, {{ Auth::user()->name }}!</h3>

                    <hr class="mb-6">

                    @can('projects.create')
                        <div class="mb-8 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-blue-700 font-bold">Manager Tools</p>
                                    <p class="text-sm text-blue-600">You have permission to initialize new tracker projects.</p>
                                </div>
                                <a href="{{ route('projects.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition shadow-md">
                                    + Create New Project
                                </a>
                            </div>
                        </div>
                    @endcan

                    <div class="mt-6">
                        <h4 class="font-semibold text-gray-700 mb-4 border-b pb-2">Task Assignments</h4>
                        <div class="space-y-4">
                            @php $hasVisibleTasks = false; @endphp

                            {{-- Loop through all tasks; the Policy handles visibility per user --}}
                            @foreach(App\Models\Task::with(['project', 'user'])->get() as $task)
                                @can('view', $task)
                                    @php $hasVisibleTasks = true; @endphp
                                    <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $task->title }}</p>
                                            <p class="text-xs text-gray-500">Project: {{ $task->project->title }}</p>

                                            {{-- Managers and Admins see who the task is assigned to --}}
                                            @if(Auth::user()->hasRole('manager') || Auth::user()->hasRole('admin'))
                                                <p class="text-xs text-blue-500 mt-1">Assigned to: {{ $task->user->name }}</p>
                                            @endif
                                        </div>

                                        <div class="flex items-center gap-4">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $task->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                                {{ ucfirst($task->status) }}
                                            </span>

                                            {{-- Only Staff assigned to the task see the 'Mark Done' button --}}
                                            @can('updateStatus', $task)
                                                @if($task->status !== 'completed')
                                                    <form action="{{ route('tasks.updateStatus', $task) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white text-xs font-bold py-1 px-3 rounded transition shadow-sm">
                                                            Mark Done
                                                        </button>
                                                    </form>
                                                @endif
                                            @endcan
                                        </div>
                                    </div>
                                @endcan
                            @endforeach

                            @if(!$hasVisibleTasks)
                                <div class="p-4 bg-gray-50 rounded border border-dashed border-gray-300">
                                    <p class="text-gray-500 text-sm italic text-center">No tasks are currently assigned to you or your projects.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if(Auth::user()->hasRole('admin'))
                        <div class="mt-12 p-4 bg-red-50 border border-red-200 rounded-lg shadow-sm">
                            <p class="text-red-700 font-bold text-sm uppercase tracking-wider">Admin Console</p>
                            <p class="text-xs text-red-600 mb-3">System-wide management restricted to Administrators.</p>
                            <button class="text-sm bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition shadow">
                                Manage System Users
                            </button>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
