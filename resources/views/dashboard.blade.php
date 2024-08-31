<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="container-fluid p-4">
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="certificate_numbers" class="form-label">Certificate Numbers</label>
                            <textarea class="form-control" name="certificate_numbers"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <label for="filename" class="form-label">Filename</label>
                            <input type="text" class="form-control" name="filename">
                        </div>
                        <div class="col-4 align-items-end">
                            <button class="btn btn-lg w-100 bg-primary text-white">Scrape</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
