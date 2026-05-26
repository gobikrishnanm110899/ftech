<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - {{ config('app.name', 'ftech') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[#fff8f1] text-zinc-950">
    <main class="mx-auto flex min-h-screen max-w-6xl items-center justify-center p-6">
        <div class="w-full max-w-md rounded-lg bg-white p-8 shadow-sm ring-1 ring-orange-100">
            <div class="text-center">
                <div class="text-sm font-medium text-orange-700">Admin Panel</div>
                <h1 class="mt-2 text-2xl font-semibold">Sign in</h1>
                <!-- <p class="mt-2 text-sm text-zinc-600">
                    Use <span class="font-medium">admin@admin.com</span> / <span class="font-medium">12341234</span>
                </p> -->
            </div>

            @if ($errors->any())
                <div class="mt-6 rounded-lg border border-orange-200 bg-orange-50 p-4 text-sm text-orange-800">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="mt-6 space-y-4">
                @csrf

                <div>
                    <label class="text-sm font-medium text-slate-700">Email</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', 'admin@admin.com') }}"
                        required
                        autofocus
                        class="mt-2 w-full rounded-md border border-orange-200 bg-white px-4 py-2.5 text-sm outline-none ring-orange-100 focus:ring-4"
                    />
                </div>

                <div>
                    <label class="text-sm font-medium text-slate-700">Password</label>
                    <input
                        type="password"
                        name="password"
                        value="12341234"
                        required
                        class="mt-2 w-full rounded-md border border-orange-200 bg-white px-4 py-2.5 text-sm outline-none ring-orange-100 focus:ring-4"
                    />
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-slate-900">
                    Remember me
                </label>

                <button
                    type="submit"
                    class="w-full rounded-md bg-orange-600 px-4 py-2.5 text-sm font-medium text-white hover:bg-orange-700"
                >
                    Login
                </button>
            </form>

            <p class="mt-6 text-center text-xs text-slate-500">
                © {{ date('Y') }} {{ config('app.name', 'ftech') }}
            </p>
        </div>
    </main>
</body>
</html>
