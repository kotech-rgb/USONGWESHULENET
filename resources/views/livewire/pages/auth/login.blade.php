<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(
            default: route('dashboard', absolute: false),
            navigate: false
        );
    }
};
?>

<div>
    <!-- Header -->
    <div class="login-header mb-3 text-center mt-3">
     @php
    $now = \Carbon\Carbon::now('Africa/Dar_es_Salaam');
    $hour = $now->hour;

    if ($hour >= 5 && $hour < 12) {
        $greeting = 'Good Morning';
        $color="Green";
    } elseif ($hour >= 12 && $hour < 17) {
        $greeting = 'Good Afternoon';
         $color="Orange";
    } elseif ($hour >= 17 && $hour < 21) {
        $greeting = 'Good Evening';
         $color="Black";
    } else {
        $greeting = 'Good Night';
         $color="Green";
    }
    @endphp

        <a style="color: {{ $color }};">Hi, <strong>{{ $greeting }}</strong></a>
        <p>Sign in to access Dashboard</p>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Login Form -->
    <form wire:submit.prevent="login">

        <!-- Email -->
        <div class="mb-3">
            <x-input-label
                for="email"
                :value="__('Email')"
                class="form-label required"
            />

            <x-text-input
                wire:model="form.email"
                id="email"
                class="form-control"
                type="email"
                required
                autofocus
                autocomplete="username"
            />

            <x-input-error
                :messages="$errors->get('form.email')"
                class="text-danger mt-1"
            />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <x-input-label
                for="password"
                :value="__('Password')"
                class="form-label required"
            />

            <div class="input-group">
                <x-text-input
                    wire:model="form.password"
                    id="password"
                    class="form-control"
                    type="password"
                    required
                    autocomplete="current-password"
                />

                <button
                    class="input-group-text"
                    type="button"
                    onclick="togglePassword()"
                >
                    <i id="eyeIcon" class="bi bi-eye"></i>
                </button>
            </div>

            <x-input-error
                :messages="$errors->get('form.password')"
                class="text-danger mt-1"
            />
        </div>

        <!-- Remember Me -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input
                    wire:model="form.remember"
                    id="remember_me"
                    type="checkbox"
                    class="form-check-input"
                >
                <label class="form-check-label" for="remember_me">
                    {{ __('Remember me') }}
                </label>
            </div>

            @if (Route::has('password.request'))
                <a
                    href="{{ route('password.request') }}"
                    class="text-decoration-none small"
                    style="color:#0b1c3d;"
                    wire:navigate
                >
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-dark btn-signin w-100">
            <span>
                <i class="fa fa-sign-in-alt me-2"></i>
                {{ __('Sign In') }}
            </span>
        </button>
    </form>
</div>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');

        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
