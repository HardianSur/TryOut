@extends('layouts.main')

@section('content')
    <section>
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                TryOut
            </a>
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                        Register
                    </h1>
                    <form class="form space-y-4 md:space-y-6">
                        <div>
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                name</label>
                            <input type="name" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="user@user.com" required="">
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Email</label>
                            <input type="email" name="email" id="email"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="user@user.com" required="">
                        </div>
                        <div class="relative">
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 pr-10 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required>
                            <button type="button" id="togglePassword"
                                class="absolute top-2/3 right-3 -translate-y-1/2 text-gray-500 dark:text-gray-400 cursor-pointer">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </div>
                        <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Kirim</button>
                        <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                            Belum memiliki akun? <a href="#"
                                class="font-medium text-primary-600 hover:underline dark:text-primary-500">Register</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            $('#togglePassword').on('click', function() {
                const passwordInput = $('#password');
                const icon = $(this).find('i');

                const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
                passwordInput.attr('type', type);

                icon.toggleClass('fa-eye fa-eye-slash');
            });

            $('.form').on('submit', function(e){
                e.preventDefault();
                console.log($('#password').val());

                $.ajax({
                    type: "POST",
                    url: "{{ config('app.base_api') }}/auth/register",
                    data: {
                        name: $('#name').val(),
                        email: $('#email').val(),
                        password: $('#password').val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Oops...",
                            text: "Berhasil Membuat Akun",
                        }).then(function(){
                            window.location.href = "{{ url('auth/login') }}";
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Email sudah terdaftar",
                        });
                    }
                });
            });
        });
    </script>
@endsection
