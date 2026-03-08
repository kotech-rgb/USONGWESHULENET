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
        $this->redirectIntended(route('dashboard'));
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
   <form wire:submit="login" class="search-form">
        <img src="/assets/img/use.jpg" width="80" height="80" alt="Avatar" class="avatar">

        @if(session('success'))
            <div style="color:green; margin-bottom:10px;">{{ session('success') }}</div>
        @endif

        <!-- Email Address -->
        <div class="form-group">
            <x-text-input wire:model="form.email" id="email" type="email" name="email" placeholder="Enter username *" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="error-message" />
        </div>

        <!-- Password -->
        <div class="form-group">
            <x-text-input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password" placeholder="Enter password *" />
            <x-input-error :messages="$errors->get('form.password')" class="error-message" />
        </div>

        <div>
            @if (Route::has('password.request'))
                <a style="text-decoration:none;" href="{{ route('password.request') }}" wire:navigate>Forgot your password ?  </a>
            @endif

            <x-primary-button>
                <i class="fa fa-sign-in"></i> SIGN IN
            </x-primary-button>
        </div>
    </form>
</div>
