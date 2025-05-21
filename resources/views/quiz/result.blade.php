@extends('layouts.main')

@section('content')
    <section class="py-16 px-4 flex justify-center items-center">
        <div class="p-6 w-full max-w-md">
            <div
                class="flex flex-col p-6 text-center text-gray-900 bg-white rounded-lg border border-gray-100 shadow dark:border-gray-600 dark:bg-gray-800 dark:text-white">
                <h3 class="mb-4 text-2xl font-semibold">Hasil TryOut</h3>

                <div class="border-b border-gray-300 dark:border-gray-600 mb-6 pb-6">
                    <div class="text-6xl font-extrabold italic"> {{ $totalScore }} </div>
                </div>

                <a href="{{ url('/') }}"
                    class="text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:ring-primary-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:focus:ring-primary-900">
                    Kembali
                </a>
            </div>
        </div>
    </section>
@endsection
