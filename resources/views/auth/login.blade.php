@extends('layouts.app')

@section('title', 'Log in — '.$siteTitle)

@section('content')
    <div class="mx-auto grid max-w-5xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-2 lg:items-center lg:py-20">
        <div class="hidden lg:block">
            <div class="relative overflow-hidden rounded-3xl bg-ink p-10 text-white">
                <div class="absolute -right-16 -top-16 size-64 rounded-full bg-indigo-500/30 blur-3xl"></div>
                <div class="absolute -bottom-20 -left-10 size-56 rounded-full bg-rose-500/20 blur-3xl"></div>

                <div class="relative">
                    <span class="grid size-12 place-items-center rounded-2xl bg-white/10 font-serif text-2xl backdrop-blur">W</span>
                    <h1 class="mt-8 font-serif text-4xl leading-tight tracking-tight">
                        Welcome back to<br>{{ $siteTitle }}.
                    </h1>
                    <p class="mt-4 text-sm leading-relaxed text-stone-300">
                        Sign in to write posts, manage categories and moderate the conversation.
                    </p>

                    <div class="mt-10 rounded-2xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                        <p class="text-[11px] font-semibold uppercase tracking-[0.18em] text-stone-400">Demo account</p>
                        <dl class="mt-3 space-y-1.5 text-sm">
                            <div class="flex justify-between gap-4">
                                <dt class="text-stone-400">Email</dt>
                                <dd class="font-mono text-xs text-white">admin@example.com</dd>
                            </div>
                            <div class="flex justify-between gap-4">
                                <dt class="text-stone-400">Password</dt>
                                <dd class="font-mono text-xs text-white">password</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-auto w-full max-w-md">
            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="lg:hidden">
                    <span class="grid size-11 place-items-center rounded-xl bg-indigo-600 font-serif text-2xl text-white">W</span>
                </div>
                <h2 class="mt-4 font-serif text-3xl tracking-tight text-ink lg:mt-0">Log in</h2>
                <p class="mt-1 text-sm text-stone-500">Use your account to access the dashboard.</p>

                <form action="{{ route('login') }}" method="POST" class="mt-6 space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-medium text-stone-700">Email address</label>
                        <input id="email" name="email" type="email" value="{{ old('email', 'admin@example.com') }}" required autofocus
                               autocomplete="username"
                               class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2.5 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                        @error('email')
                            <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between">
                            <label for="password" class="block text-xs font-medium text-stone-700">Password</label>
                            <span class="text-[11px] text-stone-400">Demo: password</span>
                        </div>
                        <input id="password" name="password" type="password" value="password" required
                               autocomplete="current-password"
                               class="mt-1.5 w-full rounded-lg border border-stone-200 bg-paper px-3 py-2.5 text-sm focus:border-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-100">
                        @error('password')
                            <p class="mt-1.5 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <label class="flex items-center gap-2.5 text-sm text-stone-600">
                        <input type="checkbox" name="remember" value="1"
                               class="size-4 rounded border-stone-300 text-indigo-600 focus:ring-indigo-500">
                        Remember me
                    </label>

                    <button type="submit"
                            class="w-full rounded-lg bg-ink px-4 py-2.5 text-sm font-medium text-white transition hover:bg-stone-800">
                        Log in
                    </button>
                </form>
            </div>

            <p class="mt-6 text-center text-sm text-stone-500">
                <a href="{{ route('home') }}" class="font-medium text-stone-700 transition hover:text-indigo-700">&larr; Back to the site</a>
            </p>
        </div>
    </div>
@endsection
