<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Initialize New Project</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('projects.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Project Title</label>
                    <input type="text" name="title" class="w-full border-gray-300 rounded" placeholder="e.g. Q1 Website Redesign" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2">Description</label>
                    <textarea name="description" rows="4" class="w-full border-gray-300 rounded" placeholder="Briefly describe the project goals..."></textarea>
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded">
                    Save Project
                </button>
            </form>
        </div>
    </div>
</x-app-layout>
