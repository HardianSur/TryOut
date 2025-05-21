@extends('layouts.main')
{{-- @dd(session('quiz_answers')) --}}
@section('content')
    <div
        class="w-full p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 dark:bg-gray-800 dark:border-gray-700">
        <p class="mb-5 text-base text-gray-700 sm:text-lg dark:text-gray-400"><span
                class="font-bold">{{ $data['no_soal'] }}.</span> {!! $data['soal'] !!}
        <p>
        <ul class="grid w-full gap-6 md:grid-cols">
            @php
                $selectedAnswer = session('quiz_answers')[$data['id']] ?? null;
            @endphp

            @foreach ($data['tryout_question_option'] as $option)
                <li>
                    <input type="radio" id="option-{{ $option['id'] }}" name="option" value="{{ $option['id'] }}"
                        class="hidden peer answer-option " {{ $selectedAnswer == $option['id'] ? 'checked' : '' }}
                        data-question-id="{{ $data['id'] }}" required />
                    <label for="option-{{ $option['id'] }}"
                        class="inline-flex items-center w-full p-5 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer peer-checked:bg-gray-100 dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 dark:peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                        <div class="flex items-center">
                            <div class="text-lg font-semibold min-w-10 mr-4">{{ $option['inisial'] }}.</div>
                            <div class="text-lg">{!! $option['jawaban'] !!}</div>
                        </div>
                    </label>
                </li>
            @endforeach
        </ul>
        <div class="flex flex-col lg:flex-row lg:justify-between items-center gap-4 pt-4">
            <!-- Kiri: Tombol Previous dan Next -->
            <div class="flex justify-between w-full lg:w-auto space-x-4">
                @if ($data['no_soal'] != 1)
                    <a href="?page={{ $data['no_soal'] - 1 }}" id="prev"
                        class="flex items-center justify-center px-3 h-8 me-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 5H1m0 0 4 4M1 5l4-4" />
                        </svg>
                        Previous
                    </a>
                @endif
                @if ($data['no_soal'] < $count)
                    <a href="?page={{ $data['no_soal'] + 1 }}" id="next"
                        class="flex items-center justify-center px-3 h-8 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                        Next
                        <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </a>
                @endif
            </div>

            <!-- Tombol Selesai -->
            <div class="w-full lg:w-auto">
                <form action="{{ url('tryout/result') }}" method="post">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $data['id'] }}">
                    <input type="hidden" name="answer_id" id="answer_id" value="">
                    <input type="submit" value="Selesai"
                        class="cursor-pointer flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 rounded-lg dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 w-full lg:w-auto">
                </form>
            </div>

            <!-- Tombol Laporkan Soal -->
            <div class="w-full lg:w-auto">
                <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
                    class="flex items-center justify-center px-5 py-2.5 text-sm font-medium text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 rounded-lg dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 w-full lg:w-auto"
                    type="button">
                    Laporkan Soal
                </button>
            </div>

        </div>

        <div id="crud-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-md max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Laporkan Soal
                        </h3>
                        <button type="button" id="close"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-toggle="crud-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <form class="p-4 md:p-5 form">
                        <div class="grid gap-4 mb-4 grid-cols-2">
                            <div class="col-span-2">
                                <input type="hidden" id="question_id" value="{{ $data['id'] }}">
                                <label for="laporan"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi
                                    Masalah</label>
                                <textarea id="laporan" rows="4"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Kirim
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('.answer-option').on('change', function() {

                    let answerId = $(this).val();
                    let questionId = $(this).data('question-id');

                    let prevLink = $('#prev').attr('href');
                    let nextLink = $('#next').attr('href');
                    $('#answer_id').val(answerId);

                    if (prevLink) {
                        $('#prev').attr('href', updateUrlParam(prevLink, 'answer_id', answerId));
                        $('#prev').attr('href', updateUrlParam($('#prev').attr('href'), 'question_id',
                            questionId));
                    }

                    if (nextLink) {
                        $('#next').attr('href', updateUrlParam(nextLink, 'answer_id', answerId));
                        $('#next').attr('href', updateUrlParam($('#next').attr('href'), 'question_id',
                            questionId));
                    }
                });

                // Fungsi untuk update parameter URL
                function updateUrlParam(url, param, value) {
                    var re = new RegExp("([?&])" + param + "=.*?(&|$)", "i");
                    var separator = url.indexOf('?') !== -1 ? "&" : "?";
                    if (url.match(re)) {
                        return url.replace(re, '$1' + param + "=" + value + '$2');
                    } else {
                        return url + separator + param + "=" + value;
                    }
                }

                $('.form').on('submit', function(e) {
                    e.preventDefault();

                    $.ajax({
                        type: "POST",
                        url: "{{ config('app.base_api') }}/tryout/lapor-soal/create",
                        data: {
                            tryout_question_id: $('#question_id').val(),
                            laporan: $('#laporan').val(),
                        },
                        headers: {
                            'Authorization': 'Bearer {{ session('access_token') }}'
                        },
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                icon: "success",
                                title: "Berhasil Terkirim",
                            }).then(function() {
                                $("#close").click();
                            });
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Terjadi Kesalahan",
                            });
                        }
                    });
                });
            });
        </script>
    @endsection
